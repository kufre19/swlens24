<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;
use Chatify\Facades\ChatifyMessenger as Chatify;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * @return Menu[]
     */
    public function registerMainMenu(): array
    {
        return [
            // Menu::make('Chat App')
            //     ->icon('bubble')
            //     ->url('chatify')
            //     ->permission('platform.systems.users')
            //     ->badge(function () {
            //         $unreadCount = 0;
            //         return $unreadCount;
            //     }),


            Menu::make('Broadcast Events')
                // ->title('Form controls')
                ->icon('note')
                ->route('platform.main'),

            Menu::make(' Week Portion Setting')
                // ->title('Form controls')
                ->icon('note')
                ->url('#'),

            Menu::make('Schedule Menu Settings')
                ->icon('briefcase')
                ->route('platform.schedule-menus'),

            // Menu::make('Text Editors')
            //     ->icon('list')
            //     ->route('platform.exacommentmple.editors'),


            // Menu::make('Chart tools')
            //     ->icon('bar-chart')
            //     ->route('platform.example.charts'),

            // Menu::make('Cards')
            //     ->icon('grid')
            //     ->route('platform.example.cards')
            //     ->divider(),




            Menu::make(__('User Settings'))
                ->icon('user')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access rights')),


        ];
    }

    /**
     * @return Menu[]
     */
    public function registerProfileMenu(): array
    {
        return [
            Menu::make('Profile')
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
        ];
    }
}
