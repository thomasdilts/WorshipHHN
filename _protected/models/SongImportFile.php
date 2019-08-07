<?php
namespace app\models;

use Yii;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use app\models\File;
use yii\web\UploadedFile;
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
class SongImportFile extends SongSearch
{
    public function getFileFromUser($model){

        $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
        $filePath ='';
        foreach ($model->imageFiles as $file) {
            $filePath = File::getTempFile();
            if($file->error!=0){
                switch($file->error)
                {
                    case UPLOAD_ERR_INI_SIZE;
                        $errMessage='UPLOAD_ERR_INI_SIZE';
                        break;
                    case UPLOAD_ERR_FORM_SIZE;
                        $errMessage='UPLOAD_ERR_FORM_SIZE';
                        break;
                    case UPLOAD_ERR_PARTIAL;
                        $errMessage='UPLOAD_ERR_PARTIAL';
                        break;
                    case UPLOAD_ERR_NO_FILE;
                        $errMessage='UPLOAD_ERR_NO_FILE';
                        break;
                    case UPLOAD_ERR_NO_TMP_DIR;
                        $errMessage='UPLOAD_ERR_NO_TMP_DIR';
                        break;
                    case UPLOAD_ERR_CANT_WRITE;
                        $errMessage='UPLOAD_ERR_CANT_WRITE';
                        break;
                    case UPLOAD_ERR_EXTENSION;
                        $errMessage='UPLOAD_ERR_EXTENSION';
                        break;
                    default:
                        $errMessage=$file->error;
                        break;
                }
                Yii::$app->session->setFlash("danger", Yii::t('app', 'Failed to upload file').' :'.$errMessage );
                return ''; 
            }
            if (!copy($file->tempName, $filePath  )) {
                Yii::$app->session->setFlash("danger", Yii::t('app', 'Failed to copy file to new destination').' :'.$filePath );
                return '';             
            }
        }
        UploadedFile::reset();
        return $filePath;
        
    }
    public function importOpenLp($file)
    {
        $tempfile=tempnam(sys_get_temp_dir(),'');
        // you might want to reconsider this line when using this snippet.
        // it "could" clash with an existing directory and this line will
        // try to delete the existing one. Handle with caution.
        if (file_exists($tempfile)) { unlink($tempfile); }
        mkdir($tempfile);
        if (is_dir($tempfile)) { 
            $zip = new \ZipArchive;
            $res = $zip->open($file);
            if ($res === TRUE) {
                $zip->extractTo($tempfile);
                $zip->close();
                Yii::info('contents of zip in :'.$tempfile, 'SongImportFile');
                $new=0;
                $updated=0;                
                foreach(glob($tempfile.'/*.*') as $openLpfile) {
                    //Yii::info('file :'.$openLpfile, 'SongImportFile');
                    $fileContents = file_get_contents($openLpfile);
                    // simple xml removes all <br/> from the file. This will preserve them by converting them first to a strange string.
                    $fileContents=str_replace('<br/>','§§£%¤',$fileContents);
                    Yii::info('file :'.$fileContents, 'SongImportFile');
                    $xmldata = simplexml_load_string($fileContents); 
                    if (false === $xmldata) {
                        $errorMessage = "Failed loading XML file= ".$openLpfile;
                        foreach(libxml_get_errors() as $error) {
                            $errorMessage .= " ; ". $error->message;
                        }
                        Yii::$app->session->setFlash("danger", $errorMessage );
                        return;
                    }
                    $testSong=new Song();

                    if($xmldata->properties->titles && $xmldata->properties->titles->title && count($xmldata->properties->titles->title )>0){
                        if(count($xmldata->properties->titles->title )>=1){
                            $testSong->name=(string)$xmldata->properties->titles->title[0];
                        }
                        if(count($xmldata->properties->titles->title )>=2){
                            $testSong->name2=(string)$xmldata->properties->titles->title[1];
                        }
                    }else{
                        Yii::$app->session->setFlash("danger", "no 'titles' in file : ".$openLpfile);
                        return;                        
                    }
                    if($xmldata->properties->authors && $xmldata->properties->authors->author && count($xmldata->properties->authors->author)>0){
                        if(count($xmldata->properties->authors->author)>=1){
                            $testSong->author=(string)$xmldata->properties->authors->author[0];
                        }
                    }
                    $testSong->description='';
                    if($xmldata->lyrics->verse && count($xmldata->lyrics->verse)>0){
                        foreach ($xmldata->lyrics->verse as $verse) {
                            $testSong->description.=(string)strlen($testSong->description)>0?"\r\n":'';
                            foreach ($verse->lines as $line) {
                                $testSong->description.=(string)str_replace('§§£%¤',"\r\n",(string)$line)."\r\n";
                            }
                        }
                    }

                    $result=SongImportFile::AttemptImportSong($testSong);
                    $updated+=$result['updated'];
                    $new+=$result['new'];
                }

                Yii::$app->session->setFlash('success', Yii::t('app', 'Successful file import'). '; ' . Yii::t('app', 'Updated'). ' = '. $updated . ' ; ' . Yii::t('app', 'New'). ' = '. $new);
                //cleanup
                SongImportFile::deleteDir($tempfile);

            } else {
                Yii::$app->session->setFlash("danger", Yii::t('app', 'Failed to unzip the file') );
                return ; 
            }
        }
    }
    public static function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }
    public function importCsv($file)
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

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        $spreadsheet = $reader->load($file);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        $validColumnNames=array('name','name2','author','description');
        $columnIndexes=array(-1,-1,-1,-1);

        $firstRow=$sheetData[0];
        $i=0;
        foreach ($firstRow as $name) {
            if(($index = SongImportFile::getIndexFoundItem($validColumnNames,$name)) == -1){
                Yii::$app->session->setFlash("danger", Yii::t('app', 'Unknown column name in the first row of the file').' : '.$name );
                return;
            }
            $columnIndexes[$index]=$i;
            $i++;
        }

        $isFirstRow=true;
        $new=0;
        $updated=0;
        foreach ($sheetData as $row) {
            if(!$isFirstRow)
            {
                $song=new Song();
                $song->name=$row[$columnIndexes[0]];
                $song->name2=$row[$columnIndexes[1]];
                $song->author=$row[$columnIndexes[2]];
                $song->description=$row[$columnIndexes[3]];

                $result=SongImportFile::AttemptImportSong($song);
                $updated+=$result['updated'];
                $new+=$result['new'];
            }
            $isFirstRow=false;
        }


        Yii::$app->session->setFlash('success', Yii::t('app', 'Successful file import'). '; ' . Yii::t('app', 'Updated'). ' = '. $updated . ' ; ' . Yii::t('app', 'New'). ' = '. $new);
        return;
    }
    public function getIndexFoundItem($arrayOfNames,$name){
        $i=0;
        foreach ($arrayOfNames as $value) {
            if(strtolower($name)==$value){ 
                return $i;
            }
            $i++;
        } 
        return -1; //not found
    }
    public function AttemptImportSong($song){
        $new=0;
        $updated=0;
        $foundSong = Song::find()->where(['name'=>$song->name,'author'=>$song->author])->one();
        if($foundSong ){
            $foundSong->name=$song->name;
            $foundSong->name2=$song->name2;
            $foundSong->author=$song->author;
            $foundSong->description=$song->description;
            $foundSong->save();
            $updated++;
        }else{
            $foundSong =new Song();
            $foundSong->name=$song->name;
            $foundSong->name2=$song->name2;
            $foundSong->author=$song->author;
            $foundSong->description=$song->description;
            $foundSong->church_id= Yii::$app->user->identity->church_id;
            $foundSong->save();
            $new++;
        }

        return array('new'=>$new,'updated'=>$updated);
    }

}

