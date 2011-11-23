<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" />
	<title><?if(isset($title)) echo $title.' - ';?>POAS igniter</title>
	<link rel="stylesheet" type="text/css" href="/css/admin.css" />
	<!--<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/base/jquery-ui.css" type="text/css" media="all" />-->
	<!--<link rel="stylesheet" href="http://static.jquery.com/ui/css/demo-docs-theme/ui.theme.css" type="text/css" media="all" />-->
	<script src="/js/jquery-ui/js/jquery-1.6.2.min.js" type="text/javascript"></script>	<!-- Заменить локальный вариант на этот! <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"  type="text/javascript"></script>-->
	
	<link type="text/css" href="/js/jquery-ui/css/smoothness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
	
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js" type="text/javascript"></script>
    <!--<script src="/js/jquery-ui/js/jquery-ui-1.8.16.custom.min.js"></script>-->
		
	<script src="/js/elrte-1.3/js/elrte.min.js"  type="text/javascript"></script>
	<script src="/js/elrte-1.3/js/i18n/elrte.ru.js" type="text/javascript" charset="utf-8"></script>
    <script src="/js/ajaxfileupload.js" type="text/javascript"></script>
    <script src="/js/jquery.form.js" type="text/javascript"></script>
	<link rel="stylesheet" href="/js/elrte-1.3/css/elrte.min.css" type="text/css" media="all" />
	

	<script src="/js/admin.js"  type="text/javascript"></script>
</head>
<body>

<div id="container">
	
	<!-- ### Header ### -->
	
	<div id="header">	
		<h1>POAS igniter <span>CMS</span></h1>
		<p>Панель управления</p>		

		<!-- ### Top Menu ### -->

		<div id="topmenu">
		<ul>
            <li><a href="/">На сайт</a></li>
			<li><a href="/admin">Главная</a></li>	
            <li><a href="/admin/news">Новости</a></li>
			<li><a href="/admin/users">Пользователи</a></li>
            <li><a href="/admin/courses">Курсы</a></li>
			<li><a href="/admin/projects">Проекты</a></li>
			<li><a href="/admin/directions">Направления</a></li>
            <li><a href="/admin/publications">Публикации</a></li>
            <li><a href="/admin/partners">Партнеры</a></li>
			<li><a href="/logout">Выйти</a></li>
		</ul>	
		</div>

	</div>
	
	<!-- ### Content ### -->
	
	<div id="contentcontainer">
		<div id="content">
			<div class="post">
				
				<h2><?php if(isset($title)) echo $title; else echo 'Здесь пока что нет полезной информации';?></h2>
				<p class="posted attention"><?php if(isset($message)) echo $message; else echo $this->input->post('message');?></p>
	
				<div class="entry">
					<?php if( isset($content) ): ?>
					<?php echo $content; else: ?>
					<blockquote><p>Где польза от того, что мы пришли — ушли?<br/>
					Где в коврик бытия хоть нитку мы вплели?<br/>
					В курильнице небес живьем сгорают души.<br/>
					Но где же хоть дымок от тех, кого сожгли?</p></blockquote>
					<i>Омар Хайям</i>
					<blockquote><p>Если подлый лекарство нальет тебе — вылей!<br/>
					Если мудрый нальет тебе яду — прими!</p></blockquote>
					<i>Омар Хайям</i>
					<blockquote><p>Если не исправишь зло, оно удвоится.</p></blockquote>
					<i>Какой-то египтянен</i>
					<?php endif;?>
				</div>
				<p class="metadata"><a href="#" class="postcomment">Да ну нафиг?</a></p>
			</div>

			<div class="postpagesnav">
				<!--<div class="older"><a href="#">&laquo; Older entries</a></div>
				<div class="newer"><a href="#">Newer entries &raquo;</a></div>-->
				</div>
		</div>

		<div id="sidebar">
			<ul>
				<li><h2>Search</h2>
				<form id="searchform" method="get" action="#">
					<div>
					<input type="text" value="" name="s" id="searchfield" />
					<input type="hidden" id="searchsubmit" value="Search" />
					</div>
				</form>
				</li>
				<?php if(isset($menu)) echo $this->load->view($menu, TRUE); ?>
			</ul>	
		</div>
	</div>
</div>	

<div id="footer">
	<p>&copy; 2011 ПОАС </p>
</div>
<div id="dialog_ui"></div>
<p><br />Page rendered in {elapsed_time} seconds</p>
</body>
</html>