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
			return '<a href="'.substr($url, 3 ).'">Переключится на русский</a>';
		}
		
		return '<a href="/en'.$url.'">Переключится на английский</a>';
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