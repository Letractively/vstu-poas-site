<?php // Полный вывод одной новости
	echo '<h3>'.$news->name.'</h3>';
	echo '<p style="float:right">'.$news->time.'</p>'.br();
	echo '<p>'.$news->text.'</p>';
	