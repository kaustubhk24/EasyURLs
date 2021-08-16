<?PHP

require_once('../config.php');

if(isset($_POST['Username']) && isset($_POST['Email']) && isset($_POST['password'])  && isset($_POST['reference']))
{ 
  if(password_verify($Auth_Token,$_POST['reference']))
    {
      $hash_password=password_hash($_POST['password'],PASSWORD_DEFAULT);
      $username=$_POST['Username'];
      $email=$_POST['Email'];
        $insert_query = "INSERT INTO users (USERNAME,EMAIL,PASSWORD) VALUES ('$username','$email' , '$hash_password')";
         $insert_query_result = mysqli_query($conn , $insert_query) or die(mysqli_error($conn));
  
  
         $error_1 = "Success! User added";
         header("location:../admin/users.php?type=success&message=".$error_1);
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
        $error_1 = "Unable to add user, try again later";
        header("location:../admin/users.php?type=danger&message=".$error_1);
        exit();
}
?>