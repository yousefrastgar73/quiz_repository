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
                <ul class="nav navbar-nav navbar-left">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Sentinel::getUser()->username }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{url('profile')}}"><i class="fa fa-tachometer" aria-hidden="true"></i> مشاهده پروفایل</a></li>
                            <div class="divider"></div>
                            <li><a href="{{url('logout')}}"><i class="fa fa-btn fa-sign-out"></i> خروج</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div id="special-features" class="hide">
        <nav id="options" class="options-list">
            <ul>
                <li><a href="{{url('#')}}">گزینه اول</a></li>
                <li><a href="{{url('#')}}">گزینه دوم</a></li>
                <li><a href="{{url('#')}}">گزینه سوم</a></li>
                <li><a href="{{url('#')}}">گزینه چهارم</a></li>
            </ul>
        </nav>
    </div>
    <div id="questions-show" class="container hide">
        <div class="main">
            <ul id="clockdiv" class="cbp_tmtimeline"></ul>
        </div>
    </div>
    <div id="start-exam-container" class="container-fluid">
        <div class="container">
            <div id="start-exam">
                <button id="start-exam-btn" class="btn btn-primary btn-large" data-toggle="tooltip" title="با کلیک بر روی این دکمه، آزمون شما شروع می شود.">درخواست شروع آزمون</button>
            </div>
        </div>
    </div>
    <footer>
        <div class="container-fluid footer-fluid">
            <div class="container">
                <p class="footer-text">آزمون آنلاین &copy 1396</p>
            </div>
        </div>
    </footer>
    <script src="{{asset("assets/scripts/questions.js")}}"></script>
</body>
</html>
