

<?php
ob_start();
session_start();
require_once 'model/dbconnect.php';
$login = false; //default false

//controllo se l'utente ha già fatto il log in
if (isset($_SESSION['user'])) {
    $login = true; //cambio status del login in true (utente loggato)
    header(../index.php);

// seleziono i dati dell'utente
$res = $conn->query("SELECT * FROM users WHERE id=" . $_SESSION['user']); //trovo l'utente nel database
$userRow = mysqli_fetch_array($res, MYSQLI_ASSOC); //restituisco la riga sottoforma di array associativo 
}
?>
<!DOCTYPE.php>
<head>
  <title>Chi siamo</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <link rel="stylesheet" href="../layout/styles/bootstrap.min.css" type="text/css"/>
  <link href="../layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">

</head>
<body id="top">
  <!-- ################################################################################################ -->
  <!-- ################################################################################################ -->
  <!-- ################################################################################################ -->
  <!-- Top Background Image Wrapper -->
  <div class="bgded overlay" style="background-image:url('../images/demo/backgrounds/01.png');"> 
    <!-- ################################################################################################ -->
    <div class="wrapper row1">
      <header id="header" class="hoc clear"> 
        <!-- ################################################################################################ -->
        <div id="logo" class="fl_left">
          <h1><a href="../index.php">Humystop</a></h1>
        </div>
        <nav id="mainav" class="fl_right">
          <ul class="clear">
            <li><a href="../index.php">Home</a></li>
            <li ><a class="drop" href="#">Pages</a>
              <ul>
                <li><a href="gallery.php">Gallery</a></li>
                <li ><a href="full-width.php">Full Width</a></li>
                <li><a href="sidebar-left.php">Sidebar Left</a></li>
                <li><a href="sidebar-right.php">Sidebar Right</a></li>
                <li><a href="basic-grid.php">Basic Grid</a></li>
              </ul>
            </li>
            <li><a class="drop" href="#">Dropdown</a>
              <ul>
                <li><a href="#">Level 2</a></li>
                <li><a class="drop" href="#">Level 2 + Drop</a>
                  <ul>
                    <li><a href="#">Level 3</a></li>
                    <li><a href="#">Level 3</a></li>
                    <li><a href="#">Level 3</a></li>
                  </ul>
                </li>
                <li><a href="#">Level 2</a></li>
              </ul>
            </li>
            <li class="active"><a href="#">Chi siamo</a></li>
            <li><a href="login.php">Accedi</a></li>
            <li><a href="registrer.php">Registrati</a></li>
          </ul>
        </nav>
        <!-- ################################################################################################ -->
      </header>
    </div>
    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->
    <div id="breadcrumb" class="hoc clear"> 
      <!-- ################################################################################################ -->
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">Chi siamo</a></li>
      </ul>
      <!-- ################################################################################################ -->
    </div>
    <!-- ################################################################################################ -->
  </div>
  <!-- End Top Background Image Wrapper -->
  <!-- ################################################################################################ -->
  <!-- ################################################################################################ -->
  <!-- ################################################################################################ -->
  <div class="wrapper row3">
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