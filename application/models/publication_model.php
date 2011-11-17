<?php
/**
 * @class Publication_model
 * Модель публикаций. 
 */

require_once('super_model.php');
class Publication_model extends Super_model 
{
    /**
     * Получить краткую информацию о публикации
     * @param int $id идентификатор публикации
     * @return публикация
     */
    function get_short($id = null)
    {
        $result = $this->_get_short(TABLE_PUBLICATIONS, 
                                 'year', 
                                 'name_' . lang() . ', name_ru, id',
                                 $id);
        if (is_array($result)) {
            foreach($result as $record){
                $this->db->from(TABLE_PUBLICATION_AUTHORS)->where('publicationid', $record->id);
                $record->authorscount = $this->db->count_all_results();
            }
        }
        return $result; 
    }
    
    /**
     * Получить информацию о публикации для представления
     * @param int $id идентификатор публикации
     * @return публикация
     */
    function get_detailed($id) {
        $select1 = 'info_' . lang() . ' as info, fulltext_ru, fulltext_en, abstract_ru, abstract_en, year';
        $select2 = 'info_ru as info, fulltext_ru, fulltext_en, abstract_ru, abstract_en, year';
        return $this->_get_detailed($id, TABLE_PUBLICATIONS, $select1, $select2);
    }
    
    /**
     * Получить полную информацию о публикации
     * @param int $id идентификатор публикации
     * @return публикация
     */
    function get_publication($id)
    {
        $publication = $this->_get_record($id, TABLE_PUBLICATIONS);
        $publication->authors=$this->get_authors($id);
        return $publication;
    }
    
    function get_view_extra() {
        $extra = null;
        $extra->users = $this->db
                                ->select(TABLE_USERS . '.id, name_'.lang().' as name, surname_'.lang().' as surname, patronymic_'.lang().' as patronymic')
                                ->from(TABLE_USERS)
                                ->order_by('surname,name,patronymic')
                                ->get()
                                ->result();
        return $extra;
    }
    
    /**
     * Получить информацию о публикации из POST-запроса
     * @return публикация
     */
    function get_from_post() 
    {
        $fields = array(
            'name_ru'     => 'publication_name_ru',
            'name_en'     => 'publication_name_en',
            'fulltext_ru' => 'publication_fulltext_ru',
            'fulltext_en' => 'publication_fulltext_en',
            'abstract_ru' => 'publication_abstract_ru',
            'abstract_en' => 'publication_abstract_en',
            'year'        => 'publication_year',
            'info_ru'     => 'publication_info_ru',
            'info_en'     => 'publication_info_en',
            'authors'      => 'publication_authors'
        );
        $nulled_fields = array(            
            'name_ru'     => 'publication_name_ru',
            'name_en'     => '',
            'fulltext_ru' => '',
            'fulltext_en' => '',
            'abstract_ru' => '',
            'abstract_en' => '',
            'info_ru'     => '',
            'info_en'     => ''
        );
        return $this->_get_from_post('publication', $fields, $nulled_fields);
    }
    
    /**
     * Обновить список авторов публикации
     * 
     * @param type $id идентификатор публикации
     * @param $members массив идентификаторов авторов
     */
    function update_publication_authors($id, $members)
    {
        $this->_update_connected_users(TABLE_PUBLICATION_AUTHORS, 
                'publicationid', 
                $id, 
                $members);
    }
    
    /**
     * Добавить публикацию, получаемую через POST-запрос
     * @return int id - идентификатор добавленной записи | FALSE
     */
    function add_from_post()
    {   $publication = $this->get_from_post();
        unset($publication->authors);
        
        if ($id = $this->_add(TABLE_PUBLICATIONS, $publication))
        {
            $this->update_publication_authors($id, $this->input->post('publication_authors'));
        }
        return $id;
    }
    
    /**
	 * Получить информацию о публикации из данных, полученных методом POST
	 * @return объект, содержащий собранную информацию о публикации
	 */
    function edit_from_post() {
        $publication = $this->get_from_post();
        unset($publication->authors);
        $result = $this->_edit(TABLE_PUBLICATIONS, $publication);
        $this->update_publication_authors($publication->id, $this->input->post('publication_authors'));
        return $result;
    }
    
    /**
     * Удалить публикацию из базы данных
     * 
     * Удалеяет так же все упоминания о публикации из таблицы авторов
     * @param int $id идентификатор публикации
     * @return TRUE, если публикация удалена, иначе FALSE 
     */
    function delete($id)
    {
        $result = $this->_delete(TABLE_PUBLICATIONS, $id);
        $message = $this->message;
        $cascade = $this->_delete(TABLE_PUBLICATION_AUTHORS, $id, 'publicationid');
        $this->message = $message;
        return $cascade && $result;
    }
    
    /**
	 * Получить информацию обо всех авторах публикации
	 * @param int $id идентификатор публикации
	 * @return массив пользователей
	 */
	function get_authors($id)
	{
		$this->db
				->select(TABLE_USERS . '.id, name_'.lang().' as name, surname_'.lang().' as surname, patronymic_'.lang().' as patronymic')
				->from(TABLE_PUBLICATION_AUTHORS)
				->join(TABLE_USERS, TABLE_USERS.'.id = ' . TABLE_PUBLICATION_AUTHORS . '.userid')
				->where('publicationid = ' . $id);
				return $this->db->get()->result();
	}
    
    /**
     * Получить все года, в которых есть публикации на указанном языке
     * @return упорядоченный по убыванию массив лет
     */
    function get_years() 
    {
        $records = $this->db
                    ->select('year')
                    ->distinct()
                    ->from(TABLE_PUBLICATIONS)
                    ->where('name_'.lang().' IS NOT NULL AND name_'.lang().' != ""')
                    ->order_by('year DESC')
                    ->get()
                    ->result();
        $years = array();
        foreach ($records as $record) 
        {
            $years[] = $record->year;
        }
        return $years;
    }
    function get_by_year($year)
    {
        $result = $this->db
					->select('id, name_'.lang().' as name, fulltext_ru, fulltext_en, abstract_ru, abstract_en, info_'.lang().' as info')
                    ->from(TABLE_PUBLICATIONS)
					->where('name_'.lang().' IS NOT NULL AND name_'.lang().' != ""'.
                            ' AND year = ' . $year)
					->order_by('id DESC')
                    ->get()
					->result();
        foreach($result as $record)
        {
            $record->authors = $this->get_authors($record->id);
            $record->year = $year;
        }
        return $result;
    }
    
    function get_errors() {
        $errors = null;
        if ($this->input->post('publication_name_ru') == '')
            $errors->nameforgotten = true;
        if ($this->input->post('publication_year') == '')
            $errors->yearforgotten = true;
        return $errors;
    }
    
    function exists($id)
    {
        return $this->_record_exists(TABLE_PUBLICATIONS, $id);
    }
}
?>