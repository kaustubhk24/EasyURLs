<?PHP

if(!file_exists('config.php'))
{
    header('location:install.php');
    exit();
}
if(file_exists('install.php'))
{
 unlink('install.php');
}
if(file_exists('install2.php'))
{
  unlink('install2.php');
}
require_once('config.php');
session_start();
if(isset($_SESSION['username']))
{
    header('location:./admin/index.php');
    exit();
}


?>



<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
  <title>Login EasyURLs</title>
  <style>
    body {
      background-color: #e5f1f1;
    }

    .form-login {
      border-radius: 10px !important;
      background-color: white;
    }

    .login-submit-btn {
      width: 100%;
      font-weight: 500 !important;
      background-color: #2ea44f !important;
    }

    .bg-light {
      background-color: aliceblue !important;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="container ">
      <div class="row justify-content-start">
        <div class="col col-lg-4 ">
        </div>
        <div class="col-12 col-lg-4 my-5 p-4 rounded form-login">
          <br>
          <h4 class=""> Login</span></h4>
          <div>
          <?PHP
          if(isset($_GET['type']) && isset($_GET['message']))
          {
            echo "<div class='alert alert-".$_GET['type']."' role='alert'>".$_GET['message']."</div>";
          }
          
          ?>
            <form method="POST" class="login-form" action="API/login.php">
              <input type="hidden" name="reference" value="<?php echo $Auth_Hash;?>">
              <div class="form-group my-2">
                <label for="username">Email or Username</label>
                <input type="text" required  class="form-control my-2" id="username" name="username" placeholder="">
              </div>
              <div class="form-group my-2">
                <label for="password"> Password</label>
                <input type="password"   class="form-control my-2" id="password" name="password" placeholder="">
              </div>
     
              <button type="submit" class="btn btn-success my-2 login-submit-btn">Login</button>
           <br><br>
           <p>Powered by <a target="_blank" href="https://github.com/kaustubhk24/EasyURLs">EasyURLs</a></p>
            </form>


          </div>
        </div>
      </div>
    </div>








  </div>
  </div>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
</body>

</html>