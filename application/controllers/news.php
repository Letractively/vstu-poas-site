<?php
class News extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		if (has_to_show_debug())
            $this->output->enable_profiler(TRUE);
		$this->load->database('default');
		$this->load->model('user_model');
		$this->load->model('news_model');
		lang();
	}

	function index()
	{
		$data['title'] = $this->lang->line('page_news');
        $data['active'] = 'page_news';
		$data['news'] = $this->news_model->get_short(1, 4);
		$data['content'] = $this->load->view('news/news_last_view', $data, TRUE);
        $data['breadcrumbs'] = $this->_get_breadcrumbs();
		$this->load->view('templates/main_view', $data);
	}


	/**
	 * @method
	 * Страница с новостями
	 * @param [in] segment3 - номер страницы
	 */
	function get()
	{
		// @todo - страница с новостями (к примеру 10 новостей на каждой странице)
		//$data['news'] = $this->news_model->get_short(1, 4);
		//$data['content'] = $this->load->view('news_last_view', $data, TRUE);
		//$this->load->view('templates/main_view', $data);
	}

	/**
	 * @todo
	 * Страница просмотра одной новости целиком
	 */
	function show( $url_of_news )
	{

        $data['breadcrumbs'] = $this->_get_breadcrumbs();
		$data['title'] = $this->lang->line('page_news');
        $data['active'] = 'page_news';
		$data['news'] = $this->{MODEL_NEWS}->get_by_url($url_of_news);

        if (!$data['news'])
        {
            $data['content'] = $this->lang->line('news_doesnt_exist');
        }
        else
        {
            $data['content'] = $this->load->view('news/news_view', $data, TRUE);
            $data['breadcrumbs']['/partners/'.$url_of_news] = $data['news']->name;
            $data['title'] .= ' - '.$data['news']->name;
        }

		$this->load->view('templates/main_view', $data);
	}

    /**
     * Сформировать хлебные крошки для страницы
     * @return array массив элементов навигации
     */
    private function _get_breadcrumbs()
    {
        $breadcrumbs = array();
        $breadcrumbs['/'] = $this->lang->line('page_main');
        $breadcrumbs['/news'] = $this->lang->line('page_news');
        return $breadcrumbs;
    }
    
    /**
     * RSS-лента новостей
     * 
     * @access public
     */
    public function rss()
    {
    	if (has_to_show_news_rss())
    	{
	    	header("Content-Type: application/rss+xml");
	    	$this->load->helper('xml');
	    	$data['news'] = $this->{MODEL_NEWS}->get_for_rss();
	    	echo $this->load->view('news/rss_view', $data);
    	}
    	else
    	{
    		$data['content'] = 'RSS-лента новостей временно отключена';
    		$data['breadcrumbs'] = $this->_get_breadcrumbs();
    		$data['breadcrumbs']['/news/rss'] = 'RSS';
    		$data['title'] = $this->lang->line('page_news');
    		$this->load->view('templates/main_view', $data);
    	}
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */