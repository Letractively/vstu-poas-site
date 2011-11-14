<?php


echo '<form name="form" action="" method="POST" enctype="multipart/form-data">';
echo '<img id="loading" src="/images/load/round.gif" style="display:none;">';
echo '<input id="fileToUpload" type="file" size="45" name="fileToUpload" class="input">';
echo '<button class="button" id="buttonUpload" onclick="return ajaxFileUpload(\'fileToUpload\');">Upload</button>';
echo '<br><img id="mypic" src=""/>';
echo '</form>';

?>
