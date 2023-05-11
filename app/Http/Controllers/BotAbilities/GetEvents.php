<?php

namespace App\Http\Controllers\BotAbilities;

use App\Http\Controllers\BotFunctions\GeneralFunctions;
use App\Http\Controllers\BotFunctions\TextMenuSelection;
use App\Models\ScheduleMenu;
use App\Models\WaUser;
use DateTime;

class GetEvents extends GeneralFunctions implements AbilityInterface
{

    const SPECIFIC_EVENT = "specific_event";
    const NEEDED_EVENT_DATE  = "needed_event_date";


    public $steps = ["askForEventDate", "ValidateDate", "askForSpecificEvent","validateSpecificEvent", "getEvent"];

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

    public function getUSerData()
    {
        $waUserModel = new WaUser();
        $user = $waUserModel->where("whatsapp_id", $this->userphone)->first();

        // check if required data are available 
        if ($user->city == "") {
            // go and ask user to register the info
        }

        return $user;
    }




    public function getEvent($params = [])
    {
       
        $user = $this->getUSerData();

        // Set the URL endpoint
        $url = "https://www.hebcal.com/hebcal?v=1&cfg=json&maj=on&min=on";

        // Add the current date to the URL as the default value for the "date" parameter
        $url .= "&start=" . urlencode(date("Y-m-d"));
        $url .= "&end=" . urlencode(date($this->user_session_data['answered_questions'][self::NEEDED_EVENT_DATE]));

        $url .= "&lg=" . urlencode($user->lang);


        // Add the city parameter to the URL
        $url .= "&city=" . urlencode($user->city);

        // Loop through any additional parameters and add them to the URL
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $url .= "&" . $key . "=" . urlencode($value);
            }
        }

        // Initialize cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the request
        $response = curl_exec($ch);

        // Close the cURL session

        $arrayed_response = json_decode($response, true);
      


        $events = $arrayed_response['items'];
        


        // try to use regex to find a specific event else display the rest
        if (!empty($events)) {
            $matchingEvents = [];
            if ($this->user_session_data['answered_questions'][self::SPECIFIC_EVENT] != "") {
                $specified = $this->user_session_data['answered_questions'][self::SPECIFIC_EVENT];
                info($specified);
                foreach ($events as $item) {
                    $title = $item['title'];
                    if (preg_match("/\b$specified\b/i", $title)) {
                        array_push($matchingEvents, $item);
                    }
                }
            }
        } else {
            // tell user  that event not found for date given and end chat!
        }



        // Return the response
        curl_close($ch);
        if(!empty($matchingEvents))
        {
            $this->showUserEvents($matchingEvents);
        }else {
            $text = "Sorry no events matched the one you specified but please see events for the date provided";
            $message = $this->make_text_message($text, $this->userphone);
            $this->send_post_curl($message);
            $this->showUserEvents($events);

        }

        return $this->ResponsedWith200();
    }


    public function showUserEvents($events)
    {
        foreach ($events as $key => $event) {
            $text = "";
            $memo = "";
            if (isset($event['memo'])) {
                $memo = $event['memo'];
            }
            $pos = strpos($event['title'], ':');
            if ($pos !== false) {
                $title = substr($event['title'], 0, $pos);
            }else{
                $title = $event['title'];
            }
            $text .= "Event: {$title} {$memo}" . PHP_EOL;
            $time = $event['date'];
            $dateTime = new DateTime($time);
            $formattedDate = $dateTime->format('l g:i A');
            $text .= "Date: {$formattedDate}" . PHP_EOL;
            $text .= "Hebrew: {$event['hebrew']}" . PHP_EOL;


            $message = $this->make_text_message($text, $this->userphone);
            $this->send_post_curl($message);
        }
    }



    public function askForSpecificEvent()
    {
        $message = "please enter a specific event if you have any in mind, or simply type 'no'";
        $message_obj = $this->make_text_message($message, $this->userphone);
        $this->send_post_curl($message_obj);
        $this->go_to_next_step();
        $this->ResponsedWith200();
    }




    public function askForEventDate()
    {
        $sample_date = date("Y-m-d");
        $message = "Please enter a date for event schedule you want to check in the given format! i.e {$sample_date}";
        $message_obj = $this->make_text_message($message, $this->userphone);
        $this->send_post_curl($message_obj);
    }

    public function ValidateDate()
    {
        // validate and retrun false if date given is fasle 
        $valid = true;

        // Create a DateTime object from the date string
        $date = DateTime::createFromFormat('Y-m-d', $this->user_message_original);

        // Check if the date string matched the format 'YYYY-MM-DD'
        if ($date && $date->format('Y-m-d') === $this->user_message_original) {
            $valid = true;
        } else {
            // tell user to give proper date and end chat
            $valid = false;
        }


        if ($valid) {

            $this->storeAnswerToSession(["store_as" => self::NEEDED_EVENT_DATE]);
            $this->go_to_next_step();
            $this->continue_session_step();
        }
    }

    public function validateSpecificEvent ()
    {
        $intent = ["no","nope",];

        if(in_array($this->user_message_lowered,$intent))
        {
            $this->user_message_original = "";
        }else{
             // first store any specific event needed by user
            $this->storeAnswerToSession(["store_as" => self::SPECIFIC_EVENT]);
            $this->go_to_next_step();
            $this->continue_session_step();
        }
    }


    public static function runThisFunctionAnon()
    {
    }
}
