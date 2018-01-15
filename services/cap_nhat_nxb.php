<?php

	$data = json_decode(file_get_contents("php://input"));
	
	include('config.php');

	$db = new DB();

	$sql = "UPDATE `bs_nha_xuat_ban` SET `ten_nha_xuat_ban` = '$data->ten_nha_xuat_ban', `dia_chi` = '$data->dia_chi', `dien_thoai` = '$data->dien_thoai', `email` = '$data->email'  WHERE `id` = '$data->id'";

	$data = $db->get_nxb_after_insert($sql);

	echo json_encode($data);