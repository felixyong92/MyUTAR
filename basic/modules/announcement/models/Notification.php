<?php

namespace app\modules\announcement\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\Department;
use asinfotrack\yii2\audittrail\behaviors\AuditTrailBehavior;
/**
 * This is the model class for table "notification".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $publishDate
 * @property string $image
 * @property string $attachment
 * @property string $link
 * @property integer $status
 * @property string $dId
 *
 * @property Department $d
 */
class Notification extends ActiveRecord
{
    public $images_Temp;
    public $attachments_Temp;

    public function behaviors(){
    return [
    	// ...
    	'audittrail'=>[
    		'class'=>AuditTrailBehavior::className(),

    		// some of the optional configurations
    		'ignoredAttributes'=>['created_at','updated_at'],
    		'consoleUserId'=>1,

        'attributeOutput'=>[
				'desktop_id'=>function ($value) {
					$model = Desktop::findOne($value);
					return sprintf('%s %s', $model->manufacturer, $model->device_name);
				},
				'last_checked'=>'datetime',
			],
    	],
    	// ...
    ];
}


    public function getStatusText() {
            return $this->statusOptions[$this->status];
    }

    public function getStatusOptions() {
            return array(
                    0 => 'Active',
                    1 => 'Archived',
            );
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'dId'], 'required'],
            [['description'], 'string'],
            [['publishDate'], 'safe'],
            [['status'], 'integer'],
            [['title'], 'string', 'max' => 200],
            [['image', 'attachment'], 'string', 'max' => 1000],
            [['link'], 'string', 'max' => 255],
            [['dId'], 'string', 'max' => 20],
            [['dId'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['dId' => 'dId']],
            [['images_Temp', 'attachments_Temp'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'publishDate' => 'Publish Date',
            'image' => 'Image',
            'attachment' => 'Attachment',
            'link' => 'Link',
            'status' => 'Status',
            'dId' => 'Department',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['dId' => 'dId']);
    }
}
