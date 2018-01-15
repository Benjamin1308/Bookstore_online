<?php 
session_start();

    // $connection=new PDO('mysql:host=localhost;dbname=ban_sach_online_db','root','');
    // $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);    
    $data = json_decode(file_get_contents("php://input"));
    date_default_timezone_set("Asia/Vientiane");
    

    $product_id = $data->product_id;
    $product_name = $data->product_name;
    $don_gia = $data->don_gia;
    $quantity = $data->quantity;
   
    if(@$_SESSION['nguoi_dung']!=''){
        if(@$_SESSION['cart']!=''){
			$max=count($_SESSION['cart']);
			for($i=0;$i<$max;$i++){
				if($product_id==$_SESSION['cart'][$i]['product_id']){
					$_SESSION['cart'][$i]['quantity']=$_SESSION['cart'][$i]['quantity']+$quantity;
				}
			}
			echo json_encode($_SESSION['cart']);
		}
		else{
        	echo 0;
		}
	}

?>