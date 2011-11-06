<?php // Отобразить все публикации

if (isset($currentyear))    {echo heading($currentyear, 3);}
foreach ($years as $year)
{
    echo anchor('/publications/' . $year, $year );
    echo ' ';
}
echo br(2);
echo '<ol type="1">';
foreach ($publications as $publication)
{
	echo '<li>';
	echo $publication->name;
    $texts = array(
        'fulltext_ru' => $this->lang->line('publication_fulltext_ru'),
        'fulltext_en' => $this->lang->line('publication_fulltext_en'),
        'abstract_ru' => $this->lang->line('publication_abstract_ru'),
        'abstract_en' => $this->lang->line('publication_abstract_en'),
        );
    foreach ($texts as $field => $label) 
    {
        if (isset($publication->$field)) 
        {
            echo br().anchor($publication->$field, $label);
        }
    }
	echo '</li>';
	echo br();
}
echo '</ol>';
/* End of file publications_view.php */
/* Location: ./application/views/publications_view.php */