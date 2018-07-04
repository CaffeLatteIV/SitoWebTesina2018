


<!DOCTYPE html>
<head>
  <title>Humystop</title>

  <?php if (isset($_SESSION["admin"]) && $_SESSION["admin"] == true) {
    $admin = true;
  } else {
   $admin = false;
 }
 ?>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
 <link rel="stylesheet" href="../layout/styles/bootstrap.min.css" type="text/css"/>
 <link href="../layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
 <style type="text/css">
 a:link {
  text-decoration: none;
}

a:visited {
  text-decoration: none;
}
</style>
</head>
<body id="top">
  <!-- ################################################################################################ -->
  <!-- ################################################################################################ -->
  <!-- ################################################################################################ -->
  <!-- Immagine di background -->
  <div class="bgded overlay" style="background-image:url('../images/nav.png');"> 
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
            
            <li><a href="info.php">Chi siamo</a></li>
            <?php 
		  if(!$login && !$admin){ //se l'utente NON ha ancora effettuato il login e NON è amministratore
		  
		  //-------------------------------------------stampa bottoni per login-----------------------------------------
     ?>
     <li><a href="login.php">Login </a></li>
     <li><a href="register.php">registrati </a></li>

   <?php };
		  // ------------------------------------------------- FINE ----------------------------------------------------
   ?>

   <?php

   if($login && !$admin){//se l'utente ha effettuato l'accesso e NON è amministratore
   
        //-------------------------------- -------------- stampa ---------------------------------------------------

       //query che restituisce tutti gli anni in ordine dal maggiore al minore
      $queryUT = $conn->query("SELECT m.anno FROM misurazioni as m, dispositivo as d WHERE m.codice = d.codice && d.proprietario=" . $_SESSION['id']." GROUP BY (anno) ORDER BY anno DESC"); //query umidità e temperatura
      $queryVA = $conn->query("SELECT m.anno FROM misurazioni as m, dispositivo as d WHERE m.codice = d.codice && d.proprietario=" . $_SESSION['id']." GROUP BY (anno) ORDER BY anno DESC"); //query volt e ampere


      if ($queryUT->num_rows >0) { // se è già stato registrato il rilevatore (non importa quale query si usi)
                # code...

        ?>

        <li><a class="drop" href="#">Misurazioni</a>
          <ul>
            <li><a class="drop" href="#">Umidità/Temperatura</a>
              <ul>
                <?php 


                while ($riga = $queryUT->fetch_assoc()) {
                // ordino le misurazioni per anno (decrescente)


                  ?>
                  <li><a href="umiTemp.php?y=<?php echo $riga['anno']//passo all il @param anno alla pagina ?>"><?php echo $riga["anno"] ?></a></li>


                  <?php

                };
                ?>
              </ul>
            </li>
            <li><a class="drop" href="#">Volt/Ampere</a>
              <ul>
                <?php 
                while ($riga = $queryVA->fetch_assoc()) {
                // ordino le misurazioni per anno (decrescente)
                  ?>
                  <li><a href="voltAmp.php?y=<?php echo $riga['anno']//passo all il @param anno,codice alla pagina ?>"><?php echo $riga["anno"] ?></a></li>
                  <?php
                };
                ?>
              </ul>
            </li>
          </ul>
        </li>
        <li>
         <a class="drop" href="#">Dispositivi</a><!-- possibilità di aggiungere un dispositivo -->
         <ul>
           <li><a href="dispositivo.php?s=a">Aggiungi</a></li>
           <li><a href="dispositivo.php?s=v">Visualizza</a></li>
         </ul>
       </li>
       <?php

    }else{ //altrimenti se non è stato registrato --> registralo
     ?>
     <li>
       <a class="drop" href="#">Dispositivi</a><!-- possibilità di aggiungere un dispositivo -->
       <ul>
         <li><a href="dispositivo.php?s=a">Aggiungi</a></li>       
       </ul>
     </li>
   <?php } ?>

   <li>
     <a class="drop" href="#"><?php echo $userRow["email"] ?></a>
     <ul>
       <li><a href="logout.php?logout">Disconnettiti</a></li>
     </ul>
   </li>
 <?php
  }
    elseif ($admin == true && $login == true) {
                # code...
?>
  <li>
     <a class="drop" href="#">Dispositivi</a>
     <ul>
       <li><a href="dispositivo.php?s=va">Visualizza</a></li> <!-- @param va = "visualizza da amministratore" -->
     </ul>
   </li>
 <li>
     <a class="drop" href="#"><?php echo "AMMINISTRATORE" ?></a>
     <ul>
      <li><a href="#">ID: <?php echo $_SESSION["user"] ?></a></li>
       <li><a href="logout.php?logout">Disconnettiti</a></li>
     </ul>
   </li>
 <?php
 }
      // ------------------------------------------------- FINE ----------------------------------------------------
 ?>

</ul>
</nav>
<!-- ################################################################################################ -->
</header>
</div>
