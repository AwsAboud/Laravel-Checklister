@extends('layouts.master')
@section('css')
    <!--  Owl-carousel css-->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet" />
    <!-- Maps css -->
    <link href="{{ URL::asset('assets/plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">{{ __('Manage Checklist') }}</h2>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
@endsection
@section('content')
{{-- ERROR BAGE --}}
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

    @if ($errors->storeTask->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->storeTask->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- row -->
    <div class="row row-sm">
        {{-- edit checklist --}}
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card  box-shadow-0">
                <div class="card-header">
                    <h4 class="card-title mb-1">{{ __('Edit Checklist') }}</h4>
                </div>
                <div class="card-body pt-0">

                    <form class="form-horizontal" action="{{ route('admin.checklist-groups.checklists.update', [$checklistGroup, $checklist]) }}" method="POST">
                        @csrf
                        @method('patch')
                        <div class="form-group">
                            <label for="">{{ __('Name') }}</label>
                            <input type="text" value="{{$checklist->name}}" class="form-control" id="inputName" name="name" required>
                        </div>
                        <div class="form-group mb-0 mt-3 justify-content-end">
                            <div>
                                <button type="submit" class="btn btn-primary">{{ __('Save Checklist') }}</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        {{-- delete checklist --}}
        <div class="col-lg-12 col-xl-12 col-md-8 col-sm-8">
            <div class="card  box-shadow-0">
                <div class="card-header">
                    <h4 class="card-title mb-1">{{ __('Delete Checklist') }}</h4>
                </div>
                <div class="card-body pt-0">

                    <form class="form-horizontal" action="{{ route('admin.checklist-groups.checklists.destroy', [$checklistGroup, $checklist]) }}" method="POST">
                        @csrf
                        @method('delete')
                        <div class="form-group">
                            <label for="">{{ __('Name') }}</label>
                            <input type="text" value="{{$checklist->name}}" class="form-control" id="inputName" name="name"  readonly>
                        </div>
                        <div class="form-group mb-0 mt-3 justify-content-end">
                            <div>
                                <button type="submit" class="btn btn-danger"
                                onclick="return confirm('{{ __('Are you sure yo whant to delete this ?')}}')">{{ __('Delete Checklist') }}</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        </hr>
        {{-- tasl table --}}
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">{{ __('List Of Tasks') }}</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mg-b-0 text-md-nowrap">
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Operations') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($checklist->tasks as $task)
                                <tr>
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
                    </div>
                </div>
            </div>
        </div>
        {{-- New Task --}}
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card  box-shadow-0">
                <div class="card-header">
                    <h4 class="card-title mb-1">{{ __('New Tasks') }}</h4>
                </div>
                <div class="card-body pt-0">
                    <form class="form-horizontal" action="{{ route('admin.checklists.tasks.store', [$checklist]) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">{{ __('Name') }}</label>
                            <input type="text" value="{{old('name')}}" class="form-control" id="task_name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('Description') }}</label>
                            <textarea type="text" class="form-control" id="descreption" name="description" rows="5" >{{old('description')}}</textarea>
                        </div>
                        <div class="form-group mb-0 mt-3 justify-content-end">
                            <div>
                                <button type="submit" class="btn btn-primary">{{ __('Save Task') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal Select2.min js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Ion.rangeSlider.min js -->
    <script src="{{ URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <!--Internal  jquery-simple-datetimepicker js -->
    <script src="{{ URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>
    <!-- Ionicons js -->
    <script src="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}"></script>
    <!--Internal  pickerjs js -->
    <script src="{{ URL::asset('assets/plugins/pickerjs/picker.min.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
@endsection
