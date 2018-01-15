<?php 
session_start();

if(@$_POST['username']!='' && @$_POST['password']!=''){
    
    include('config.php');

	$db = new DB();

	$data = $db->get_user_login($_POST['username'],md5($_POST['password']));
	
    if($data!=''){
        $_SESSION['nguoi_dung'] = $data;
        echo json_encode($data);
    }

}else{
     if(@$_SESSION['nguoi_dung']!=''){
        $chuoi = json_encode($_SESSION['nguoi_dung'][0]);

    }else{
        $chuoi = 0;
    }
    echo($chuoi);
}
?>