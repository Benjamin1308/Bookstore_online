<?php

	$data = json_decode(file_get_contents("php://input"));
	
	include('config.php');

	$db = new DB();

	$sql = "DELETE FROM `bs_tin_tuc` WHERE `id` = $data->id";

	$data = $db->xuat_tin_tuc_after_insert($sql);

	echo json_encode($data);
