<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $uId
 * @property string $uName
 * @property string $uEmail
 * @property string $uPhone
 * @property string $uPassword
 *
 * @property Feedback[] $feedbacks
 * @property Satisfaction[] $satisfactions
 */
class UserNew extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uId', 'uName', 'uEmail', 'uPhone', 'uPassword'], 'required'],
            [['uId', 'uPhone'], 'string', 'max' => 20],
            [['uName', 'uEmail'], 'string', 'max' => 255],
            [['uPassword'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uId' => 'U ID',
            'uName' => 'U Name',
            'uEmail' => 'U Email',
            'uPhone' => 'U Phone',
            'uPassword' => 'U Password',
        ];
    }
}
