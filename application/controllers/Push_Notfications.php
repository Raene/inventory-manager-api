<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Push_Notifications extends CI_Controller
{
    private $subscription;

    public function __construct()
    {
        parent::__construct();
        headersUp();
    }

    public function save_subscription()
    {
        try {
                $data = $this->input->raw_input_stream;
                $data = utf8_encode($data);
                $data = json_decode($data, true);
    
                $this->subscription = $data['subscription'];
    
                if (!isset($this->subscription['endpoint'])) {
                    return response(400, 'Subscription must have an Endpoint');
                }
    
                $resp['payload'] = $this->push_notification->save_sub   ($this->subscription);
                $resp['status']  = 201;
                return response($resp['status'], $resp['payload']);

        } catch (Exception $e) {
            return response($e->getCode(),$e->getMessage());
        }             
    }
}