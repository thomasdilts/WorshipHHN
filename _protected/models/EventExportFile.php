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
class EventExportFile extends Event
{
    public function exportPdf()
    {
        $spreadsheet = $this->CreateEventReport();
        $filePath = File::getTempFile();
        //require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'../vendor/phpoffice/phpspreadsheet/writer/pdf/tcpdf.php');
        //$writer = IOFactory::createWriter($spreadsheet, 'Tcpdf');
        $writer = IOFactory::createWriter($spreadsheet, 'Dompdf');
		$church=Church::findOne(Yii::$app
            ->user
            ->identity
            ->church_id);
        $writer->setPaperSize($church->paper_size);
        $writer->save($filePath);

        return Yii::$app
            ->response
            ->sendContentAsFile(file_get_contents($filePath), $this->GetFileName() . '.pdf', $options = [ 'mimeType' => 'application/pdf']);
    }
    public function exportExcel()
    {
        $spreadsheet = $this->CreateEventReport();
        $filePath = File::getTempFile();
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($filePath);

        return Yii::$app
            ->response
            ->sendContentAsFile(file_get_contents($filePath), $this->GetFileName() . '.xlsx', $options = ['inline' => true, 'mimeType' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']);
    }
    private function GetFileName()
    {
        $title = $this->name . ' ' . Yii::$app
            ->formatter
            ->asDate($this->start_date, "Y-MM-dd HH:mm");
        $file = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '-', $title);
        return mb_ereg_replace("([\.]{2,})", '-', $file);
    }
    private function GetStartTime($model)
    {
        $value = '';
        $isRed = false;
        if ($model
            ->activityType
            ->use_globally)
        {
            $value = $model->global_order;
        }
        else
        {
            $isRed = $model->start_time == null || strlen($model->start_time) == 0;
            $value = $isRed ? Yii::t('app', 'Missing') : $model->start_time;
        }
        return array(
            'value' => $value,
            'isRed' => $isRed
        );
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
    private function CreateEventReport()
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

        $searchModel = new ActivitySearch();
        $searchModel->event = $this;
        $dataProvider = $searchModel->search(Yii::$app
            ->request->queryParams, 10000);
        if (($sort = $dataProvider->getSort()) !== false) {
            $dataProvider->query->addOrderBy($sort->getOrders());
        }
  
        $activities = $dataProvider->query->all($dataProvider->db); 

        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        // Set document properties
        $title = $this->name . ' ' . Yii::$app
            ->formatter
            ->asDate($this->start_date, "Y-MM-dd HH:mm");
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

		$this->SetBold('A2',$spreadsheet,Yii::t('app', 'Today'));
        Yii::$app->formatter->defaultTimeZone=$church->time_zone;
        Yii::$app->formatter->timeZone=$church->time_zone;
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('C1', $title)
            ->setCellValue('B2', Yii::$app->formatter->asDate(time() , "Y-MM-dd HH:mm"))
            ->setCellValue('C2', $churchname);

		$this->SetBold('A3',$spreadsheet,Yii::t('app', 'Start time'));
		$this->SetBold('B3',$spreadsheet,Yii::t('app', 'Name'));
		$this->SetBold('C3',$spreadsheet,Yii::t('app', 'Other'));

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

        foreach ($activities as $activity)
        {
            $startTime = $this->GetStartTime($activity);
            $other = Activity::getOtherColumn($activity,$this->start_date);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $row, $startTime['value'])
                ->setCellValue('B' . $row, $activity->name)
                ->setCellValue('C' . $row, $other['value']);
            if ($startTime['isRed'])
            {
            	$this->SetRed('A' . $row,$spreadsheet,$startTime['value']);
            }
            if ($other['isRed'])
            {
            	$this->SetRed('C' . $row,$spreadsheet,$other['value']);
            }elseif ($other['isYellow'])
            {
                $this->SetYellow('C' . $row,$spreadsheet,$other['value']);
            }
            if($activity->activityType->use_globally)
            {
	        	$colorSetting=$setRowColor? $rowGlobalColor1:$rowGlobalColor2;
	        }
	        else
	        {
	        	$colorSetting=$setRowColor? $rowColor1:$rowColor2;
	        }
	        $spreadsheet->getActiveSheet()->getStyle('A' . $row.':'.'C' . $row)->applyFromArray($colorSetting);
            $setRowColor = !$setRowColor;
            $row++;

        }
        $row--;

		$spreadsheet->getActiveSheet()->getStyle('A3:C3')->applyFromArray(
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

        $spreadsheet->getActiveSheet()
            ->getStyle('A3:A' . $row)->applyFromArray($styleThinBlackBorderOutline);
        $spreadsheet->getActiveSheet()
            ->getStyle('B3:B' . $row)->applyFromArray($styleThinBlackBorderOutline);
        $spreadsheet->getActiveSheet()
            ->getStyle('C3:C' . $row)->applyFromArray($styleThinBlackBorderOutline);

        $spreadsheet->getActiveSheet()
            ->getColumnDimension('A')
            ->setAutoSize(true);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('B')
            ->setAutoSize(true);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('C')
            ->setAutoSize(true);
        return $spreadsheet;

    }
}

