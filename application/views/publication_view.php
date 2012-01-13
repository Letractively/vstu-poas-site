<?php


// Вывод названия публикации
echo '<p>' . $publication->name . '</p><br>';

$has_abstract = isset($publication->abstract_ru)
                || isset($publication->abstract_en)
                || isset($publication->abstract_ru_file)
                || isset($publication->abstract_en_file);
$has_fulltext = isset($publication->fulltext_ru)
                || isset($publication->fulltext_en)
                || isset($publication->fulltext_ru_file)
                || isset($publication->fulltext_en_file);
$has_author = isset($publication->authors)
        && is_array($publication->authors)
        && count($publication->authors) > 0;
$has_info = isset($publication->info);
$has_year = isset($publication->year);

if(!$has_abstract && !$has_fulltext && !$has_author && !$has_info && !$has_year)
    return;
echo '<a href="#" class="toggleextra">' . $this->lang->line('extra') . '</a>';
echo '<div class="extra" >';

// Вывод ссылок или файлов публикаций

if ($has_abstract)
{
    echo $this->lang->line('abstract') . ' (';
    $resourses = array();
    if (isset($publication->abstract_ru))
        $resourses[] = '<a href="'
            .$publication->abstract_ru
            .'">'
            .$this->lang->line('publication_abstract_link_ru')
            .'</a>';
    if (isset($publication->abstract_ru_file))
        $resourses[] = '<a href="'
            .$this->config->item('base_url')
            .$publication->abstract_ru_file
            .'">'
            .$this->lang->line('publication_abstract_file_ru')
            .'</a>';
    if (isset($publication->abstract_en))
        $resourses[] = '<a href="'
            .$publication->abstract_en
            .'">'
            .$this->lang->line('publication_abstract_link_en')
            .'</a>';
    if (isset($publication->abstract_en_file))
        $resourses[] = '<a href="'
            .$this->config->item('base_url')
            .$publication->abstract_en_file
            .'">'
            .$this->lang->line('publication_abstract_file_en')
            .'</a>';
    echo implode (', ', $resourses);
    echo ')'.br();
}

if ($has_fulltext)
{
    echo $this->lang->line('fulltext') . ' (';
    $resourses = array();
    if (isset($publication->fulltext_ru))
        $resourses[] = '<a href="'
            .$publication->fulltext_ru
            .'">'
            .$this->lang->line('publication_fulltext_link_ru')
            .'</a>';
    if (isset($publication->fulltext_ru_file))
        $resourses[] = '<a href="'
            .$this->config->item('base_url')
            .$publication->fulltext_ru_file
            .'">'
            .$this->lang->line('publication_fulltext_file_ru')
            .'</a>';
    if (isset($publication->fulltext_en))
        $resourses[] = '<a href="'
            .$publication->fulltext_en
            .'">'
            .$this->lang->line('publication_fulltext_link_en')
            .'</a>';
    if (isset($publication->fulltext_en_file))
        $resourses[] = '<a href="'
            .$this->config->item('base_url')
            .$publication->fulltext_en_file
            .'">'
            .$this->lang->line('publication_fulltext_file_en')
            .'</a>';
    echo implode (', ', $resourses);
    echo ')';
}
if ($has_abstract || $has_fulltext)
    echo '<br>';

// Вывод списка авторов
if ($has_author)
{
    if (count($publication->authors) == 1)
        echo $this->lang->line('author').':';
    else
        echo $this->lang->line('authors').':';
    $authors = array();
    for ($i = 0; $i <count($publication->authors); $i++) {

        $author =  $publication->authors[$i]->surname
                . ' '
                . mb_substr($publication->authors[$i]->name, 0, 1)
                . '. '
                . mb_substr($publication->authors[$i]->patronymic, 0, 1)
                . '.';
        $authors[] = anchor('/users/' . $publication->authors[$i]->id, $author);
    }
    echo implode(', ', $authors);
    echo '<br>';
}

// Вывод дополнительной информации
if ($has_info)
        echo $this->lang->line('info').':<br>'.$publication->info;

// Вывод года и ссылки на все публикации этого года
if ($has_year)
        echo $this->lang->line('year'). ' : '.anchor('/about/scientific/publications/'.$publication->year, $publication->year);
echo '</div>';