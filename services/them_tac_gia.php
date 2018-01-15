<?php
	$data = json_decode(file_get_contents("php://input"));

	include('config.php');

	$db = new DB();
	
	$sql = "INSERT INTO `bs_tac_gia`(`ten_tac_gia`,`gioi_thieu`)VALUES('$data->ten_tac_gia','$data->gioi_thieu')";
	
	$data = $db->get_tac_gia_after_insert($sql);

	echo json_encode($data);