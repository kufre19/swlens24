<?php

namespace App\Http\Controllers;

use App\Models\ScheduleMenu;
use Illuminate\Http\Request;

class ScheduleMenuController extends Controller
{
    //

    public function index()
    {
        return view("platform::schedule_menu.index");
    }

    public function save(Request $request )
    {
       $schedule_model =  new ScheduleMenu();
       $schedule_model->name = $request->input("schedule");
       $schedule_model->save();

       return redirect()->back()->with("success","Added!");
    }

    public function list_menu_items()
    {
       $schedule_model =  new ScheduleMenu();
        $items = $schedule_model->get();
        return view("platform::schedule_menu.list",compact("items"));

    }

    public function edit_menu_item($id)
    {
       $schedule_model =  new ScheduleMenu();
        $item = $schedule_model->where("id",$id)->first();
        return view("platform::schedule_menu.edit",compact("item"));
        
    }

    public function save_edit_menu_item(Request $request)
    {
       $schedule_model =  new ScheduleMenu();

       $schedule_model->where("id",$request->input("id"))->update([
        "name"=>$request->input("schedule")
       ]);
       return redirect()->back()->with("success","updated!");


    }
}
