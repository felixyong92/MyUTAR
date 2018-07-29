<?php

namespace app\modules\announcement\models;

use Yii;
use app\models\Department;
/**
 * This is the model class for table "event".
 *
 * @property integer $id
 * @property string $title
 * @property string $venue
 * @property string $time
 * @property string $startDate
 * @property string $endDate
 * @property string $fee
 * @property string $type
 * @property string $description
 * @property string $publishDate
 * @property string $status
 * @property string $image
 * @property string $attachment
 * @property string $dId
 *
 * @property Department $d
 */
class Event extends \yii\db\ActiveRecord
{

    public $images_Temp;
    public $attachments_Temp;

    public function getExpired(){
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $currentDate = date('Y-m-d');

        if($currentDate > $this->endDate){
            return 0;
        }else if($currentDate == $this->endDate){
            return 1;
        }else if($currentDate < $this->endDate){
            return 2;
        }
    }

    public function getExpiredText(){

       if($this->expired==0)
           return 'Archived';
       else if($this->expired==1)
           return 'Today';
       else if($this->expired==2)
           return 'Upcoming';
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

    public function getTypes() {
            return array(
                    'Competition' => 'Competition',
                    'Talk' => 'Talk',
                    'Seminar' => 'Seminar',
                    'Course' => 'Course',
                    'Workshop' => 'Workshop',
                    'Campaign/Festival' => 'Campaign/Festival',
                    'Festival' => 'Festival',
                    'Others' => 'Others',


            );
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'type', 'endDate', 'dId'], 'required'],
            [['description'], 'string'],
            [['time','publishDate', 'startDate', 'endDate'], 'safe'],
            [['title', 'type'], 'string', 'max' => 200],
            [['status'], 'integer'],
            [['venue', 'fee'], 'string', 'max' => 255],
            [['image', 'attachment'], 'string', 'max' => 1000],
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
            'venue' => 'Venue',
            'time' => 'Time',
            'startDate' => 'Start Date',
            'endDate' => 'End Date',
            'fee' => 'Fee',
            'type' => 'Type',
            'description' => 'Description',
            'publishDate' => 'Publish Date',
            'status' => 'Status',
            'image' => 'Image',
            'attachment' => 'Attachment',
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
