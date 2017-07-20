<?php
class AjaxClassToCount extends System {
    public function countDownloads() {
        if ($this->Input->post('path') != '') {
            $path =  rawurldecode($this->Input->post('path'));
            $this->import('Database'); 
            $rs = DataBase::getInstance()
                ->query('SELECT * FROM tl_downloads WHERE href ="'.$path.'"');
            
            $results = $rs->fetchAllAssoc();
            foreach ($results as $result) {
                    $value = $result['count'];
                    $id = $result['id'];
                    
            }
            $value = (int)$value;
            $id = (int)$id;
            $value = $value + 1;
            $this->Database->prepare('UPDATE tl_downloads SET tl_downloads.count = ?  WHERE tl_downloads.id=?')->execute($value, $id);
            $back = $value;
            echo $back;
            exit;
        }
    }
}
?>