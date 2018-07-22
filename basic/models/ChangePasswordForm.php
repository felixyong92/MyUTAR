<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * Change password form for current user only
 */
class ChangePasswordForm extends Model
{
    public $id;
	public $name;
	public $oldpassword;
    public $password;
    public $confirm_password;
 
    /**
     * @var \common\models\User
     */
    private $_user;
 
    /**
     * Creates a form model given a token.
     *
     * @param  string                          $token
     * @param  array                           $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($id, $config = [])
    {
        $this->_user = User::findIdentity($id);
        
        if (!$this->_user) {
            throw new InvalidParamException('Unable to find user!');
        }
        
        $this->id = $this->_user->id;
		$this->name = $this->_user->dsName;
        parent::__construct($config);
    }
 
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['oldpassword','password','confirm_password'], 'required'],
            [['password','confirm_password'], 'string', 'min' => 6],
			['oldpassword','findPasswords'],
            ['confirm_password', 'compare', 'compareAttribute' => 'password'],
        ];
    }
	
	/**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
			'oldpassword' => 'Old Password',
            'password' => 'New Password',
            'confirm_password' => 'Confirm New Password',
        ];
    }
	
	/**
     * find password.
     *
     * @return boolean if password was changed.
     */
	public function findPasswords($attribute, $params){
        $user = User::find()->where([
           'dsId'=>Yii::$app->user->identity->dsId
        ])->one();
        $password = $user->dsPassword;
        if($password!=sha1($this->oldpassword))
            $this->addError($attribute,'Old Password is incorrect');
    }
 
    /**
     * Changes password.
     *
     * @return boolean if password was changed.
     */
    public function changePassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
 
        return $user->save(false);
    }
}