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
		styleWithCSS : true,
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
			toolbar      : 'mini'
		};

	$('.elrte_editor_mini').elrte(elrte_options_mini);
	$('.elrte_editor').elrte(elrte_options);


    $('.hideble').css('display','none');
    $('.hideble .error').parent('.hideble').css('display','block');
    $('.hideble .error').parent('.hideble').parent('div').children('a').addClass('wrong-data');

    $('.date').datepicker({dateFormat: 'yy-mm-dd'});
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
	};
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
			if( arguments[1] ) inverse = arguments[1];

			var is_checked = Boolean(checkbox_obj.attr('checked'));
			var is_display = is_checked;
			if(inverse) is_display = ! is_display;
			if( is_display )
				this_obj.show("slide", {direction: "up"}, 420 );
			else
				this_obj.hide("slide", {direction: "up"}, 420);
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
 * max_width - ширина, если это изображение
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
                        if (allowed_types.indexOf('doc') != -1)
                        {
                            $('#file_preview').attr('href', data.path);
                            $('#file_preview').text(data.path);
                        }
                        else
                        {
                            $('#file_preview').attr('src', data.path);
                        }
                    }
                }
                $("#loading").hide();
            },
            error: function (data, status, e)
            {
                $("#loading").hide();
                alert(e);
            }
        }
    );
    return false;
}

/**
 * Отображает и отвечает за функционирование окна выбора пользователей
 * @param title - заголовок окна
 * @param table - таблица связи пользователей с прочими сущностями
 * (напр. пользователь-проект, пользователь-курс, пользователь-направление)
 * @param userfield - название поля, которое содержит id пользователя
 * @param fkfield - название поля, которое содержит id второй сущности
 * @param fk - id второй сущности
 */
function usersSelector(
    title,
    table,
    userfield,
    fkfield,
    fk)
{
    var users;          // Список всех пользователей
    var members;        // Список всех участников
    // получить список всех пользователей
    $.ajax({
			data: {},
			dataType: "JSON",
			type:'POST',
			url:'/ajax/get_all_users/',
			success:function(data){
                users = data;

                // получить список всех участников
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
                            var html =
                                '<form name="users" method="post" action="/ajax/update_members/">' +
                                '<select multiple="" name="users[]" class="users-selector">';
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
                            html += '</select>';
                            html += '<input type="hidden" name="table" value="' + table + '"/>';
                            html += '<input type="hidden" name="fkfield" value="' + fkfield + '"/>';
                            html += '<input type="hidden" name="userfield" value="' + userfield + '"/>';
                            html += '<input type="hidden" name="fk" value="' + fk + '"/>';
                            html += '</form>';

                            // отобразить окошко со списком пользователей
                            $('#dialog_ui').html(html);
                            $("#dialog_ui").dialog({
                                modal: true,
                                position: ["center","center"],
                                title: title,
                                buttons:
                                {
                                    "Сохранить": function()
                                    {
                                        $('#dialog_ui form[name=users]').ajaxForm();
                                        $('#dialog_ui form[name=users]').submit();
                                        window.location.reload();
                                    },
                                    "Отмена": function()
                                    {
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
function advancedUsersSelector(
    title,
    table,
    userfield,
    fkfield,
    fk,
    extrafield,
    extravalue)
{
    var users;          // Список всех пользователей
    var members;        // Список всех участников
    // получить список всех пользователей
    $.ajax({
			data: {},
			dataType: "JSON",
			type:'POST',
			url:'/ajax/get_all_users/',
			success:function(data){
                users = data;

                // получить список всех участников
                $.ajax({
                        data: {
                            table:table,
                            userfield:userfield,
                            fkfield:fkfield,
                            fk:fk,
                            extrafield:extrafield,
                            extravalue:extravalue
                        },
                        dataType: "JSON",
                        type:'POST',
                        url:'/ajax/get_members_advanced/',
                        success:function(data){
                            members = data;
                            var html =
                                '<form name="users" method="post" action="/ajax/update_members_advanced/">' +
                                '<select multiple="" name="users[]" class="users-selector">';
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
                            html += '</select>';
                            html += '<input type="hidden" name="table" value="' + table + '"/>';
                            html += '<input type="hidden" name="fkfield" value="' + fkfield + '"/>';
                            html += '<input type="hidden" name="userfield" value="' + userfield + '"/>';
                            html += '<input type="hidden" name="fk" value="' + fk + '"/>';
                            html += '<input type="hidden" name="extrafield" value="' + extrafield + '"/>';
                            html += '<input type="hidden" name="extravalue" value="' + extravalue + '"/>';
                            html += '</form>';

                            // отобразить окошко со списком пользователей
                            $('#dialog_ui').html(html);
                            $("#dialog_ui").dialog({
                                modal: true,
                                position: ["center","center"],
                                title: title,
                                buttons:
                                {
                                    "Сохранить": function()
                                    {
                                        $('#dialog_ui form[name=users]').ajaxForm();
                                        $('#dialog_ui form[name=users]').submit();
                                        window.location.reload();
                                    },
                                    "Отмена": function()
                                    {
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
function ajaxFileDelete(
    table_name,
    record_id,
    field_name){

    $.ajax({
        data: {table: table_name,
                id: record_id,
                field: field_name
        },
        dataType: "HTML",
        type:'POST',
        url:'/ajax/delete_file/',
        success:function(data){
            alert(data);
            $('#file_preview').attr('src', '');
            $('#file_preview').text('');

        },
        error:function(data){
            alert("Произошла ошибка при попытке удалить файл");
        }
    });
    return false;
}

/**
 * Выводит диалог для загрузки файлов
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
function fileLoader(
    upload_path,
    allowed_types,
    max_size,
    max_width,
    max_height,
    table_name,
    field_name,
    record_id,
    file_url
    ){

    // отобразить окошко со списком пользователей
    var html = '';
    html += '<img id="loading" src="/images/load/round.gif" style="display:none;">';
    html += '<br>';
    html += '<input type="file" id="file_form" value=" " name="file_form">';
    html += '<br>';
    if (allowed_types.indexOf('doc') != -1)
    {
        html += 'Ваш файл : <a id="file_preview" href="' + file_url + '">' + file_url + '</a>';
    }
    else
    {
        html += '<img id="file_preview" class= "minipic" alt="Ваш файл" src="' + file_url + '">';
    }
    //html += '<button onclick="" id="file_load" type="button" name="file_load">Загрузить</button>';
    $('#dialog_ui').html(html);
    $('#dialog_ui').dialog({
        modal: true,
        position: ["center","center"],
        title: 'Изображение пользователя',
        buttons:
        {
            "Загрузить": function()
            {
                ajaxFileUpload(
                    upload_path,
                    allowed_types,
                    max_size,
                    max_width,
                    max_height,
                    table_name,
                    record_id,
                    field_name);
            },
            "Удалить": function()
            {
                ajaxFileDelete(
                    table_name,
                    record_id,
                    field_name);
            },
            "Закрыть": function()
            {
                $(this).dialog("close");
            }
        },
        beforeClose:function(){
            window.location.reload();
            return true;
        }
    });
    return false;
}

/**
 * Выводит диалог для загрузки файлов
 *
 * @param name - тип файла
 * @param id - идентификатор файла
 */
function advFileLoader(name, id) {
    var html = '';
    html += '<img id="loading" src="/images/load/round.gif" style="display:none;">';
    html += '<br>';
    var file_url = ajaxGetFileURL(name, id);
    if (name == 'partner' || name == 'direction' || name == 'project' || name == 'user')
    {
        html += '<img id="file_preview" class= "minipic" alt="Ваше изображение" src="' + file_url + '">';
    }
    else
    {
        html += 'Ваш файл : <a id="file_preview" href="' + file_url + '">' + file_url + '</a>';
    }
    html += '<br>';
    html += '<input type="file" id="file_form" value=" " name="file_form">';
    html += '<br>';
    $('#dialog_ui').html(html);
    $('#dialog_ui').dialog({
        modal: true,
        position: ["center","center"],
        title: 'Загрузить файл',
        buttons:
        {
            "Загрузить": function()
            {
                advAjaxFileUpload(name, id);
            },
            "Удалить": function()
            {
                advAjaxFileDelete(name, id);
            },
            "Закрыть": function()
            {
                $(this).dialog("close");
            }
        }
    });
    return false;
}

function advAjaxFileUpload(name, id)
{
    $("#loading").ajaxStart(function(){
        $(this).show();
    }).ajaxComplete(function(){
        $(this).hide();
    });

    $.ajaxFileUpload
    (
        {
            url:'/ajax/advUpload',
            secureuri:false,
            dataType: 'json',
            fileElementId:'file_form',
            type:'POST',
            data:
                {
                    name: name,
                    id: id
                },
            success: function (data, status)
            {
                $("#loading").hide();
                if(typeof(data.error) != 'undefined')
                {
                    if(data.error != '')
                    {
                        alert(data.error);
                    }
                    else
                    {
                        if (name == 'partner')
                            alert('Файл был успешно загружен (id=' + data.file_id +')');

                        ajaxGetFileURL(name, id);
                    }
                }
            },
            error: function (data, status, e)
            {
                $("#loading").hide();
                alert(e);
            }
        }
    );
    return false;
}

function advAjaxFileDelete(name, id){

    $.ajax({
        data: {
            name:name,
            id: id
        },
        dataType: "HTML",
        type:'POST',
        url:'/ajax/adv_delete_file/',
        success:function(data){
            alert(data);
            $('#file_preview').attr('src', '');
            $('#file_preview').text('');

        },
        error:function(data){
            alert("Произошла ошибка при попытке удалить файл");
        }
    });
    return false;
}
/**
 * Получить путь к файлу
 * @param name тип файла
 * @param id идентификатор записи, к которой относится файл
 */
function ajaxGetFileURL(name, id)
{
    $("#loading").ajaxStart(function(){
        $(this).show();
    }).ajaxComplete(function(){
        $(this).hide();
    });
    $.ajax({
            data: {
                name:name,
                id:id
            },
            dataType: "html",
            type:'POST',
            url:'/ajax/get_file_url/',
            success:function(data){
                if (data == '')
                {
                    if ($('#file_preview').get(0).tagName == 'A' ||
                        $('#file_preview').get(0).tagName == 'a')
                    {
                        $('#file_preview').html('Файл отсутствует');
                    }
                    else
                    {
                        $('#file_preview').attr('alt', 'Изображение отсутствует');
                    }
                }
                else
                {
                    if ($('#file_preview').get(0).tagName == 'IMG' ||
                            $('#file_preview').get(0).tagName == 'img')
                    {
                        $('#file_preview').attr('src', data);
                    }
                    else
                    {
                        $('#file_preview').attr('href', data);
                        $('#file_preview').html(data);
                    }
                }
                return data;
            },
            error:function(data){
                if ($('#file_preview').get(0).tagName == 'A' ||
                        $('#file_preview').get(0).tagName == 'a')
                {
                    $('#file_preview').html('Ошибка');
                }
                else
                {
                    $('#file_preview').attr('alt', 'Ошибка');
                }
                return null;
            }
    });
}