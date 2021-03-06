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

if ($_SESSION["admin"]) {
  # code...
  $proprietario = $_GET["id"];
} else {
  # code...
  $proprietario = $_SESSION['id'];
}

?>

<?php
require __DIR__ . "/nav.php" //carico la navbar
?>
</div> <!-- fine navbar -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row3">
  <main class="hoc clear"> 
    <div class="content"> 
      <div style="width:100%;">
        <canvas id="grafico"></canvas>
      </div>
    </div>
  </main>
  </div>
<!-- ################################################################################################ -->




<script src="../layout/chart/Chart.min.js"></script>
<script>
  var config = {
    type: 'line',
    data: {
      labels: [<?php 

         $dUmidita = $conn->query("SELECT m.data FROM misurazioni as m, dispositivo as d WHERE d.proprietario=" .$proprietario."&& d.codice = m.codice && anno=".$anno." ORDER BY m.id "); //query data
         while ($rUmidita = $dUmidita->fetch_assoc()) { //@param rUmidita = riga restituita dalla query, @param dUmidita = data
          $data = explode("-", $rUmidita["data"]);
          echo "'".$data[2]."/".$data[1]."',";
        };

        ?>],
      datasets: [{
        label: 'Volt',
        backgroundColor: "#FFA000",
        borderColor: "#FFA000",
        data: [<?php 

         $query = $conn->query("SELECT m.volt FROM misurazioni as m, dispositivo as d WHERE d.proprietario=" . $proprietario."&& d.codice = m.codice && anno=".$anno." ORDER BY m.id "); //query valori umidità
         while ($riga = $query->fetch_assoc()) {
          echo $riga["volt"].",";
        };

        ?>],
        fill: false,
      }, {
        label: 'Ampere',
        fill: false,
        backgroundColor: "#388E3C",
        borderColor: "#388E3C",
        data: [<?php 

         $query = $conn->query("SELECT m.ampere FROM misurazioni as m, dispositivo as d WHERE d.proprietario=" . $proprietario."&& d.codice = m.codice && anno=".$anno." ORDER BY m.id "); //query valori umidità
         while ($riga = $query->fetch_assoc()) {
          echo $riga["ampere"].",";
        };

        ?>],
      }]
    },
    options: {
      responsive: true,
      title: {
        display: true,
        text: "Misurazioni di Volt e Ampere nel <?php echo $anno; ?> "
      },
      tooltips: {
        mode: 'index',
        intersect: false,
      },
      hover: {
        mode: 'nearest',
        intersect: true
      }
      }
    
  };

  window.onload = function() {
    var ctx = document.getElementById('grafico').getContext('2d');
    window.myLine = new Chart(ctx, config);
  };
</script>
  <?php
  require __DIR__ . "/bottom.php"
  ?>