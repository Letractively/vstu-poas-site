<?php
class Notfound extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		lang();
		if (has_to_show_debug())
            $this->output->enable_profiler(TRUE);
	}

	/// Главная страница сайта
	function index()
	{
        $breadcrumbs = array();
        $breadcrumbs['/'] = $this->lang->line('page_main');
        $breadcrumbs['/notfound'] = $this->lang->line('page_404');

        $data['breadcrumbs'] = $breadcrumbs;
		$data['content'] = $this->load->view('static/404', NULL, TRUE);
        $data['active'] = 'none';
        $data['title'] = $this->lang->line('page_404');

        $this->load->view('templates/main_view', $data);
	}

    /**
     * Страница, которая срабатывает как 404-ая
     */
    function notfound()
    {
        /// Если выводить содержимое страницы в этом методе,
        /// то возникнут ошибки - на этой странице нельзя использовать модели
        ///  - не отобразятся ни новости, ни конференции, управляющие кнопки
        /// типа "Авторизация", "Кабинет".

        /// Поэтому перенаправляем страницу на /notfound/index, на которой
        /// все эти несуразности пропадают
        redirect('/notfound');
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */