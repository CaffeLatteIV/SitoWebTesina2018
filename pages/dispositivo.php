<?php
ob_start();
session_start();
require_once '../model/dbconnect.php';
$login = false; //default false
$operazione = filter_input(INPUT_GET, 's', FILTER_SANITIZE_STRING);
//controllo se l'utente abbia già fatto il log in
if (!isset($_SESSION['user']) && $_SESSION['user'] == "" ) {
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

  //controllo che il codice esista
  $stmt = $conn->prepare("SELECT codice  FROM dispositivo WHERE codice=?");
  $stmt->bind_param("s", $cDispositivo);
  $stmt->execute();
  $result = $stmt->get_result();
  $stmt->close();

  $count = $result->num_rows;

  echo $count;

    if ($count == 0 ) { // controllo che il codice non esista nella tabella dispositivo 
      $stmts = $conn->prepare("INSERT INTO dispositivo(proprietario,codice,nome) VALUES(?,?, ?)");
      $stmts->bind_param("sss", $_SESSION["id"],$cDispositivo, $nDispositivo);
      $res = $stmts->execute();
      $stmts->close();
      header("Location: dispositivo.php?s=v");
    } else $errMSG = "Errore, dispositivo già registrato"; //altrimenti --> messaggio di errore
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
                <th>Identificativo</th>
                <th>Nome dispositivo</th>
                <th>Codice</th>


                <?php

      if ($query->num_rows >0) { // se esistono dispositivi già registrati
        while ($riga = $query->fetch_assoc()) {

          ?>
          <tr> 
            <td><?php echo $riga["id"]?></td>
            <td><?php echo $riga["nome"]?></td>
            <td><?php echo $riga["codice"]?></td>
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