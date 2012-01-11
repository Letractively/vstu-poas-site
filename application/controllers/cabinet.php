<?php
/**
 * Личный кабинет пользователей
 */
class Cabinet extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if (has_to_show_debug())
            $this->output->enable_profiler(TRUE);
		$this->load->database('default');
		$this->load->model(MODEL_USER);
		lang();
	}

    /**
     * Основная страница личного кабинета, на которой отображаются все данные
     * с возможностью их изменения
     *
     * @access public
     */
	function index()
	{
		$data['title'] = $this->lang->line('page_cabinet');
        $data['active'] = '';
        $data['breadcrumbs'] = $this->_get_breadcrumbs();

        if ($this->ion_auth->logged_in())
        {
            $data['user'] = $this->{MODEL_USER}->get_info_for_cabinet($this->session->userdata('user_id'));
            $data['content'] = $this->load->view('cabinet/cabinet_view', $data, TRUE);
        }
        else
        {
            $data['content'] = $this->load->view('/login_view', NULL, TRUE);
        }
		$this->load->view('templates/main_view', $data);
	}

    function update()
    {
        $this->load->model(MODEL_USER);
        $this->load->library('form_validation');
        if ($this->{MODEL_USER}->cabinet_validate())
        {
            if ($this->{MODEL_USER}->cabinet_edit_from_post())
                $this->session->set_flashdata(
                        'cabinet_message',
                        '<div class="edit-ok">'.$this->lang->line('your_account_successfully_changed').'</div>');
            else
                $this->session->set_flashdata('cabinet_message', 'error updating database');

            if (lang() == 'ru')
                redirect('/cabinet');
            else
                redirect(lang().'/cabinet');

        }
        else
        {
            $this->index();
        }
    }

    /**
     * Получить хлебные крошки для личного кабинета
     *
     * @access private
     * @return array массив хлебных крошек
     */
    private function _get_breadcrumbs()
    {
        $breadcrumbs = array();
        $breadcrumbs['/'] = $this->lang->line('page_main');
        $breadcrumbs['/cabinet'] = $this->lang->line('page_cabinet');
        return $breadcrumbs;
    }
}