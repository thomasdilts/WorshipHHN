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
class SongExportCsvFile extends SongSearch
{

    public function exportCsv()
    {
        $spreadsheet = SongExportCsvFile::CreateEventReport();
        $filePath = File::getTempFile();
        //require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'../vendor/phpoffice/phpspreadsheet/writer/pdf/tcpdf.php');
        //$writer = IOFactory::createWriter($spreadsheet, 'Tcpdf');
        $writer = IOFactory::createWriter($spreadsheet, 'Csv');
        //$writer->set_paper('A4', 'landscape');
        $writer->save($filePath);

        return Yii::$app
            ->response
            ->sendContentAsFile(file_get_contents($filePath), SongExportCsvFile::GetFileName() . '.csv', $options = ['inline' => true, 'mimeType' => 'text/csv']);
    }

    private function GetFileName()
    {
        $title = Yii::t('app', 'Song export');
        $title .= Yii::$app->formatter->asDate(time() , "Y-MM-dd HH:mm");
        $file = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '-', $title);
        return mb_ereg_replace("([\.]{2,})", '-', $file);
    }
    private function CreateEventReport()
    {
        $searchModel = new SongSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 200000);

        if (($sort = $dataProvider->getSort()) !== false) {
            $dataProvider->query->addOrderBy($sort->getOrders());
        }
  
        $songs = $dataProvider->query->all($dataProvider->db); 

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
        $churchname = Church::findOne(Yii::$app
            ->user
            ->identity
            ->church_id)->name;
        $spreadsheet->getProperties()
            ->setCreator('Worship HisHolyName')
            ->setLastModifiedBy('Worship HisHolyName')
            ->setTitle('Song CSV export')->setSubject('WorshipHHN')
            ->setDescription('')
            ->setKeywords('office 2007 openxml php')
            ->setCategory($churchname);
        $spreadsheet->setActiveSheetIndex(0)
    		->setCellValue('A1',Yii::t('app', 'Name'))
    		->setCellValue('B1',Yii::t('app', 'Name').'2')
            ->setCellValue('C1',Yii::t('app', 'Author'))
            ->setCellValue('D1',Yii::t('app', 'Description'));

        $row = 2;
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

        foreach ($songs as $song)
        {               
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $row, $song->name)
                ->setCellValue('B' . $row, $song->name2)
                ->setCellValue('C' . $row, $song->author)
                ->setCellValue('D' . $row, $song->description);

        	$colorSetting=$setRowColor? $rowGlobalColor1:$rowGlobalColor2;

	        $spreadsheet->getActiveSheet()->getStyle('A' . $row.':'.'D' . $row)->applyFromArray($colorSetting);
            $setRowColor = !$setRowColor;
            $row++;

        }
        $row--;

		$spreadsheet->getActiveSheet()->getStyle('A1:D1')->applyFromArray(
		    ['fill' => [
		                'fillType' => Fill::FILL_SOLID,
		                'color' => ['argb' => 'CCD5D5D5'],
		            ],
		            'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ],
		        ]
		);

        $styleThinBlackBorderOutline = ['borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];

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
        return $spreadsheet;

    }
}

