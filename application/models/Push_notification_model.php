<?php
    class Push_notification_model extends CI_Model{
        
        public function __construct(){
            $this->load->database();
        }

        public function save_sub($subscription){
            $query = $this->db->insert('subscriptions', $subscription);
            db_error_response($query);
            return "Subscription Successful";
        }
    }