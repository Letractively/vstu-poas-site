<?php

echo $publication->name;

if (isset($publication->year)) {echo ' (' . $publication->year . ')';};
        
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
