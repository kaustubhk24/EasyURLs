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

if(isset($_POST['long_url']) && isset($_POST['short_url']) && isset($_POST['reference']))
{ 
     if(password_verify($Auth_Token,$_POST['reference']))
     { 
          $short_url=$_POST['short_url'];
          $long_url=$_POST['long_url'];
            $insert_query = "INSERT INTO urls (LONG_URL,SHORT_URL,COUNT) VALUES ('$long_url','$short_url',0)";
             $insert_query_result = mysqli_query($conn , $insert_query) or die(mysqli_error($conn));
      
      
             $error_1 = $lang["Success! Link saved"];
             header("location:../admin/index.php?type=success&message=".$error_1);
             exit();
      
     }
     else{
          echo $lang["401 UnAuthorized"];
      }
      
    
$conn->close();


}
else
{
   $conn->close();
        $error_1 = $lang["Unable to add url, try again later"];
        header("location:../admin/index.php?type=danger&message=".$error_1);
        exit();
}
?>