<?php // Полный вывод одной новости
	echo '<h3>'.$news->name.'</h3>';
	echo '<p>'.$news->text.'</p>';
	
	echo '<div style="clear:both"></div>';
	if($news->photos)
	{
		foreach ( $news->photos as $_photo )
		{
			echo '<img class="img_after_news" src="/'.$_photo->filename.'" />';
		}
		echo '<div style="clear:both"></div>';
	}
	
	if( $news->files )
	{
		echo '<div class="attached_files"><span>'.$this->lang->line('attached_files').':</span><br/><ul>';
		foreach ( $news->files as $_file )
		{
			$_name = explode('/', $_file->filename);
			$_name = $_name[count($_name)-1];
			echo '<li><a href="/'.$_file->filename.'">'.$_name.'</a> ('.(int)($_file->size/1024).'КБ)</li>';
		}
		echo "</ul></div>";
	}
	
	echo br().'<p style="float:right">'.$news->format_time.'</p>'.br();