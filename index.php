

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
  </style>
</head>
<body id="top">
  <!-- ################################################################################################ -->
  <!-- ################################################################################################ -->
  <!-- ################################################################################################ -->
  <!-- Immagine di background -->
  <div class="bgded overlay" style="background-image:url('images/demo/backgrounds/01.png');"> 
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
            <li><a class="drop" href="#">Pages</a>
              <ul>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="full-width.php">Full Width</a></li>
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
            <li><a href="pages/info.php">Chi siamo</a></li>
            <?php 
      if(!$login){ //se l'utente NON ha ancora effettuato il login 
      
      //-------------------------------------------stampa bottoni per login-----------------------------------------
      ?>
      <li><a href="pages/login.php">Login </a></li>
      <li><a href="pages/register.php">registrati </a></li>

    <?php };
      // ------------------------------------------------- FINE ----------------------------------------------------
    ?>

    <?php

      if($login){//se l'utente ha effettuato l'accesso
      
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
                  <li><a href="pages/umiTemp.php?y=<?php echo $riga['anno']//passo all il @param anno alla pagina ?>"><?php echo $riga["anno"] ?></a></li>


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
                  <li><a href="pages/voltAmp.php?y=<?php echo $riga['anno']//passo all il @param anno alla pagina ?>"><?php echo $riga["anno"] ?></a></li>
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
         <li><a href="pages/dispositivo.php?s=v">Visualizza</a></li>
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
 <?php };
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
<div id="pageintro" class="hoc clear"> 
  <!-- ################################################################################################ -->
  <div class="flexslider basicslider">
    <ul class="slides">
      <li>
        <article>
          <p class="heading">Cum sociis natoque penatibus</p>
          <h2 class="heading">Tincidunt nec venenatis etiam tellus</h2>
          <p>Et magnis dis montes ridiculus mus sed mi eros molestie eget mauris</p>
          <footer>
            <ul class="nospace inline pushright">
              <li><a class="btn" href="#">Parturient</a></li>
              <li><a class="btn inverse" href="#">Nascetur</a></li>
            </ul>
          </footer>
        </article>
      </li>
      <li>
        <article>
          <p class="heading">Urna gravida eget consequat</p>
          <h2 class="heading">Rhoncus pharetra ligula vestibulum</h2>
          <p>Sed varius dui eget convallis nibh lectus ultricies lacus ac auctor lacus</p>
          <footer>
            <ul class="nospace inline pushright">
              <li><a class="btn" href="#">Consequat</a></li>
              <li><a class="btn inverse" href="#">Phasellus</a></li>
            </ul>
          </footer>
        </article>
      </li>
      <li>
        <article>
          <p class="heading">Porta congue lacus eleifend</p>
          <h2 class="heading">Efficitur porta quisque nisl odio suscipit</h2>
          <p>Ante et velit in elit sapien vulputate non mattis ut euismod sed nisi</p>
          <footer>
            <ul class="nospace inline pushright">
              <li><a class="btn" href="#">Accumsan</a></li>
              <li><a class="btn inverse" href="#">Molestie</a></li>
            </ul>
          </footer>
        </article>
      </li>
    </ul>
  </div>
  <!-- ################################################################################################ -->
</div>
<!-- ################################################################################################ -->
</div>
<!-- fine navbar -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->

<div class="wrapper row4">
  <section class="hoc container clear"> 
    <!-- ################################################################################################ -->
    <div class="center btmspace-80">
      <h2 class="heading nospace">Vehicula donec dignissim</h2>
      <p class="nospace">Varius porta maecenas vestibulum efficitur elit eu lacinia massa</p>
    </div>
    <ul class="nospace group services">
      <li class="one_third first">
        <article><a href="#"><i class="fa fa-500px"></i></a>
          <h6 class="heading">Hendrerit quis lorem</h6>
          <p>Iaculis sagittis sapien at porta justo rhoncus sed etiam et metus justo quisque&hellip;</p>
          <footer><a href="#">Read More &raquo;</a></footer>
        </article>
      </li>
      <li class="one_third">
        <article><a href="#"><i class="fa fa-adjust"></i></a>
          <h6 class="heading">Consectetur adipiscing</h6>
          <p>Vulputate lorem eu laoreet orci blandit at nullam sed venenatis magna phasellus ac&hellip;</p>
          <footer><a href="#">Read More &raquo;</a></footer>
        </article>
      </li>
      <li class="one_third">
        <article><a href="#"><i class="fa fa-empire"></i></a>
          <h6 class="heading">Maecenas scelerisque</h6>
          <p>Molestie odio a convallis purus donec lobortis eget ligula nec tincidunt vivamus ut&hellip;</p>
          <footer><a href="#">Read More &raquo;</a></footer>
        </article>
      </li>
      <li class="one_third first">
        <article><a href="#"><i class="fa fa-medium"></i></a>
          <h6 class="heading">Lectus ligula interdum</h6>
          <p>Dolor in hac habitasse platea dictumst suspendisse porttitor justo nec mauris semper&hellip;</p>
          <footer><a href="#">Read More &raquo;</a></footer>
        </article>
      </li>
      <li class="one_third">
        <article><a href="#"><i class="fa fa-scissors"></i></a>
          <h6 class="heading">Varius nullam iaculis</h6>
          <p>Libero luctus pellentesque vel pretium erat praesent id ante sed diam condimentum&hellip;</p>
          <footer><a href="#">Read More &raquo;</a></footer>
        </article>
      </li>
      <li class="one_third">
        <article><a href="#"><i class="fa fa-share-alt"></i></a>
          <h6 class="heading">Cursus ultrices integer</h6>
          <p>A eros laoreet convallis fusce sollicitudin elit non velit eleifend consequat phasellus&hellip;</p>
          <footer><a href="#">Read More &raquo;</a></footer>
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
-
<!--  -->
<div class="wrapper row4">
  <footer id="footer" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <div class="one_third first">
      <h6 class="heading">est ut dolor tristique</h6>
      <p>maecenas tempus vestibulum felis in efficitur sed facilisis urna metus interdum pretium mi dignissim et fusce.</p>
      <p class="btmspace-15">sagittis tempor nullam iaculis dolor id condimentum cursus duis scelerisque ac metus amet laoreet vestibulum dictum.</p>
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
      <h6 class="heading">luctus vestibulum magna</h6>
      <ul class="nospace linklist contact">
        <li><i class="fa fa-map-marker"></i>
          <address>
            Street Name &amp; Number, Town, Postcode/Zip
          </address>
        </li>
        <li><i class="fa fa-phone"></i> +00 (123) 456 7890</li>
        <li><i class="fa fa-fax"></i> +00 (123) 456 7890</li>
        <li><i class="fa fa-envelope-o"></i> info@domain.com</li>
      </ul>
    </div>
    <div class="one_third">
      <h6 class="heading">velit porttitor ac euismod</h6>
      <ul class="nospace linklist">
        <li>
          <article>
            <h2 class="nospace font-x1"><a href="#">ut porttitor sit amet</a></h2>
            <time class="font-xs block btmspace-10" datetime="2045-04-06">Friday, 6<sup>th</sup> April 2045</time>
            <p class="nospace">nunc sed eget augue varius dapibus mi eget lobortis risus nunc a leo&hellip;</p>
          </article>
        </li>
        <li>
          <article>
            <h2 class="nospace font-x1"><a href="#">finibus commodo ex eu</a></h2>
            <time class="font-xs block btmspace-10" datetime="2045-04-05">Thursday, 5<sup>th</sup> April 2045</time>
            <p class="nospace">pharetra nam sit amet lacus tempor ipsum finibus luctus sed fringilla&hellip;</p>
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
<script src="layout/chart/Chart.min.js"></script>
</body>
</html>