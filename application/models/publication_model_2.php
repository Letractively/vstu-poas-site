<?php
/**
 * Модель партнера
 */
require_once('super.php');
class Publication_model_2 extends Super{

    /**
     * Получить список записей для панели администратора
     * @param int $page страница
     * @param int $amount_on_page количество записей на странице
     * @return array массив записей
     */
    public function get_records_for_admin_view($page = 1, $amount_on_page = 20)
    {
        $result = $this->db
                ->select('id, name_ru as name')
                ->get(TABLE_PUBLICATIONS, $amount_on_page, ($page - 1) * $amount_on_page)
                ->result();
        if (is_array($result)) {
            foreach($result as $record){
                $record->authorscount = $this->get_authors_count($record->id);
            }
        }
        return $result;
    }

    /**
     * Получить число авторов публикации
     * @param int $id идетификатор публикации
     * @return int число авторов публикации
     */
    public function get_authors_count($id)
    {
        return $this->db->from(TABLE_PUBLICATION_AUTHORS)->where('publicationid', $id)->count_all_results();
    }
}

/* End of file partner_model.php */
/* Location: ./application/models/partner_model.php */