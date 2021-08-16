<?php 

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
            echo 'Available';
        }
        else
        {
            echo 'Not Available';
        }
        
    }
    else{
        echo '401 UnAuthorized';
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
            echo 'Available';
        }
        else
        {
            echo 'Already registered';
        }
        
    }
    else{
        echo '401 UnAuthorized';
    } 
      
        mysqli_close($conn);
    
   
   
}



else{
    echo '401 UnAuthorized';
}

  
?>