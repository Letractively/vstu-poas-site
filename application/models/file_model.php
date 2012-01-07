<?php
class File_model extends CI_Model{
    function get_file_path($fileid)
    {
        if ($fileid != NULL && $fileid != '')
        {
            $file = $this->db
                                ->select('name')
                                ->get_where(TABLE_FILES, array('id' => $fileid))
                                ->result();
            return $file ? $file[0]->name : NULL;
        }
        return NULL;
    }
    function delete_file($fileid)
    {
        if ($fileid != NULL)
        {
            $oldpath = $this->get_file_path($fileid);
            if($oldpath)
            {
                if (!unlink(iconv("UTF-8", "CP1251", $oldpath)))
                    unlink($oldpath);
            }
            $this->db->delete(TABLE_FILES, array('id' => $fileid));
        }
    }
}
