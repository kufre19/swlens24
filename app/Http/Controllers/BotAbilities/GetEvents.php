<?php

namespace App\Http\Controllers\BotAbilities;

use App\Http\Controllers\BotFunctions\GeneralFunctions;
use App\Http\Controllers\BotFunctions\TextMenuSelection;
use App\Models\ScheduleMenu;




class GetEvents extends GeneralFunctions implements AbilityInterface
{

    const SPECIFIC_EVENT = "specific_event";
    const NEEDED_EVENT_DATE  = "needed_event_date";


    public $steps = ["askForEventDate", "ValidateDate", "askForSpecificEvent", "getEvent"];

    private $method_map = array();


    public function begin_func()
    {
        // $sch_menu_model = new ScheduleMenu();
        // $menu_data = $sch_menu_model->get();
        // $TextMenu_obj = new TextMenuSelection($menu_data);
        // $this->set_session_route("GetEvents");
        // $this->go_to_next_step();
        // $TextMenu_obj->send_menu_to_user();

        // firdt send buttom message to user to ask for date they want to check which is now or future date
        $this->set_session_route("GetEvents");
        $this->askForEventDate();
        $this->go_to_next_step();
        $this->ResponsedWith200();
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




    public function getEvent($params = [])
    {
        // first store any specific event needed by user
        $this->storeAnswerToSession(["store_as" => self::SPECIFIC_EVENT]);

        // Set the URL endpoint
        $url = "https://www.hebcal.com/hebcal?v=1&cfg=json&maj=on&min=on&il=es";

        // Add the current date to the URL as the default value for the "date" parameter
        $url .= "&date=" . urlencode(date($this->user_session_data['answered_questions'][self::NEEDED_EVENT_DATE]));

        // Add the city parameter to the URL
        $url .= "&city=Madrid";

        // Loop through any additional parameters and add them to the URL
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
        return info($response) ;
    }



    public function askForSpecificEvent()
    {
        $message = "Any specific event in mind?";
        $message_obj = $this->make_text_message($message, $this->userphone);
        $this->send_post_curl($message_obj);
        $this->go_to_next_step();
        $this->ResponsedWith200();
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


    public function askForEventDate()
    {
        $sample_date = date("d/m/Y");
        $message = "Please enter a date for event schedule you want to check! i.e {$sample_date}";
        $message_obj = $this->make_text_message($message, $this->userphone);
        $this->send_post_curl($message_obj);
    }

    public function ValidateDate()
    {
        // validate and retrun false if date given is fasle 
        $this->storeAnswerToSession(["store_as" => self::NEEDED_EVENT_DATE]);
        return true;
    }


    public static function runThisFunctionAnon()
    {
    }
}
