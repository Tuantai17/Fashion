<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Menu;

class MainMenu extends Component
{
    public $menu_list;

    public function __construct()
    {
        $this->menu_list = Menu::with('menu')
            ->where([
                ['parent_id', '=', 0],
                ['position', '=', 'mainmenu'],
                ['status', '=', 1],
            ])
            ->orderBy('sort_order', 'asc')
            ->get();
    }

    public function render()
    {
        return view('components.main-menu');
    }
}