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
        return $this->_get_short(TABLE_PUBLICATIONS, 'year', $id);
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
        return $this->_get_record($id, TABLE_PUBLICATIONS);
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
            'abstract_ru' => 'publication_abstract_en',
            'abstract_en' => 'publication_abstract_en',
            'year'        => 'publication_year',
            'info_ru'     => 'publication_info_ru',
            'info_en'     => 'publication_info_en'
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
        return $this->_get_from_post('project', $fields, $nulled_fields);
    }
    
    /**
     * Добавить публикацию, получаемую через POST-запрос
     * @return int id - идентификатор добавленной записи | FALSE
     */
    function add_from_post()
    {        
        return $this->_add(TABLE_PUBLICATIONS, $this->get_from_post());
    }
    
    /**
	 * Получить информацию о публикации из данных, полученных методом POST
	 * @return объект, содержащий собранную информацию о публикации
	 */
    function edit_from_post() {
        return $this->_edit(TABLE_PUBLICATIONS, $this->get_from_post());
    }
    
    /**
     * Удалить публикацию из базы данных
     * @param int $id идентификатор публикации
     * @return TRUE, если публикация удалена, иначе FALSE 
     */
    function delete($id)
    {
        return $this->_delete(TABLE_PUBLICATIONS, $id);
    }
    
    /**
	 * Получить информацию обо всех авторах публикации
	 * @param int $id идентификатор публикации
	 * @return массив пользователей
	 */
	function get_authors($id)
	{
		$this->db
				->select(TABLE_USERS . '.id, first_name, last_name')
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
        return $this->db
					->select('id, name_'.lang().' as name, fulltext_ru, fulltext_en, abstract_ru, abstract_en, info_ru, info_en')
                    ->from(TABLE_PUBLICATIONS)
					->where('name_'.lang().' IS NOT NULL AND name_'.lang().' != ""'.
                            ' AND year = ' . $year)
					->order_by('id DESC')
                    ->get()
					->result();
    }
}
?>