<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html lang="<?=lang();?>?>"> 
<head> 
	<title><?php if(isset($title)) echo $title; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	
	<link rel="stylesheet" href="/css/style.css">
	<script src="/js/jquery-ui/js/jquery-1.6.2.min.js" type="text/javascript"></script>	<!-- Заменить в релизе локальный вариант на этот! <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"  type="text/javascript"></script>-->
	<script src="/js/site.js" type="text/javascript"></script>
    <script src="/js/ajaxfileupload.js" type="text/javascript"></script>
	<script src="/js/jquery/crypt.js" type="text/javascript"></script>	  
</head> 
<body leftmargin="0" topmargin="0" alink="red" link="#0051a4" vlink="#0051a4"> 
<!-- Основная таблица -->
<div id="admin-panel" style="height:25px; text-align: center; background-color: #BBBBBB">
    <a href="/admin">Управление</a>
</div>
<table height="100%" border="1" align="center" width="65%" style="margin:0 auto;" class="body_table">
<tr>
<td colspan="2" bgcolor="#add2ea" height="79">
<h2><?php if(isset($title)) echo $title; ?></h2></td>
</tr>
<tr>

<td bgcolor="#f0f0f0" width="18%" valign="top">
<!-- Таблица меню -->
<table cellpadding="10">
<tr>
<td>
<font face="Arial" size="2">
<a href="/">Главная</a><br><br>
<a href="/news">Новости</a><br><br>
<a href="/users">Все пользователи</a><br><br>
<a href="/projects">Проекты</a><br><br>
<a href="/publications">Публикации</a><br><br>
<a href="/directions">Направления</a><br><br>
<?php if(isset($main_menu)) echo $main_menu; ?>
</font>
</td>
</tr>
</table>
<!-- Конец таблицы меню -->
</td>
<td valign="top">
<!-- Начало таблицы контента -->
<table cellpadding="3">
<tr>
<td width="800px">

<?php if(isset($content)) echo $content; ?>

</td>
</tr>
</table>
<!-- Конец таблицы контента -->
</td>
</tr>
<tr>
<td colspan="2" align="center"><font size="2">Copyright © 2011, <?php  echo link_to_translate();?> </font></td>

</tr>
</table>
<!-- Конец основной таблицы -->
</body> 

</html> 
