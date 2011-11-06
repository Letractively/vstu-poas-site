<?php
/**
 * @class Publication_model
 * Модель публикаций.
 */
require_once('super_model.php');
class Publication_model extends Super_model 
{
    function get_short($id = null)
    {
        return $this->_get_short(TABLE_PUBLICATIONS, $id);
    }
    function get_detailed($id) {
        $select1 = 'year, fulltext_ru, fulltext_en, abstract_ru, abstract_en, info_' . lang(). 'as info';
        $select2 = 'year, fulltext_ru, fulltext_en, abstract_ru, abstract_en, info_ru as info';
        return $this->_get_detailed($id, TABLE_PUBLICATIONS, $select1, $select2);
    }
}
?>
