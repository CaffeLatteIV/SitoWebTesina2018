

<?php
ob_start();
session_start();
require_once 'model/dbconnect.php';
$login = false; //default false

//controllo se l'utente ha già fatto il log in
if (isset($_SESSION['user'])) {
    $login = true; //cambio status del login in true (utente loggato)

// seleziono i dati dell'utente
$res = $conn->query("SELECT * FROM users WHERE id=" . $_SESSION['user']); //trovo l'utente nel database
$userRow = mysqli_fetch_array($res, MYSQLI_ASSOC); //restituisco la riga sottoforma di array associativo 
$_SESSION['id'] = $userRow["id"];
}
?>

<!DOCTYPE php>
<php>
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
   <link rel="stylesheet" href="layout/styles/bootstrap.min.css" type="text/css"/>
   <link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
   <style type="text/css">
   a:link {
    text-decoration: none;
  }

  a:visited {
    text-decoration: none;
  }
  i.my{
    background-color: #FF5723;
  }

</style>
</head>
<body id="top">
  <!-- ################################################################################################ -->
  <!-- ################################################################################################ -->
  <!-- ################################################################################################ -->
  <!-- Immagine di background -->
  <div class="bgded overlay" style="background-image:url('images/nav.png');"> 
    <!-- ################################################################################################ -->
    <div class="wrapper row1">
      <header id="header" class="hoc clear"> 
        <!-- ################################################################################################ -->
        <div id="logo" class="fl_left">
          <h1><a href="#">Humystop</a></h1>
        </div>
        <nav id="mainav" class="fl_right">
          <ul class="clear">
            <li class="active"><a href="#">Home</a></li>
            
            <li><a href="pages/info.php">Chi siamo</a></li>
            <?php 
       if(!$login && !$admin){ //se l'utente NON ha ancora effettuato il login e NON è amministratore

      //-------------------------------------------stampa bottoni per login-----------------------------------------
       ?>
       <li><a href="pages/login.php">Login </a></li>
       <li><a href="pages/register.php">registrati </a></li>

     <?php };
      // ------------------------------------------------- FINE ----------------------------------------------------
     ?>

     <?php

     if($login && !$admin){//se l'utente ha effettuato l'accesso e NON è amministratore
      
        //-------------------------------- -------------- stampa ---------------------------------------------------

       //query che restituisce tutti gli anni in ordine dal maggiore al minore
      $queryUT = $conn->query("SELECT m.anno FROM misurazioni as m, dispositivo as d WHERE m.codice = d.codice && d.proprietario=" . $_SESSION['id']." GROUP BY (anno) ORDER BY anno DESC" ); //query umidità e temperatura
      $queryVA = $conn->query("SELECT m.anno FROM misurazioni as m, dispositivo as d WHERE m.codice = d.codice && d.proprietario=" . $_SESSION['id']." GROUP BY (anno) ORDER BY anno DESC" ); //query volt e ampere


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
                  <li><a href="pages/umiTemp.php?y=<?php echo $riga['anno']//passo il @param anno alla pagina ?>"><?php echo $riga["anno"] ?></a></li>


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
                  <li><a href="pages/voltAmp.php?y=<?php echo $riga['anno']//passo il @param anno alla pagina ?>"><?php echo $riga["anno"] ?></a></li>
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
           <li><a href="pages/dispositivo.php?s=a">Aggiungi</a></li>
           <li><a href="pages/dispositivo.php?s=v">Visualizza</a></li>
         </ul>
       </li>
       <?php

    }else{ //altrimenti se non è stato registrato --> registralo
     ?>
     <li>
       <a class="drop" href="#">Dispositivi</a><!-- possibilità di aggiungere un dispositivo -->
       <ul>
         <li><a href="pages/dispositivo.php?s=a">Aggiungi</a></li>        
       </ul>
     </li>
   <?php } ?>
   
   <li>
     <a class="drop" href="#"><?php echo $userRow["email"] ?></a>
     <ul>
       <li><a href="pages/logout.php?logout">Disconnettiti</a>
       </li>
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
       <li><a href="pages/dispositivo.php?s=va">Visualizza</a></li> <!-- @param va = "visualizza da amministratore" -->       
     </ul>
   </li>
 <li>
     <a class="drop" href="#"><?php echo "AMMINISTRATORE" ?></a>
     <ul>
      <li><a  href="#">ID: <?php echo $_SESSION["user"] ?></a></li>
       <li><a href="pages/logout.php?logout">Disconnettiti</a></li>
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
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->


<!-- ################################################################################################ -->
</div>

<!-- fine navbar -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->

<div class="wrapper row3">
  <section class="hoc container clear"> 
    <!-- ################################################################################################ -->
    <div class="center btmspace-80">
      <h1 class="heading nospace">Humystop</h1>
      <p class="nospace">- Your problem, our solution -</p>
    </div>
    <ul class="nospace group services">
      <li class="one_third first">
        <article><a href="#"><i class="fa fa-balance-scale my"></i></a>
          <h6 class="heading">Economico</h6>
          <p>Il dispositivo è stato ideato con un design di alta qualità per offire performace ottimali in ogni ambiente, il  tutto al minor prezzo sul mercato.</p>
          
        </article>
      </li>
      <li class="one_third">
        <article><a href="#"><i class="fa fa-500px my"></i></a>
          <h6 class="heading">Semplice</h6>
          <p>Installazione veloce, grazie ai nostri validi tecnici. I dati rilevati sono facilemente consultabili dal sito.</p>
        </article>
      </li>
      <li class="one_third">
        <article><a href="#"><i class="fa fa-fast-forward my"></i></a>
          <h6 class="heading">Dinamico</h6>
          <p>Il dispositivo è stato sviluppato per conformarsi a seconda delle esigenze del consumatore esemplificando il più possibile ogni sua operazione </p>
        </article>
      </li>
    </ul>
    <!-- ################################################################################################ -->
    <div class="clear"></div>
  </section>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->

</section>
</div>


<div class="wrapper row4">
  <footer id="footer" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <div class="one_third first">
      <h6 class="heading">Humystop s.r.l.</h6><br><br>
      <p>Seguici sui vari social per rimanere al corrente di tutte le nostre news!</p><br><br>
      
      <ul class="faico clear">
        <li><a class="faicon-facebook" href="#"><i class="fa fa-facebook"></i></a></li>
        <li><a class="faicon-twitter" href="#"><i class="fa fa-twitter"></i></a></li>
        <li><a class="faicon-dribble" href="#"><i class="fa fa-dribbble"></i></a></li>
        <li><a class="faicon-linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
        <li><a class="faicon-google-plus" href="#"><i class="fa fa-google-plus"></i></a></li>
        <li><a class="faicon-vk" href="#"><i class="fa fa-vk"></i></a></li>

      </ul>

    </div>

    <div class="one_third">
      <h6 class="heading">Dove trovarci</h6>
      <ul class="nospace linklist contact">
        <li><i class="fa fa-map-marker"></i>
          <address>
            Bologna, via dei mille 12/B
          </address>
        </li>
        <li><i class="fa fa-phone"></i>+39 5622884596</li>
        <li><i class="fa fa-fax"></i> +39 0512884596</li>
        <li><i class="fa fa-envelope-o"></i> info@humystop.com</li>
      </ul>
    </div>
    <div class="one_third">
      <h6 class="heading">Chi siamo</h6>
      <ul class="nospace linklist">
        <li>
          <article>
            <h2 class="nospace font-x1"><a href="#">Gianmarco Cavazza</a></h2>
            <br>
            <p class="nospace">Studente 5Ci IIS Belluzzi-Fioravanti</p>
          </article>
        </li>
        <li>
          <article>
            <h2 class="nospace font-x1"><a href="#">Mattia Babbini</a></h2>
            <br>
            <p class="nospace">Studente 5Ci IIS Belluzzi-Fioravanti</p>
            <br><br><br>

          </article>
        </li>
      </ul>

    </div>
    
    <p class="fl_left" >Copyright &copy; 2016 - All Rights Reserved - Humystop s.r.l</p> 
    <!-- ################################################################################################ -->

  </div>
  <div class="wrapper row5">
    <div id="copyright" class="hoc clear"> 
      <!-- ################################################################################################ -->

      <!-- ################################################################################################ -->
    </div>
  </div>
</footer>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>
<!-- JAVASCRIPTS -->
<script src="layout/scripts/jquery.min.js"></script>
<script src="layout/scripts/jquery.backtotop.js"></script>
<script src="layout/scripts/jquery.mobilemenu.js"></script>
</body>
</html>