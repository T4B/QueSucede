<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Security_lib {

    public function generateToken(){
        $CI =& get_instance();
        $CI->load->library('encrypt');
        $CI->load->helper('date');

        $now = now();

        $token = $CI->config->item('csrf_secret');
        $token .= rand(1, 100);
        $token .= $now;
        $token = $CI->encrypt-> sha1($token);

        $CI->session->set_userdata('csrf_hash', $token);
        $CI->session->set_userdata('hash_time', $now);
        
        return $token;
    }

    public function verifyToken($token, $delta_time=0, $reset=False){
        $CI =& get_instance();
        $CI->load->helper('date');
        $flag = 0;
        $current_token = $CI->session->userdata('csrf_hash');
        $hash_time = $CI->session->userdata('hash_time');

        if($reset){
            $this->generateToken();    
        }

        if(!$current_token){
            return false;
        }
        
        if($current_token != $token){
            return false;
        }

        if($delta_time > 0){
            $token_age = now() - $hash_time;
            if($token_age >= $delta_time){
                return false;
            }
        }
        
        return true;
    }
    
    public function escapeArray($array){
    
        $CI =& get_instance();
        
        foreach($array as $key => $value){
            $value = $CI->db->escape_str($value);
            $array[$key] = $value;
        }
        
        return $array;
    }

}

