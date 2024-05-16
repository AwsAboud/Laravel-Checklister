<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Checklist;
use App\Models\ChecklistGroup;
use App\Models\Task;

class MenuService
{
    public function getMenu(): array
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
            'checklists.user_completed_tasks',
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
                    $checklist['completed_tasks_count'] = count($checklist['user_completed_tasks']);
                }
                $groups[] = $group;
            }
        }

        $user_tasks_menu = [];
        if(! auth()->user()->is_admin){
            // Retrieve all user tasks to count 'My Day', 'Important', and 'Planned' tasks
            // We utilize collection methods on user_tasks to avoid querying the database each time
            $user_tasks = Task::where('user_id', auth()->id())->get();
            $user_tasks_menu = [
                'my_day' => [
                    'name' => __('My Day'),
                    'icon' => 'sun',
                    'tasks_count' => $user_tasks->whereNotNull('added_to_my_day_at')->count(),
                ],
                'important' => [
                    'name' => __('Important'),
                    'icon' => 'star',
                    'tasks_count' => $user_tasks->where('is_important',1)->count(),
                ],
                'planned' => [
                    'name' => __('Planned'),
                    'icon' => 'calender',
                    'tasks_count' => $user_tasks->whereNotNull('due_date')->count(),
                ],
            ];

        }

        return [
            'userMenu' => $groups,
            'adminMenu' => $menu,
            'user_tasks_menu' => $user_tasks_menu
         ];
    }
}

