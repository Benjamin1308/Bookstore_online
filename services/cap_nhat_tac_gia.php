<?php

	$data = json_decode(file_get_contents("php://input"));
	
	include('config.php');

	$db = new DB();

	$sql = "UPDATE `bs_tac_gia` SET `ten_tac_gia` = '$data->ten_tac_gia', `gioi_thieu` = '$data->gioi_thieu'  WHERE `id` = '$data->id'";

	$data = $db->get_tac_gia_after_insert($sql);

	echo json_encode($data);