<?php
session_start();
require_once '../model/dbconnect.php';

if (!isset($_SESSION['user']) && !isset($_SESSION["admin"])) {
	header("Location: login.php");
}elseif (isset($_SESSION["admin"])) {

	$codice = filter_input(INPUT_GET, 'c', FILTER_SANITIZE_STRING); //id del dispositivo da cancellare

	/************************* cancellazione dispositivo *************************/
	$query = $conn->query("DELETE FROM  dispositivo  WHERE codice='".$codice."'");//CANCELLO il dispositivo selezionato
	$query = $conn->query("DELETE FROM  misurazioni  WHERE codice='".$codice."'"); //cancello le misurazioni fatte fino ad ora
	header("Location: dispositivo.php?s=va");
	exit;
}