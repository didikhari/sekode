<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class DashboardController extends MY_Controller {
        
        public function __construct(){
            parent ::__construct();
            $this->is_logged_in();
            $this->load->model('menuDao');
        }
        
        public function index(){
            $userSession = $this->session->userdata('user_data');
            $menus = $this->menuDao->getAllMenu();
            $generatedMenuHtml = $this->buildMenu($menus);
            
            $this->session->set_userdata('generatedMenuHtml', $generatedMenuHtml);
            
            $data = array(
                    'title' => 'DidikH',
                    'username' => $userSession[0]->ID,
                    'generatedMenuHtml' => $generatedMenuHtml
                );
            $this->template->load('dashboard', 'home', $data);
    	}
        
        public function buildMenu($menus){
            $generated = "<ul class='page-sidebar-menu' data-keep-expanded='true' data-auto-scroll='true' data-slide-speed='200'>";            
            foreach($menus as $menu){
                if($menu->parentId() == 0 && $menu->isAdminMenu() && !$menu->isAction()){
                    $generated = $generated."<li>";
                    
                    $generated = $generated."<a href='".$menu->target()."'>";
                    $generated = $generated."<i class='".$menu->icon()."'></i>";
                    $generated = $generated."<span class='title'>".$menu->label()."</span>";
                    if($this->hasChild($menus, $menu->id())){
                        $generated = $generated."<span class='arrow'></span>";
                    }
                    $generated = $generated."</a>";
                    $generated = $generated.$this->buildSubMenu($menus, $menu->id());
                    $generated = $generated."</li>";
                }
            }
            $generated = $generated."</ul>";
            return $generated;
        }
        
        public function buildSubMenu($menus, $parentId){
            if($this->hasChild($menus, $parentId)){
                $generated = "<ul class='sub-menu'>";
                foreach($menus as $menu){
                    if($menu->parentId() == $parentId && $menu->isAdminMenu() && !$menu->isAction()){
                        $generated = $generated."<li>";
                        $generated = $generated."<a href='".$menu->target()."'>";
                        $generated = $generated."<i class='".$menu->icon()."'></i>";
                        $generated = $generated.$menu->label();
                        $generated = $generated."</a>";
                        $generated = $generated.$this->buildSubMenu($menus, $menu->id());
                        $generated = $generated."</li>";
                    }
                }
                $generated = $generated."</ul>";
                return $generated;
            }
        }
        
        public function hasChild($menus, $parentId){
            $foundChild = false;
            foreach($menus as $menu){
                if($menu->parentId() == $parentId){
                    $foundChild = true;
                }
            }
            return $foundChild;
        }
        
        public function test(){
        	echo "testing";
        }           
    }
?>