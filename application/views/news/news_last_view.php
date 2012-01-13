<?php // Отобразить кратко последние новости?>

<div class="news-short">
<?php

foreach($news as $curr_news):
?>
	<div>
		<h3><?=$curr_news->name;?></h3>
		<p class="padd-right text-2 p"><?=$curr_news->notice;?></p>
		<?=anchor('/news/show/'.$curr_news->url, $this->lang->line('site_detail').'...' );?>
	</div>
<?php
endforeach;
?>      

</div>
<?php
/* End of file news_las_view.php */
/* Location: ./application/views/admin/news_last_view.php */