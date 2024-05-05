<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;

class TasksTable extends Component
{
    public $checklist;

    public function render()
    {
        // Fetch admin tasks
        $tasks = $this->checklist->tasks()->where('user_id', NULL)->orderBy('position')->get();

        return view('livewire.tasks-table', compact('tasks'));
    }

    public function taskUp($taskId)
    {
        $task = Task::find($taskId);

        // If task exists
        if($task){
            // Find the previous task and swap positions with the current task
            Task::where('position', $task->position - 1)->update([
                'position' => $task->position,
            ]);
            // Decrement the position of the current task
            $task->decrement('position');
        }
    }

    public function taskDown($taskId)
    {
        $task = Task::find($taskId);

        // If task exists
        if($task){
            // Find the next task and swap positions with the current task
            Task::where('position', $task->position + 1)->update([
                'position' => $task->position,
            ]);
            // Increment the position of the current task
            $task->increment('position');
        }
    }
}
