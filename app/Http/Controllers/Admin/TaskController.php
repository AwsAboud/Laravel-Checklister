<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use App\Models\Checklist;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;

class TaskController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request, Checklist $checklist)
    {
        //Admin tasks are those where the user_id column is null.
        //For admin tasks determine the highest position and increment by 1
        $position =  $checklist->tasks()->where('user_id', NULL)->max('position') + 1;
        //Assign the calculated position to the created task
        $checklist->tasks()->create($request->validated() + ['position' => $position]);

        return redirect()->route('admin.checklist-groups.checklists.edit', [
            $checklist->checklist_group_id, $checklist
        ]);
    }

    public function edit(Checklist $checklist, Task $task)
    {
        return view('admin.tasks.edit',compact(['checklist','task']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTaskRequest  $request, Checklist $checklist, Task $task)
    {
        $task->update($request->validated());

        return redirect()->route('admin.checklist-groups.checklists.edit', [
            $checklist->checklist_group_id, $checklist
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Checklist $checklist,Task $task)
    {
        // Reorder the admin tasks before deleting a spesifec task,
        $checklist->tasks()
            ->where('user_id', NULL)
            ->where('position', '>', $task->position)
            ->decrement('position', 1);
        $task->delete();

        return redirect()->route('admin.checklist-groups.checklists.edit', [
            $checklist->checklist_group_id, $checklist
        ]);
    }
}
