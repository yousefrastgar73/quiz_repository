@extends('app')
@section('content')
    <div id="start" class="container-fluid">
        <div class="container">
            {{ Form::open(['url' => '/', 'method' => 'GET']) }}
            <div class="form-group">
                {{ Form::button('شروع',['type' => 'button', 'class' => 'btn btn-default btn-primary btn-large start-btn', 'data-toggle' => 'modal', 'data-target' => '#exampleModal']) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>
    <div class="modal fade" id="startModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h2 class="modal-title" id="exampleModalLabel">کجا بریم ؟</h2>
                </div>
                <div class="modal-footer">
                    <a href="{{url('/questions')}}"><button type="button" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i> ورود به آزمون</button></a>
                    <a href="{{url('/profile')}}"><button type="button" class="btn btn-primary" style="float: left"><i class="fa fa-user" aria-hidden="true"></i> ورود به حساب کاربری</button></a>
                </div>
            </div>
        </div>
    </div>
@endsection
