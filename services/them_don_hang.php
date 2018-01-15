<?php
    session_start();
	$data = json_decode(file_get_contents("php://input"));
    
    include('config.php');
    $db = new DB();
    $check = true;
	
    $ngay_dat = date('Y-m-d H:i:s');
   
    $sql = "INSERT INTO `bs_don_hang`(`tong_tien`,`ngay_dat`,`id_nguoi_dung`,`ho_ten_nguoi_nhan`,`email_nguoi_nhan`,`so_dien_thoai_nguoi_nhan`,`dia_chi_nguoi_nhan`) 
            VALUES('$data->tong_tien','$ngay_dat','$data->id_nguoi_dung','$data->ho_ten_nguoi_nhan','$data->email_nguoi_nhan','$data->so_dien_thoai_nguoi_nhan','$data->dia_chi_nguoi_nhan')";
    // $data = $db->them_thong_tin($sql);
    // $result=mysql_query("insert into orders values('','$date','$customerid')");
	// $orderid=mysql_insert_id();

    $id_don_hang = $db->them_thong_tin2($sql);
    
    $max=count($_SESSION['cart']);
    
    $stm = $db->con->prepare('INSERT INTO `bs_chi_tiet_don_hang`(`id_don_hang`,`id_sach`,`so_luong`,`don_gia`,`thanh_tien`) VALUES(:a,:b,:c,:d,:e)');
    // $sql2 = "INSERT INTO bs_chi_tiet_don_hang(id_don_hang,id_sach,so_luong,don_gia,thanh_tien) 
        //     VALUES(:a,:b,:c,:d,:e)";

    for($i=0;$i<$max;$i++){
        
        $product_id = $_SESSION['cart'][$i]['product_id'];
        $quantity = $_SESSION['cart'][$i]['quantity'];
        $don_gia = $_SESSION['cart'][$i]['don_gia'];
        $price = $_SESSION['cart'][$i]['quantity'] * $_SESSION['cart'][$i]['don_gia'];
        
     
        // $sql2 = "INSERT INTO bs_chi_tiet_don_hang(id_don_hang,id_sach,so_luong,don_gia,thanh_tien) 
        //     VALUES('$id_don_hang','$product_id','$quantity','$don_gia','$price')";
        // $con->exec("INSERT INTO bs_chi_tiet_don_hang(id_sach,so_luong,don_gia) 
        //     VALUES('$product_id','$quantity','$don_gia')");
        // $data = $db->them_thong_tin($sql);
        
        $stm->bindValue(':a', $id_don_hang);
        $stm->bindValue(':b', $_SESSION['cart'][$i]['product_id']);
        $stm->bindValue(':c', $_SESSION['cart'][$i]['quantity']);
        $stm->bindValue(':d', $_SESSION['cart'][$i]['don_gia']);
        $stm->bindValue(':e', $_SESSION['cart'][$i]['quantity'] * $_SESSION['cart'][$i]['don_gia']);
        $stm->execute();
        
        // $data = $db->them_thong_tin($sql2);
        
    }
  
    echo "success";
  
   
?>
	
