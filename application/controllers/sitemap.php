<?php

/**
 * Страница карты сайта *
 */
class Sitemap extends CI_Controller{
	/**
	 * Конструктор контроллера
	 * 
	 * @access public
	 */
    public function __construct()
    {
        parent::__construct();
        lang();
        if (has_to_show_debug())
            $this->output->enable_profiler(TRUE);
    }

    /**
     * Страница карты сайта
     * 
     * @access public
     */
    public function index()
    {
    	// Сформировать хлебные крошки
    	$breadcrumbs['/'] = $this->lang->line('page_main');
    	$breadcrumbs['/sitemap'] = $this->lang->line('page_sitemap');
    	
    	$data['breadcrumbs'] = $breadcrumbs;
        $data['title'] = $this->lang->line('page_sitemap');
		$data['content'] = $this->load->view('sitemap/sitemap_view', '', TRUE);
        
		$this->load->view('templates/main_view', $data);

    }
}

/* End of file sitemap.php */
/* Location: ./application/controllers/sitemap.php */