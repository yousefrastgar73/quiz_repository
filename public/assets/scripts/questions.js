window.onbeforeunload = function() {
    clearCache();
};
var questionHtml = "<li class='active'><time class='cbp_tmtime'><span class='seconds'>30</span><div class='smalltext'>زمان(ثانیه)</div></time><div id='question-number' class='cbp_tmicon'>1</div><div class='cbp_tmlabel'><p class='question-text'><span style='float:left'>(<span class='score'></span>&nbsp;امتیاز)</span></p><ul class='question-options'><li class='option1'><input name='option' value='option1' type='radio'>&nbsp;&nbsp;</li><li class='option2'><input name='option' value='option2' type='radio'>&nbsp;&nbsp;</li><li class='option3'><input name='option' value='option3' type='radio'>&nbsp;&nbsp;</li><li class='option4'><input name='option' value='option4' type='radio'>&nbsp;&nbsp;</li></ul><div id='true-answer' class='alert alert-success hide'><i class='fa fa-check'></i>&nbsp;پاسخ شما صحیح است </div><div id='false-answer' class='alert alert-danger hide'><i class='fa fa-close'></i>&nbsp;پاسخ شما نادرست است </div><div id='time-out' class='alert alert-warning hide'><i class='fa fa-warning'></i>&nbsp;زمان شما به پایان رسید </div><div id='selected_answer' class='form-group'><button id='selected_answer-btn' class='btn btn-default btn-primary'>ارسال پاسخ <i class='fa fa-paper-plane' aria-hidden='true'></i></button></div><div id='next-question' class='form-group hide'><button id='next-question-btn' class='btn btn-default btn-primary' type='button'>درخواست سوال بعدی <i class='fa fa-share' aria-hidden='true'></i></button><button id='finish-exam-btn' class='btn btn-default btn-primary' type='button'>خروج از آزمون <i class='fa fa-times' aria-hidden='true'></i></button></div></div></li>";
function initializeClock (counter) {
    var interval = setInterval(function(){
        counter--;
        $('li.active span.seconds').text(counter);
        if (counter <= 0) {
            clearInterval(interval);
        }
    }, 1000);
}
var totalScore = 0;
var id = 1;
$('button#start-exam-btn').on('click', function () {
    $('.tooltip').hide();
    $.ajax({
        url        : BASE_URL + 'questions/set-status',
        method     : 'POST',
        dataType   : 'JSON',
        beforeSend : function () {
            var count = 3;
            var startExamCounter = $("<div>", {
                id      : "startExamCounter",
                css     : {
                    "font-size" : "70px",
                    "color"     : "#AA5555"
                },
                text    : count
            });
            var interval = setInterval(function(){
                count--;
                startExamCounter.text(count);
                if (count <= 0) {
                    clearInterval(interval);
                    $.LoadingOverlay("hide");
                }
            }, 1000);
            $.LoadingOverlay("show", {
                custom  : startExamCounter
            });
        },
        success    : function () {
            setTimeout(function () {
                $('#start-exam-container').fadeOut().remove();
                $('#special-features').removeClass('hide').fadeIn();
                $('#questions-show').removeClass('hide').fadeIn();
                $('#questions-show').show(function () {
                    var timer = setInterval(fetchQuestion(id), 1000);
                    function fetchQuestion(id) {
                        $.ajax({
                            url: BASE_URL + 'questions/fetch-question',
                            type: 'POST',
                            dataType: 'JSON',
                            data: {id: id},
                            beforeSend: function () {
                                var firstQuestionLoader = $("<div>", {
                                    id: "firstQuestionLoader",
                                    css: {
                                        "font-size": "26px",
                                        "color": "#AA5555",
                                        "position": "absolute",
                                        "top": "32%",
                                        "left": "36%"
                                    },
                                    text: "لطفا منتظر دریافت سوال باشید..."
                                });
                                $.LoadingOverlay("show", {
                                    custom: firstQuestionLoader
                                });
                            },
                            success: function (data) {
                                $.LoadingOverlay("hide");
                                if (data == false) {
                                    fetchQuestion(id);
                                }
                                else {
                                    $.ajax({
                                        url: BASE_URL + 'questions/wait-question',
                                        type: 'POST',
                                        dataType: 'JSON',
                                        success: function (data) {
                                            console.log(data);
                                        }
                                    });
                                    $('#clockdiv').prepend(questionHtml).fadeIn();
                                    clearInterval(timer);
                                    $("li.active #question-number").text(id);
                                    $("li.active p.question-text").prepend(data.question_text);
                                    $("li.active span.score").append(data.score);
                                    $("li.active li.option1").append(data.option1);
                                    $("li.active li.option2").append(data.option2);
                                    $("li.active li.option3").append(data.option3);
                                    $("li.active li.option4").append(data.option4);
                                    initializeClock(30);
                                    var timesRun = 0;
                                    var checkCounter = setInterval(function () {
                                        timesRun += 1;
                                        if (timesRun == 30) {
                                            clearInterval(checkCounter);
                                        }
                                        if ($('li.active span.seconds').text() == 0) {
                                            $('li.active time.cbp_tmtime').fadeOut().remove();
                                            $('li.active #time-out').slideDown().removeClass('hide');
                                            $('li.active input[name=option]').attr('disabled', 'disabled');
                                            $('li.active #selected_answer').remove();
                                            $('li.active #next-question').fadeIn().removeClass('hide');
                                            $('li.active #next-question-btn').on('click', function () {
                                                if (id == 15) {
                                                    $.ajax({
                                                        url: BASE_URL + 'profile',
                                                        type: 'POST',
                                                        dataType: 'JSON',
                                                        data: {totalScore: totalScore},
                                                        success: function () {
                                                            toastr.info('آزمون به پایان رسید');
                                                            clearCache();
                                                            setTimeout(function () {
                                                                location.replace(BASE_URL + 'profile');
                                                            }, 3000);
                                                        }
                                                    });
                                                }
                                                else {
                                                    $.ajax({
                                                        url        : BASE_URL + 'questions/next-question',
                                                        type       : 'POST',
                                                        dataType   : 'JSON',
                                                        success    : function () {
                                                            $('li.active #next-question').fadeOut().remove();
                                                            $('li.active').removeClass('active');
                                                        }
                                                    });
                                                    setTimeout(fetchQuestion(++id), 5000);
                                                }
                                            });
                                        }
                                    }, 1000);
                                    $('li.active #selected_answer-btn').on('click', function (e) {
                                        e.preventDefault();
                                        if ($('li.active span.seconds').text() == 0) {
                                            $('li.active #time-out').slideDown().removeClass('hide');
                                        }
                                        else {
                                            var selected_answer = $('li.active input[name=option]:checked').val();
                                            if (selected_answer == 'option'+data.correct_answer) {
                                                totalScore += parseInt(data.score);
                                                $('li.active #true-answer').slideDown().removeClass('hide');
                                            }
                                            else {
                                                $('li.active #false-answer').slideDown().removeClass('hide');
                                            }
                                        }
                                        $('li.active time.cbp_tmtime').fadeOut().remove();
                                        $('li.active #selected_answer').fadeOut().remove();
                                        $('li.active input[name=option]').attr('disabled', 'disabled');
                                        $('li.active #next-question').fadeIn().removeClass('hide');
                                        $('li.active #next-question-btn').on('click', function () {
                                            if (id == 15) {
                                                $.ajax({
                                                    url: BASE_URL + 'profile',
                                                    type: 'POST',
                                                    dataType: 'JSON',
                                                    data: {totalScore: totalScore},
                                                    success: function () {
                                                        toastr.info('آزمون به پایان رسید');
                                                        clearCache();
                                                        setTimeout(function () {
                                                            location.replace(BASE_URL + 'profile');
                                                        }, 3000);
                                                    }
                                                });
                                            }
                                            else {
                                                $.ajax({
                                                    url        : BASE_URL + 'questions/next-question',
                                                    method     : 'POST',
                                                    dataType   : 'JSON',
                                                    success    : function () {
                                                        $('li.active #next-question').fadeOut().remove();
                                                        $('li.active').removeClass('active');
                                                    }
                                                });
                                                setTimeout(fetchQuestion(++id), 5000);
                                            }
                                        });
                                        $('li.active #finish-exam-btn').on('click', function () {
                                            $.ajax({
                                                url: BASE_URL + 'profile',
                                                type: 'POST',
                                                dataType: 'JSON',
                                                data: {totalScore: totalScore},
                                                success: function () {
                                                    clearCache();
                                                    setTimeout(function () {
                                                        location.replace(BASE_URL + 'finish');
                                                    }, 3000);
                                                }
                                            });
                                        });
                                        clearInterval(checkCounter);
                                    });
                                }
                            }
                        });
                    }
                });
            }, 1000);
        }
    });
});
