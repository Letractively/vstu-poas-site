<div class="student-form-select">
<div class="top-menu">
    <?php
    	$attr = 'class="button"';
        $form == 'bachelor' ? $func = 'menu_item_wii_off' : $func = 'menu_item_wii';
        $func('page_bachelors', '/about/students/bachelor', $attr);
    ?>
    <?php
        $form == 'master' ? $func = 'menu_item_wii_off' : $func = 'menu_item_wii';
        $func('page_masters', '/about/students/master', $attr);
    ?>
    <?php
        $form == 'pg' ? $func = 'menu_item_wii_off' : $func = 'menu_item_wii';
        $func('page_pgs', '/about/students/pg', $attr);
    ?>
    <?php
        $form == 'doc' ? $func = 'menu_item_wii_off' : $func = 'menu_item_wii';
        $func('page_docs', '/about/students/doc', $attr);
    ?>
</div>

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