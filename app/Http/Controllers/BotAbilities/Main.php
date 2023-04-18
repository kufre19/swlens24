<?php
namespace App\Http\Controllers\BotAbilities;

use App\Http\Controllers\BotFunctions\GeneralFunctions as BotFunctionsGeneralFunctions;
use App\Http\Controllers\BotFunctions\TextMenuSelection;
use App\Models\ScheduleMenu;
use App\Traits\GeneralFunctions;
use App\Traits\HandleSession;
use App\Traits\MessagesType;
use App\Traits\SendMessage;

class Main extends BotFunctionsGeneralFunctions {
    use HandleSession,MessagesType,SendMessage,GeneralFunctions;

    public $steps = ["GetScheduleMenu","check_for_selection","get_event_schedule"];

    private $method_map = array();


    
   

    function call_method($key) {
        $method_name = $this->steps[$key];
        $this->$method_name();
    }
    

    public function GetScheduleMenu()
    {
        $sch_menu_model = new ScheduleMenu();
        $menu_data = $sch_menu_model->get();
        $TextMenu_obj = new TextMenuSelection($menu_data,$this->userphone,$this->username);
        $this->set_session();
        $this->go_to_next_step();
        $TextMenu_obj->send_menu_to_user();
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
        $TextMenu_obj = new TextMenuSelection($menu_data,$this->userphone,$this->username);
        $TextMenu_obj->check_expected_response($this->user_message_original);
        
        $this->go_to_next_step();
        $this->continue_session_step();

    }


    public function set_session()
    {
        $session_data = [
            "step_name"=>"Main",
            "answered_questions" => [],
            "run_action_step"=>1,
            "current_step" => 0,
            "next_step" => 1,
            "last_operation_status"=>0,
           
        ];

        return $this->update_session($session_data);
    }

    public function test()
    {
        return "test";
    }

}