jQuery(document).ready( function($)
{
    // Переключение видимости дополнительной информации о публикации
    $('.toggleextra').click(function() {
        $(this).parent('li').children('.extra').slideToggle(250);
        return false;
    })
    
	// Попытка залогинится через форму авторизации (form_login_view.php)
	$("#login_send_button").click( function()
	{
		$('#error_login_admin').html('');
		var displayModeOfButton = $('#login_send_button').css('display');
		$('#login_send_button').css('display', 'none');
		$('#login_send_button').after('<img id="image_load_login_send" src="/images/load/round.gif" />');
		
		$.ajax({
			data: {form_login_username: $('[name="login_username"]').val(),
					form_login_password: $().crypt({method:"md5",source:$('[name="login_password"]').val()})
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
					$('#error_login_admin').html('Неправильный логин или пароль');
					$('#image_load_login_send').remove();
					$('#login_send_button').css('display', displayModeOfButton);
				}		
			},
			error:function(data){
				$('#image_load_login_send').remove();
				$('#login_send_button').css('display', displayModeOfButton);
				$('#error_login_admin').html("Произошла непоправимая ошибка при попытке войти на сайт. Расскажите об этом всем! И да воцарит провасудие - виновный будет наказан");
			}
		});
	});
});

function ajaxFileUpload(uploadid)
{
    $("#loading").ajaxStart(function(){
        $(this).show();
    }).ajaxComplete(function(){
        $(this).hide();
    });

    $.ajaxFileUpload
    (
        {
            url:'http://igniter/doupload',
            secureuri:false,
            fileElementId:uploadid,
            dataType: 'json',
            type:'POST',
            data:{name:'logan', id:'id',fileElementId:'fileToUpload'},
            success: function (data, status)
            {
                if(typeof(data.error) != 'undefined')
                {
                    if(data.error != '')
                    {
                        alert(data.error);
                    }else
                    {
                        alert(data.msg);
                        $('#mypic').attr('src', data.name);
                    }
                }
            },
            error: function (data, status, e)
            {
                alert(e);
            }
        }
    )

    return false;

}