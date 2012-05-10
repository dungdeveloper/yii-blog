<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    private $_id;
    public $email;

    public function __construct($email, $password) {
        $this->email = $email;
        $this->password = $password;
    }

    public function getId() {
        return $this->_id;
    }

    public function authenticate() {
        $user = User::model()->findByAttributes(array('email'=>$this->email));
        
        if (is_null($user))
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if (! $user->checkPassword($this->password))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else {
            $this->username = $user->username;
            $this->_id = $user->id;
            $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

}