<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Services\MenueService;
class MenuComposer
{

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $menue = (new  MenueService())->getMenue();

        $view->with('adminMenu', $menue['adminMenu']);
        $view->with('userMenu', $menue['userMenu']);
    }
}
