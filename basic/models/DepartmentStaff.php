<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "department_staff".
 *
 * @property string $dsId
 * @property string $dsName
 * @property string $dsEmail
 * @property string $dsPassword
 * @property string $dId
 *
 * @property Department $d
 */
class DepartmentStaff extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'department_staff';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dsId', 'dsName', 'dsEmail', 'dsPassword', 'dId'], 'required'],
            [['dsId', 'dId'], 'string', 'max' => 20],
            [['dsName', 'dsEmail', 'dsPassword'], 'string', 'max' => 100],
            [['dId'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['dId' => 'dId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dsId' => 'Ds ID',
            'dsName' => 'Ds Name',
            'dsEmail' => 'Ds Email',
            'dsPassword' => 'Ds Password',
            'dId' => 'D ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getD()
    {
        return $this->hasOne(Department::className(), ['dId' => 'dId']);
    }
}
