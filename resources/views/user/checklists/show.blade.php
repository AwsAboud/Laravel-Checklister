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
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">{{ __('My Checklist') }}</h2>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
@endsection

@section('content')
<div class="col-xl-12">
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
                    @foreach ($checklist->tasks as $task)
                    <tr>
                        <td></td>
                        <td class="task-description-toggle"
                        data-id="{{$task->id}}"> {{ $task->name }} </td>
                        <td>
                            <svg id="task-arrow-bottom-{{ $task->id }}" class="d-none" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                            </svg>

                            <svg id="task-arrow-top-{{ $task->id }}" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708z"/>
                            </svg>
                        </td>
                    </tr>
                    <tr class="d-none" id="task-description-{{ $task->id }}">
                        <td></td>
                        <td colspan="2"> {!! $task->description !!}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
   <!--Internal  jquery.maskedinput js -->
   <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
   <!-- Internal form-elements js -->
   <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
@endsection
@section('scripts')
    {{-- <script>
        $(function(){
            $('.task-description-toggle').click(function(){
                $('#task-description-' + $(this).data('id')).toggleClass('d-none');
            })s
        })
    </script> --}}
    <script>
        $(function(){
            $('.task-description-toggle').click(function(){

                $('#task-description-' + $(this).data('id')).toggleClass('d-none');
                $('#task-arrow-top-' + $(this).data('id')).toggleClass('d-none');
                $('#task-arrow-bottom-' + $(this).data('id')).toggleClass('d-none');
            })
        })
    </script>

@endsection

