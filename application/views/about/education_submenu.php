<div class="education-submenu">
    <?php
        lang();
        if ($section == 'index')
            echo anchor('/about/education/index',$this->lang->line('page_education_index'),'class=selected'). ' ';
        else
            echo anchor('/about/education/index',$this->lang->line('page_education_index')). ' ';

        if ($section == 'bachelor')
            echo anchor('/about/education/bachelor',$this->lang->line('page_education_bachelor'),'class=selected'). ' ';
        else
            echo anchor('/about/education/bachelor',$this->lang->line('page_education_bachelor')). ' ';

        if ($section == 'magistracy')
            echo anchor('/about/education/magistracy',$this->lang->line('page_education_magistracy'),'class=selected'). ' ';
        else
            echo anchor('/about/education/magistracy',$this->lang->line('page_education_magistracy')). ' ';

        if ($section == 'pgdoc')
            echo anchor('/about/education/pgdoc',$this->lang->line('page_education_pgdoc'),'class=selected'). ' ';
        else
            echo anchor('/about/education/pgdoc',$this->lang->line('page_education_pgdoc')). ' ';
    ?>
</div>