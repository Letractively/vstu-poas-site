<?php
class About extends CI_Controller{
    function __construct()
	{
		parent::__construct();
        $this->output->enable_profiler(TRUE);
	}

    /**
     * Вывести страницу истории кафедры
     */
    function history()
    {
        // Загрузка нужного словаря -
        // необходимо для корректной работы $this->lang->line()
        lang();
        $data['title'] = $this->lang->line('page_history');
		$data['content'] = $this->load->view('static/about_history_'.lang(), '', TRUE);
		$this->load->view('templates/main_view', $data);
    }

    /**
     * Вывести список студентов
     * @param $form форма обучения студента (бакалавр, магистр...)
     * @param $year год обучения
     */
    function students($form = 'bachelor', $year = null)
    {
        if (!is_numeric($year))
            $year = null;
        lang();
        $this->load->model(MODEL_COURSE);
        $data['form'] = $form;
        $data['years'] = $this->{MODEL_COURSE}->get_years_by_form($form);
        if ($year == null)
            if(count($data['years']) > 0)
                $data['currentyear'] = $data['years'][0];
            else
                $data['currentyear'] = '';
        else
            $data['currentyear'] = $year;
		$data['content'] = $this->load->view('about/student_form', $data, TRUE);
        $user_cards = $this->{MODEL_COURSE}->get_user_cards($form, $year);
        foreach($user_cards as $user_card)
            $data['content'] .= $this->load->view('templates/user_card', (array)$user_card, TRUE);
        $data['title'] = $this->lang->line('page_students');
		$this->load->view('templates/main_view', $data);
    }
}