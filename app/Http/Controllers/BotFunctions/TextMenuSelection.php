<?php

namespace App\Http\Controllers\BotFunctions;

use App\Traits\MessagesType;
use App\Traits\SendMessage;

class TextMenuSelection extends GeneralFunctions
{
    use MessagesType,SendMessage;

    public $expected_responses = [];
    public $mapped_responses = [];
    public $menu_data;
    public $menu_as_text;

    public function __construct(mixed $menu_data,$phone,$username)
    {
        parent::__construct($phone,$username);
        $this->menu_data = $menu_data;
        $this->make_menu_data();
    }

    public function send_menu_to_user()
    {
        $text = $this->make_text_message($this->menu_as_text);
        $send = $this->send_post_curl($text);
        $this->ResponsedWith200();

    }

    public function make_menu_data()
    {
        $counter = 1;
        foreach($this->menu_data as $item)
        {
            array_push($this->expected_responses,$item['name']);
            $this->map_response_to_data($item['name'],$item['name']);
            array_push($this->expected_responses,$counter);
            $this->map_response_to_data($item['name'],$counter);
            $this->menu_as_text .="{$counter }. ". $item['name']. "\n";
            // should come last
            $counter++;

        }

    }

    public function map_response_to_data($data,$response)
    {
        $this->mapped_responses[$response] = $data;
        return true;
    }

    public function check_expected_response($response)
    {
        if(!in_array($response,$this->expected_responses))
        {
            info($response);
            $message = "Please select from the menu given!";
            $text = $this->make_text_message($message);
            $send = $this->send_post_curl($text);
            return $this->ResponsedWith200();
        }

        return true;
    }

    public function get_selected_item($response)
    {
        $selected_item = $this->mapped_responses[$response];
        return $selected_item;
    }
}
