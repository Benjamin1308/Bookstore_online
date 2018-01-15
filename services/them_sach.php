<?php
	$data = json_decode(file_get_contents("php://input"));

	include('config.php');

	$db = new DB();
	
	$sql = "INSERT INTO `bs_sach`(`ten_sach`,`so_trang`)VALUES('$data->ten_sach','$data->so_trang')";

	$data = $db->get_book_after_insert($sql);

	echo json_encode($data);
