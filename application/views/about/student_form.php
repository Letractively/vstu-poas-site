<div class="student-form-select">
    <?php
        $form == 'bachelor' ? $attr = 'class="current"' : $attr = '';
        menu_item('page_bachelors', '/about/students/bachelor', $attr);
    ?>
    <?php
        $form == 'master' ? $attr = 'class="current"' : $attr = '';
        menu_item('page_masters', '/about/students/master', $attr);
    ?>
    <?php
        $form == 'pg' ? $attr = 'class="current"' : $attr = '';
        menu_item('page_pgs', '/about/students/pg', $attr);
    ?>
    <?php
        $form == 'doc' ? $attr = 'class="current"' : $attr = '';
        menu_item('page_docs', '/about/students/doc', $attr);
    ?>
    <hr>
    <div class="year-select">
        <?php
            foreach($years as $year)
            {
                $year == $currentyear ? $attr = 'class="current"' : $attr = '';
                    echo anchor('/about/students/' . $form . '/' . $year, $year, $attr) . ' ';
            }
        ?>
    </div>
</div>