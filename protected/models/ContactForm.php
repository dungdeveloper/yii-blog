<?php

class ContactForm extends CFormModel {

    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    public function rules() {
        return array(
            // name, email, subject and body are required
            array('name, email, subject, body', 'required'),
            // email has to be a valid email address
            array('email', 'email'),
            // verifyCode needs to be entered correctly
            array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements()),
        );
    }

    public function attributeLabels() {
        return array(
            'verifyCode' => 'Verification Code',
        );
    }
    
    /**
     * Send contact to admin 
     */
    public function send() {
        $to = Yii::app()->params['adminEmail'];
        $subject = $this->subject;
        $message = $this->body;
        @mail($to, $subject, $message);
        return true;
    }

}