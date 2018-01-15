<?php
	$data = json_decode(file_get_contents("php://input"));

	include('config.php');

	$db = new DB();
	
	$sql = "INSERT INTO `bs_tin_tuc`(`tieu_de_tin`,`noi_dung_tom_tat`,`noi_dung_chi_tiet`,`hinh_dai_dien`)VALUES('$data->tieu_de_tin','$data->noi_dung_tom_tat','$data->noi_dung_chi_tiet','$data->hinh_dai_dien')";

	$data = $db->xuat_tin_tuc_after_insert($sql);

	echo json_encode($data);
    // echo "success";
?>
