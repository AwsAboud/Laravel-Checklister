<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class CompletedTasksCounter extends Component
{
    public $completed_tasks = 0;
    public $tasks_count = 0;
    public $checklist_id;

    #[On('task_complete')]

    public function recalculate_tasks($taskId, $checklistId, $countChange = 1)
    {
        if ($checklistId == $this->checklist_id) {
            $this->completed_tasks += $countChange;
        }

    }
}
