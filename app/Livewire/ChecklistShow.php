<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;
class ChecklistShow extends Component
{
    public $checklist;
    public $opendTasks = [];
    public $completedTasks = [];
    public ?Task $currentTask;

    public function mount()
    {
        $this->completedTasks = Task::where('checklist_id', $this->checklist->id)
        ->where('user_id', auth()->id())
        ->whereNotNull('completed_at')
        ->pluck('task_id')
        ->toArray();

        $this->currentTask = NULL;
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
        $this->currentTask = NULL;
       } else{
        $this->opendTasks[] = $taskId;
        $this->currentTask = Task::where('task_id', $taskId)
            ->where('user_id', auth()->id())
            ->first();

            if(!$this->currentTask){
                $this->currentTask = Task::find($taskId)->replicate();
                $this->currentTask['user_id'] = auth()->id();
                $this->currentTask['task_id'] = $taskId;
                $this->currentTask->save();
            }
       }
    }

    public function completeTask($taskId)
    {
        // Remember there is admin tasks and users tasks
        // The admin tasks are the tasks that user_id coulmn is null
        // Admin manage tasks while user take the tasks

        $task = Task::find($taskId);
        if($task){
            $userTask = Task::where('task_id',$taskId)
                ->where('user_id',auth()->id())
                ->first();

            if($userTask){
                if(is_null($userTask->completed_at)){
                    $userTask->update(['completed_at' => now()]);
                    $this->completedTasks[] = $taskId;
                    $this->dispatch('task_complete', taskId: $taskId, checklistId: $task->checklist_id);
                } else{
                    $userTask->update(['completed_at' => NULL]);
                    $this->dispatch('task_complete', taskId: $taskId, checklistId: $task->checklist_id, countChange: -1);
                }

            } else{
                $userTask = $task->replicate();
                $userTask['completed_at'] = now();
                $userTask['user_id'] = auth()->id();
                $userTask['task_id'] = $taskId;
                $userTask->save();
                $this->completedTasks[] = $taskId;
                $this->dispatch('task_complete', taskId: $taskId, checklistId: $task->checklist_id);
            }
        }
    }
    public function AddToMyDay($taskId)
    {

        $userTask = Task::where('user_id', auth()->id())
            ->where('id', $taskId)
            ->first();

        if($userTask){
            if(is_null($userTask->added_to_my_day_at)){
                $userTask->update(['added_to_my_day_at' => now()]);
                $this->dispatch('user_tasks_counter_change','my_day');
            }else{
                $userTask->update(['added_to_my_day_at' => NULL]);
                $this->dispatch('user_tasks_counter_change','my_day', -1);
            }
        }

        else{
            $userTask = Task::find($taskId)->replicate();
            $userTask['user_id'] = auth()->id();
            $userTask['task_id'] = $taskId;
            $userTask['added_to_my_day_at'] = now();
            $userTask->save();
            $this->dispatch('user_tasks_counter_change','my_day');
        }
        $this->currentTask = $userTask;
    }

}
