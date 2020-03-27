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

function fetch_by_email($tablename,$email)
{
        $ci = & get_instance();
        $query = $ci->db->get_where($tablename, array('email' => $email));

        if(!$query){
            $error = $ci->db->error();
            $errorMessage = $error['message'];
            $errorStatus = 400;
            throw new Exception($errorMessage, $errorStatus);
        }

        if($query->num_rows() == 1){
            return $query->row_array();
        }else{
            return false;
        }
    }
