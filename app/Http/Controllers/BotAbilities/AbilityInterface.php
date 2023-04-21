<?php

namespace App\Http\Controllers\BotAbilities;


interface AbilityInterface {
    
    public function begin_func();
    public function check_for_selection();
    public function perform_selection();
    public function call_method($key);
}