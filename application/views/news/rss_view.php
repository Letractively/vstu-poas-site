<?='<?xml version="1.0" encoding="utf-8"?>'?>
<rss version="2.0">
	<channel>
		<title>Новости кафедры ПОАС</title>
		<link><?=$this->config->item('base_url')?></link>
		<description>Новости кафедры Программного обеспечения автоматизированных систем Волгоградского государственного технического университета</description>
		<language>ru</language>
		
		<? foreach($news as $news_item):?>
			<item>
				<title><?=xml_convert($news_item->name_ru)?></title>
				<link><?=$this->config->item('base_url').'news/show/'.$news_item->url?></link>
				<description><?=xml_convert($news_item->notice_ru)?></description>
				<pubDate><?=date('r', strtotime($news_item->time))?></pubDate>
			</item>
		<? endforeach;?>
	</channel>
</rss>