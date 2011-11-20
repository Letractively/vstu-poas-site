jQuery(document).ready(function($)
{
		
    $(".admin-data-table tr:even").css("background-color", "#e6e6d6");    
	/** кнопки удаления срабатывают только после подтверждения */
	$('a.button_delete').click( delete_confirm );

	/** Объект класса js_obj_visability изменяет свою 
	 * доступность для ввода (вкл на выкл и наоборот)
	 * при изменении чекбокса с классом js_checkbox_visability */ 
	$('.js_obj_visability').visability_with($('.js_checkbox_visability'));
	
    $('.showhide').click(function() {
        $(this).parent('div').children('.hideble').slideToggle(250);
        return false;
    });
    
    /** Объект класса js_obj_hidden изменяет свою 
	 * видимость на странице (с невидим на виден при "включении" чекбокса и наоборот);
	 * Связанный чекбокс должен имепть класс js_checkbox_hidden */ 
	$('.js_obj_hidden').hidden_with( $('.js_checkbox_hidden'), 'inline-block', false );
	
	$('.valid_url').valid_url();
	
	/** Подключение HTML редактора в к объектам с классом "elrte_editor" */
	var elrte_options = {
		lang         : 'ru',
		styleWithCSS : false,
		height       : 320,
		fmAllow		 : true,
		toolbar      : 'maxi'
		//, fmOpen : function(callback) {
		//	$('<div id="elfinder" />').elfinder({
		//		url : '/js/elfinder-1.2/connectors/php/connector_articles.php', // @todo ждём elfinder-2.0 официальный релиз
		//		lang : 'ru',
		//		 contextmenu : { /** @todo после залития на хостинг функции архивация и разъархивация требуют тестирования - читать тут: http://elrte.org/redmine/boards/1/topics/3144*/
		//			 	cwd : ['reload', 'delim', 'mkdir', 'mkfile', 'upload', 'delim', 'paste', 'delim', 'info'], 
		//			 	file : ['select', 'open', 'delim', 'copy', 'cut', 'rm', 'delim', 'duplicate', 'rename'], 
		//			 	group : ['copy', 'cut', 'rm', 'delim', 'archive', 'extract', 'delim', 'info'] 
		//			 },
		//		dialog : { width : 900, modal : true, title : 'elFinder - file manager for web' },
		//		closeOnEditorCallback : true,
		//		editorCallback : callback,
		//		curr_directory: 'volgograd'
		//	});
		//}
	};
	var elrte_options_mini = {
			lang         : 'ru',
			styleWithCSS : false,
			height       : 100,
			fmAllow		 : true,
			toolbar      : 'maxi'
		};
	$('.elrte_editor').elrte(elrte_options);
	$('.elrte_editor_mini').elrte(elrte_options_mini);
    
    
    $('.hideble').css('display','none');
    $('.hideble .error').parent('.hideble').css('display','block');
    $('.hideble .error').parent('.hideble').parent('div').children('a').addClass('wrong-data');
});

/**
 * Связать доступность объекта (его css атрибут disabled) с чекбоксом - 
 * при изменении чекбокса изменяется доступность объекта 
 * @param [in] checkbox_obj - объект jquery, чекбокс(ы)
 */
(function( $ ){
	jQuery.fn.visability_with = function(checkbox_obj)
	{
		var this_obj = this;
		checkbox_obj.change(function() {
			var disabled = this_obj.attr('disabled');
			this_obj.attr('disabled', !disabled);
		});
		return true;
	}
})( jQuery );


/**
 * @todo задокументировать (транслетирация)
 */
(function( $ ){
	jQuery.fn.valid_url = function()
	{
		var this_obj = this;
		this_obj.change(function() {
			this_obj.val( toUrl(this_obj.val()) );
		});
		return true;
	};
})( jQuery );


/**
 * Связать видимость объекта (его css атрибут display: none | <param [in] display>) с чекбоксом - 
 * при изменении чекбокса изменяется видимость объекта (видим или невидим)
 * @param [in] J_obj checkbox_obj - объект jquery, чекбокс(ы)
 * @param [in] string display - значение атрибута display, когда объект должен быть виден (необязательный параметр, по-умолчанию 'inline-block') 
 * @param [in] bool inverse - если true, то объект должен быть невидим когда чекбокс отмечен (необязательный параметр, по-умолчанию false)
 */
(function( $ ){
	jQuery.fn.hidden_with = function(checkbox_obj)
	{
		var this_obj = this;
		var display = 'inline-block';
		var inverse = false;
		checkbox_obj.change(function()
		{
			if( arguments[1] ) display = arguments[1];	
			if( arguments[2] ) inverse = arguments[2];
			
			var is_checked = Boolean(checkbox_obj.attr('checked'));
			var is_display = is_checked;
			if(inverse) is_display = ! is_display;
			if( is_display )
				this_obj.css('display', display);
			else
				this_obj.css('display', 'none');
		});
	};
})( jQuery );

/** Окошко подтверждения при желании удалить что-либо */
function delete_confirm()
{
	$('#dialog_ui').html('Вы действительно хотите ' + $(this).attr('title')+'?'); // Окончание должно быть прописано в атрибуте title у ссылки (<a title="...">)
	var link_to_delete = $(this).attr('href');
	$("#dialog_ui").dialog({
		modal: true,
		position: ["center","center"],
		title: 'Подтвердите операцию удаления',
		buttons: 
		{
			"Отмена": function()
			{
				$(this).dialog("close");
			},
			"Удалить": function()
			{
				document.location.href = link_to_delete;
				$(this).dialog("close");
			}
		}
	});
	return false;
}

/** Простой вывод содержимого объекта (для отладки) */
function alertObj(obj)
{
	var str = "";
	for(k in obj)
	{
		str += k+": " + obj[k]+"\r\n";
	}
	alert(str);
}

/**
 * Сделать строку пригодной для использования в качестве url-адреса (транслетилировать, убрать лишнее, заменить пробелы)
 * @param str - строка, которую нужно превратить в url
 * @return string - получившийся url-адрес
 */
function toUrl(str) {
	var tr='a b v g d e j z i y k l m n o p r s t u f h c ch sh shh ~ y ~ e yu ya ~ jo'.split(' ');
	var ww='';
	str = str.toLowerCase().replace(/ /g,'_');
	for(i=0; i<str.length; ++i)
	{
		cc = str.charCodeAt(i); 
		ch = (cc>=1072?tr[cc-1072]:str[i]); 
		ww+=ch;
	}
	return(ww.replace(/[^a-zA-Z0-9_-]+/g, ''));
}

function startUpload(){
    return true;
}

/**
 * upload_path - куда сохранять файл
 * allowed_types - разрешенные типы файлов
 * max_size - максимальный разрешенный размер
 * max_width - ширина, если это файл
 * max_height - максимальная высота
 * 
 * table_name - имя таблицы, к которой будет относиться файл
 * record_id - id записи в таблице table_name, к которой будет относится файл
 * field_name - имя поля, в которое должен будет записаться id файла
 */
function ajaxFileUpload(
    upload_path,
    allowed_types,
    max_size,
    max_width,
    max_height,
    table_name,
    record_id,
    field_name)
{
    $("#loading").ajaxStart(function(){
        $(this).show();
    }).ajaxComplete(function(){
        $(this).hide();
    });

    $.ajaxFileUpload
    (
        {
            url:'/ajax/upload',
            secureuri:false,
            dataType: 'json',
            fileElementId:'file_form',
            type:'POST',
            data:
                {
                    upload_path:upload_path,
                    allowed_types:allowed_types,
                    max_size:max_size,
                    max_width:max_width,
                    max_height:max_height,
                    
                    table_name:table_name,
                    record_id:record_id,
                    field_name:field_name
                },
            success: function (data, status)
            {
                if(typeof(data.error) != 'undefined')
                {
                    if(data.error != '')
                    {
                        alert(data.error);
                    }
                    else
                    {
                        alert('Файл был успешно загружен (id=' + data.id +')');
                        $('#file_preview').attr('src',data.path);
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

function usersSelector(
    title,
    table,
    userfield,
    fkfield,
    fk)
{
    var users;          // Список всех пользователей
    var members;        // Список всех участников
    $.ajax({
			data: {},
			dataType: "JSON",
			type:'POST',
			url:'/ajax/get_all_users/',
			success:function(data){
                users = data;
                $.ajax({
                        data: {
                            table:table,
                            userfield:userfield,
                            fkfield:fkfield,
                            fk:fk
                        },
                        dataType: "JSON",
                        type:'POST',
                        url:'/ajax/get_members/',
                        success:function(data){
                            members = data;
                            //alertObj(users);
                            var html = '<select multiple="" name="users" class="users-selector">';
                            for (k in users){
                                var selected = '';
                                if ($.inArray(users[k].id, members) != -1)
                                    selected = 'selected="selected"';
                                html += '<option value="' + 
                                        users[k].id + 
                                        '"' + 
                                        selected + 
                                        '>' + 
                                        users[k].surname + 
                                        ' ' + 
                                        users[k].name + 
                                        ' ' + 
                                        users[k].patronymic + 
                                        '</option>';
                            }
                            //alertObj(html);
                            $('#dialog_ui').html(html);
                            $("#dialog_ui").dialog({
                                modal: true,
                                position: ["center","center"],
                                title: title,
                                buttons: 
                                {
                                    "Сохранить": function()
                                    {
                                        $(this).dialog("close");
                                    },
                                    "Отмена": function()
                                    {
                                        //document.location.href = link_to_delete;
                                        $(this).dialog("close");
                                    }
                                }
                            });
                        },
                        error:function(data){
                        }
                });
			},
			error:function(data){
			}
    });   
    
	return false;
}