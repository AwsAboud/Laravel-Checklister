<table class="table mg-b-0 text-md-nowrap">
    <thead>
        <tr>
            <th>{{ __('Sort
            ') }}</th>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Operations') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tasks as $task)
        <tr>
            <td>
                {{-- prevent showing the up arrow for the first task in the list --}}
                @if($task->position > $task->min('position'))
                    <a wire:click.prevent="taskUp({{ $task->id }})" href="#">&uarr;</a>
                @endif
                {{-- prevent showing the down arrow for the last task in the list --}}
                @if ($task->position < $task->max('position'))
                    <a wire:click.prevent="taskDown({{ $task->id }})" href="#">&darr;</a>
                @endif
            </td>
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
