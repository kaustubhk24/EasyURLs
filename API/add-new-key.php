<?PHP

require_once('../config.php');

if(isset($_POST['KEY_NAME']) && isset($_POST['API_KEY']) && isset($_POST['reference']))
{ 
     if(password_verify($Auth_Token,$_POST['reference']))
     { 
          $API_KEY=$_POST['API_KEY'];
          $KEY_NAME=$_POST['KEY_NAME'];
            $insert_query = "INSERT INTO api (KEY_NAME,API_KEY) VALUES ('$KEY_NAME','$API_KEY')";
             $insert_query_result = mysqli_query($conn , $insert_query) or die(mysqli_error($conn));
      
      
             $error_1 = "Success! API Key saved";
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
        $error_1 = "Unable to add key, try again later";
        header("location:../admin/api.php?type=danger&message=".$error_1);
        exit();
}
?>