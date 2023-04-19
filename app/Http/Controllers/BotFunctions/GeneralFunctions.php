<?php
namespace App\Http\Controllers\BotFunctions;

use App\Http\Controllers\BotController;
use Illuminate\Http\Request;


class GeneralFunctions extends BotController {
    public $username;
    public $user_session_data;
    public $userphone;
    public $user_message_original;
    

    // public function __construct($phone,$username,$user_message_original="")
    // {
    //     $this->userphone = $phone;
    //     $this->username = $username;
    //     info($user_message_original);
    //     $this->user_message_original = $user_message_original;
        
    // }

    public function __construct()
    {
        parent::__construct(session()->get("request_stored"));

    }

   


    public function set_properties($value,$property)
    {
        $this->$property = $value;
    }

    public function set_session($name)
    {
        $session_data = [
            "step_name"=>$name,
            "answered_questions" => [],
            "run_action_step"=>1,
            "current_step" => 0,
            "next_step" => 1,
            "last_operation_status"=>0,
           
        ];

        return $this->update_session($session_data);
    }

    

}