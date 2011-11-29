<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html lang="<?=lang();?>?>">
<head>

<!-- This template was created by Mantis-a [http://www.mantisa.cz/]. For more templates visit Free website templates [http://www.mantisatemplates.com/]. -->

<meta name="Description" content="..." />
<meta name="Keywords" content="..." />
<meta name="robots" content="all,follow" />
<meta name="author" content="..." />
<meta name="copyright" content="Mantis-a [http://www.mantisa.cz/]" />

<meta http-equiv="Content-Script-Type" content="text/javascript" />

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- CSS -->
<link rel="stylesheet" href="/css/style_new.css" type="text/css" media="screen, projection, tv" />
<!--[if lte IE 6]><link rel="stylesheet" type="text/css" href="/css/style-ie.css" media="screen, projection, tv" /><![endif]-->
<link rel="stylesheet" href="/css/style-print.css" type="text/css" media="print" />

<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<script src="/js/jquery-ui/js/jquery-1.6.2.min.js" type="text/javascript"></script>	
<!-- Заменить в релизе локальный вариант на этот! <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"  type="text/javascript"></script>-->
<script src="/js/site.js" type="text/javascript"></script>
<script src="/js/ajaxfileupload.js" type="text/javascript"></script>
<script src="/js/jquery/crypt.js" type="text/javascript"></script>
<title><?php if (isset($title)) echo $title . '. ' . $this->lang->line('site_name'); else echo $this->lang->line('site_name');?></title>
</head>

<body>
<div id="main">

	<!-- Header -->
	<div id="header">
		<div id="header-in">
			<ul id="navigation">
				<li id="house"><a href="#">Главная</a>|</li>
				<li id="sitemap"><a href="#">Карта сайта</a>|</li>
				<li id="envelope"><a href="#">Связаться с нами</a></li>
		</ul>
		<!-- Your website name  -->
		<h1><a href="#">ПОАС</a></h1>
		<!-- Your website name end -->
		
			<!-- Your slogan -->
			<h2>Программное обеспечение автоматизированных систем</h2>
			<!-- Your slogan end -->

		<!-- Search form -->
		<form  class="searching" action="">
		<fieldset>
			<label>Searching</label>
				<input class="search" type="text" onfocus="if(this.value==this.defaultValue)this.value=''" 
				onblur="if(this.value=='')this.value=this.defaultValue" value="Искать..." />
				<input class="hledat" type="image" src="/images/site/design/search-button.gif" name="" alt="Search" />
		</fieldset>
		</form>
		<!-- Search end -->		
		</div>
	</div>
	<!-- Header end -->
	
	<!-- Menu -->
	<div id="menu-box" class="cleaning-box">
	<a href="#skip-menu" class="hidden">Skip menu</a>
		<ul id="menu">
			<li class="first"><?php menu_item('page_main', '/', $active == 'page_main' ? 'class=active':'');?></li>
			<li><?php menu_item('page_news', '/news', $active == 'page_news' ? 'class=active':'');?></li>
			<li><?php menu_item('page_conferences', '/conferences', $active == 'page_conferences' ? 'class=active':'')?></li>
			<li>
				<?php menu_item('page_about', '#', $active == 'page_about' ? 'class=active submenu':'class=submenu')?>
				<ul>
					<li>
						<?php menu_item('page_history', '/about/history')?>
					</li>
					<li>
						<?php menu_item('page_students', '/about/students')?>
					</li>
					<li>
						<?php menu_item('page_staff', '/about/staff')?>
					</li>
					<li>
						<?php menu_item('page_education', '/about/education')?>
					</li>
					<li>
						<?php menu_item('page_scientific', '/about/scientific')?>
					</li>
					<li>
						<?php menu_item('page_international', '/about/international')?>
					</li>
				</ul>
			</li>
			<li><?php menu_item('page_partners', '/partners', $active == 'page_partners' ? 'class=active':'')?></li>
			<li><?php menu_item('page_contacts', '/contacts', $active == 'page_contacts' ? 'class=active':'')?></li>
		</ul>
	</div>
	<!-- Menu end -->
	
<hr class="noscreen" />

<div id="skip-menu"></div>
	
	<div id="content">
	
		<!-- Content box with white background and gray border -->
		<div id="content-box">
		
			<!-- Left column -->
			<div id="content-box-in-left">
				<div id="content-box-in-left-in">
					<?php if(isset($content)) echo $content; ?>
				</div>
			</div>
			<!-- Left column end -->

<hr class="noscreen" />
			
			<!-- Right column -->
			<div id="content-box-in-right">
				<div id="content-box-in-right-in">
					<h3>Новости</h3>
						<dl>
							<dt>15 ноября, 2011</dt>
								<dd>Закончилась XVI Региональная конференция молодых исследователей Волгоградской области...</dd>
								
							<dt>10 ноября, 2011</dt>
								<dd>Состоялось слушение работ...</dd>
								
							<dt>February 2008</dt>
								<dd>Donec massa dui, rhoncus nec, ornare sit amet, euismod vitae, mi.</dd>
								
							<dt>February 2008</dt>
								<dd>Donec massa dui, rhoncus nec, ornare sit amet, euismod vitae, mi.</dd>
						</dl>
			<h3>Конференции</h3>
<dl>
							<dt>8 ноября, 2011</dt>
								<dd>XVI Региональная конференция молодых исследователей Волгоградской области</dd>
						</dl>
				
			</div>
			</div>
			<div class="cleaner">&nbsp;</div>
			<!-- Right column end -->
		</div>
		<!-- Content box with white background and gray border end -->
	</div>

<hr class="noscreen" />
	
	<!-- Footer -->
	<div id="footer">
		<div id="footer-in">
			<p class="footer-left">© <a href="#">ПОАС</a>, 2011.</p>
			<p class="footer-right">Дизайн<a href="http://www.mantisa.cz/">Mantis-a</a></p>
		</div>
	</div>
	<!-- Footer end -->

</div>
</body>
</html>