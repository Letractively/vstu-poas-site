<?php
echo '<div class="partner">';
echo heading($partner->name, 3);
if (isset($partner->image))
{
    echo br().img($partner->image).br();
}
if (isset($partner->url))
{
    echo "<a href='$partner->url'>" . $this->lang->line('visit_site') . "</a>";
}
echo br(2);
echo $partner->short;
echo br(2);
echo $partner->full;
echo '</div>';
?>