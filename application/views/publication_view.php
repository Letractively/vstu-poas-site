<?php

echo '<p>' . $publication->name . '</p><br>';

$has_abstract = isset($publication->abstract_ru) || isset($publication->abstract_en);
$has_fulltext = isset($publication->fulltext_ru) || isset($publication->fulltext_en);
$has_author = isset($publication->authors) 
        && is_array($publication->authors)
        && count($publication->authors) > 0;
$has_info = isset($publication->info);

if(!$has_abstract && !$has_fulltext && !$has_author && !$has_info)
    return;
echo '<a href="#" class="toggleextra">' . $this->lang->line('extra') . '</a>';
echo '<div class="extra" >';

// Вывод ссылок или файлов публикаций

if ($has_abstract)
{
    echo $this->lang->line('abstract') . ' (';
    if (isset($publication->abstract_ru))
            echo '<a href="'.$publication->abstract_ru.'">'.$this->lang->line('russian').'</a>';
    if (isset($publication->abstract_ru) && isset($publication->abstract_en))
            echo ', ';
    if (isset($publication->abstract_en))
            echo '<a href="'.$publication->abstract_en.'">'.$this->lang->line('english').'</a>';
    echo ')';
}

if ($has_fulltext)
{
    if ($has_abstract && $has_fulltext)
        echo ', '.strtolower($this->lang->line('fulltext')) . ' (';
    else
        echo $this->lang->line('fulltext') . ' (';
    if (isset($publication->fulltext_ru))
            echo '<a href="'.$publication->fulltext_ru.'">'.$this->lang->line('russian').'</a>';
    if (isset($publication->fulltextt_ru) && isset($publication->abstract_en))
            echo ', ';
    if (isset($publication->fulltext_en))
            echo '<a href="'.$publication->fulltext_en.'">'.$this->lang->line('english').'</a>';
    echo ')';
}
if ($has_abstract || $has_fulltext)
    echo '.<br>';

// Вывод списка авторов
if ($has_author)
{
    if (count($publication->authors) == 1)
        echo $this->lang->line('author').':';
    else
        echo $this->lang->line('authors').':';
    for ($i = 0; $i <count($publication->authors); $i++) {
        
        $author =  $publication->authors[$i]->surname 
                . ' ' 
                . mb_substr($publication->authors[$i]->name, 0, 1)
                . '. ' 
                . mb_substr($publication->authors[$i]->patronymic, 0, 1)
                . '.';
        echo anchor('/users/' . $publication->authors[$i]->id, $author);
        if ($i != count($publication->authors)-1)
            echo ', ';
    }
    echo '<br>';
}

// Вывод дополнительной информации
if ($has_info)
        echo $this->lang->line('info').':<br>'.$publication->info;
echo '</div>';