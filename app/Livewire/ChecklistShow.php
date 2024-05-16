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
    public $dueDateOpened = FALSE;
    public $dueDate;

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
            ->where(function($query) use ($taskId){
                $query->where('id',$taskId)
                    ->orWhere('task_id',$taskId);
            })
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

    public function markTaskAsImportant($taskId)
    {
        $userTask = Task::where('user_id', auth()->id())
            ->where(function ($query) use ($taskId) {
                $query->where('id', $taskId)
                    ->orWhere('task_id', $taskId);
            })
            ->first();

        if($userTask){
            if($userTask->is_important){
                $userTask->update(['is_important' => FALSE]);
                $this->dispatch('user_tasks_counter_change','important',-1);

            }else{
                $userTask->update(['is_important' => TRUE]);
                $this->dispatch('user_tasks_counter_change','important');
            }
        }

        else{
            $task = Task::find($taskId);
            $userTask = $task->replicate();
            $userTask['user_id'] = auth()->id();
            $userTask['task_id'] = $taskId;
            $userTask['is_important'] = TRUE;
            $userTask->save();
            $this->dispatch('user_tasks_counter_change','important');
        }
        $this->currentTask = $userTask;
    }

    public function toggleDueDate()
    {
        $this->dueDateOpened = !$this->dueDateOpened;
    }

    public function setDueDate($taskId, $dueDate = NULL)
    {
        $userTask = Task::where('user_id', auth()->id())
            ->where(function ($query) use ($taskId) {
                $query->where('id', $taskId)
                    ->orWhere('task_id', $taskId);
            })
            ->first();

        if ($userTask) {
            if (is_null($dueDate)) {
                $userTask->update(['due_date' => NULL]);
                $this->dispatch('user_tasks_counter_change','planned',-1);
            } else {
                $userTask->update(['due_date' => $dueDate]);
                $this->dispatch('user_tasks_counter_change', 'planned');
            }
        } else {
            $task = Task::find($taskId);
            $userTask = $task->replicate();
            $userTask['user_id'] = auth()->id();
            $userTask['task_id'] = $taskId;
            $userTask['due_date'] = $dueDate;
            $userTask->save();
            $this->dispatch('user_tasks_counter_change', 'planned');
        }
        $this->currentTask = $userTask;

    }

    //This method called automaticly when the change of $dueDate attribute (it will called after picking a date from the date picker)
    public function updatedDueDate($value)
    {
        dd('called');
        $this->setDueDate($this->currentTask->id, $value);
    }
}
