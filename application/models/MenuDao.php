<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
    class MenuDao extends CI_Model{
        
        public function __construct(){
            parent ::__construct();
            $this->load->library('menu');
        }
        
        /**
         * Return All Menu by casting to Menu Domain
         * @see libraries/Menu.php
         */
        public function getAllMenu(){
            $query = $this->db->get('s_menu');
            return $query->custom_result_object('Menu');
        }
    }

?>