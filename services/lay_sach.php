<?php
	include('config.php');

	$db = new DB();

	$data = $db->get_book();
	
	echo json_encode($data);