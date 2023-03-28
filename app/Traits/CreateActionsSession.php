<?php

namespace App\Traits;

/*
|-----------------------------------------------
| sample session data steps
|-----------------------------------------------
$session_data = [
            "step_name"=>"IncidentReport",
            "answered_questions" => [],
            "run_action_step"=>1,
            "current_step" => 0,
            "next_step" => 1,
            "last_operation_status"=>0,
            "steps" => [
                ["action_type"=>"ask_user","value"=>"Incident Description"],
                ["action_type"=>"store_answer","value"=>["aked"=>"Incident Description","store_as"=>"incident_description"]],
                ["action_type"=>"ask_user","value"=>"Incident Location"],
                ["action_type"=>"store_answer","value"=>["aked"=>"Incident Location","store_as"=>"incident_location"]],
                ["action_type"=>"ask_user","value"=>"Other Information"],
                ["action_type"=>"store_answer","value"=>["aked"=>"Other Information","store_as"=>"other_information"]],
                ["action_type"=>"ask_user","value"=>"Send a picture, if any or send not available"],
                ["action_type"=>"store_answer","value"=>["aked"=>"Send a picture","store_as"=>"incident_image","expect"=>["type"=>"image","or_type"=>"text"]]],
                ["action_type"=>"make_incident_report","value"=>""],
                ["action_type"=>"end_steps","value"=>["text"=>"Thanks for submiting your data","next_journey"=>"GetSchedule"]],


               
            ]
        ];
        return $this->update_session($session_data);
|
|

*/


trait CreateActionsSession
{

    use HandleSession;


    public function getUserData()
    {
        $session_data = [
            "step_name"=>"getUserData",
            "answered_questions" => [],
            "run_action_step"=>1,
            "current_step" => 0,
            "next_step" => 1,
            "last_operation_status"=>0,
            "steps" => [
                ["action_type"=>"ask_user","value"=>"What's your name?"],
                ["action_type"=>"store_answer","value"=>["aked"=>"name","store_as"=>"name"]],
                ["action_type"=>"ask_user","value"=>"What's your phone number?"],
                ["action_type"=>"store_answer","value"=>["aked"=>"phone number","store_as"=>"phone"]],
                ["action_type"=>"ask_user","value"=>"What city do you live in?"],
                ["action_type"=>"store_answer","value"=>["aked"=>"city","store_as"=>"city"]],
                ["action_type"=>"end_steps","value"=>["text"=>"Thanks for submiting your data","next_journey"=>"GetScheduleMenu"]],
               

               
            ]
        ];
       

        return $this->update_session($session_data);

    }

    public function GetScheduleMenu()
    {
        $menu_message = <<<MSG
        1. Shabbat candle lighting
        2. Holidays
        3. Fasts
        4. Daily prayer
        MSG;
        $expected_options = ["1","2","3","4","5"];
        $session_data = [
            "step_name"=>"GetScheduleMenu",
            "answered_questions" => [],
            "run_action_step"=>1,
            "current_step" => 0,
            "next_step" => 1,
            "last_operation_status"=>0,
            "steps" => [
                ["action_type"=>"send_option_menu","value"=>["menu"=>$menu_message,"expected_options"=>$expected_options]],
                ["action_type"=>"check_for_expected_response","value"=>""],
                ["action_type"=>"end_steps","value"=>["text"=>"Your Schedule will be sent","next_journey"=>""]],
            ]
        ];

        return $this->update_session($session_data);

    }


    
}
