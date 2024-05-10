<div class="breadcrumb-header justify-content-between">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">{{ __('Store Review') }}</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
            </div>
            <div class="card-body d-flex justify-content-between">
                @foreach ($checklists as $checklist)
                    <div class="text-center flex-grow-1 mr-3">
                        <a class="font-weight-bold"
                           href="{{ route('user.checklists.show', $checklist->id) }}">{{ $checklist->name }}</a>
                        <br>
                        <div class="progress progress-xs mt-2 mb-1">
                            @if ($checklist->tasks_count > 0)
                                <div class="progress-bar bg-success" role="progressbar"
                                     style="width: {{ $checklist->user_tasks_count / $checklist->tasks_count * 100 }}%"
                                     aria-valuenow="{{ $checklist->user_tasks_count / $checklist->tasks_count * 100 }}"
                                     aria-valuemin="0"
                                     aria-valuemax="100">
                                </div>
                            @else
                                <div class="progress-bar bg-success" role="progressbar"
                                     style="width: 0%"
                                     aria-valuenow="0"
                                     aria-valuemin="0"
                                     aria-valuemax="100">
                                </div>
                            @endif
                        </div>
                        <strong>{{ $checklist->user_tasks_count }}/{{ $checklist->tasks_count }}</strong>
                    </div>
                @endforeach
                <h2 class="mt-3">{{ $checklists->sum('user_tasks_count') }}/{{ $checklists->sum('tasks_count') }}</h2>
            </div>
        </div>
    </div>
</div>

