<?php
	$data = json_decode(file_get_contents("php://input"));
    
    include('config.php');
    $db = new DB();
    $check = true;
	
    $mail = $db->get_user_by_email($data->email);
    $taikhoan = $db->get_user_by_tai_khoan($data->tai_khoan);
    
    $ngay_dang_ky = date('Y-m-d H:i:s');
    $mat_khau = md5($data->mat_khau);

    if (!$mail && !$taikhoan){
        $sql = "INSERT INTO `bs_nguoi_dung`(`tai_khoan`,`mat_khau`,`id_loai_user`,`ho_ten`,`email`,`ngay_sinh`,`dia_chi`,`ngay_dang_ky`,`dien_thoai`) 
                VALUES('$data->tai_khoan','$mat_khau','$data->id_loai_user','$data->ho_ten','$data->email','$data->ngay_sinh','$data->dia_chi','$ngay_dang_ky','$data->dien_thoai')";
        $data = $db->them_thong_tin($sql);
        echo "success";
    }
    else if ($mail && $taikhoan){
        echo "both";   
    }
    else if ($taikhoan){
        echo "username";
    }
    else if ($mail){
        echo "email";
    }
   
?>
	
