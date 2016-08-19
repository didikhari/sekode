<?php
    class Menu {
        private $id;
        private $target;
        private $label;
        private $parentId;
        private $isAction;
        private $ordinal;
        private $isAdminMenu;
        private $icon;
        
        public function id(){
            return $this->id;
        }
        
        public function target(){
            return $this->target;
        }
        
        public function label(){
            return $this->label;
        }
        
        public function parentId(){
            return $this->parentId;
        }
        
        public function isAction(){
            return $this->isAction;
        }
        
        public function ordinal(){
            return $this->ordinal;
        }
        
        public function isAdminMenu(){
            return $this->isAdminMenu;
        }
        
        public function icon(){
            return $this->icon;
        }
        public function __set($name, $value)
        {
                if ($name === 'ID'){
                    $this->id = $value;
                }else if($name === 'TARGET'){
                    if(empty($value))
                        $this->target = "#";
                    else
                        $this->target = $value;
                }else if($name === 'LABEL'){
                    $this->label = $value;
                }else if($name === 'PARENT_ID'){
                    $this->parentId = $value;
                }else if($name === 'IS_ACTION'){
                    if($value == 'Y') $this->isAction = true;
                    else $this->isAction = false;
                }else if($name === 'ORDINAL'){
                    $this->ordinal = $value;
                }else if($name === 'IS_ADMIN_MENU'){
                    if($value == 'Y') $this->isAdminMenu = true;
                    else $this->isAdminMenu = false;
                }else if($name === 'ICON'){
                    $this->icon = $value;
                }
        }

        public function __get($name)
        {
                if (isset($this->$name))
                {
                        return $this->$name;
                }
        }
    }
?>