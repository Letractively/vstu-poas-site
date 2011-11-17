<?php // Отобразить проект

echo '<div class="direction">';
echo heading($direction->name, 3);

echo br(2);
if (isset ($direction->description) && $direction->description !== '')
{
	echo $direction->description;
	echo br(2);
}

//print_r($members);
if (count($members) > 0)
{
	// подготовим список руководителей и заодно узнаем, много ли их
	$headcount = 0;
	$othercount = 0;
	$heads = '';
	$others = '';
	foreach ($members as $member)
	{
		if ($member->ishead == true) 
		{
			$headcount++;
			$heads .= anchor('/users/'.$member->id, $member->surname . ' '. $member->name).br();
		}
		else
		{
			$othercount++;
			$others .= anchor('/users/'.$member->id, $member->surname . ' '. $member->name).br();
		}
		 
	}
	if ($headcount == 1)
		echo heading($this->lang->line('directionheaderis',3));
	if ($headcount > 1)
		echo heading($this->lang->line('directionheaderare',3));
	echo $heads;
	echo br();
	if ($othercount == 1)
		echo heading($this->lang->line('directionmemberis',3));
	if ($othercount > 1)
		echo heading($this->lang->line('directionmembersare',3));
	echo $others;
}
echo '</div>';
?>
<?php
/* End of file direction_view.php */
/* Location: ./application/views/direction_view.php */ 