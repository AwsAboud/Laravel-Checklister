<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;

class ChecklistShow extends Component
{
    public $checklist;
    public $opendTasks = [];
    public $completedTasks = [];

     public function mount()
    {
        $this->completedTasks = Task::where('checklist_id', $this->checklist->id)
        ->where('user_id', auth()->id())
        ->whereNotNull('completed_at')
        ->pluck('task_id')
        ->toArray();
    }

    public function render()
    {
        return view('livewire.checklist-show');
    }

    public function toggleTask($taskId)
    {

       if(in_array($taskId, $this->opendTasks)){
        //remove taskId from the opendTasks array
        $this->opendTasks = array_diff($this->opendTasks,[$taskId]);
       } else{
        $this->opendTasks[] = $taskId;
       }
    }

    public function completeTask($taskId)
    {
        // Remember there is admin tasks and users tasks
        // The admin tasks are the tasks that user_id coulmn is null
        // Admin manage tasks while user take the tasks

        $task = Task::find($taskId);
        if($task){
            $userTask = Task::where('task_id',$taskId)->first();
            if($userTask){
                if(is_null($userTask->completed_at)){
                    $userTask->update(['completed_at' => now()]);
                }
            }
            else{
                $userTask = $task->replicate();
                $userTask['completed_at'] = now();
                $userTask['user_id'] = auth()->id();
                $userTask['task_id'] = $taskId;
                $userTask->save();
            }

            $this->dispatch('task_complete', taskId: $taskId, checklistId: $task->checklist_id);
        }
    }
}
