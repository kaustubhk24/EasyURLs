<?php
if(!file_exists('config.php'))
{
    header('location:install.php');
    exit();
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
  <title>Step 2</title>
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
          <h4 class=""> Signup</span></h4>
          <div>
          <?PHP
          if(isset($_GET['type']) && isset($_GET['message']))
          {
            echo "<div class='alert alert-".$_GET['type']."' role='alert'>".$_GET['message']."</div>";
          }
          
          ?>
          <p>Let's setup your account</p>

            <form method="POST" class="login-form" action="API/installation2.php">
              <div class="form-group my-2">
                <label for="username">Username</label>
                <input type="text" required class="form-control my-2" id="username" name="username" aria-describedby="emailHelp" >
              </div>
              <div class="form-group my-2">
                <label for="email">Email</label>
                <input type="email" required  class="form-control my-2" id="email" name="email" placeholder="e.g. you@domain.com">
              </div>
              <div class="form-group my-2">
                <label for="password"> Password</label>
                <input type="password" minlength="8"  class="form-control my-2" id="password" name="password" placeholder="">
              </div>
              <button type="submit" class="btn btn-success my-2 login-submit-btn">Complete Installation</button>
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