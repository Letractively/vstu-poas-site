<?php if(!isset($last_conferences))
{
	$ci = get_instance();
    $ci->load->model(MODEL_CONFERENCE);
	$last_conferences = $ci->{MODEL_CONFERENCE}->get_last(3);
}
?>
<dl>
    <?php foreach ($last_conferences as $conference) : ?>
        <dt>
            <?=format_date($conference->begin)?>
        </dt>
        <dd>
            <?=$conference->name?>
            <br>
            <?=anchor('/conferences/'.$conference->id, $this->lang->line('site_detail').'...')?>
        </dd>
    <?php endforeach;?>
</dl>