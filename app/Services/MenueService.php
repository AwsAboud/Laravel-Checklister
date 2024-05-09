<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Checklist;
use App\Models\ChecklistGroup;

class MenueService
{
    public function getMenue(): array
    {
        // Fetch only admin checklists ( when user_id is null it means that it is admin checklist )
        $menu = ChecklistGroup::with([
            'checklists' => function ($query) {
                $query->whereNull('user_id');
            },
            'checklists.tasks' => function ($query) {
                $query->whereNull('tasks.user_id');
            },
            //Check checklists model
            'checklists.user_tasks',
        ])->get();

        $groups = [];
        $last_action_at = auth()->user()->last_action_at;
        if(is_null($last_action_at)){
            $last_action_at = now()->subYears(10);
        }
        $user_checklists = Checklist::where('user_id', auth()->id());

        foreach($menu->toArray() as $group){
            if($group['checklists'] > 0){
                $group_updated_at = $user_checklists->where('checklist_group_id', $group['id'])->max('updated_at');
                $group['is_new'] = Carbon::create($group['created_at'])->greaterThan($group_updated_at);
                $group['is_updated'] = !($group['is_new'])
                    && Carbon::create($group['updated_at'])->greaterThan($group_updated_at);

                foreach($group['checklists'] as  &$checklist){
                    $checklist_updated_at = $user_checklists->where('checklist_id', $checklist['id'])->max('updated_at');
                    $checklist['is_new'] =  !($group['is_new'])
                        && Carbon::create($checklist['created_at'])->greaterThan($checklist_updated_at);
                    $checklist['is_updated'] =  !($group['is_updated']) && !($checklist['is_new'])
                        && Carbon::create($checklist_updated_at)->greaterThan($checklist_updated_at);
                    $checklist['tasks_count'] = count($checklist['tasks']);
                    $checklist['completed_tasks_count'] = count($checklist['user_tasks']);
                }
                $groups[] = $group;
            }
        }

        return [
            'userMenu' => $groups,
            'adminMenu' => $menu,
         ];
    }
}

