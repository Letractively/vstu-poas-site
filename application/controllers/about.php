<?php
class About extends CI_Controller{
    function __construct()
	{
		parent::__construct();
        if (has_to_show_debug())
            $this->output->enable_profiler(TRUE);
        lang();
	}

    /**
     * Вывести страницу истории кафедры
     */
    function history()
    {
        $breadcrumbs['/'] = $this->lang->line('page_main');
        $breadcrumbs['/about'] = $this->lang->line('page_about');
        $breadcrumbs['/about/history'] = $this->lang->line('page_history');

        $data['breadcrumbs'] = $breadcrumbs;
        $data['active'] = 'page_about';
        $data['title'] = $this->lang->line('page_history');
		$data['content'] = $this->load->view('static/about_history_'.lang(), '', TRUE);
		$this->load->view('templates/main_view', $data);
    }

    /**
     * Вывести список студентов
     * @param string $form форма обучения студента (бакалавр, магистр...)
     * @param int $year год обучения
     */
    function students($form = 'bachelor', $year = null)
    {
        $breadcrumbs['/'] = $this->lang->line('page_main');
        $breadcrumbs['/about'] = $this->lang->line('page_about');
        $breadcrumbs['/about/students'] = $this->lang->line('page_students');

        if (!is_numeric($year))
            $year = null;
        $this->load->model(MODEL_COURSE);
        $data['breadcrumbs'] = $breadcrumbs;
        $data['form'] = $form;
        $data['breadcrumbs']['/about/students/'.$form] = $this->lang->line('page_'.$form.'s');
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

        if ($data['currentyear'] != '')
            $data['breadcrumbs']['/about/students/'.$form.'/'.$data['currentyear']] = $data['currentyear'];

		$data['content'] = $this->load->view('about/student_form', $data, TRUE);
        $user_cards = $this->{MODEL_COURSE}->get_user_cards($form, $year);
        foreach($user_cards as $user_card)
            $data['content'] .= $this->load->view('templates/user_card', (array)$user_card, TRUE);
        $data['title'] = $this->lang->line('page_students');
        $data['active'] = 'page_about';
		$this->load->view('templates/main_view', $data);
    }

    function staff()
    {
        $breadcrumbs['/'] = $this->lang->line('page_main');
        $breadcrumbs['/about'] = $this->lang->line('page_about');
        $breadcrumbs['/about/staff'] = $this->lang->line('page_staff');

        $this->load->model(MODEL_USER);
        $user_cards = $this->{MODEL_USER}->get_staff_cards();
        $data['content'] = '';
        foreach($user_cards as $user_card)
            $data['content'] .= $this->load->view('templates/user_card', (array)$user_card, TRUE);
        $data['title'] = $this->lang->line('page_staff');
        $data['active'] = 'page_about';
        $data['breadcrumbs'] = $breadcrumbs;
		$this->load->view('templates/main_view', $data);
    }

    /**
     * Страница учебной деятельности кафедры
     * @param string $section подраздел
     */
    function education($section = 'index')
    {
        $breadcrumbs['/'] = $this->lang->line('page_main');
        $breadcrumbs['/about'] = $this->lang->line('page_about');
        $breadcrumbs['/about/education'] = $this->lang->line('page_education_index');

        $data['active'] = 'page_about';
        $data['section'] = $section;
        $data['content'] = $this->load->view('about/education_submenu', $data, TRUE);
        $data['breadcrumbs'] = $breadcrumbs;
        switch ($section)
        {
            case 'index':
                $data['content'] .= $this->load->view('static/education_index_'.lang(), '', TRUE);
                $data['title'] = $this->lang->line('page_education_general');
                $data['breadcrumbs']['/about/education/index'] = $this->lang->line('page_education_general');
                break;
            case 'bachelor':
                $data['content'] .= $this->load->view('static/education_bachelor_'.lang(), '', TRUE);
                $data['title'] = $this->lang->line('page_education_bachelor');
                $data['breadcrumbs']['/about/education/bachelor'] = $this->lang->line('page_education_bachelor');
                break;
            case 'magistracy':
                $data['content'] .= $this->load->view('static/education_magistracy_'.lang(), '', TRUE);
                $data['title'] = $this->lang->line('page_education_magistracy');
                $data['breadcrumbs']['/about/education/magistracy'] = $this->lang->line('page_education_magistracy');
                break;
            case 'pgdoc':
                $data['content'] .= $this->load->view('static/education_pgdoc_'.lang(), '', TRUE);
                $data['title'] = $this->lang->line('page_education_pgdoc');
                $data['breadcrumbs']['/about/education/pgdoc'] = $this->lang->line('page_education_pgdoc');
                break;
        }
        $this->load->view('templates/main_view', $data);
    }

    /**
     * Раздел "научная деятельность"
     * @param string $section подраздел
     * @param string $param дополнительный параметр
     */
    function scientific($section = 'index', $param = null)
    {
        $breadcrumbs['/'] = $this->lang->line('page_main');
        $breadcrumbs['/about'] = $this->lang->line('page_about');
        $breadcrumbs['/about/scientific'] = $this->lang->line('page_scientific_index');

        $data['active'] = 'page_about';
        $data['section'] = $section;
        $data['content'] = $this->load->view('about/scientific_submenu', $data, TRUE);
        $data['breadcrumbs'] = $breadcrumbs;

        switch ($section)
        {
            case 'index':
                $data['content'] .= $this->load->view('static/scientific_index_'.lang(), '', TRUE);
                $data['title'] = $this->lang->line('page_scientific_general');
                $data['breadcrumbs']['/about/scientific/index'] = $this->lang->line('page_scientific_general');
                break;
            case 'publications':
                $this->load->model(MODEL_PUBLICATION);
                $data['years'] = $this->{MODEL_PUBLICATION}->get_years();
                $data['title'] = $this->lang->line('page_scientific_publications');
                $data['breadcrumbs']['/about/scientific/publications'] = $this->lang->line('page_scientific_publications');

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
                    $data['breadcrumbs']['/about/scientific/publications/'.$data['currentyear']] = $data['currentyear'];
                }
                $data['content'] .= $this->load->view('publications_view', $data, TRUE);
                break;
            case 'projects':
                $this->load->model(MODEL_PROJECT);
                $data['title'] = $this->lang->line('page_scientific_projects');
                $data['breadcrumbs']['/about/scientific/projects'] = $this->lang->line('page_scientific_projects');
                if (is_numeric($param))
                {
                    if (!$this->{MODEL_PROJECT}->exists($param))
                    {
                        $data['content'] = $this->lang->line('project_doesnt_exist');
                        $this->load->view('templates/main_view', $data);
                    }
                    else
                    {
                        $data['project'] = $this->{MODEL_PROJECT}->get_card($param);
                        $data['members'] = $this->{MODEL_PROJECT}->get_members($param);
                        $data['content'] = $this->load->view('project_view', $data, TRUE);
                        $data['breadcrumbs']['/about/scientific/projects/'.$param] = $data['project']->name;
                        $data['title'] .= ' - '.$data['project']->name;
                        $this->load->view('templates/main_view', $data);
                    }
                    return;
                }


                //$data['projects'] = $this->{MODEL_PROJECT}->get_short();
                $data['projects'] = $this->{MODEL_PROJECT}->get_cards();
                $data['content'] .= $this->load->view('projects_view', $data, TRUE);
                break;
            case 'directions':
                $this->load->model(MODEL_DIRECTION);
                $data['title'] = $this->lang->line('page_scientific_directions');
                $data['breadcrumbs']['/about/scientific/directions'] = $this->lang->line('page_scientific_directions');
                if (is_numeric($param))
                {

                    if (!$this->{MODEL_DIRECTION}->exists($param))
                    {
                        $data['content'] = $this->lang->line('direction_doesnt_exist');
                        $this->load->view('templates/main_view', $data);
                    }
                    else
                    {
                        $data['direction'] = $this->{MODEL_DIRECTION}->get_card($param);
                        $data['members'] = $this->direction_model->get_members($param);
                        $data['content'] = $this->load->view('direction_view', $data, TRUE);
                        $data['breadcrumbs']['/about/scientific/directions/'.$param] = $data['direction']->name;
                        $data['title'] .= ' - '.$data['direction']->name;
                        $this->load->view('templates/main_view', $data);
                    }
                    return;
                }

                $data['directions'] = $this->{MODEL_DIRECTION}->get_cards();
                $data['content'] .= $this->load->view('directions_view', $data, TRUE);
                break;
        }
        $this->load->view('templates/main_view', $data);
    }

    function international()
    {
        $breadcrumbs['/'] = $this->lang->line('page_main');
        $breadcrumbs['/about'] = $this->lang->line('page_about');
        $breadcrumbs['/about/international'] = $this->lang->line('page_international');

        $data['breadcrumbs'] = $breadcrumbs;
        $data['content'] = 'Нет инфомации';
        $data['active'] = 'page_about';
        $data['title'] = $this->lang->line('page_international');
        $this->load->view('templates/main_view', $data);
    }
}