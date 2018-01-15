<?php

	$data = json_decode(file_get_contents("php://input"));
	
	include('config.php');

	$db = new DB();

	$sql = "DELETE FROM `bs_tac_gia` WHERE id = '$data->id'";

	$data = $db->get_tac_gia_after_insert($sql);

	echo json_encode($data);
