<?php if(!isset($last_news))
{
	$ci = get_instance();
	$last_news = $ci->news_model->get_short(1, AMOUNT_LAST_NEWS);
}
?>

<dl>

<? foreach($last_news as $_news): ?>

<dt><?=$_news->name;?><span style="float:right"></span></dt>
<dd>
<p><?=$_news->notice;?></p>
<?=anchor('/news/show/'.$_news->url, $this->lang->line('site_detail').'...', 'class="read_more_button"');?>
<p class="last_news_date"><?=$_news->date;?></p>
</dd>
<? endforeach;?>
</dl>