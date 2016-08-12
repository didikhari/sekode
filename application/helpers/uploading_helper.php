<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function getConfigUpload($file_name){
	// print_r($file); die();
	$config = array(
		'file_name'	=> date('Ymdhis').$file_name,
        'upload_path' => './upload/',
        'allowed_types' => 'gif|jpg|png',
        'max_size'  => '6000',
    );
	return $config; 
}
function getConfigThumb($path){
 	$config = array(
       	'source_image' => $path,
        'new_image' => './upload/thumbs',
        'maintain_ratio' => true,
        'width' => 200,
        'height' => 100
    );  	
    return $config;
}
function date_for_mysql($date){
    $date = explode("/", $date);
    return $date[2].'/'.$date[1].'/'.$date[0];
}

function date_for_form($date){
    $date = explode("-", $date);
    return $date[2].'/'.$date[1].'/'.$date[0];
}

function getStatus(){
    $status = array (0=>'Diajukan', '1'=>'Disetujui', '2'=> 'Ditolak');
    return $status;
}
function getStatusByValue($id){
    $status = array (0=>'Diajukan', '1'=>'Disetujui', '2'=> 'Ditolak');
    return $status[$id];
}


function date_formater($date){
    $bulan = array(
            '1' => 'januari',
            '2' => 'februari',
            '3' => 'maret',
            '4' => 'april',
            '5' => 'mei',
            '6' => 'juni',
            '7' => 'juli',
            '8' => 'agustus',
            '9' => 'september',
            '10' => 'oktober',
            '11' => 'november',
            '12' => 'desember'
    );
    $date = explode("-", $date);
    return $date[2].' '.$bulan[(int)$date[1]].' '.$date[0];
}


function MonthTranslate($value){
    $bulan = array(
            '1' => 'januari',
            '2' => 'februari',
            '3' => 'maret',
            '4' => 'april',
            '5' => 'mei',
            '6' => 'juni',
            '7' => 'juli',
            '8' => 'agustus',
            '9' => 'september',
            '10' => 'oktober',
            '11' => 'november',
            '12' => 'desember'
    );
    // echo array_search($value, $bulan); die();
    return array_search($value, $bulan);
}

//recursive
  function get_menu($results,$parent_id){
        $menu = array();
            foreach ($results as $element) {
                if ($element['menuParent'] == $parent_id) {
                    $children = get_menu($results, $element['menuId']);
                    if ($children) { 
                       $element['children'] = $children;
                    }else{
                        $element['children'] = array();
                    }
                    $menu[] = $element;
                }
            }

        return $menu;
    }
