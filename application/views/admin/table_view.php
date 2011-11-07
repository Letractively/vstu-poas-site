<table class="admin-data-table">
<?php
if (!isset($classes))   {$classes = array('','','','');}

foreach ($rows as $row)
{
    echo '<tr>';
    for($i = 0; $i < count($row); $i++)
    {
        echo '<td class="' . $classes[$i] .'">';
        echo $row[$i];
        echo '</td>';
    }
    echo '</tr>';    
}
    
?>
</table>