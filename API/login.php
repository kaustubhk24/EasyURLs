<?PHP
if(isset($_GET['lang']))
{
    require_once ('../assets/local/'.$_COOKIE["lang"].'.php');
    header('Location: ' . basename(__FILE__));
    setcookie("lang", $_GET['lang'], time() + (86400 * 30));
}
if(!isset($_COOKIE["lang"])) {
     require_once ('../assets/local/en.php');
  } else {
    if(!file_exists('../assets/local/'.$_COOKIE["lang"].'.php'))
    {
      require_once ('../assets/local/en.php');
    }
    else
    {
      require_once ('../assets/local/'.$_COOKIE["lang"].'.php');

    }
  }

require_once('../config.php');

if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['reference']))
{
  if(password_verify($Auth_Token,$_POST['reference']))
  {
    $username = mysqli_real_escape_string($conn , $_POST['username']);
    $password = mysqli_real_escape_string($conn , $_POST['password']);

    $sql = "SELECT * from users WHERE 	USERNAME = '$username' OR EMAIL='$username'";
    $result = mysqli_query($conn , $sql) or die(mysqli_error($conn));


    // calculating no of rows
    $total = mysqli_num_rows($result);

    //if no email found
    if($total===0){
      $error_1 = $lang["Invalid Login, Try again"];
      header("location:../login.php?type=danger&message=".$error_1);
       exit();
    }


    else
    {
      $row = mysqli_fetch_array($result);
      //if email exists in db then verifying the password
      if(password_verify($password,$row['PASSWORD']))
      {
        $conn->close();
        session_start();
        $_SESSION['username']=$username;
        header("location:../admin/index.php");
        exit();


      }
      else
      {
        $conn->close();
        $error_1 = $lang["Invalid Login, Try again"];
        header("location:../login.php?type=danger&message=".$error_1);
        exit();
      }
    }

  }
  else
  {
    echo $lang["401 UnAuthorized"];
  }
    
}
else{
  $conn->close();
}


?>