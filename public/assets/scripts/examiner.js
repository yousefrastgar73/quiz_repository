$(document).ready(function(){
    $('input[name=question_text]').attr('disabled', 'disabled');
    $('input[name=option1]').attr('disabled', 'disabled');
    $('input[name=option2]').attr('disabled', 'disabled');
    $('input[name=option3]').attr('disabled', 'disabled');
    $('input[name=option4]').attr('disabled', 'disabled');
    $('input[name=score]').attr('disabled', 'disabled');
    $('input[name=correct_answer]').attr('disabled', 'disabled');
    $('button#send-question').attr('disabled', 'disabled');
    toastr.info('لطفا منتظر آزمون دهنده باشید...');
    var timer = setInterval(checkStartExamFlag, 500);
    function checkStartExamFlag() {
        $.ajax({
            url        : BASE_URL + 'examiner/check-status',
            type       : 'GET',
            dataType   : 'JSON',
            success    : function () {
                toastr.success('آزمون دهنده آنلاین است. لطفا سوالات را برای او ارسال کنید.');
                $('input[name=question_text]').removeAttr('disabled');
                $('input[name=option1]').removeAttr('disabled');
                $('input[name=option2]').removeAttr('disabled');
                $('input[name=option3]').removeAttr('disabled');
                $('input[name=option4]').removeAttr('disabled');
                $('input[name=score]').removeAttr('disabled');
                $('input[name=correct_answer]').removeAttr('disabled');
                $('button#send-question').removeAttr('disabled');
                clearInterval(timer);
            }
        });
    }
});
$('#questions-form').ready(function () {
    var id = Math.min(Math.max(parseInt($('.question-number-label').text()), 1), 15);
    $('#questions-form').on('submit', function (e) {
        var checkFinish = setInterval(checkFinishExamFlag, 3000);
        function checkFinishExamFlag() {
            $.ajax({
                url: BASE_URL + 'examiner/check-finish',
                dataType: 'JSON',
                method: 'GET',
                success: function () {
                    clearInterval(checkFinish);
                    toastr.warning('آزمون دهنده آفلاین شد !');
                    clearCache();
                    setTimeout(function () {
                        location.replace(BASE_URL);
                    }, 5000);
                }
            });
        }
        e.preventDefault();
        var formData = {
            id            : id,
            question_text : $('input[name=question_text]').val(),
            option1       : $('input[name=option1]').val(),
            option2       : $('input[name=option2]').val(),
            option3       : $('input[name=option3]').val(),
            option4       : $('input[name=option4]').val(),
            score         : $('input[name=score]').val(),
            correct_answer: $('input[name=correct_answer]').val()
        };
        $.ajax({
            url        : BASE_URL + 'examiner/send-question',
            type       : 'POST',
            dataType   : 'JSON',
            data       : formData,
            beforeSend : function () {
                $.LoadingOverlay("show");
            },
            success    : function () {
                $.LoadingOverlay("hide");
                $('input[name=question_text]').attr('disabled', 'disabled');
                $('input[name=option1]').attr('disabled', 'disabled');
                $('input[name=option2]').attr('disabled', 'disabled');
                $('input[name=option3]').attr('disabled', 'disabled');
                $('input[name=option4]').attr('disabled', 'disabled');
                $('input[name=score]').attr('disabled', 'disabled');
                $('input[name=correct_answer]').attr('disabled', 'disabled');
                $('button#send-question').attr('disabled', 'disabled');
                if (id == 15) {
                    toastr.info('امتحان به پایان رسید');
                    clearCache();
                    setTimeout(function () {
                        location.replace(BASE_URL);
                    }, 5000);
                }
                else {
                    toastr.success("سوال با موفقیت ارسال شد . لطفا منتظر دریافت درخواست باشید ...");
                    $('.question-number-label').text(++id + ')');
                    $('.help-block').hide();
                    $('.form-group').parent().removeClass('has-error');
                    $('#questions-form').each(function() {
                        this.reset();
                    });
                    var checkTimer = setInterval(checkNextQuestion, 1000);
                    function checkNextQuestion() {
                        $.ajax({
                            url        : BASE_URL + 'examiner/check-question',
                            type       : 'GET',
                            dataType   : 'JSON',
                            cache      : false,
                            success    : function () {
                                clearInterval(checkTimer);
                                toastr.error('لطفا سوال بعدی را برای آزمون دهنده ارسال کنید !');
                                $('input[name=question_text]').removeAttr('disabled');
                                $('input[name=option1]').removeAttr('disabled');
                                $('input[name=option2]').removeAttr('disabled');
                                $('input[name=option3]').removeAttr('disabled');
                                $('input[name=option4]').removeAttr('disabled');
                                $('input[name=score]').removeAttr('disabled');
                                $('input[name=correct_answer]').removeAttr('disabled');
                                $('button#send-question').removeAttr('disabled');
                            }
                        });
                    }
                }
            },
            error      : function (res) {
                setTimeout(function () {
                    $.LoadingOverlay("hide");
                    $.each(res.responseJSON, function (key, value) {
                        var input = '#questions-form input[name=' + key + ']';
                        $(input + '+span.help-block>strong').text(value);
                        $('.form-group').parent().addClass('has-error');
                        $('.help-block').show();
                    });
                }, 1000);
            }
        });
    });
});
