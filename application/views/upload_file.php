<div class="file_upload">
<?php
    $args = '';
    // upload_path
    $args .= "'";
    $args .= isset($upload_path) ? $upload_path : './uploads/other/';
    $args .= "'";
    $args .= ',';
    // allowed_types
    $args .= "'";
    $args .= isset($allowed_types) ? $allowed_types : 'gif|jpg|png';
    $args .= "'";
    $args .= ',';
    // max_size
    $args .= "'";
    $args .= isset($max_size) ? $max_size : '1000';
    $args .= "'";
    $args .= ',';
    // max_width
    $args .= "'";
    $args .= isset($max_width) ? $max_width : '800';
    $args .= "'";
    $args .= ',';
    // max_height
    $args .= "'";
    $args .= isset($max_height) ? $max_height : '600';
    $args .= "'";
    $args .= ',';
    
    //table_name
    $args .= "'";
    $args .= $table_name;
    $args .= "'";
    $args .= ',';
    //record_id
    $args .= "'";
    $args .= $record_id;
    $args .= "'";
    $args .= ',';
    //field_name
    $args .= "'";
    $args .= $field_name;
    $args .= "'";
?>
<?php 
    $img = array('id'=>'loading', 'src'=>"/images/load/round.gif", 'style'=>'display:none;');
    echo img($img).br();
    
    echo form_upload('file_form', ' ','id="file_form"');
    echo form_button('file_load', 'Загрузить', 'id="file_load" onclick="return ajaxFileUpload('.$args.');"');
    echo br();
    
    echo '<img id="file_preview" alt="Ваш файл" src="'.$this->config->item('base_url').$file_url.'">';
?>
</div>