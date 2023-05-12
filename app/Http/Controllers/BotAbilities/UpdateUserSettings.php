<?php

namespace App\Http\Controllers\BotAbilities;


use App\Http\Controllers\BotAbilities\AbilityInterface;
use App\Http\Controllers\BotFunctions\GeneralFunctions;
use App\Models\WaUser;
use Psy\Exception\BreakException;
use App\Http\Controllers\BotFunctions\TextMenuSelection;

class UpdateUserSettings extends GeneralFunctions implements AbilityInterface
{

    public $steps = ["begin_func", "check_for_user_setting", "update_settings"];

    public function begin_func()
    {
        $this->set_session_route("UpdateUserSettings");
        $this->go_to_next_step();
        $this->check_for_user_setting();
    }

    public function check_for_selection()
    {
    }

    public function perform_selection()
    {
        // info("here");
    }


    function call_method($key)
    {
        $method_name = $this->steps[$key];
        $this->$method_name();
    }

    public function check_for_user_setting()
    {
        $user_model = new WaUser();
        $user = $user_model->where("whatsapp_id", $this->userphone)->first();

        if ($user['name'] == "" && $user['country'] == "" && $user['city'] == "" && $user["number"] == "") {
            $str = "You have no settings to update, please respond to the questions  correctly to create your account settings";
            $message = $this->make_text_message($str);
            $this->send_post_curl($message);
            $this->go_to_next_step();
            $this->update_settings();

            // then start creating new user settings

        } else {
            // just show settings and then call method do start 
            $this->show_settings();
            $this->go_to_next_step();
            $message = "you can skip any info you don't want to update by typing 'skip' or 'no' ";
            $message_obj = $this->make_text_message($message, $this->userphone);
            $this->send_post_curl($message_obj);
            $this->update_settings();

        }
    }

   
    public function update_settings()
    {
        // form
        $form_counter = $this->user_session_data['form_counter'];
        $ask_qs = 0;
        if(isset($this->user_message_lowered))
        {
            if($this->user_message_lowered == "no" || $this->user_message_lowered == "skip")
            {
                $this->go_to_next_step_on_form();
                $ask_qs = 1;
                return $this->continue_session_step();
            }
        }
       
        switch ($form_counter) {
            case '0':

                $qs = "Please enter your name:";
                $this->message_user($qs, $this->userphone);
                $ask_qs = 1;
                break;
            case "1":
                $this->storeAnswerToSession(["store_as" => "name"]);
                break;
            case "2":
                $qs = "Please enter your number:";
                $this->message_user($qs, $this->userphone);
                $ask_qs = 1;

                break;
            case "3":
                $this->storeAnswerToSession(["store_as" => "number"]);
                break;
            case "4":
                $qs = "Please enter your country:";
                $this->message_user($qs, $this->userphone);
                $ask_qs = 1;

                break;
            case "5":
                $this->storeAnswerToSession(["store_as" => "country"]);
                break;
            case "6":
                $qs = "Please enter your city:";
                $this->message_user($qs, $this->userphone);
                $ask_qs = 1;
                break;
            case "7":
                $this->storeAnswerToSession(["store_as" => "city"]);
                break;
            case "8":
                $qs = "Please select your prefered language:";
                $this->message_user($qs, $this->userphone);
                $item =  ["English","Espaniol"];
                $objMenu = $this->MenuArrayToObj($item);
                $menu = new TextMenuSelection($objMenu);
                $menu->send_menu_to_user();
                $ask_qs = 1;
                break;
            case "9":
                $item =  ["English","Espaniol"];
                $objMenu = $this->MenuArrayToObj($item);
                $menu = new TextMenuSelection($objMenu);
                $menu->check_expected_response($this->user_message_original);
                
                break;
            case "10":
                if($this->user_message_original == "1" || $this->user_message_original == "English")
                {
                    $this->user_message_original = "en";
                }
                if($this->user_message_original == "2" || $this->user_message_original == "Espaniol")
                {
                    $this->user_message_original = "es";
                }
                $this->storeAnswerToSession(["store_as" => "lang"]);
                break;
            default:
                # code...
                break;
        }

        if($form_counter == 10)
        {
            // now store data to db and send back the info to user and send back main menu
            $this->saveUserSettingsToDb();
            $this->show_settings();
            $this->backToMainMenu();
            // $this->go_to_next_step();
        }else{

            $this->go_to_next_step_on_form();
            if($ask_qs == 1)
            {
                $this->ResponsedWith200();
            }else{
                $this->continue_session_step();
            }
        }


    }

    public function show_settings(){
        $user_model = new WaUser();
        $user = $user_model->where("whatsapp_id", $this->userphone)->first();
        $text = <<<MSG
        Name: {$user['name']}
        Number: {$user['number']}
        Country: {$user['country']}
        City: {$user['city']}
        Language: {$user['lang']}
        MSG;

        $message = $this->make_text_message($text,$this->userphone);
        $this->send_post_curl($message);
    }

    


    public static function runThisFunctionAnon()
    {
        
    }
}
