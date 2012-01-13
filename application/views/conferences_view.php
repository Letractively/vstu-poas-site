<div class="conferences-list">
    <?php foreach ($conferences as $conference): ?>
        <div class="conference-card">
            <h3>
                <?=$conference->name?>
            </h3>
            <h4><?=format_date($conference->begin)?>&nbsp;&nbsp;-&nbsp;&nbsp;<?=format_date($conference->end)?></h4>
            <?php if (isset($conference->url)) : ?>
                <a href="<?=$conference->url;?>"><?=$this->lang->line('visit_site');?></a>
                <br><br>
            <?php endif; ?>
            <?=anchor('/conferences/'.$conference->id, $this->lang->line('site_detail').'...')?>
        </div>
    <?php endforeach; ?>
</div>