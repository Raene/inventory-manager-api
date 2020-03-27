<?php
function isNot_zero($num){
    
        if ($num <= 0) {
            return false;
        } else {
            return true;
        }       
    }

function email_exists($tablename,$email){
        $ci = & get_instance();
        $query = $ci->db->get_where($tablename, array('email' => $email));

        if(empty($query->row_array())){
            return true;
        } else{
            return false;
        }
    }
