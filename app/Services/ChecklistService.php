<?php

namespace App\Services;

use App\Models\Checklist;

class ChecklistService
{

    public function sync_checklis(Checklist $checklist, int $user_id): Checklist
    {
        $checklist = Checklist::firstOrCreate(
            [
                'user_id' => $user_id,
                'checklist_id' => $checklist->id,
            ],
            [
                'checklist_group_id' => $checklist->checklist_group_id,
                'name' => $checklist->name,
            ]
        );

        //set the updated at column to the current time whenever the user click on the checklist
        $checklist->touch();

        return $checklist;
    }
}
