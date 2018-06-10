<?php
require_once '../model/dbconnect.php';
if (isset($_GET["c"])) {
	# code...
	$codice = $_GET["c"];
	$res = explode(":", $codice);
	if (sizeof($res)==6) {
		# code...
		$text ="".$res [0].$res [1].$res [2].$res [3].$res [4].$res [5];
	}else{
		$text = $codice;
	}
	
	$stmts = $conn->prepare("INSERT INTO prova(codice) VALUES(?)");
	$stmts->bind_param("s", $text);
	$result = $stmts->execute();
	$stmts->close();

echo "done";
}else{
	echo "error";
}