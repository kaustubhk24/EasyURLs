<?php 

require_once('../config.php');


if(isset($_POST['Username']) && isset($_POST['reference']) )
{   
        $Username=$_POST['Username'];
    if(password_verify($Auth_Token,$_POST['reference']))
    {
        $query = mysqli_query($conn,"SELECT * FROM users WHERE USERNAME =   '$Username' ");

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
      
    else
    {
        echo '401 UnAuthorized';
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
            echo 'Available';
        }
        else
        {
            echo 'Already registered';
        }
        
      
        mysqli_close($conn);
    
    }
    else{
        echo '401 UnAuthorized';
    }
    
}



else{
    echo '401 UnAuthorized';
}

  
?>