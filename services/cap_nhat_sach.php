<?php

	$data = json_decode(file_get_contents("php://input"));
	
	include('config.php');

	$db = new DB();

	$sql = "UPDATE `bs_sach` SET `ten_sach` = '$data->ten_sach' WHERE `id` = $data->id";

	$data = $db->get_book_after_insert($sql);

	echo json_encode($data);
