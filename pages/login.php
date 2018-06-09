<?php
ob_start();
session_start();
require_once '../model/dbconnect.php';
$login = false; //default false

if (isset($_POST['btn-login'])) {
  $email = $_POST['email'];
  $upass = $_POST['pass'];

    $password = hash('sha256', $upass); // calcolo l'hash della password (SHA256)
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email= ?"); // cerco id, username e password per verificare che l'utente esista davvero
    $stmt->bind_param("s", $email);
    /* eseguo la query */
    $stmt->execute();
    //get result
    $res = $stmt->get_result();
    $stmt->close();

    $row = mysqli_fetch_array($res, MYSQLI_ASSOC);

    $count = $res->num_rows;
    
    if ($count == 1 && $row['password'] == $password) { // controllo che le password corrispondano
      $_SESSION['user'] = $row['id'];
      header("Location: ../index.php");
    } else $errMSG = "Dati di accesso non validi"; //altrimenti --> messaggio di errore
  }

  ?>
  <?php
require __DIR__ . "/nav.php"
?>
</div>
  <div class="wrapper row3">
    <main class="hoc container clear"> 
      <!-- main body -->
      <!-- ################################################################################################ -->
      <div class="content"> 
        <!-- ################################################################################################ -->
        

        <div id="login-form">
          <form method="post" autocomplete="off">

            <div class="col-md-12">

              <div class="form-group">
                <h2 class="">Login</h2>
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
                <div class="input-group">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                  <input type="email" name="email" class="form-control" placeholder="Email" required/>
                </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                  <input type="password" name="pass" class="form-control" placeholder="Password" required/>
                </div>
              </div>

              <div class="form-group">
                <hr/>
              </div>

              <div class="form-group">
                <button type="submit" class="btn btn-block btn-primary" name="btn-login">Accedi</button>
              </div>

              <div class="form-group">
                <hr/>
              </div>
            </div>

          </form>
        </div>

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