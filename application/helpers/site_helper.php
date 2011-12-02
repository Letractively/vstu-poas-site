<?php
	/**
	 * Получить текущий используемый язык
	 * @return string - 'ru' | 'en'
	 */

	function lang($is_full_name = FALSE)
	{
		$ci = & get_instance();
		if( ! isset($ci->curr_lang) )
		{
			$ci->curr_lang = $ci->uri->segment(1);

			if( $ci->curr_lang != 'en' )
			{
				$ci->curr_lang = 'ru';
				$ci->config->config['language'] = 'russian';
			}
			else
			{
				$ci->config->config['language']  = 'english';
			}
			$ci->lang->load('site');
		}

			//if( $ci->curr_lang == 'ru' ) return 'russian';
		//	if( $ci->curr_lang == 'en' ) return 'english';

		return $ci->curr_lang;
	}

	/**
	 * Языковой префикс url-адреса.
	 * Если русский язык - префикс отсутствует. Если английский, то префикс - 'en'
	 * @return string - 'en' | ''
	 */
	function lang_prefix()
	{
		$ci = & get_instance();
		if( ! isset($ci->curr_lang) ) lang();
		if( $ci->curr_lang == 'ru' ) return '';
		return '/'.$ci->curr_lang;
	}

	/**
	 * Получить код ссылки на эту же страницу на другом языке.
	 */
	function link_to_translate()
	{
		$url = $_SERVER['REQUEST_URI'];
		if( substr($url,0,3) == '/en' && ( !isset($url[3]) || $url[3] == '/' ) )
		{
			return '<a href="'.substr($url, 3 ).'"><img src="/images/site/ru.png" title="Переключится на русский"></a>';
		}

		return '<a href="/en'.$url.'"><img src="/images/site/us.png" title="Switch to English"></a>';
	}




	// Этой функцией удобно отлаживать ajax запросы. Выводит строку в файл
	function debug($string) {
		$file = fopen ('C://debug.txt','a+');
		$time = date ('H:i:s');
		fputs ($file, "\n");
		fputs ($file, "$time: ".$string);
		fclose ($file);
	}


	/**
	 * Перевести строку в валидный url-адрес (+ЧПУ)
	 * @param string $str - исходная строка (возможно, с кириллическими символами)
	 * @return string - url-адрес
	 */
	function str_to_url($str) {
		$ci = get_instance();
		$ci->load->helper('url');
		$ci->load->helper('text');

		// Транслетерируем в латинский алфавит и переводим
		// все символы в допустимый для URL вид. Параметр underscore - пробелы заменять на символ '_'.
		// Функция convert_accented_characters производит транслетирацию используя массив, объявленный в файле foreign_chars.php
		return url_title(convert_accented_characters($str), 'underscore', TRUE);
	}

    /**
     * Вывести label c указанным id и классом $class1.
     * Если выполняется условие $condition, то класс дополняется
     * строкой $class2
     * @param $label_text текст метки
     * @param $id идентификатор метки
     * @param $class1 класс метки по-умолчанию
     * @param $condition условие добавочного класса
     * @param $class2 добавочный класс
     * @return html-код
     */
    function form_label_adv($label_text, $id, $class1, $condition, $class2)
    {
        $class = $class1;
        if ($condition)
            $class .= ' ' . $class2;
        return form_label($label_text, $id, array('class' => $class));
    }

    /**
     * Вывести ссылку на страницу с учетом языка
     * @param $name метка строки в словаре
     * @param $path путь к странце без учета языка. Путь должен начинаться с "/"
     * @param $attrs строка дополнительных свойств ссылки
     */
    function menu_item($name, $path, $attrs = '')
    {
        $ci = & get_instance();
        $ci->lang->load('site');
        if (lang() == 'ru')
            echo '<a href="' . $path . '" ' . $attrs . ' >'.$ci->lang->line($name) . '</a>';
        else
            echo '<a href="/en' . $path . '" ' . $attrs . ' >'.$ci->lang->line($name) . '</a>';
    }

    /**
     * Возвращает строку вида <div ...>
     *
     * @param type $class
     * @return type
     */
    function div($class = null)
    {
        if($class === null)
            return '<div>';
        else
            return '<div class="'.$class.'">';
    }

    /**
     * Определяет, нужно ли выводить отладочную информацию
     *
     * @return true, если необходимо, иначе false
     */
    function has_to_show_debug()
    {
        return TRUE;
    }
