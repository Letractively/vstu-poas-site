jQuery(document).ready( function($)
{
    startTime();
    // Переключение видимости дополнительной информации о публикации
    $('.toggleextra').click(function() {
        $(this).parent('li').children('.extra').slideToggle(250);
        return false;
    })
    $('.site-menu .submenu').click(function() {
        $(this).siblings('ul').slideToggle(200);
        return false;
    });

    $('#authorization').click(function() {
        var html = '';
        html += '<div class="auth-js">';
        html += '<p>Пожалуйста, представьтесь</p>';
        html += '<label for="dialog_login">Логин</label>';
        html += '<input type="text" name="dialog_login"/><br>';
        html += '<label for="dialog_password">Пароль</label>';
        html += '<input type="password" name="dialog_password"/><br>';
        html += '<span id="dialog_error_login_admin"></span>';
        html += '</div>';
        $('#dialog_ui').html(html);
        $("#dialog_ui").dialog({
            modal: true,
            position: ["center","center"],
            title: 'Авторизация',
            buttons:
            {
                "Авторизация": function()
                {
                    $.ajax({
                        data: {
                            form_login_username: $('[name="dialog_login"]').val(),
                            form_login_password: $('[name="dialog_password"]').val()
                        },
                        dataType: "JSON",
                        type:'POST',
                        url:'/ajax/login/',
                        success:function(data){
                            if(data==1)
                            {
                                document.location.href='/cabinet';
                            }
                            else
                            {
                                $('#dialog_error_login_admin').html(data);
                            }
                            $(this).dialog("close");
                        },
                        error:function(data){
                            $('#dialog_error_login_admin').html("Произошла ошибка при попытке авторизоваться");
                        }
                    });
                },
                "Отмена": function()
                {
                    $(this).dialog("close");
                }
            }
        });
        return false;
    });

	// Попытка залогинится через форму авторизации (login_view.php)
	$("#login_send_button").click( function()
	{
		$('#error_login_admin').html('');
		var displayModeOfButton = $('#login_send_button').css('display');
		$('#login_send_button').css('display', 'none');
		$('#login_send_button').after('<img id="image_load_login_send" src="/images/load/round.gif" />');
		$.ajax({
			data: {form_login_username: $('[name="login"]').val(),
					form_login_password: $('[name="password"]').val()
		 	},
			dataType: "JSON",
			type:'POST',
			url:'/ajax/login/',
			success:function(data){
				//data = eval(data);
				if(data==1)
				{
					location.reload();
				}
				else
				{
					$('#error_login_admin').html(data);
					$('#image_load_login_send').remove();
					$('#login_send_button').css('display', displayModeOfButton);
				}
			},
			error:function(data){
				$('#image_load_login_send').remove();
				$('#login_send_button').css('display', displayModeOfButton);
				$('#error_login_admin').html("Произошла ошибка при попытке авторизоваться");
			}
		});
	});
});
function startTime()
{
    var tm=new Date();
    var h=tm.getHours();
    var m=tm.getMinutes();
    var s=tm.getSeconds();
    var N = 2;
    m = m.toString(N);
    s = s.toString(N);
    h = h.toString(N);
    while (h.length < parseInt('23', '10').toString(N).length)
    {
        h = "0" + h;
    }
    while (m.length < parseInt('59', '10').toString(N).length)
    {
        m = "0" + m;
    }
    while (s.length < parseInt('59', '10').toString(N).length)
    {
        s = "0" + s;
    }
    var result = h + ':' + m + ':' + s;
    var resulthtml = '';
    for(var i = 0; i < result.length; i++)
    {
        switch (result.charAt(i))
        {
            case '1':
                resulthtml += '<img src=/images/site/clock/1.png>';
                break;
            case '0':
                resulthtml += '<img src=/images/site/clock/0.png>';
                break;
            case ':':
                resulthtml += '<img src=/images/site/clock/colon.png>';
                break;
        }
    }
    $('#time').html(resulthtml);

    t=setTimeout('startTime()', 500);
}