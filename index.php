<?PHP

if(isset($_GET['lang']))
{
    require_once ('assets/local/'.$_COOKIE["lang"].'.php');
    header('Location: ' . basename(__FILE__));
    setcookie("lang", $_GET['lang'], time() + (86400 * 30));
}
if(!isset($_COOKIE["lang"])) {
  require_once ('assets/local/en.php');
  } else {
    if(!file_exists('assets/local/'.$_COOKIE["lang"].'.php'))
    {
      require_once ('assets/local/en.php');
    }
    else
    {
      require_once ('assets/local/'.$_COOKIE["lang"].'.php');

    }
  }

if(!file_exists('config.php'))
{
    header('location:install.php');
    exit();
}

if(isset($_GET['id']))
{
    require_once('config.php');
   
    $url = mysqli_real_escape_string($conn , $_GET['id']);

    $sql = "SELECT LONG_URL from urls WHERE SHORT_URL = '$url'";
    $result = mysqli_query($conn , $sql) or die(mysqli_error($conn));


    // calculating no of rows
    $total = mysqli_num_rows($result);

    //if nothing found
    if($total===0){
       echo $lang['Invalid Short URL'];
    }


    else{
        $row = mysqli_fetch_array($result);

        // redirection
        header("location:".$row['LONG_URL']);
        //increment
        updateCount($url,$conn);
        //exit this
               exit();
    }

}
else
{
    echo $lang['Invalid Short URL'];
}



//function to increase count when link opened

function updateCount($url,$conn)
{
    $query="UPDATE urls SET COUNT=(COUNT+1) WHERE SHORT_URL = '$url'";
    $result = mysqli_query($conn , $query) or die(mysqli_error($conn));
    $conn->close();
}

?>