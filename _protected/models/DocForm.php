<?php
namespace app\models;

use yii\base\Model;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * LoginForm is the model behind the login form.
 */
class DocForm extends Model
{
    public $language_iso_name;

    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['language_iso_name', 'string'],
        ];
    }

    /**
     * Returns the attribute labels.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'language_iso_name' => Yii::t('app', 'Language'),
        ];
    }
	public static function getLanguages(){
		$firstChurch = Church::find()->min('id');
		return ArrayHelper::map(\app\models\Language::find()->where([
			'church_id' => $firstChurch])->orderBy("display_name_native ASC")->all(), 'iso_name', 'display_name_native');
	}
}
