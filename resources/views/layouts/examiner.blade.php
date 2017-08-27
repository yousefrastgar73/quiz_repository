<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta keywords="آزمون آنلاین">
    <meta description="سامانه برگزاری آزمون آنلاین">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{asset("assets/images/Quiz.png")}}">
    <title>آزمون آنلاین</title>
    <link rel="stylesheet" href="{{asset("assets/styles/font-awesome.css")}}">
    <link rel="stylesheet" href="{{asset("assets/styles/bootstrap.css")}}">
    <link rel="stylesheet" href="{{asset("assets/styles/toastr.css")}}">
    <link rel="stylesheet" href="{{asset("assets/styles/styles.css")}}">
    <script src="{{asset("assets/scripts/jquery.js")}}"></script>
    <script src="{{asset("assets/scripts/bootstrap.js")}}"></script>
    <script src="{{asset("assets/scripts/toastr.js")}}"></script>
    <script src="{{asset("assets/scripts/loadingoverlay.js")}}"></script>
    <script src="{{asset("assets/scripts/scripts.js")}}"></script>
    <script src="{{asset("assets/scripts/examiner.js")}}"></script>
</head>
<body id="app-layout">
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header navbar-right">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{url('/')}}">آزمون آنلاین</a>
        </div>
        <div id="app-navbar-collapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{url('/guide')}}"><i class="fa fa-info-circle" aria-hidden="true"></i> راهنمای کاربر</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-left">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        {{ Sentinel::getUser()->username }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{url('logout')}}"><i class="fa fa-btn fa-sign-out"></i> خروج</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="container">
        {{ Form::open(['url' => 'questions', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'questions-form']) }}
            <div class="row form-group examiner-form margin-top-bottom">
                <div class="col-md-12 col-xs-12 pull-right margin-top-bottom">
                    <div class="form-group">
                        <div class="col-md-1 pull-right qnum">
                            <label class="control-label question-number-label" for="question_number">1)</label>
                        </div>
                        <div class="col-md-10 margin-top-bottom pull-right">
                            <input type="text" name="question_text" class="form-control" placeholder="متن سوال">
                            <span class="help-block"><strong></strong></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12 pull-right margin-top-bottom">
                    <div class="form-group">
                        <div class="col-md-1 pull-right qnum">
                            <label class="control-label question-option-label" for="option1">1.</label>
                        </div>
                        <div class="col-md-9 pull-right">
                            <input type="text" name="option1" class="form-control" placeholder="گزینه 1">
                            <span class="help-block"><strong></strong></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12 margin-top-bottom">
                    <div class="form-group">
                        <div class="col-md-1 pull-right qnum">
                            <label class="control-label question-option-label" for="option2">2.</label>
                        </div>
                        <div class="col-md-9 pull-right">
                            <input type="text" name="option2" class="form-control" placeholder="گزینه 2">
                            <span class="help-block"><strong></strong></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12 pull-right margin-top-bottom">
                    <div class="form-group">
                        <div class="col-md-1 pull-right qnum">
                            <label class="control-label question-option-label" for="option3">3.</label>
                        </div>
                        <div class="col-md-9 pull-right">
                            <input type="text" name="option3" class="form-control" placeholder="گزینه 3">
                            <span class="help-block"><strong></strong></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12 pull-right margin-top-bottom">
                    <div class="form-group">
                        <div class="col-md-1 pull-right qnum">
                            <label class="control-label question-option-label" for="option4">4.</label>
                        </div>
                        <div class="col-md-9 pull-right">
                            <input type="text" name="option4" class="form-control" placeholder="گزینه 4">
                            <span class="help-block"><strong></strong></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12 pull-right margin-top-bottom">
                    <div class="form-group">
                        <div class="col-md-2 pull-right qnum">
                            <label class="control-label score-label" for="score">امتیاز سوال</label>
                        </div>
                        <div class="col-md-4 pull-right">
                            <input type="text" name="score" class="form-control" placeholder="امتیاز">
                            <span class="help-block"><strong></strong></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12 pull-right margin-top-bottom">
                    <div class="form-group">
                        <div class="col-md-2 pull-right qnum">
                            <label class="control-label score-label" for="correct_answer">گزینه صحیح</label>
                        </div>
                        <div class="col-md-5 pull-right">
                            <input type="text" name="correct_answer" class="form-control" placeholder="شماره گزینه صحیح را وارد کنید">
                            <span class="help-block"><strong></strong></span>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-11 pull-right send-question">
                    {{ Form::button('ارسال سوال <i class="fa fa-paper-plane" aria-hidden="true"></i>',['type' => 'submit', 'id' => 'send-question', 'class' => 'btn btn-default btn-primary btn-large']) }}
                </div>
            </div>
        {{ Form::close() }}
    </div>
</div>
<footer>
    <div class="container-fluid footer-fluid">
        <div class="container">
            <p class="footer-text">آزمون آنلاین &copy 1396</p>
        </div>
    </div>
</footer>
</body>
</html>
