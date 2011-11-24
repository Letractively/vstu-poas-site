jQuery(document).ready( function($)
{
    // Переключение видимости дополнительной информации о публикации
    $('.toggleextra').click(function() {
        $(this).parent('li').children('.extra').slideToggle(250);
        return false;
    })
    $('.site-menu .submenu').click(function() {
        $(this).siblings('ul').slideToggle(200);
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
			data: {form_login_username: $('[name="login_username"]').val(),
					form_login_password: $('[name="login_password"]').val()
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