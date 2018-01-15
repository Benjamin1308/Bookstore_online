<?php
	$data = json_decode(file_get_contents("php://input"));

	include('config.php');

	$db = new DB();
	
	$sql = "INSERT INTO `bs_nha_xuat_ban`(`ten_nha_xuat_ban`,`dia_chi`,`dien_thoai`, `email`)VALUES('$data->ten_nxb','$data->dia_chi', '$data->dien_thoai', '$data->email')";
	
	$data = $db->get_nxb_after_insert($sql);

	echo json_encode($data);
