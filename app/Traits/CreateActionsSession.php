<?php

namespace App\Traits;

/*
|-----------------------------------------------
| sample session data
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
                ["action_type"=>"end_steps","value"=>"Thank you for submitting the incident. One of our representative will speak to you soon."],

               
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
            "step_name"=>"makeUserLogin",
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
                ["action_type"=>"ask_user","value"=>"Whatcity do you live in?"],
                ["action_type"=>"store_answer","value"=>["aked"=>"city","store_as"=>"city"]],
               
            ]
        ];

        return $this->update_session($session_data);

    }


    
}
