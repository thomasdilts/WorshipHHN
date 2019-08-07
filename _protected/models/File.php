<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\web\ServerErrorHttpException;

/**
 * This is the model class for table "attach_file".
 *
 * @property integer $id
 * @property string $name
 * @property string $model
 * @property integer $itemId
 * @property string $hash
 * @property integer $size
 * @property string $type
 * @property string $mime
 */
class File extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attach_file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'model', 'itemId', 'hash', 'size', 'mime'], 'required'],
            [['itemId', 'size'], 'integer'],
            [['name', 'model', 'hash', 'mime'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
          /*  'id' => 'ID',
            'name' => 'Name',
            'model' => 'Model',
            'itemId' => 'Item ID',
            'hash' => 'Hash',
            'size' => 'Size',
            'mime' => 'Mime'*/
        ];
    }

    public function getUrl()
    {
        return Url::to(['/attachments/file/download', 'id' => $this->id]);
    }

    public function getPath()
    {
        return $this->getModule()->getFilesDirPath($this->hash) . DIRECTORY_SEPARATOR . $this->hash . '.' . $this->type;
    }
    
    public static function addFileTrimImage($model,$dimension)
	{
		$model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
		
		foreach ($model->imageFiles as $file) {

			if($file->error!=0){
				File::getError($file->error);
				return;
			}
			$tempfile=File::getTempFile();
			if (!copy($file->tempName, $tempfile )) {
				Yii::$app->session->setFlash("danger", Yii::t('app', 'Failed to copy file to new destination').' :'.$fileDestination );
				return;				
			}

			$tempJpgFile=File::getTempFile();
			try{
				File::convertImage($tempfile, $tempJpgFile, 90);
			}catch(\Exception $e) {
				Yii::$app->session->setFlash("danger", Yii::t('app', 'Failed to copy file to new destination').' :'.$e->getMessage() );
				return;
			}

			$tempTrimedFile=File::getTempFile();
			try{
				File::square_thumbnail_with_proportion($tempJpgFile,$tempTrimedFile,$dimension);
			}catch(\Exception $e) {
				Yii::$app->session->setFlash("danger", Yii::t('app', 'Failed to copy file to new destination').' :'.$e->getMessage() );
				return;
			}

			$fileModel= new File();
			$fileModel->hash = $fileModel->GetRandomHash();
			$fileModel->name = $file->name;
			$fileModel->model = $model->tableName();
			$fileModel->itemId = $model->id;
			$fileModel->size = filesize($tempTrimedFile);
			$fileModel->mime = $file->type;
			$fileDestination = Yii::$app->params['fileVaultPath']. DIRECTORY_SEPARATOR .$fileModel->hash;
			if (!copy($tempTrimedFile, $fileDestination )) {
				Yii::$app->session->setFlash("danger", Yii::t('app', 'Failed to copy file to new destination').' :'.$fileDestination );
				return;				
			}			

			if(!$fileModel->save()){
				Yii::$app->session->setFlash("danger", Yii::t('app', 'Failed to upload file'));
				return;	
			}

			break; //only one file allowed
		}
		UploadedFile::reset();
		Yii::$app->session->setFlash('success', Yii::t('app', 'Successful file add'));		
	}
	private static function getError($file)
	{
		switch($file)
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
				$errMessage=$file;
				break;
		}
		Yii::$app->session->setFlash("danger", Yii::t('app', 'Failed to upload file').' :'.$errMessage );
		return;	
	}
	public static function addFilesByAjax($model)
	{
		$imageFiles = $_FILES['imageFiles'];
		//foreach ($imageFiles as $file) {
			$fileModel= new File();
			$fileModel->hash = $fileModel->GetRandomHash();
			$fileModel->name = $imageFiles['name'][0];
			$fileModel->model = $model->tableName();
			$fileModel->itemId = $model->id;
			$fileModel->size = $imageFiles['size'][0];
			$fileModel->mime = $imageFiles['type'][0];
			$fileDestination = Yii::$app->params['fileVaultPath']. DIRECTORY_SEPARATOR .$fileModel->hash;
			if($imageFiles['error'][0]!=0){
				File::getError($imageFiles['error'][0]);
				return;
			}
			if (!copy($imageFiles['tmp_name'][0], $fileDestination )) {
				Yii::$app->session->setFlash("danger", Yii::t('app', 'Failed to copy file to new destination').' :'.$fileDestination );
				return;				}	
			if(!$fileModel->save()){
				Yii::$app->session->setFlash("danger", Yii::t('app', 'Failed to upload file'));
				return;	
			}
		//}
		UploadedFile::reset();
		Yii::$app->session->setFlash('success', Yii::t('app', 'Successful file add'));
	}
	public static function addFiles($model)
	{
		$model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
		
		foreach ($model->imageFiles as $file) {
			$fileModel= new File();
			$fileModel->hash = $fileModel->GetRandomHash();
			$fileModel->name = $file->name;
			$fileModel->model = $model->tableName();
			$fileModel->itemId = $model->id;
			$fileModel->size = $file->size;
			$fileModel->mime = $file->type;
			$fileDestination = Yii::$app->params['fileVaultPath']. DIRECTORY_SEPARATOR .$fileModel->hash;
			if($file->error!=0){
				File::getError($file->error);
				return;
			}
			if (!copy($file->tempName, $fileDestination )) {
				Yii::$app->session->setFlash("danger", Yii::t('app', 'Failed to copy file to new destination').' :'.$fileDestination );
				return;				}
			if(!$fileModel->save()){
				Yii::$app->session->setFlash("danger", Yii::t('app', 'Failed to upload file'));
				return;	
			}
		}
		UploadedFile::reset();
		Yii::$app->session->setFlash('success', Yii::t('app', 'Successful file add'));
	}	
	public static function getTempFile()
	{
		$tempFileListName=Yii::$app->params['fileVaultPath']. DIRECTORY_SEPARATOR .'temporaryFileList';
		if(file_exists($tempFileListName)){
			$tempFileList=unserialize(file_get_contents($tempFileListName));
		}
		else{
			$tempFileList=array();
		}
		// delete files older then 10 minutes
		$tempFileListToSave=array();
		foreach ($tempFileList as $tempFile) {
			//throw new ServerErrorHttpException(serialize($tempFile));
			if($tempFile['createDate']<strtotime('-10 minutes')){
				if(file_exists($tempFile['path'])){
					unlink($tempFile['path']);
				}				
			}
			else{
				array_push($tempFileListToSave,$tempFile);
			}
		}
		$pathNewTemp=Yii::$app->params['fileVaultPath']. DIRECTORY_SEPARATOR .File::GetRandomHash();
		array_push($tempFileListToSave,array('path'=>$pathNewTemp,'createDate'=>time()));
		file_put_contents($tempFileListName, serialize($tempFileListToSave));
		return $pathNewTemp;
	}
	public static function getFileSearch($model,$pageSize, $controller)
	{		
        return $controller->render('files', File::getSearchArray($model, $pageSize));			
	}

	public static function getSearchArray($model, $pageSize, $searchModelName='searchModel',$dataProviderName='dataProvider' ){
		$fileModel=new File();
		$searchModel = new FileSearch();
		$searchModel->modelName=$model->tableName();
		$searchModel->modelId=$model->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $pageSize);			
        return [
			'fileModel' => $fileModel, 
			'model' => $model, 
            $searchModelName => $searchModel,
            $dataProviderName => $dataProvider,
			];	
	}
	public static function getFileDownload($id,$teamid, $controller=null)
    {
        $file = File::findOne(['id' => $id]);
        $filePath = Yii::$app->params['fileVaultPath']. DIRECTORY_SEPARATOR .$file->hash;
		if(!file_exists ($filePath)){
			Yii::$app->session->setFlash("danger", Yii::t('app', 'Failed to download the file. Deleting it instead.'));
			return File::deletefile($id,$teamid, $controller);
		}
        return Yii::$app->response->sendFile($filePath, "$file->name");		
	}	
	public static function deletefile($id,$teamid=null, $controller=null)
    {
		$file = File::findOne(['id'=>$id]);
		$filePath = Yii::$app->params['fileVaultPath']. DIRECTORY_SEPARATOR .$file->hash;
		if (!$file->delete()) {
			Yii::$app->session->setFlash("danger", Yii::t("app", "Failed to delete"));
        }else{
			if(file_exists ($filePath)){
				unlink($filePath);
			}
			Yii::$app->session->setFlash('success', Yii::t('app', 'Successful delete'));
		}
		if($controller!=null){
			return $controller->redirect(['files','id'=>$teamid]);		
		}
	}	
	
	/**
	 * Generate a random string, using a cryptographically secure 
	 * pseudorandom number generator (random_int)
	 * 
	 * For PHP 7, random_int is a PHP core function
	 * For PHP 5.x, depends on https://github.com/paragonie/random_compat
	 * 
	 * @param int $length      How many characters do we want?
	 * @param string $keyspace A string of all possible characters
	 *                         to select from
	 * @return string
	 */
	public static function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
	{
		$pieces = [];
		$max = mb_strlen($keyspace, '8bit') - 1;
		for ($i = 0; $i < $length; ++$i) {
			$pieces []= $keyspace[random_int(0, $max)];
		}
		return implode('', $pieces);
	}
	/**
	* Guarentee a unique random hash is gotten.
	*/
	public function GetRandomHash()
	{
		$randomHash='';
		$testFile=null;
		do{
			$randomHash=File::random_str(30);
			$newFile=new File();
			$testFile = $newFile->getFileByHash($randomHash);
		}while($testFile!=null);
		return $randomHash;
	}
	public function getFile($id)
	{
		return File::findOne(['id'=>$id]);
	}
	public function getFileByHash($findHash)
	{
		return File::findOne(['hash'=>$findHash]);
	}
	public static function getAllFiles($modelName,$modelId)
    {   
        return File::find()->where(['model'=>$modelName,'itemId'=>$modelId]);
    }
    private function convertImage($originalImage, $outputImage, $quality) {

	    switch (exif_imagetype($originalImage)) {
	        case IMAGETYPE_PNG:
	            $imageTmp=imagecreatefrompng($originalImage);
	            break;
	        case IMAGETYPE_JPEG:
	            $imageTmp=imagecreatefromjpeg($originalImage);
	            break;
	        case IMAGETYPE_GIF:
	            $imageTmp=imagecreatefromgif($originalImage);
	            break;
	        case IMAGETYPE_BMP:
	            $imageTmp=imagecreatefrombmp($originalImage);
	            break;
	        // Defaults to JPG
	        default:
	            $imageTmp=imagecreatefromjpeg($originalImage);
	            break;
	    }

	    // quality is a value from 0 (worst) to 100 (best)
	    imagejpeg($imageTmp, $outputImage, $quality);
	    imagedestroy($imageTmp);

	    return 1;
	}
    private static function square_thumbnail_with_proportion($src_file,$destination_file,$square_dimensions,$jpeg_quality=90)
    {
        // Step one: Rezise with proportion the src_file *** I found this in many places.

        $src_img=imagecreatefromjpeg($src_file);

        $old_x=imageSX($src_img);
        $old_y=imageSY($src_img);

        $ratio1=$old_x/$square_dimensions;
        $ratio2=$old_y/$square_dimensions;

        if($ratio1>$ratio2)
        {
            $thumb_w=$square_dimensions;
            $thumb_h=$old_y/$ratio1;
        }
        else    
        {
            $thumb_h=$square_dimensions;
            $thumb_w=$old_x/$ratio2;
        }

        // we create a new image with the new dimmensions
        $smaller_image_with_proportions=ImageCreateTrueColor($thumb_w,$thumb_h);

        // resize the big image to the new created one
        imagecopyresampled($smaller_image_with_proportions,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 

        // *** End of Step one ***

        // Step Two (this is new): "Copy and Paste" the $smaller_image_with_proportions in the center of a white image of the desired square dimensions

        // Create image of $square_dimensions x $square_dimensions in white color (white background)
        $final_image = imagecreatetruecolor($square_dimensions, $square_dimensions);
        $bg = imagecolorallocate ( $final_image, 255, 255, 255 );
        imagefilledrectangle($final_image,0,0,$square_dimensions,$square_dimensions,$bg);

        // need to center the small image in the squared new white image
        if($thumb_w>$thumb_h)
        {
            // more width than height we have to center height
            $dst_x=0;
            $dst_y=($square_dimensions-$thumb_h)/2;
        }
        elseif($thumb_h>$thumb_w)
        {
            // more height than width we have to center width
            $dst_x=($square_dimensions-$thumb_w)/2;
            $dst_y=0;

        }
        else
        {
            $dst_x=0;
            $dst_y=0;
        }

        $src_x=0; // we copy the src image complete
        $src_y=0; // we copy the src image complete

        $src_w=$thumb_w; // we copy the src image complete
        $src_h=$thumb_h; // we copy the src image complete

        $pct=100; // 100% over the white color ... here you can use transparency. 100 is no transparency.

        imagecopymerge($final_image,$smaller_image_with_proportions,$dst_x,$dst_y,$src_x,$src_y,$src_w,$src_h,$pct);

        imagejpeg($final_image,$destination_file,$jpeg_quality);

        // destroy aux images (free memory)
        imagedestroy($src_img); 
        imagedestroy($smaller_image_with_proportions);
        imagedestroy($final_image);
    }
}
