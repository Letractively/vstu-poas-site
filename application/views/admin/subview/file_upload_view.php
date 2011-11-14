<div>
<?php
    if(!isset($path))
    {
        echo '<div class="service">Нет изображения</div>';
        $path = '';
    }
    else
    {
        echo '<div class="service"></div>';
    }
    $loadedimg = array('id'=>$field.'_image', 'src'=>$path);
    
    echo img($loadedimg).br();
    
    echo form_label($label, $field, array('class' => 'inline-block'));
    echo form_upload($field.'_form', set_value($field, $fileid),'id="'.$field.'_form"');
    
    echo form_button($field.'_load', 'Загрузить', 'id="'.$field.'_load" onclick="return ajaxFileUpload(\''.$field.'_form\',\''.$field.'\');"');
    echo br();
    $img = array('id'=>'loading', 'src'=>"/images/load/round.gif", 'style'=>'display:none;');
    echo img($img);    
    echo form_hidden($field.'_id', $fileid); 
    echo form_hidden($field.'_name', $path); 
    echo br();
?>
</div>