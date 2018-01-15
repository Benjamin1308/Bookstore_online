<?php
    $data = json_decode(file_get_contents("php://input"));

    include('config.php');
    $db = new DB();

    date_default_timezone_set("Asia/Bangkok");
    // $t=time();    
    // $d=date("y-m-d",$t);
    // $d=now();
    $id_s=($data->sach_id)*1;
    $id_nguoi_dung=($data->id_nguoi_dung)*1;
    $sql = "INSERT INTO bs_binh_luan(noi_dung,ngay_binh_luan,id_sach,id_nguoi_dung) 
				VALUES('$data->noi_dung_nx',UNIX_TIMESTAMP(),'$id_s','$id_nguoi_dung')";
    $data = $db->them_thong_tin($sql);
    echo "success";

?>