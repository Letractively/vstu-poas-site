<div class="student-form-select">
    <?php
        if ($form == 'bachelor')
            $attr = 'class="current"';
        else
            $attr = '';
        menu_item('page_bachelors', '/about/students/bachelor', $attr);
    ?>
    <?php
        if ($form == 'master')
            $attr = 'class="current"';
        else
            $attr = '';
        menu_item('page_masters', '/about/students/master', $attr);
    ?>
    <?php
        if ($form == 'pg')
            $attr = 'class="current"';
        else
            $attr = '';
        menu_item('page_pgs', '/about/students/pg', $attr);
    ?>
    <?php
        if ($form == 'doc')
            $attr = 'class="current"';
        else
            $attr = '';
        menu_item('page_docs', '/about/students/doc', $attr);
    ?>
    <hr>
    <div class="year-select">
        <?php
            foreach($years as $year)
                echo anchor('/about/students/' . $form . '/' . $year, $year);
        ?>
    </div>
</div>