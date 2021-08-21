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

if(isset($_POST['long_url']) && isset($_POST['reference']))
{   
    if(password_verify($Auth_Token,$_POST['reference']))
    {
        $long_url=$_POST['long_url'];

        $query = mysqli_query($conn,"SELECT * FROM urls WHERE LONG_URL =   '$long_url' ");

        $find = mysqli_num_rows($query);
      
        if($find==0)
        {
            echo $lang["Available"];
        }
        else
        {
            echo $lang["Not Available"];
        }
        
    }
    else{
        echo $lang["401 UnAuthorized"];
    }
        
      
        mysqli_close($conn);
   
   
}


else if(isset($_POST['short_url']) && isset($_POST['reference']))
{   
    if(password_verify($Auth_Token,$_POST['reference']))
    {
        $SHORT_URL=$_POST['short_url'];

        $query = mysqli_query($conn,"SELECT * FROM urls WHERE SHORT_URL =   '$SHORT_URL' ");

        $find = mysqli_num_rows($query);
      
        if($find==0)
        {
            echo $lang["Available"];
        }
        else
        {
            echo $lang["Already Registered"];
        }
        
    }
    else{
        echo $lang["401 UnAuthorized"];
    } 
      
        mysqli_close($conn);
    
   
   
}



else{
    echo $lang["401 UnAuthorized"];
}

  
?>