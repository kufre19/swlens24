<?php
namespace App\Http\Controllers\BotAbilities;

use App\Http\Controllers\BotAbilities\AbilityInterface;
use App\Http\Controllers\BotFunctions\GeneralFunctions;
use App\Http\Controllers\BotFunctions\TextMenuSelection;

class OnboardNewUser extends GeneralFunctions implements AbilityInterface
{

    public $steps = ["begin_func", "registerNewUserForm", "get_event_schedule"];


    public  function begin_func()
    {
        $this->set_session_route("OnboardNewUser");
        $this->go_to_next_step();
        $this->registerNewUserForm();
    }
 
    public function check_for_selection()
    {
    }

    public function perform_selection()
    {
    }

    public function call_method($key)
    {
    }

    public function checUserData()
    {
    }

    public  function registerNewUserForm()
    {
        $form_question_counter = $this->user_session_data['form_counter'];



        $questions =
            [
                "what's your name ?",
                "validate_store",
                "what's your name ?",
                "validate_store",
                "What's your phone number ?",
                "validate_store",
                "What country do you live in please enter a correct country?",
                "validate_store",
                "What city do you live in please enter a correct city?",
                "validate_store",
                "Please select your prefered language:",
                "validate_store",
            ];
        $question = $questions[$form_question_counter];
        $user = $this->userphone;
        $ask_qs = 0;


        if ($question == "validate_store") {
            // validate and store response

            switch ($form_question_counter) {
                case '1':
                    $validate = true;
                    if ($validate) {
                        // store data to sesseion
                        $this->storeAnswerToSession(["store_as" => "name"]);
                        break;
                    } else {
                        // give warning to enter correct data and repeat the question
                    }

                case "3":
                    // validate data
                    $validate = true;
                    if ($validate) {
                        // store data to sesseion
                        $this->storeAnswerToSession(["store_as" => "phone"]);
                        break;
                    } else {
                        // give warning to enter correct data and repeat the question
                    }

                case '5':
                    // validate data
                    $validate = true;
                    if ($validate) {
                        // store data to sesseion
                        $this->storeAnswerToSession(["store_as" => "country"]);
                        break;
                    } else {
                        // give warning to enter correct data and repeat the question
                    }

                case '7':
                    // validate data
                    $validate = true;
                    if ($validate) {
                        // store data to sesseion
                        $this->storeAnswerToSession(["store_as" => "city"]);
                        break;
                    } else {
                        // give warning to enter correct data and repeat the question
                    }

                case '9':
                    // validate data
                    $validate = true;
                    if ($validate) {
                        // store data to sesseion
                        if ($this->user_message_original == "1" || $this->user_message_original == "English") {
                            $this->user_message_original = "en";
                        }
                        if ($this->user_message_original == "2" || $this->user_message_original == "Espaniol") {
                            $this->user_message_original = "es";
                        }
                        $this->storeAnswerToSession(["store_as" => "lang"]);
                        break;
                    } else {
                        // give warning to enter correct data and repeat the question
                    }

                default:
                    # code...
                    break;
            }
        } else {
            // this part will form question and ask

            switch ($form_question_counter) {
                case '0':
                    $message = $this->make_text_message($question, $user);
                    $this->send_post_curl($message);
                    $ask_qs = 1;
                    break;

                case "2":

                    $message = $this->make_text_message($question, $user);
                    $this->send_post_curl($message);
                    $ask_qs = 1;
                    break;


                case '4':
                    // validate data
                    $message = $this->make_text_message($question, $user);
                    $this->send_post_curl($message);
                    $ask_qs = 1;
                    break;

                case '6':
                    // validate data
                    $message = $this->make_text_message($question, $user);
                    $this->send_post_curl($message);
                    $ask_qs = 1;
                    break;

                case '8':
                    // validate data

                    $question = $questions[$form_question_counter];
                    $this->message_user($question, $this->userphone);
                    $item =  ["English", "Espaniol"];
                    $objMenu = $this->MenuArrayToObj($item);
                    $menu = new TextMenuSelection($objMenu);
                    $menu->send_menu_to_user();
                    $ask_qs = 1;
                    break;


                    $message = $this->make_text_message($question, $user);
                    $this->send_post_curl($message);
                    $ask_qs = 1;
                    break;



                default:
                    # code...
                    break;
            }
        }





        if ($form_question_counter == 100) {
            // now store data to db and send back the info to user and send back main menu
            $this->saveUserSettingsToDb();
            $this->backToMainMenu();
            // $this->go_to_next_step();
        } else {

            $this->go_to_next_step_on_form();
            if ($ask_qs == 1) {
                $this->ResponsedWith200();
            } else {
                $this->continue_session_step();
            }
        }
    }
}
