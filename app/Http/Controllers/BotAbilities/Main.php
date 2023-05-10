<?php

namespace App\Http\Controllers\BotAbilities;

use App\Http\Controllers\BotFunctions\GeneralFunctions as BotFunctionsGeneralFunctions;
use App\Http\Controllers\BotFunctions\TextMenuSelection;
use App\Models\ScheduleMenu;
use Illuminate\Http\Request;


class Main extends BotFunctionsGeneralFunctions implements AbilityInterface
{

    public $steps = ["begin_func", "check_for_selection", "perform_selection"];



    public function begin_func()
    {
        // echo"loozp";

        $menu_items_arr = ["Check Events", "Update Settings"];
       $obj = $this->MenuArrayToObj($menu_items_arr);


        $menu = new TextMenuSelection($obj);
        $menu->send_menu_to_user();
        $this->set_session_route("Main");
        $this->go_to_next_step();
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

        // check if response from menu is a match to any of the following
        $response = $this->user_message_original;
        if($response == "1" || $response == "Check Events")
        {
            $EventObj = new GetEvents;
            $this->change_route_name("GetEvents");
            $EventObj->begin_func();
            $this->ResponsedWith200();

        }


        if($response =="2" || $response == "Update Settings"){
            // create new object flow for updating user settings
            $UserSettings = new  UpdateUserSettings;
            $UserSettings->begin_func();

        }
    }


    function call_method($key)
    {
        $method_name = $this->steps[$key];
        $this->$method_name();
    }

    public static function test_main()
    {
        return "ok";
    }



}
