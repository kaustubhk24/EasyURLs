<?php 

require_once('../config.php');

if(isset($_POST['Username']))
{   
        $Username=$_POST['Username'];

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
        
      
        mysqli_close($conn);
   
   
}


else if(isset($_POST['Email']))
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
    echo 'Not Available';
}

  
?>