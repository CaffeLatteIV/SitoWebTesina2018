<?php
require_once '../model/dbconnect.php';
if (isset($_GET["c"])) {
	# code...
	$codice =  filter_input(INPUT_GET, 'c', FILTER_SANITIZE_STRING);
	$umidita =  filter_input(INPUT_GET, 'u', FILTER_SANITIZE_STRING);
	$temp =  filter_input(INPUT_GET, 't', FILTER_SANITIZE_STRING);
	$volt =  filter_input(INPUT_GET, 'v', FILTER_SANITIZE_STRING);
	$amp =  filter_input(INPUT_GET, 'a', FILTER_SANITIZE_STRING);
	date_default_timezone_set("Europe/Rome");
	$data = date("Y-m-d");
	$anno = date("Y");
	$res = explode(":", $codice);
	if (sizeof($res)==6) {
		# code...
		$text ="".$res [0].$res [1].$res [2].$res [3].$res [4].$res [5];
	}else{
		$text = $codice;
	}
/*
	$stmts = $conn->prepare("INSERT INTO misurazioni(codice,temperatura,umidita,volt,ampere,data,anno) VALUES(???????)");
	$stmts->bind_param("sssssss", $text,$umidita,$temp,$volt,$amp,$data,$anno);
	$result = $stmts->execute();
	$stmts->close();
*/  
	$ora = date("h");
    if($ora == 1 || $ora == 9  ){
    
	$query = $conn->query("INSERT INTO misurazioni(id,codice,temperatura,umidita,volt,ampere,data,anno) VALUES (null,'$text',$temp,$umidita,$volt,$amp,'$data','$anno')");
	
    }
    echo "done";
}else{
	echo "error";
}