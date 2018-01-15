<?php
	$data = json_decode(file_get_contents("php://input"));

	include('config.php');

	$db = new DB();

	$sql = "UPDATE `bs_tin_tuc` SET `tieu_de_tin` = '$data->tieu_de_tin', `noi_dung_tom_tat` = '$data->noi_dung_tom_tat', `noi_dung_chi_tiet` = '$data->noi_dung_chi_tiet', `hinh_dai_dien` = '$data->hinh_dai_dien' WHERE id = '$data->id'";
	
	$data = $db->xuat_tin_tuc_after_insert($sql);

	echo json_encode($data);
?>