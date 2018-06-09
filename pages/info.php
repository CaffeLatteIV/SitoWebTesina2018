<?php
ob_start();
session_start();
require_once '../model/dbconnect.php';
$login = false; //default false
$anno =  filter_input(INPUT_GET, 'y', FILTER_SANITIZE_STRING); //analizzo il @param anno per evitare manipolazioni
//controllo se l'utente ha già fatto il log in
if (isset($_SESSION['user']) && $_SESSION['user'] != "" ) {
    $login = true; //cambio status del login in true (utente loggato)

// seleziono i dati dell'utente
$res = $conn->query("SELECT * FROM users WHERE id=" . $_SESSION['user']); //trovo l'utente nel database
$userRow = mysqli_fetch_array($res, MYSQLI_ASSOC); //restituisco la riga sottoforma di array associativo 
}
?>

  <?php
  require __DIR__ . "/nav.php"
  ?>
    <main class="hoc container clear"> 
      <!-- main body -->
      <!-- ################################################################################################ -->
      <div class="content"> 
        <!-- ################################################################################################ -->
        

        
        <!-- ################################################################################################ -->
      </div>
      <!-- ################################################################################################ -->
      <!-- / main body -->
      <div class="clear"></div>
    </main>
  </div>
  <?php
  require __DIR__ . "/bottom.php"
  ?>