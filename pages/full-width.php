
<?php
ob_start();
session_start();
require_once '../model/dbconnect.php';

// if session is set direct to index
if (isset($_SESSION['user'])) {
  header("Location: ../index.php");
  exit;
}

if (isset($_POST['btn-login'])) {
  $email = $_POST['email'];
  $upass = $_POST['pass'];

    $password = hash('sha256', $upass); // password hashing using SHA256
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email= ?");
    $stmt->bind_param("s", $email);
    /* execute query */
    $stmt->execute();
    //get result
    $res = $stmt->get_result();
    $stmt->close();

    $row = mysqli_fetch_array($res, MYSQLI_ASSOC);

    $count = $res->num_rows;
    if ($count == 1 && $row['password'] == $password) {
      $_SESSION['user'] = $row['id'];
      header("Location: index.php");
    } else $errMSG = "Dati di accesso non validi";
  }
  ?><!DOCTYPE html>

  <html>
  <head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="../layout/styles/bootstrap.min.css" type="text/css"/>
    <link href="../layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">

    <style type="text/css">
    #login-form {
      margin:5% auto;
      max-width:500px;
    }
    .form-control {
       box-sizing: content-box; 
      display: block;
      width: 100%;
      height: 34px;
      padding: 6px 12px;
      font-size: 14px;
      line-height: 1.42857143;
      color: #555;
      background-color: #fff;
      background-image: none;
      border: 1px solid #ccc;
      border-radius: 4px;
      -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
      box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
      -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
      -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
      transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    }
    .form-control:focus {
      border-color: #66afe9;
      outline: 0;
      -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
      box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
    }
    .form-control::-moz-placeholder {
      color: #999;
      opacity: 1;
    }
    .form-control:-ms-input-placeholder {
      color: #999;
    }
    .form-control::-webkit-input-placeholder {
      color: #999;
    }
    .form-control::-ms-expand {
      background-color: transparent;
      border: 0;
    }
    .form-control[disabled],
    .form-control[readonly],
    fieldset[disabled] .form-control {
      background-color: #eee;
      opacity: 1;
    }
    .form-control[disabled],
    fieldset[disabled] .form-control {
      cursor: not-allowed;
    }
    textarea.form-control {
      height: auto;
    }
    input[type="search"] {
      -webkit-appearance: none;
    }
  </style>
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
          <h1><a href="../index.html">Humystop</a></h1>
        </div>
        <nav id="mainav" class="fl_right">
          <ul class="clear">
            <li><a href="../index.html">Home</a></li>
            <li ><a class="drop" href="#">Pages</a>
              <ul>
                <li><a href="gallery.html">Gallery</a></li>
                <li ><a href="full-width.html">Full Width</a></li>
                <li><a href="sidebar-left.html">Sidebar Left</a></li>
                <li><a href="sidebar-right.html">Sidebar Right</a></li>
                <li><a href="basic-grid.html">Basic Grid</a></li>
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
            <li  class="active"><a href="#">Accedi</a></li>
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
        <li><a href="#">Accedi</a></li>
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
              if (isset($errMSG)) {

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