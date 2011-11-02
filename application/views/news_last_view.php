<?php // Отобразить кратко последние новости?>

<div class="row1-container">
	<div class="wrapper">
<?php

foreach($news as $curr_news):
?>
	<div class="grid_6">
		<h3><?=$curr_news->name;?></h3>
		<p class="padd-right text-2 p"><?=$curr_news->notice;?></p>
		<?=anchor('/news/show/'.$curr_news->url, $this->lang->line('site_detail').'...', array('class'=>'link') );?>  <?php /// @todo Добавить использование словарей для полной поддержки двух языков?>
	</div>
<?php
endforeach;
?>      
<?php /* Пример
<div class="grid_6">
	<figure class="img-container img-indent-bot"><img src="images/img/page1-in.jpg" alt="" /></figure>
	<div class="clear"></div>
	<h3>Outsourcing of all<span class="block mt-7"> Marketing Functions</span></h3>
	<p class="padd-right text-2 p">Fusce euismod consequat ante. Lorem ipsum dolor sit amet, con- sectetuer adipiscing elit. Pellen- tesque sed dolor. Aliquam congue fermentum nisl. auris accumsan nulla vel diam. Sed in lacus ut </p>
	<a class="link" href="">Read More</a>
</div> 
*/ ?>

</div></div>
<?php
/* End of file news_las_view.php */
/* Location: ./application/views/admin/news_last_view.php */