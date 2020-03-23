<?php
function response($resp_code, $response){
	$CI = & get_instance();
		return 	$CI->output
					->set_status_header($resp_code)
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode($response, JSON_PRETTY_PRINT | 	JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
	}