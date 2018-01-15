<?php
	include('config.php');

	$db = new DB();

	$data = $db->lay_tac_gia();
	
	echo json_encode($data);