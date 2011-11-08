<?php // Отобразить все публикации

if (isset($currentyear))    {echo heading($currentyear, 3);}
foreach ($years as $year)
{
    echo anchor('/publications/' . $year, $year );
    echo ' ';
}
echo br(2);

if(isset($publications))
{
    echo '<ol class="publications">';

    foreach ($publications as $publication)
    {
        echo '<li>';
        $data['publication'] = $publication;
        $this->load->view('publication_view', $data);
        echo '</li>' . br();

    }
    echo '</ol>';
}
/* End of file publications_view.php */
/* Location: ./application/views/publications_view.php */