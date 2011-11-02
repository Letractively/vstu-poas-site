<!DOCTYPE html>
<html lang="<?=lang();?>?>">
<head>
    <title><?php if(isset($title)) echo $title; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="/css/style.css" type="text/css" media="screen">
	<link rel="stylesheet" href="/css/grid.css" type="text/css" media="screen">	
    <script src="/js/jquery-ui/js/jquery-1.6.2.min.js" type="text/javascript"></script>	<!-- Заменить локальный вариант на этот! <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"  type="text/javascript"></script>-->
	<script src="/js/site.js" type="text/javascript"></script>
	<script src="/js/jquery/crypt.js" type="text/javascript"></script>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
</head>
<body id="page1">
    <div class="main">
    	<div class="container_24" >
            <!--==============================header=================================-->
            <header>
            	<div class="wrapper" >
                	<div class="grid_4 index-2">
                        <h1><a href="">GLOBAL solutions</a></h1>
                        <nav>
                            <ul class="menu">
                                <li class="first"><a href="/news">Новости</a></li>
                                <li class="second"><a href="/projects">Проекты</a></li>
								<!--
                                <li class="third"><a href="/">Services</a>
                                	<ul>
                                    	<li><a href="/">Overview</a></li>
                                        <li><a href="/">Small Business</a>
                                        	<ul>
                                            	<li><a href="/">Overview</a></li>
                                                <li><a href="/">Small Business</a></li>
                                                <li><a href="/">Corporate</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="">Что-нибудь</a></li>
                                    </ul>
                                </li>
                                <li class="four"><a href="">Clients</a></li>
                                <li class="five"><a href="">Contacts</a></li>
								-->
                            </ul>
                        </nav>
                	</div>
                    <div class="grid_20 index-1" >
                    	  <div class="slider">
                    	  <img src="/images/img/korpus3.jpg" style="" />
                        <!--    <ul class="items">
                                <li>
                                    <img src="images/img/slider-i.jpg" alt="" />
                                </li>
                                <li>
                                    <img src="images/img/slider-j.jpg" alt="" />
                                </li>
                                <li>
                                    <img src="images/img/slider-k.jpg" alt="" />
                                </li>
                            </ul>
                            <ul class="pagination">
                                <li><a href=""><span></span></a></li>
                                <li><a href=""><span></span></a></li>
                                <li><a href=""><span></span></a></li>
                            </ul>-->
                        </div>
                    </div>
                </div>
                <!--div class="wrapper">
                	<div class="grid_4">
                    	<div class="header-box">
                        	<h5 class="mt2 h5border border-1 p2">online chat</h5>
                            <p class="text-3 color-3 p2">Fusce euismod conse- quat ante. Lorem ipsum dolor sit amet, consect etuer adipiscing elit.</p>
                            <a class="button" href=""><strong><strong><strong>Start Now!</strong></strong></strong></a>
                        </div>
                    </div>
                    <div class="grid_20">
                    	<div class="wrapper">
                        	<div class="border-1 padd-bot p">
                                <ul class="second-menu wrapper">
                                	<li class="first"><a href=""><strong>Strategy</strong><em>Proin dictum elementum velit</em></a></li>
                                    <li class="second"><a href=""><strong>Mission</strong><em>In pede mi, aliquet sit amet</em></a></li>
                                    <li class="third"><a href=""><strong>Results</strong><em>Donec sagittis euismod purus</em></a></li>
                                </ul>
                            </div>
                            <div class="greating border-1 padd-bot-spec">
                            	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent vestibulum molestie lacus. Aenean nonummy hendrerit mauris. Phasellus porta. Fusce suscipit varius mi. Cum sociis natoque !
                            </div>
                        </div>
                    </div>
                </div>
				-->
            </header>
        
            <!--==============================content================================-->
            <section id="content">
            	 <?php if(isset($content)) echo $content; ?>
				 <!--
                <div class="row2-container">	
                    <div class="wrapper">
                    	<div class="grid_5 suffix_1">
                        	<div class="wrapper">
                            	<figure class="fleft img-indent"><img src="/images/img/page1-ic.png" alt="" /></figure>
                                <div class="extra-wrap">
                                	<h5 class="p">latest tweet</h5>
                                    <span class="color-3 inline-block text-2">In pede mi, aliquet sit amet, euismod in,auctor</span>
                                    <a class="decor text-2 p2 inline-block" href="">http/loremipsum/doler</a>
                                    <a class="link">Follow us on Twitter</a>
                                </div>
                            </div>
                        </div>
                        <div class="grid_5 suffix_1">
                        	<div class="wrapper">
                            	<figure class="fleft img-indent"><img src="/images/img/page1-id.png" alt="" /></figure>
                                <div class="extra-wrap">
                                	<h5 class="p">Facebook</h5>
                                    <span class="color-3 p2 inline-block text-2">Praesent justo dolor, lobortis quis, lobortis dignissim, pulvinar ac, lorem liquam dapibus</span>
                                    <a class="link">Like us on Facebook</a>
                                </div>
                            </div>
                        </div>
                        <div class="grid_11 suffix_1">
                        	<div class="wrapper">
                            	<figure class="fleft img-indent"><img src="/images/img/page1-ie.png" alt="" /></figure>
                                <div class="extra-wrap">
                                	<h5 class="p2">mail us</h5>
                                    <div class="wrapper">
                                 		<form id="mail">
                                        <div class="success"> Contact form submitted!<br>
                               			<strong>We will be in touch soon.</strong> </div>
											<fieldset>
                                            	<div class="fleft img-indent3">
                                                    <label class="name">
                                                              <input type="text" value="Name:">
                                                              <span class="error">* Wrong name.</span> <span class="empty">*This field is required.</span> </label>
                                                            <label class="email">
                                                              <input type="text" value="E-mail:">
                                                              <span class="error">* Wrong email address.</span> <span class="empty">*This field is required.</span> </label>
                                                </div>
                                                <div class="extra-wrap">
                                                	<label class="message">
                                  <textarea>Message:</textarea>
                                  <span class="error">*The message is too short.</span> <span class="empty">*This field is required.</span> </label>
													<div class="buttons">
                                                    <a class="button-1" data-type="reset"><strong><strong><strong>Clear</strong></strong></strong></a>
                                                    <a class="button-1" data-type="submit"><strong><strong><strong>Send message</strong></strong></strong></a>
													</div>
                                                </div>											
											</fieldset>           
										</form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				-->
            </section>
            <!--==============================footer=================================-->
            <footer>
            	<div class="wrapper">
                	<span class="fleft padd-left">Global Solutions &copy; 2011 <a class="decor" href="">Privacy Policy</a></span>
                	<span class="fright"><!-- {%FOOTER_LINK} --></span>
                </div>
            </footer>
        </div>
    </div>
    <?php  echo link_to_translate();?>
</body>
</html>