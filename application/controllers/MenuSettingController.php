<?php defined('BASEPATH') OR exit('No direct script access allowed');

    class MenuSettingController extends MY_Controller {
        
        public function __construct(){
            parent ::__construct();
            $this->is_logged_in();
            $this->load->model('menuDao');
        }
        
        public function index(){
            $menus = $this->menuDao->getAllMenu();
            $treeMenu = $this->buildTreeMenu($menus);
            print_r(json_encode($treeMenu));
            die;
            $data = array(
                    'title' => 'Menu Setting | DidikH',
                    'username' => $userSession[0]->ID,
                    'generatedMenuHtml' =>  $this->session->userdata('generatedMenuHtml')
                );
            $this->template->load('dashboard', 'menu-setting', $data);
        }
        
        private function buildTreeMenu($menus){
            $menuArr = array();
            $idx = 0;
            foreach($menus as $menu){
                if($menu->parentId() == 0 && $menu->isAdminMenu() && !$menu->isAction()){
                    
                    if($this->hasChild($menus, $menu->id())){
                        $chids = $this->buildChilds($menus, $menu->id());
                        $menuArr[$idx] = array(
                                            'id' => $menu->id(),
                                            'children' => $chids
                                            );  
                    }else{
                        $menuArr[$idx] = array('id' => $menu->id());
                    }
                    
                    $idx = $idx + 1;
                }
            }
            return $menuArr;
        }
        
        private function buildChilds($menus, $parentId){
            $chidsArr = array();
            $idx = 0;
            foreach($menus as $menu){
                if($menu->parentId() == $parentId){
                    if($this->hasChild($menus, $menu->id())){
                        $chids = $this->buildChilds($menus, $menu->id());
                        $chidsArr[$idx] = array(
                                            'id' => $menu->id(),
                                            'children' => $chids
                                            );  
                    }else{
                        $chidsArr[$idx] = array('id' => $menu->id());
                    }
                    
                    $idx = $idx + 1;
                }
            }
            return $chidsArr;
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
    }
?>