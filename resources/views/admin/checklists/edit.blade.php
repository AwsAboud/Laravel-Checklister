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

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
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
        {{-- Task Table --}}
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
                        @livewire('tasks-table', ['checklist' => $checklist])
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
                            <textarea type="text" class="form-control" id="description" name="description" rows="5" >{{old('description')}}</textarea>
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
   <!--Internal  jquery.maskedinput js -->
   <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
   <!-- Internal form-elements js -->
   <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
@endsection
@section('scripts')
<script>
    @include('admin.ckeditor')
@endsection
