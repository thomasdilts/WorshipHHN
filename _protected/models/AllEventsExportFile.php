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
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

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
class AllEventsExportFile extends Activity
{
	public const ColumnNumToColumnLetter=[
		'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
		'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ',
		'BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ',
		'CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ'];
    public function exportExcel($start_date,$end_date)
    {
        $spreadsheet = AllEventsExportFile::CreateEventReport($start_date,$end_date);
        $filePath = File::getTempFile();
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($filePath);

        return Yii::$app
            ->response
            ->sendContentAsFile(file_get_contents($filePath), AllEventsExportFile::GetFileName($start_date,$end_date) . '.xlsx', $options = ['inline' => true, 'mimeType' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']);
    }
    private function GetFileName($start_date,$end_date)
    {
        $title = Yii::t('app', 'Tasks by event') . ' ' . $start_date . '_to_' .$end_date;
        $file = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '-', $title);
        return mb_ereg_replace("([\.]{2,})", '-', $file);
    }

    private function SetRed($cell,$spreadsheet,$text){
		$richRedText = new RichText();
		$red = $richRedText->createTextRun($text);
		$red->getFont()
		->setColor(new Color(Color::COLOR_RED));
		$spreadsheet->getActiveSheet()
		->getCell($cell)->setValue($richRedText);
    }
    private function SetYellow($cell,$spreadsheet,$text){
        $richRedText = new RichText();
        $red = $richRedText->createTextRun($text);
        $red->getFont()
        ->setColor(new Color(Color::COLOR_DARKYELLOW));
        $spreadsheet->getActiveSheet()
        ->getCell($cell)->setValue($richRedText);
    }
    private function SetBold($cell,$spreadsheet,$text){
		$richBoldText = new RichText();
		$bold = $richBoldText->createTextRun($text);
		$bold->getFont()
		->setBold(true);
		$spreadsheet->getActiveSheet()
		->getCell($cell)->setValue($richBoldText);
    }
	public static function getDataArray($start_date,$end_date,$isHtml=true){
		$searchModel = new EventActivitySearch();
		
        $searchModel = new EventActivitySearch();
		$searchModel->filter_start_date=$start_date;
		$searchModel->filter_end_date=$end_date;
        $dataProvider = $searchModel->search(Yii::$app
            ->request->queryParams, 10000);
        if (($sort = $dataProvider->getSort()) !== false) {
            $dataProvider->query->addOrderBy($sort->getOrders());
        }	

		$dataByRows=$dataProvider->query->all();
		$dataByEvent=[];
		$columns=[];
        foreach ($dataByRows as $row)
        {
			if(!array_key_exists($row->event_id,$dataByEvent)){
				$event = [];
				$event['event_name']=($isHtml?'<a href="'.URL::toRoute('event/activities').'?id='.$row->event_id.'">':'').$row->event->name.($isHtml?'</a>':'');
				$event['start_date']=date('Y-m-d H:i',strtotime($row->event->start_date));
				$dataByEvent[$row->event_id]=$event;
			}	
			$event=$dataByEvent[$row->event_id];
			$status=EventActivitySearch::getStatus($row,$isHtml);
			$status[0]=$status[0]==Yii::t('app', 'Accepted')?'':$status[0];
			if(!array_key_exists($row->activityType->id,$event)){
				$event[$row->activityType->id]=['color'=>$status[1],'text'=>''];
			}
			$activity=$event[$row->activityType->id];
			$username=isset($row->team)?$row->team->name:(isset($row->user)?$row->user->display_name:'');
			
			$activity['text'].=($isHtml?'<a href="'.URL::toRoute('event/editactivity'). '?id='.$row->id.'&eventid='.$row->event->id.'&returnurl=alltasksbyevent%3Fstart%3D'.$start_date . '%26end%3D'.$end_date.'" >':'')
				 .$username. (strlen($username)>0&&strlen($status[0])>0?'; ':'') . $status[0] . ($isHtml?'</a>':'');
				
			$event[$row->activityType->id]=$activity;
			$dataByEvent[$row->event_id]=$event;
			$columnKey=sprintf('%08d', $row->activityType->default_global_order).';'.$row->activityType->id;
			if(!array_key_exists($columnKey,$columns)){
				$columns[$columnKey]=['name'=>$row->activityType->name,'id'=>$row->activityType->id];
			}
        }	
		// sort the columns by globalOrder		
		ksort($columns);
		return [$dataByEvent,$columns];
	}
    private function CreateEventReport($start_date,$end_date)
    {
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
		
		$dataByEvent = AllEventsExportFile::getDataArray($start_date,$end_date,false);
		$columns=$dataByEvent[1];
		$dataRows=$dataByEvent[0];
		
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        // Set document properties
        $title = Yii::t('app', 'Tasks by event') . ' ' . $start_date . ' to ' .$end_date;
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

		AllEventsExportFile::SetBold('A2',$spreadsheet,Yii::t('app', 'Today'));
        Yii::$app->formatter->defaultTimeZone=$church->time_zone;
        Yii::$app->formatter->timeZone=$church->time_zone;
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('C1', $title)
            ->setCellValue('B2', Yii::$app->formatter->asDate(time() , "Y-MM-dd HH:mm"))
            ->setCellValue('C2', $churchname);
			
		// set the column headers	
		AllEventsExportFile::SetBold('A3',$spreadsheet,Yii::t('app', 'Start Date'));
		AllEventsExportFile::SetBold('B3',$spreadsheet,Yii::t('app', 'Event'));
		$i=2;
		foreach($columns as $key => $value){
			AllEventsExportFile::SetBold(AllEventsExportFile::ColumnNumToColumnLetter[$i].'3',$spreadsheet,$value['name']);
			$i++;
		}  

		$spreadsheet->getActiveSheet()->getPageMargins()->setTop(floatval($church->paper_margin_top_bottom));
		$spreadsheet->getActiveSheet()->getPageMargins()->setBottom(floatval($church->paper_margin_top_bottom));
		$spreadsheet->getActiveSheet()->getPageMargins()->setRight(floatval($church->paper_margin_right_left));
		$spreadsheet->getActiveSheet()->getPageMargins()->setLeft(floatval($church->paper_margin_right_left));

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

        foreach ($dataRows as $rowKey=>$rowValue)
        {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $row, $rowValue['start_date'])
                ->setCellValue('B' . $row, $rowValue['event_name']);
			$i=2;
			foreach($columns as $key=>$value){
				if(array_key_exists($value['id'],$rowValue)){
					if ($rowValue[$value['id']]['color']=='red')
					{
						AllEventsExportFile::SetRed(AllEventsExportFile::ColumnNumToColumnLetter[$i] . $row,$spreadsheet,$rowValue[$value['id']]['text']);
					}
					else if ($rowValue[$value['id']]['color']=='yellow')
					{
						AllEventsExportFile::SetYellow(AllEventsExportFile::ColumnNumToColumnLetter[$i] . $row,$spreadsheet,$rowValue[$value['id']]['text']);
					}
					else{
						$spreadsheet->setActiveSheetIndex(0)
							->setCellValue(AllEventsExportFile::ColumnNumToColumnLetter[$i] . $row, $rowValue[$value['id']]['text']);
					}
				}
				$i++;
			}
			$colorSetting=$setRowColor? $rowColor1:$rowColor2;

	        $spreadsheet->getActiveSheet()->getStyle('A' . $row.':'.AllEventsExportFile::ColumnNumToColumnLetter[count($columns)+1] . $row)->applyFromArray($colorSetting);
            $setRowColor = !$setRowColor;
            $row++;

        }
        $row--;

		$spreadsheet->getActiveSheet()->getStyle('A3:'.AllEventsExportFile::ColumnNumToColumnLetter[count($columns)+1].'3')->applyFromArray(
		    ['fill' => [
		                'fillType' => Fill::FILL_SOLID,
		                'color' => ['argb' => 'CCD5D5D5'],
		            ],
		            'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ],
		        ]
		);

        $styleThinBlackBorderOutline = ['borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
        $spreadsheet->getActiveSheet()
            ->getStyle('A1:C2')
            ->applyFromArray($styleThinBlackBorderOutline);
        $spreadsheet->getActiveSheet()
            ->getStyle('A2:B2')
            ->applyFromArray($styleThinBlackBorderOutline);
		
		for($i=0;$i<count($columns)+2;$i++){
			$spreadsheet->getActiveSheet()
				->getStyle(AllEventsExportFile::ColumnNumToColumnLetter[$i].'3:'. AllEventsExportFile::ColumnNumToColumnLetter[$i] . $row)->applyFromArray($styleThinBlackBorderOutline);
			$spreadsheet->getActiveSheet()
            ->getColumnDimension(AllEventsExportFile::ColumnNumToColumnLetter[$i])
            ->setAutoSize(true);	
		}  

        return $spreadsheet;

    }
}

