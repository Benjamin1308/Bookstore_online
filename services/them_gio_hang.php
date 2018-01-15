<?php 
session_start();

// if(isset($_SESSION['nguoi_dung'])){
//     ;
    
//     echo 1;
// }

try{
    $connection=new PDO('mysql:host=localhost;dbname=ban_sach_online_db','root','');
    $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);    
    $data = json_decode(file_get_contents("php://input"));
    date_default_timezone_set("Asia/Vientiane");
    
    $gio_hang = $data->gio_hang;
   
    if(@$_SESSION['nguoi_dung']!=''){
        $_SESSION['gio_hang'] = $gio_hang;
        // print_r($_SESSION['gio_hang']);
        echo json_encode($_SESSION['gio_hang']);
    }else{
        echo 0;
    }
    
}
catch (PDOException $e) {
    // echo $sql . "<br>" . $e->getMessage();
}
$connection = null;
?>