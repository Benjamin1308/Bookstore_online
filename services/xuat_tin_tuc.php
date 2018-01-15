<?php
    include('config.php');
    $db = new DB();
    date_default_timezone_set("Asia/Bangkok");
    
    $data = $db->xuat_tin_tuc();
 
    echo json_encode($data)
?>
