<?php

namespace app\modules\staff\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;
use app\models\Department;
/**
 * This is the model class for table "department_staff".
 *
 * @property string $dsId
 * @property string $dsName
 * @property string $dsEmail
 * @property string $dsPassword
 * @property string $dsRole
 * @property string $dId
 *
 * @property Department $d
 */
class Staff extends \yii\db\ActiveRecord implements IdentityInterface
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
            [['dsId', 'dsName', 'dsEmail', 'dsPassword', 'dsResponsibility', 'dId'], 'required'],
			[['dsId', 'dsEmail'], 'unique'],
			[['dsPassword'], 'string', 'min' => 6],
            [['dsId'], 'string', 'max' => 20],
			[['dsId'],'match', 'pattern' => '/^[a-zA-Z\s]+$/','message' => 'Staff ID is invalid. Enter Alphabet Characters Only'],
			[['dsName'],'match', 'pattern' => '/^[a-zA-Z\s]+$/','message' => 'Name is invalid. Enter Alphabet Characters Only'],
			[['dsName'], 'string', 'max' => 100],
			[['dsEmail'], 'string', 'max' => 100],
			[['dsPassword'], 'string', 'max' => 100],
			[['dsResponsibility'], 'string', 'max' => 255],
            [['dId'], 'string', 'max' => 20],
            [['dId'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['dId' => 'dId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dsId' => 'Staff ID',
            'dsName' => 'Name',
            'dsEmail' => 'Email Address',
            'dsPassword' => 'Password',
            'dsResponsibility' => 'Responsibilities',
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
	
	/** INCLUDE USER LOGIN VALIDATION FUNCTIONS**/
        /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
/* modified */
    public static function findIdentityByAccessToken($token, $type = null)
    {
          return static::findOne(['access_token' => $token]);
    }
 
/* removed
    public static function findIdentityByAccessToken($token)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
*/
    /**
     * Finds user by dsId
     *
     * @param  string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['dsId' => $username]);
    }

    /**
     * Finds user by password reset token
     *
     * @param  string      $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = \Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        //return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->dsPassword === sha1($password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
	 * @return string $hashPassword
     */
    public function setPassword($password)
    {
        $this->dsPassword = sha1($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Security::generateRandomKey();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Security::generateRandomKey() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    /** EXTENSION MOVIE **/
}
