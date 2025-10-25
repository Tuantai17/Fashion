<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Menu;

class MainMenuItem extends Component
{
    public $menuitem;

    public function __construct(Menu $menuitem)
    {
        $this->menuitem = $menuitem;
    }

    public function render()
    {
        return view('components.main-menu-item');
    }
}