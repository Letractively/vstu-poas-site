<?php
class About extends CI_Controller{
    function __construct()
	{
		parent::__construct();
        $this->output->enable_profiler(TRUE);
        lang();
	}

    /**
     * Вывести страницу истории кафедры
     */
    function history()
    {
        // Загрузка нужного словаря -
        // необходимо для корректной работы $this->lang->line()

        $data['active'] = 'page_about';
        $data['title'] = $this->lang->line('page_history');
		$data['content'] = $this->load->view('static/about_history_'.lang(), '', TRUE);
		$this->load->view('templates/new_main_view', $data);
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
        $this->load->model(MODEL_COURSE);
        $data['form'] = $form;
        $data['years'] = $this->{MODEL_COURSE}->get_years_by_form($form);
        if ($year == null)
            if(count($data['years']) > 0)
            {
                $data['currentyear'] = $data['years'][0];
                $year = $data['years'][0];
            }
            else
                $data['currentyear'] = '';
        else
            $data['currentyear'] = $year;
		$data['content'] = $this->load->view('about/student_form', $data, TRUE);
        $user_cards = $this->{MODEL_COURSE}->get_user_cards($form, $year);
        foreach($user_cards as $user_card)
            $data['content'] .= $this->load->view('templates/user_card', (array)$user_card, TRUE);
        $data['title'] = $this->lang->line('page_students');
        $data['active'] = 'page_about';
		$this->load->view('templates/new_main_view', $data);
    }

    function staff()
    {
        $this->load->model(MODEL_USER);
        $user_cards = $this->{MODEL_USER}->get_staff_cards();
        $data['content'] = '';
        foreach($user_cards as $user_card)
            $data['content'] .= $this->load->view('templates/user_card', (array)$user_card, TRUE);
        $data['title'] = $this->lang->line('page_staff');
        $data['active'] = 'page_about';
		$this->load->view('templates/new_main_view', $data);
    }

    function education($section = 'index')
    {
        $data['active'] = 'page_about';
        $data['section'] = $section;
        $data['content'] = $this->load->view('about/education_submenu', $data, TRUE);
        switch ($section)
        {
            case 'index':
                $data['content'] .= $this->load->view('static/education_index_'.lang(), '', TRUE);
                $data['title'] = $this->lang->line('page_education_index');
                break;
            case 'bachelor':
                $data['content'] .= $this->load->view('static/education_bachelor_'.lang(), '', TRUE);
                $data['title'] = $this->lang->line('page_education_bachelor');
                break;
            case 'magistracy':
                $data['content'] .= $this->load->view('static/education_magistracy_'.lang(), '', TRUE);
                $data['title'] = $this->lang->line('page_education_magistracy');
                break;
            case 'pgdoc':
                $data['content'] .= $this->load->view('static/education_pgdoc_'.lang(), '', TRUE);
                $data['title'] = $this->lang->line('page_education_pgdoc');
                break;
        }
        $this->load->view('templates/new_main_view', $data);
    }

    function scientific($section = 'index', $param = null)
    {
        $data['active'] = 'page_about';
        $data['section'] = $section;
        $data['content'] = $this->load->view('about/scientific_submenu', $data, TRUE);
        switch ($section)
        {
            case 'index':
                $data['content'] .= $this->load->view('static/scientific_index_'.lang(), '', TRUE);
                $data['title'] = $this->lang->line('page_scientific_index');
                break;
            case 'publications':
                $this->load->model(MODEL_PUBLICATION);
                $data['years'] = $this->{MODEL_PUBLICATION}->get_years();
                $data['title'] = $this->lang->line('page_scientific_publications');

                if (($param == null || !is_numeric($param)) && count($data['years']) > 0)
                {
                    $data['currentyear'] = $data['years'][0];
                }
                else
                {
                    $data['currentyear'] = $param;
                }
                if ($data['currentyear'])
                {
                    $data['publications'] = $this->{MODEL_PUBLICATION}->get_by_year($data['currentyear']);
                }
                $data['content'] .= $this->load->view('publications_view', $data, TRUE);
                break;
            case 'projects':
                $this->load->model(MODEL_PROJECT);
                $data['title'] = $this->lang->line('page_scientific_projects');
                if (is_numeric($param))
                {
                    $data['project'] = $this->{MODEL_PROJECT}->get_detailed($param);
                    $data['image'] = $this->{MODEL_PROJECT}->get_image($param);
                    if (!$data['project'])
                    {
                        $data['content'] = $this->lang->line('project_doesnt_exist');
                        $this->load->view('templates/new_main_view', $data);
                    }
                    else
                    {
                        $data['members'] = $this->{MODEL_PROJECT}->get_members($param);
                        $data['content'] = $this->load->view('project_view', $data, TRUE);
                        $this->load->view('templates/new_main_view', $data);
                    }
                    return;
                }


                $data['projects'] = $this->{MODEL_PROJECT}->get_short();
                $data['content'] .= $this->load->view('projects_view', $data, TRUE);
                break;
            case 'directions':
                $this->load->model(MODEL_DIRECTION);
                $data['title'] = $this->lang->line('page_scientific_directions');
                if (is_numeric($param))
                {
                    $data['direction'] = $this->{MODEL_DIRECTION}->get_detailed($param);
                    if (!$data['direction'])
                    {
                        $data['content'] = $this->lang->line('direction_doesnt_exist');
                        $this->load->view('templates/new_main_view', $data);
                    }
                    else
                    {
                        $data['members'] = $this->direction_model->get_members($param);
                        $data['content'] = $this->load->view('direction_view', $data, TRUE);
                        $this->load->view('templates/new_main_view', $data);
                    }
                    return;
                }


                $data['directions'] = $this->{MODEL_DIRECTION}->get_short();
                $data['content'] .= $this->load->view('directions_view', $data, TRUE);
                break;
        }
        $this->load->view('templates/new_main_view', $data);
    }

    function international()
    {
        $data['content'] = 'Нет инфомации';
        $data['active'] = 'page_about';
        $data['title'] = $this->lang->line('page_international');
        $this->load->view('templates/new_main_view', $data);
    }
}