@extends('app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                @if (session('status'))
                    <div class="alert alert-danger" style="text-align: center; border: 2px solid #8A6D3B; margin-top: 2%;">
                        <h4 style="font-weight: bold;"><i class="fa fa-close"></i> {{ session('status') }}</h4>
                    </div>
                @endif
                <div class="panel panel-default login-panel">
                    <div class="panel-heading">ورود به پنل کاربری</div>
                    <div class="panel-body">
                        {{ Form::open(['url' => 'login', 'method' => 'POST', 'class' => 'form-horizontal']) }}
                            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                <label for="username" class="col-md-3 control-label pull-right">نام کاربری</label>
                                <div class="col-md-6 pull-right">
                                    <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="نام کاربری">
                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-3 control-label pull-right">پست الکترونیک</label>
                                <div class="col-md-6 pull-right">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="پست الکترونیک">
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-3 control-label pull-right">رمز عبور</label>
                                <div class="col-md-6 pull-right">
                                    <input id="password" type="password" class="form-control" name="password" placeholder="رمز عبور">
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-9">
                                    {{ Form::button('<i class="fa fa-sign-in"></i> ورود', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-9">
                                    <a class="btn btn-link" href="{{url('signup')}}">ایجاد حساب کاربری</a>
                                </div>
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
