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
<link rel="stylesheet" href="/css/style.css" type="text/css" media="screen, projection, tv" />
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
                <li id="house"><?php menu_item('page_main', '/');?>|</li>
                <li id="rss"><?php echo anchor('/rss', 'RSS');?>|</li>
                <li id="sitemap"><?php menu_item('sitemap', '/sitemap');?>|</li>
                <li id="envelope"><a href="#"><?php echo $this->lang->line('contactus');?></a>|</li>
                <li id="lang"><?php  echo link_to_translate();?></li>
            </ul>
            <?php echo anchor('/','<img id="logo" src="/images/site/design/logo.jpg">');?>
            <!-- Your website name  -->
            <h1><?php echo anchor('/', $this->lang->line('department_acronim'));?></h1>
            <!-- Your website name end -->

                <!-- Your slogan -->
                <h2><?php echo $this->lang->line('department_name');?></h2>
                <h2><a href="http://www.vstu.ru/"><?php echo $this->lang->line('university_name');?></a></h2>
                <!-- Your slogan end -->

            <!-- Search form -->
            <form  class="searching" action="">
            <fieldset>
                <label>Searching</label>
                    <input class="search" type="text" onfocus="if(this.value==this.defaultValue)this.value=''"
                    onblur="if(this.value=='')this.value=this.defaultValue" value="<?php echo $this->lang->line('search');?>..." />
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
            <?php if (!isset($active)) $active = 'none'; ?>
<!--			<li class="first"><?php menu_item('page_main', '/', $active == 'page_main' ? 'class=active':'');?></li>-->
            <li>
				<?php menu_item('page_about', '#', $active == 'page_about' ? 'class=active submenu':'class=submenu')?>
				<ul>
					<li>
						<?php menu_item('page_history', '/about/history')?>
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
					<li>
						<?php menu_item('page_staff', '/about/staff')?>
					</li>
                    <li>
						<?php menu_item('page_students', '/about/students')?>
					</li>
				</ul>
			</li>
			<li><?php menu_item('page_news', '/news', $active == 'page_news' ? 'class=active':'');?></li>
			<li><?php menu_item('page_conferences', '/conferences', $active == 'page_conferences' ? 'class=active':'')?></li>
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
                <div class="breadcrumbs">
                    <?php
                        if(isset($breadcrumbs))
                        {
                            $anchored_breadcrumbs = array();
                            foreach ($breadcrumbs as $link => $name)
                            {
                                if ($link != '/about')
                                    $anchored_breadcrumbs[] = anchor($link, $name);
                                else
                                    $anchored_breadcrumbs[] = $name;
                            }
                            $anchored_breadcrumbs[count($anchored_breadcrumbs)-1]
                                = '<span class="last">'.$anchored_breadcrumbs[count($anchored_breadcrumbs)-1].'</span>';
                            echo '// ' . implode('<span class="delimiter"> // </span>', $anchored_breadcrumbs);
                        }
                    ?>
                </div>
				<div id="content-box-in-left-in">
					<?php if(isset($content)) echo $content; ?>
				</div>
			</div>
			<!-- Left column end -->

<hr class="noscreen" />

			<!-- Right column -->
			<div id="content-box-in-right">
				<div id="content-box-in-right-in">
					<h3><?php echo $this->lang->line('news');?></h3>
						<?
						$ci = get_instance();
						echo $ci->load->view('/news/last_news_view', NULL, TRUE);
						?>
                    <h3><?php echo $this->lang->line('conferences');?></h3>
                        <dl>
							<dt>8 ноября, 2011</dt>
								<dd>XVI Региональная конференция молодых исследователей Волгоградской области</dd>
                            <dt>1 апреля, 2011</dt>
								<dd>MVIII Межгалактическая конференция нанопрограммистов Волгоградской системы</dd>
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
			<p class="footer-left">&copy; <?php echo anchor('/',$this->lang->line('department_acronim'));?>, 2011.</p>
			<p class="footer-right"><?php echo $this->lang->line('designby');?> <a href="http://www.mantisa.cz/">Mantis-a</a></p>
		</div>
	</div>
	<!-- Footer end -->

</div>
</body>
</html>