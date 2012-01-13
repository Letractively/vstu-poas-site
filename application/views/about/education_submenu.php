<div class="education-submenu">
	<div class="top-menu">
	    <?php
	        lang();
	        
	        $section == 'index' ? $func = 'menu_item_wii_off' : $func = 'menu_item_wii';
	        $func('page_education_general', '/about/education/index', 'class="button"');
	        
	        $section == 'bachelor' ? $func = 'menu_item_wii_off' : $func = 'menu_item_wii';
	        $func('page_education_bachelor', '/about/education/bachelor', 'class="button"');
	        
	        $section == 'magistracy' ? $func = 'menu_item_wii_off' : $func = 'menu_item_wii';
	        $func('page_education_magistracy', '/about/education/magistracy', 'class="button"');
	        
	        $section == 'pgdoc' ? $func = 'menu_item_wii_off' : $func = 'menu_item_wii';
	        $func('page_education_pgdoc', '/about/education/pgdoc', 'class="button"');
	    ?>
    </div>
</div>