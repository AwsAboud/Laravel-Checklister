<table class="table mg-b-0 text-md-nowrap" wire:sortable="updateTaskOrder">
    <thead>
        <tr>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Operations') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tasks as $task)
        <tr wire:sortable.item="{{ $task->id }}" wire:key="task-{{ $task->id }}">
            <td> {{$task->name}} </td>
            <td>
                 {{-- Edit --}}
                <a href="{{ route('admin.checklists.tasks.edit', [$checklist, $task]) }}"
                    class="btn btn-primary  btn-sm" >
                    {{ __('Edit') }}
                </a>
                 {{-- Delete --}}
                <form style="display: inline-block" action="{{ route('admin.checklists.tasks.destroy', [$checklist, $task]) }}" method="POST">
                    @csrf
                    @method('delete')
                        <div>
                            <button type="submit" class="btn btn-danger  btn-sm"
                            onclick="return confirm('{{ __('Are you sure yo whant to delete this ?')}}')">{{ __('Delete') }}</button>
                        </div>
                    </div>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
