<?php // Полный вывод одной новости
	echo '<h3>'.$news->name.'</h3>';
	echo '<p>'.$news->text.'</p>';
	echo br().'<p style="float:right">'.$news->time.'</p>'.br();
	