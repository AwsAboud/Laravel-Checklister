<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
class UserTasksCounter extends Component
{
    public string $task_type;
    public int $tasks_count;

    #[On('user_tasks_counter_change')]

    // public function render()
    // {
    //     return view('livewire.user-tasks-count');
    // }

    public function recalculate_tasks($task_type, $count_change = 1)
    {
        if ($this->task_type == $task_type) {
            $this->tasks_count += $count_change;
        }
    }
}
