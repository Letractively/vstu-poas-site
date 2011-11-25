<div class="scientific-submenu">
    <?php
        lang();
        if ($section == 'index')
            echo anchor('/about/scientific/index',$this->lang->line('page_scientific_index'),'class=selected'). ' ';
        else
            echo anchor('/about/scientific/index',$this->lang->line('page_scientific_index')). ' ';

        if ($section == 'publications')
            echo anchor('/about/scientific/publications',$this->lang->line('page_scientific_publications'),'class=selected'). ' ';
        else
            echo anchor('/about/scientific/publications',$this->lang->line('page_scientific_publications')). ' ';

        if ($section == 'projects')
            echo anchor('/about/scientific/projects',$this->lang->line('page_scientific_projects'),'class=selected'). ' ';
        else
            echo anchor('/about/scientific/projects',$this->lang->line('page_scientific_projects')). ' ';

        if ($section == 'directions')
            echo anchor('/about/scientific/directions',$this->lang->line('page_scientific_directions'),'class=selected'). ' ';
        else
            echo anchor('/about/scientific/directions',$this->lang->line('page_scientific_directions')). ' ';
    ?>
</div>