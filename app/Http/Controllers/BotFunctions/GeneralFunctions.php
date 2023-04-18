<?php
namespace App\Http\Controllers\BotFunctions;




class GeneralFunctions {
    public $username;
    public $user_session_data;
    public $userphone;
    public $user_message_original;
    

    public function __construct($phone,$username,$user_message_original="")
    {
        $this->userphone = $phone;
        $this->username = $username;
        info($user_message_original);
        $this->user_message_original = $user_message_original;
        
    }


    public function set_properties($value,$property)
    {
        $this->$property = $value;
    }
    

}