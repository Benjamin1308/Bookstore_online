<?php
	include('config.php');

	$db = new DB();

	$data = $db->lay_loai_sach();
	
	echo json_encode($data);