<?php
	include('config.php');

	$db = new DB();

	$data = $db->get_nxb();
	
	echo json_encode($data);