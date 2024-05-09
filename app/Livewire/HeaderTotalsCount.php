<?php

namespace App\Livewire;

use App\Models\Checklist;
use Livewire\Component;
use Livewire\Attributes\On;

class HeaderTotalsCount extends Component
{
    public $checklist_group_id;

    #[On('task_complete')]

    // Responed to task_complete event
    public function updateTotals()
    {
        // Trigger a render to update the component's view
        $this->render();
    }

    public function render()
    {
        // Retrieve checklists with counts
        $checklists = Checklist::where('checklist_group_id', $this->checklist_group_id)
            ->whereNull('user_id')
             // Get the count of total admin tasks in the checklist (totlal count of checklist tasks)
            ->withCount(['tasks' => function($query){
                $query->whereNull('user_id');
            }])
             // Get the count of completed user tasks
            ->withCount(['user_tasks' => function($query){
                $query->whereNotNull('completed_at');
            }])
            ->get();

        return view('livewire.header-totals-count', compact('checklists'));
    }
}
