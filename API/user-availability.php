<?php 

require_once('../config.php');
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


if(isset($_POST['Username']) && isset($_POST['reference']) )
{   
        $Username=$_POST['Username'];
    if(password_verify($Auth_Token,$_POST['reference']))
    {
        $query = mysqli_query($conn,"SELECT * FROM users WHERE USERNAME =   '$Username' ");

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
      
    else
    {
        echo $lang["401 UnAuthorized"];
    }
        
      
        mysqli_close($conn);
   
   
}


else if(isset($_POST['Email'] ) && isset($_POST['reference']) )
{   if(password_verify($Auth_Token,$_POST['reference']))
    {
    
        $Email=$_POST['Email'];

        $query = mysqli_query($conn,"SELECT * FROM users WHERE EMAIL =   '$Email' ");

        $find = mysqli_num_rows($query);
      
        if($find==0)
        {
            echo $lang["Available"];
        }
        else
        {
            echo $lang["Already Registered"];
        }
        
      
        mysqli_close($conn);
    
    }
    else{
        echo $lang["401 UnAuthorized"];
    }
    
}



else{
    echo $lang["401 UnAuthorized"];
}

  
?>