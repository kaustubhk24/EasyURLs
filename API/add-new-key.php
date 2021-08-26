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
if(isset($_GET['lang']))
{
    //require_once ('assets/local/'.$_COOKIE["lang"].'.php');
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

if(isset($_POST['KEY_NAME']) && isset($_POST['API_KEY']) && isset($_POST['reference']))
{ 
     if(password_verify($Auth_Token,$_POST['reference']))
     { 
          $API_KEY=$_POST['API_KEY'];
          $KEY_NAME=$_POST['KEY_NAME'];
            $insert_query = "INSERT INTO api (KEY_NAME,API_KEY) VALUES ('$KEY_NAME','$API_KEY')";
             $insert_query_result = mysqli_query($conn , $insert_query) or die(mysqli_error($conn));
      
      
             $error_1 = $lang["Success! API Key saved"];
             header("location:../admin/api.php?type=success&message=".$error_1);
             exit();
      
     }
     else{
          echo '401 UnAuthorized';
      }
      
    
$conn->close();


}
else
{
   $conn->close();
        $error_1 = $lang["Unable to add key, try again later"];
        header("location:../admin/api.php?type=danger&message=".$error_1);
        exit();
}
?>