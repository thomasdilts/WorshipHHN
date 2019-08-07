<?php
namespace app\models;

use Yii;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use yii\helpers\ArrayHelper;

use yii\web\ServerErrorHttpException;

/**
 * This is the model class for table "event".
 *
 * @property int $id
 * @property int $church_id
 * @property string $name
 * @property string $description
 * @property string $start_date
 * @property string $end_date
 *
 * @property Activity[] $activities
 * @property Church $church
 * @property EventTemplate $eventTemplate
 */
class ActivityExportFile extends UserActivitySearch
{
    public function exportIcs($user_id,$teamArray,$start,$end)
    {
        $data = ActivityExportFile::GetAllData($user_id,$teamArray,$start,$end, 20000);
        if (($sort = $data['dataProvider']->getSort()) !== false) {
            $data['dataProvider']->query->addOrderBy($sort->getOrders());
        }
  
        $activities = $data['dataProvider']->query->all($data['dataProvider']->db); 
		$church= Church::findOne(Yii::$app
            ->user
            ->identity
            ->church_id);
        $churchname =$church->name;
        $linkHost = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 
                "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . Yii::$app->request->baseUrl;    
		$events = array();				
        foreach ($activities as $activity)
        {
            $status='';
            $isRed=false;
            $notifications= Notification::find()->where(['activity_id'=>$activity->id])->all();
            if($notifications && count($notifications)>0) {                                 
                $statuses = ArrayHelper::getColumn($notifications,'status');
                if(in_array('Accepted',$statuses)){
                    $status.=Yii::t('app', 'Accepted');
                }elseif(in_array('Not replied yet',$statuses)) {
                    $status.=Yii::t('app', 'Not replied yet');
                }elseif(in_array('Rejected',$statuses)) {
                    $status.=Yii::t('app', 'Rejected');
                    $isRed=true;
                }
            }     
            if(isset($activity->team) && $activity->team->IsTeamBlocked($activity->event->start_date)){
                $status.=strlen($status)>0?'; ':'';
                $status.=Yii::t('app', 'Unavailable-team');    
                $isRed=true;                                             
            }elseif(isset($activity->user) && $activity->user->IsUserBlocked($activity->event->start_date)){
                $status.=strlen($status)>0?'; ':'';
                $status.=Yii::t('app', 'Unavailable-user');
                $isRed=true;                         
            }    
            $events[] = array(
                'location' => $churchname,
                'description' => $activity->team?$activity->team->name:'' . "; " . $status. "; " . $activity->name,
                'dtstart' => Yii::$app->formatter->asTime($activity->event->start_date, "YMMddTH:mm:ss"),
                'dtend' => Yii::$app->formatter->asTime($activity->event->end_date, "YMMddTH:mm:ss"),
                'summary' => $activity->event->name. "; " . $activity->name,
                'url' => $linkHost . "/event/activities?id=".$activity->id,
                'alarm' => '30M'
            );                           
        }

		if(!$events || count($events)==0){
			return Yii::$app
				->response
				->sendContentAsFile('', ActivityExportFile::GetFileName($user_id,$teamArray) . '.ics', $options = ['inline' => true, 'mimeType' => 'text/calendar']);
		}
        $ics = new Ics($events);
        $filePath = File::getTempFile();
        file_put_contents($filePath, $ics->prepare($church->time_zone));

        return Yii::$app
            ->response
            ->sendContentAsFile(file_get_contents($filePath), ActivityExportFile::GetFileName($user_id,$teamArray) . '.ics', $options = ['inline' => true, 'mimeType' => 'text/calendar']);
    }
    public function GetAllData($user_id,$teamArray,$start,$end, $page_size){
        $searchModel = new UserActivitySearch();
        $team = count($teamArray)>0?Team::findOne($teamArray[0]):null;
        $user = User::findOne($user_id);
        $searchModel->teamIdArray= $teamArray;
        $searchModel->user = $user;

        $searchModel->filter_start_date = $start; // get start date
        $searchModel->filter_end_date = $end;
        $searchModel->userid=$user_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $page_size);
		
        //Yii::info($start.':'.$end, 'ActivityExportFile');
        return [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' =>  $user?$user:$team,
        ];        
    }
    public function exportPdf($user_id,$teamArray,$start,$end)
    {
        $spreadsheet = ActivityExportFile::CreateEventReport($user_id,$teamArray,$start,$end);
        $filePath = File::getTempFile();
        //require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'../vendor/phpoffice/phpspreadsheet/writer/pdf/tcpdf.php');
        //$writer = IOFactory::createWriter($spreadsheet, 'Tcpdf');
        $writer = IOFactory::createWriter($spreadsheet, 'Dompdf');
        $writer->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
		$church=Church::findOne(Yii::$app
            ->user
            ->identity
            ->church_id);
        $writer->setPaperSize($church->paper_size);
        //$writer->set_paper('A4', 'landscape');
        $writer->save($filePath);

        return Yii::$app
            ->response
            ->sendContentAsFile(file_get_contents($filePath), ActivityExportFile::GetFileName($user_id,$teamArray) . '.pdf', $options = ['inline' => true, 'mimeType' => 'application/pdf']);
    }
    public function exportExcel($user_id,$teamArray,$start,$end)
    {
        $spreadsheet = ActivityExportFile::CreateEventReport($user_id,$teamArray,$start,$end);
        $filePath = File::getTempFile();
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($filePath);

        return Yii::$app
            ->response
            ->sendContentAsFile(file_get_contents($filePath), ActivityExportFile::GetFileName($user_id,$teamArray) . '.xlsx', $options = ['inline' => true, 'mimeType' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']);
    }
    private function GetFileName($user_id,$teamArray)
    {
        if(!$user_id){
            $team = Team::findOne($teamArray[0]);
            $title=Yii::t('app', 'Tasks for team') . ' : '. $team->name;
        }
        else{
            $user = User::findOne($user_id);
            $title = Yii::t('app', 'Tasks for user') . ' : '.$user->display_name ;
        }
        $title .= Yii::$app->formatter->asDate(time() , "Y-MM-dd HH:mm");
        $file = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '-', $title);
        return mb_ereg_replace("([\.]{2,})", '-', $file);
    }
    private function SetBold($cell,$spreadsheet,$text){
		$richBoldText = new RichText();
		$bold = $richBoldText->createTextRun($text);
		$bold->getFont()
		->setBold(true);
		$spreadsheet->getActiveSheet()
		->getCell($cell)->setValue($richBoldText);
    }
    private function SetRed($cell,$spreadsheet,$text){
        $richRedText = new RichText();
        $red = $richRedText->createTextRun($text);
        $red->getFont()
        ->setColor(new Color(Color::COLOR_RED));
        $spreadsheet->getActiveSheet()
        ->getCell($cell)->setValue($richRedText);
    }    
    private function CreateEventReport($user_id,$teamArray,$start,$end)
    {
        $data = ActivityExportFile::GetAllData($user_id,$teamArray,$start,$end, 20000);
        if (($sort = $data['dataProvider']->getSort()) !== false) {
            $data['dataProvider']->query->addOrderBy($sort->getOrders());
        }
  
        $activities = $data['dataProvider']->query->all($data['dataProvider']->db); 
        $team = null;
        if(!$user_id){
            $title=Yii::t('app', 'Tasks for team') . ' : '. $data['model']->name;
        }
        else{
            $title = Yii::t('app', 'Tasks for user') . ' : '.$data['model']->display_name;
        }


        // This sucks, but we have to try to find the composer autoloader
        $paths = [__DIR__ . '/../vendor/autoload.php', // In case PhpSpreadsheet is cloned directly
        ];
        $foundAutoLoader = false;
        foreach ($paths as $path)
        {
            if (file_exists($path))
            {
                require_once $path;
                $foundAutoLoader = true;

            }
        }
        if (!$foundAutoLoader)
        {
            throw new \Exception('Composer autoloader could not be found. Install dependencies with `composer install` and try again.');
        }

        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        // Set document properties
		$church=Church::findOne(Yii::$app
            ->user
            ->identity
            ->church_id);
        $churchname = $church->name;
        $spreadsheet->getProperties()
            ->setCreator('Worship HisHolyName')
            ->setLastModifiedBy('Worship HisHolyName')
            ->setTitle($title)->setSubject('WorshipHHN')
            ->setDescription('')
            ->setKeywords('office 2007 openxml php')
            ->setCategory($churchname);
		$spreadsheet->getActiveSheet()->getPageMargins()->setTop(floatval($church->paper_margin_top_bottom));
		$spreadsheet->getActiveSheet()->getPageMargins()->setBottom(floatval($church->paper_margin_top_bottom));
		$spreadsheet->getActiveSheet()->getPageMargins()->setRight(floatval($church->paper_margin_right_left));
		$spreadsheet->getActiveSheet()->getPageMargins()->setLeft(floatval($church->paper_margin_right_left));
		ActivityExportFile::SetBold('A2',$spreadsheet,Yii::t('app', 'Today'));
        Yii::$app->formatter->defaultTimeZone=$church->time_zone;
        Yii::$app->formatter->timeZone=$church->time_zone;
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('C1', $title)
            ->setCellValue('B2', Yii::$app->formatter->asDate(time() , "Y-MM-dd HH:mm"))
            ->setCellValue('C2', $churchname);

		ActivityExportFile::SetBold('A3',$spreadsheet,Yii::t('app', 'Event Name'));
		ActivityExportFile::SetBold('B3',$spreadsheet,Yii::t('app', 'Start Date'));
        ActivityExportFile::SetBold('C3',$spreadsheet,Yii::t('app', 'Team'));
        ActivityExportFile::SetBold('D3',$spreadsheet,Yii::t('app', 'Status'));
        ActivityExportFile::SetBold('E3',$spreadsheet,Yii::t('app', 'Activity'));




        $row = 4;
        $setRowColor=false;
        $rowGlobalColor1=['fill' => [
		                'fillType' => Fill::FILL_SOLID,
		                'color' => ['argb' => 'CCFFF8DC'],
		            ],
		            'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ],
		        ];
        $rowGlobalColor2=['fill' => [
		                'fillType' => Fill::FILL_SOLID,
		                'color' => ['argb' => 'CCFFEC8B'],
		            ],
		            'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ],
		        ];
        $rowColor1=['fill' => [
		                'fillType' => Fill::FILL_SOLID,
		                'color' => ['argb' => 'CCE8F1D4'],
		            ],
		            'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ],
		        ];
        $rowColor2=['fill' => [
		                'fillType' => Fill::FILL_SOLID,
		                'color' => ['argb' => 'CCD4ED91'],
		            ],
		            'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ],
		        ];

        foreach ($activities as $activity)
        {
            $status='';
            $isRed=false;
            $notifications= Notification::find()->where(['activity_id'=>$activity->id])->all();
            if($notifications && count($notifications)>0) {                                 
                $statuses = ArrayHelper::getColumn($notifications,'status');
                if(in_array('Accepted',$statuses)){
                    $status.=Yii::t('app', 'Accepted');
                }elseif(in_array('Not replied yet',$statuses)) {
                    $status.=Yii::t('app', 'Not replied yet');
                }elseif(in_array('Rejected',$statuses)) {
                    $status.=Yii::t('app', 'Rejected');
                    $isRed=true;
                }
            }     
            if(isset($activity->team) && $activity->team->IsTeamBlocked($activity->event->start_date)){
                $status.=strlen($status)>0?'; ':'';
                $status.=Yii::t('app', 'Unavailable-team');    
                $isRed=true;                                             
            }elseif(isset($activity->user) && $activity->user->IsUserBlocked($activity->event->start_date)){
                $status.=strlen($status)>0?'; ':'';
                $status.=Yii::t('app', 'Unavailable-user');
                $isRed=true;                         
            }                   
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $row, $activity->event->name)
                ->setCellValue('B' . $row, Yii::$app->formatter->asDate($activity->event->start_date, "Y-MM-dd H:mm"))
                ->setCellValue('C' . $row, $activity->team?$activity->team->name:($team?$team->name:''))
                ->setCellValue('D' . $row, $status)
                ->setCellValue('E' . $row, $activity->name);
            if ($isRed)
            {
                ActivityExportFile::SetRed('D' . $row,$spreadsheet,$status);
            }
        	$colorSetting=$setRowColor? $rowGlobalColor1:$rowGlobalColor2;

	        $spreadsheet->getActiveSheet()->getStyle('A' . $row.':'.'E' . $row)->applyFromArray($colorSetting);
            $setRowColor = !$setRowColor;
            $row++;

        }
        $row--;

		$spreadsheet->getActiveSheet()->getStyle('A3:E3')->applyFromArray(
		    ['fill' => [
		                'fillType' => Fill::FILL_SOLID,
		                'color' => ['argb' => 'CCD5D5D5'],
		            ],
		            'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ],
		        ]
		);

        $styleThinBlackBorderOutline = ['borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
        $spreadsheet->getActiveSheet()
            ->getStyle('A1:E2')
            ->applyFromArray($styleThinBlackBorderOutline);
        $spreadsheet->getActiveSheet()
            ->getStyle('A2:B2')
            ->applyFromArray($styleThinBlackBorderOutline);

        $spreadsheet->getActiveSheet()
            ->getStyle('A3:A' . $row)->applyFromArray($styleThinBlackBorderOutline);
        $spreadsheet->getActiveSheet()
            ->getStyle('B3:B' . $row)->applyFromArray($styleThinBlackBorderOutline);
        $spreadsheet->getActiveSheet()
            ->getStyle('C3:C' . $row)->applyFromArray($styleThinBlackBorderOutline);
        $spreadsheet->getActiveSheet()
            ->getStyle('D3:D' . $row)->applyFromArray($styleThinBlackBorderOutline);
        $spreadsheet->getActiveSheet()
            ->getStyle('E3:E' . $row)->applyFromArray($styleThinBlackBorderOutline);

        $spreadsheet->getActiveSheet()
            ->getColumnDimension('A')
            ->setAutoSize(true);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('B')
            ->setAutoSize(true);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('C')
            ->setAutoSize(true);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('D')
            ->setAutoSize(true);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('E')
            ->setAutoSize(true);
        return $spreadsheet;

    }
}

