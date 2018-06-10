<?php
ob_start();
session_start();
require_once '../model/dbconnect.php';
$login = false; //default false
$operazione = filter_input(INPUT_GET, 's', FILTER_SANITIZE_STRING);
//controllo se l'utente abbia già fatto il log in
if (!isset($_SESSION['user']) && $_SESSION['user'] == "" ) { 
    //non ha effettuato il login
  header("Location: ../index.php");

}else{
// seleziono i dati dell'utente
$res = $conn->query("SELECT * FROM users WHERE id=" . $_SESSION['user']); //trovo l'utente nel database
$userRow = mysqli_fetch_array($res, MYSQLI_ASSOC); //restituisco la riga sottoforma di array associativo 
$login = true;
}

if (isset($_POST['btn-dispositivo'])) {//se è stato premuto il bottone --> aggiungi dispositivo

  $nDispositivo = filter_input(INPUT_POST, 'nDispositivo', FILTER_SANITIZE_STRING); //analizzo il @param nDispositivo per evitare manipolazioni
  $cDispositivo = filter_input(INPUT_POST, 'cDispositivo', FILTER_SANITIZE_STRING); //analizzo il @param cDispositivo per evitare manipolazioni

  //controllo che il codice NON ESISTA nella tabella dei dispositivi
  $stmt = $conn->prepare("SELECT codice  FROM dispositivo WHERE codice=?");
  $stmt->bind_param("s", $cDispositivo);
  $stmt->execute();
  $result = $stmt->get_result();
  $stmt->close();

  $cDis = $result->num_rows; 

  //controllo che il codice ESISTA nella tabella delle misurazioni
  $stmt = $conn->prepare("SELECT codice  FROM misurazioni WHERE codice=?");
  $stmt->bind_param("s", $cDispositivo);
  $stmt->execute();
  $result = $stmt->get_result();
  $stmt->close();

  $cMis = $result->num_rows;

  //echo $cDis." ".$cMis; controllo 

    if ($cDis >0 ) {// dispositivo  è GIA STATO AGGIUNTO alla tabella dispositivi
      $errMSG = "Errore, dispositivo già registrato";// messaggio di errore
    }elseif ($cMis == 0) { // dispositivo non eisite nella tabella delle misurazioni
      # code...
      $errMSG = "Errore, dati inseriti non correttamente"; // messaggio di errore
    }else{ // altrimenti aggiungi dispositivo

      date_default_timezone_set("Europe/Rome"); //imposto la data italiana

      $stmts = $conn->prepare("INSERT INTO dispositivo(proprietario,codice,nome,data) VALUES(?,?, ?,?)");
      $stmts->bind_param("ssss", $_SESSION["id"],$cDispositivo, $nDispositivo,date("d/m/Y"));
      $res = $stmts->execute();
      $stmts->close();
      header("Location: dispositivo.php?s=v"); //reindirizzaa alla pagina di visualizzazione dei dispositivi
    }
  }
    ?>

    <?php
    require __DIR__ . "/nav.php"
    ?>
    <style type="text/css">

    table {
      border-collapse: collapse;
      border-spacing: 0;
      width: 100%;
      border: 1px solid #ddd;
    }

    th, td {
      text-align: left;
      padding: 1%;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2
    }
  </style>
  <div class="wrapper row3">
    <main class="hoc container clear"> 
      <!-- main body -->
      <!-- ################################################################################################ -->
      <div class="content"> 
        <!-- ################################################################################################ -->
        
        <?php if ($operazione == "a") { //se l'operazione richiesta è di aggiungere un dispositivo:

        ?>
        <div id="login-form">
          <form method="post" autocomplete="off">

            <div class="col-md-12">

              <div class="form-group">
                <h2 class="">Dispositivo</h2>
              </div>

              <div class="form-group">
                <hr/>
              </div>

              <?php
              if (isset($errMSG)) { //stampo il messaggio di errore

                ?>
                <div class="form-group">
                  <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                  </div>
                </div>
                <?php
              }
              ?>

              <div class="form-group">
                <div class="input-group">Nome: 
                  <input type="text" name="nDispositivo" class="form-control" placeholder="Nome dispositivo" required/>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">Codice:
                  <input type="text" name="cDispositivo" class="form-control" placeholder="Codice dispositivo" required/>
                </div>
              </div>



              <div class="form-group">
                <hr/>
              </div>

              <div class="form-group">
                <button type="submit" class="btn btn-block btn-primary" name="btn-dispositivo">Aggiungi</button> <!-- bottone per l'aggiunta di un dispositivo -->
              </div>

              <div class="form-group">
                <hr/>
              </div>
            </div>

          </form>
        </div>
      <?php }else if($operazione == "v"){
              $query = $conn->query("SELECT * FROM  dispositivo WHERE proprietario=" . $_SESSION['id']); //query per visualizzare informazioni riguardo i propri dispositivi
              ?>
              <table>
                <th>Codice</th>
                <th>Nome dispositivo</th>
                <th>Data registrazione</th>


                <?php

      if ($query->num_rows >0) { // se esistono dispositivi già registrati
        while ($riga = $query->fetch_assoc()) {

          ?>
          <tr> 
            <td><?php echo $riga["codice"]?></td>
            <td><?php echo $riga["nome"]?></td>
            <td><?php echo $riga["data"]?></td>
          </tr>


          <?php 

        }}?>

      </table>
      <?php
    } ?>

  </div>
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