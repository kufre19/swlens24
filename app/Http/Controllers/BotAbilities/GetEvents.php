<?php

namespace App\Http\Controllers\BotAbilities;

use App\Http\Controllers\BotFunctions\GeneralFunctions;
use App\Http\Controllers\BotFunctions\TextMenuSelection;
use App\Models\ScheduleMenu;




class GetEvents extends GeneralFunctions implements AbilityInterface
{


    public $steps = ["GetScheduleMenu", "check_for_selection", "get_event_schedule"];

    private $method_map = array();


    public function begin_func()
    {
        $sch_menu_model = new ScheduleMenu();
        $menu_data = $sch_menu_model->get();
        $TextMenu_obj = new TextMenuSelection($menu_data);
        $this->set_session_route("GetEvents");
        $this->go_to_next_step();
        $TextMenu_obj->send_menu_to_user();
        
    }


    function call_method($key)
    {
        $method_name = $this->steps[$key];
        $this->$method_name();
    }


   
    public function get_event_schedule()
    {
        $event = "Event is at 12pm";
        $text = $this->make_text_message($event);
        $this->send_post_curl($text);
        $this->ResponsedWith200();
    }

    public function check_for_selection()
    {
        $sch_menu_model = new ScheduleMenu();
        $menu_data = $sch_menu_model->get();
        $TextMenu_obj = new TextMenuSelection($menu_data, $this->userphone, $this->username);
        $TextMenu_obj->check_expected_response($this->user_message_original);

        $this->go_to_next_step();
        $this->continue_session_step();
    }


    public function perform_selection()
    {
        
    }



    public static function getEvent($params)
    {
        // Set the URL endpoint
        $url = "https://www.hebcal.com/hebcal?v=1&cfg=json";

        // Loop through the parameters and add them to the URL
        foreach ($params as $key => $value) {
            $url .= "&" . $key . "=" . urlencode($value);
        }

        // Initialize cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the request
        $response = curl_exec($ch);

        // Close the cURL session
        curl_close($ch);

        // Return the response
        return json_decode($response, true);
    }

    // public function test()
    // {
    //     return "test";
    // }


    public static function getGeonameId($city, $country)
    {
        // Replace YOUR_USERNAME with your Geonames API username
        $username = "YOUR_USERNAME";

        // Set up the API endpoint URL
        $url = "http://api.geonames.org/searchJSON?q=" . urlencode($city) . "&country=" . urlencode($country) . "&maxRows=1&username=" . $username;

        // Initialize a cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the request
        $response = curl_exec($ch);

        // Close the cURL session
        curl_close($ch);

        // Parse the JSON response
        $data = json_decode($response, true);

        // Return the geoname ID (if found)
        if (isset($data['geonames'][0]['geonameId'])) {
            return $data['geonames'][0]['geonameId'];
        } else {
            return null;
        }
    }
}
