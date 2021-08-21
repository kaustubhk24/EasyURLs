<?php
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
    if(isset($_POST['TYPE']))
    {
        echo $_GET['TYPE'];
        echo $_POST['API_KEY'];
    }



    // if(isset($_POST['API_KEY']))
    // {
    //     echo $_POST['API_KEY'];
    //     if(validAPIKey($_POST['API_KEY'],$conn))
    //     {

    //     }
    //     else
    //     {
    //         echo 'Invalid API Key';
    //     }

    // }
    // {
    //     echo 'Invalid API Key';
    // }

    function validAPIKey($key,$conn)
    {
        $sql = "SELECT * from api WHERE API_KEY='$key'";
        $result = mysqli_query($conn , $sql) or die(mysqli_error($conn));
        $total = mysqli_num_rows($result);
        if($total===0)
        {
            return false;
          }
          else
          {
              return true;
          }
    }
?>