<?php
    include('config.php');
    $db = new DB();
    date_default_timezone_set("Asia/Bangkok");
    
    $data = $db->xuat_binh_luan();
 
    echo json_encode($data)
?>