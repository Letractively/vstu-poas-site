<?php
/**
 * Переопределянная функция anchor, с поддержкой языков.
 * На сайте для вывода ссылок всегда используем функцию anchor, без учёта языка
 * (функция сама подправит ссылку с учётом языка, если нужно)
 * 
 * Также, в отличии от стандартной, параметр $uri может начинаться с # (пустая (#none) или якорная ссылка)
 * 
 * Пример: anchor('/news','Новости') - вернёт ссылку на "/en/news", либо на "/news", в зависимости от текущего url
 */
function anchor($uri = '', $title = '', $attributes = '')
{
	$title = (string) $title;

	if ( ! is_array($uri))
	{
		if($uri[0] == '#')
		{
			$site_url = $uri;
		}
		else
		{
			$site_url = ( ! preg_match('!^\w+://! i', $uri)) ? site_url(lang_prefix().$uri) : lang_prefix().$uri;
		}
	}
	else
	{
		$site_url = site_url(lang_prefix().$uri);
	}

	if ($title == '')
	{
		$title = $site_url;
	}

	if ($attributes != '')
	{
		$attributes = _parse_attributes($attributes);
	}
	
	return '<a href="'.$site_url.'"'.$attributes.'>'.$title.'</a>';
}