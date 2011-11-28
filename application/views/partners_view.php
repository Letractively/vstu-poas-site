<?php
foreach ($partners as $partner)
{
	echo '<div class="partner">';
    //$count = ' (Участвует в проекте:' . $project->memberscount . ')';
	echo heading(anchor('/partners/'.$partner->id, $partner->name), 3);
    echo $partner->short.br();
	if (isset($partner->url))
	{
		// Так не работает на английской версии страницы, перед http:\\ добавляется en
		// echo anchor($project->url, $this->lang->line('visit_site'), array('class'=>'link'));
		echo "<a href='$partner->url'>" . $this->lang->line('visit_site') . "</a>";
	}
	echo '</div>';
	echo br();
}
?>