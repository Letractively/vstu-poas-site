<?php
class File_model extends CI_Model{
    function get_file_path($fileid)
    {
        $file = $this->db
                            ->select('name')
                            ->get_where(TABLE_FILES, array('id' => $fileid))
                            ->result();
        return $file ? $file[0]->name : NULL;
    }
    function delete_file($fileid)
    {
        //$f = fopen('log.txt', 'w');
        //fputs($f, 'in');
        if ($fileid != NULL)
        {
            $oldpath = $this->get_file_path($fileid);
            //fputs($f, $oldpath);
            if($oldpath)
            {
                unlink($oldpath);
            }
            $this->db->delete(TABLE_FILES, array('id' => $fileid));
        }
    }
}
