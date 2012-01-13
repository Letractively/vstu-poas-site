<div class="scientific-submenu">
	<div class="top-menu">
	    <?php
	        lang();
	        $section == 'index' ? $func = 'menu_item_wii_off' : $func = 'menu_item_wii';
	        $func('page_scientific_general', '/about/scientific/index', 'class="button"');
	        
	        $section == 'publications' ? $func = 'menu_item_wii_off' : $func = 'menu_item_wii';
	        $func('page_scientific_publications', '/about/scientific/publications', 'class="button"');
	        
	        $section == 'projects' ? $func = 'menu_item_wii_off' : $func = 'menu_item_wii';
	        $func('page_scientific_projects', '/about/scientific/projects', 'class="button"');
	        
	        $section == 'directions' ? $func = 'menu_item_wii_off' : $func = 'menu_item_wii';
	        $func('page_scientific_directions', '/about/scientific/directions', 'class="button"');        
	    ?>
    </div>
</div>