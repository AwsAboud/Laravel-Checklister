<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use App\Services\ChecklistService;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    public function show(Checklist $checklist)
    {
        // Sync checklist from admin
        (new ChecklistService())->sync_checklis($checklist, auth()->id());

        return view('user.checklists.show', compact('checklist'));
    }
}
