<?php

namespace App\Orchid\Screens;

use App\Models\ScheduleMenu;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
// use Orchid\Screen\Layout;
use Orchid\Support\Facades\Layout;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
// use Orchid\Screen\Fields\Mod;

use Orchid\Screen\Fields\Label;
use Orchid\Screen\Layouts\Rows;



class ScheduleMenuScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'schedule_menus' => ScheduleMenu::orderBy('name')->paginate(),
        ];
    }


    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Schedule Menu';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Go print')->method('print'),
        Link::make('External reference')->href('http://orchid.software'),
        ModalToggle::make('Modal window')
        ->modal('CreateUserModal')
        ->method('save'),

        ];
    }










    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::modal('taskModal', Layout::rows([
                Input::make('task.name')
                    ->title('Name')
                    ->placeholder('Enter task name')
                    ->help('The name of the task to be created.'),
            ]))
                ->title('Create Task')
                ->applyButton('Add Task'),
        ];
    }
}
