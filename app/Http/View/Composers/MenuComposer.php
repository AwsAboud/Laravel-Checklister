<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Services\MenuService;
class MenuComposer
{

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $menu = (new  MenuService())->getMenu();

        $view->with('adminMenu', $menu['adminMenu']);
        $view->with('userMenu', $menu['userMenu']);
        $view->with('user_tasks_menu', $menu['user_tasks_menu']);
    }
}
