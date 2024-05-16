<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">{{ $checklist->name }}</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
            </div>
            <div class="card-body">
                <table class="table mg-b-0 text-md-nowrap">
                    <tbody>
                        @foreach ($checklist->tasks->where('user_id', NULL) as $task)
                        <tr>
                            <td> <input type="checkbox" wire:click="completeTask({{$task->id}})"
                                @if (in_array($task->id, $completedTasks)) checked="checked" @endif> </td>
                            <td wire:click="toggleTask({{$task->id}})">{{ $task->name }} </td>
                            <td wire:click="toggleTask({{$task->id}})">
                                @if (in_array($task->id, $opendTasks))
                                    <svg  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                    </svg>
                                @else
                                    <svg  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708z"/>
                                    </svg>
                                @endif
                            </td>
                            <td>
                                @if(optional($checklist->user_tasks()->where('task_id', $task->id)->first())->is_important)
                                    <a wire:click.prevent="markTaskAsImportant({{ $task->id }})" href="#">&starf;</a>
                                @else
                                <a wire:click.prevent="markTaskAsImportant({{ $task->id }})" href="#">&star;</a>
                                @endif
                            </td>
                        </tr>
                        @if (in_array($task->id, $opendTasks))
                            <tr>
                                <td></td>
                                <td colspan="2"> {!! $task->description !!}</td>
                            </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        @if (!is_null($currentTask))
            <div class="card">
                <div class="card-body">
                    <div class="float-right">
                        @if($currentTask->is_important)
                                    <a wire:click.prevent="markTaskAsImportant({{ $task->id }})" href="#">&starf;</a>
                                @else
                                <a wire:click.prevent="markTaskAsImportant({{ $task->id }})" href="#">&star;</a>
                                @endif
                    </div>
                    <b>{{ $currentTask->name }}</b>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    &#9788;
                    &nbsp;
                    @if ($currentTask->added_to_my_day_at)
                        <a wire:click.prevent="AddToMyDay({{ $currentTask->id }})" href="#">{{ __('Remove from My Day') }}</a>
                    @else
                        <a wire:click.prevent="AddToMyDay({{ $currentTask->id }})" href="#">{{ __('Add to My Day') }}</a>
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    &#9993;
                    &nbsp;
                    <a href="#">{{ __('Remind me') }}</a>
                    <hr />
                    &#9745;
                    &nbsp;
                    <a href="#">{{ __('Add Due Date') }}</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    &#9998;
                    &nbsp;
                    <a href="#">{{ __('Note') }}</a>
                </div>
            </div>
        @endif
    </div>
</div>
