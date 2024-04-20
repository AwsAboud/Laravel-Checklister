<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Checklist;
use App\Models\Task;

class TaskController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request, Checklist $checklist)
    {
        $checklist->tasks()->create($request->validated());
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
        $task->delete();
        return redirect()->route('admin.checklist-groups.checklists.edit', [
            $checklist->checklist_group_id, $checklist
        ]);
    }
}
