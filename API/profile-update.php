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
session_start();

$user_id=$_SESSION['USER_ID'];

if(isset($_POST['Email']) && isset($_POST['Username']) && isset($_POST['password']) && isset($_POST['confirm_password']) )
{
    $user=$_POST['Username'];
    $email=$_POST['Email'];
    $pass=$_POST['password'];
    if(!$_POST['password']==$_POST['confirm_password'])
    {
        $conn->close();
        $error_1 = $lang["Passwords do not match"];
        header("location:../admin/profile.php?type=danger&message=".$error_1);
        exit();
    }
    if(password_verify($Auth_Token,$_POST['reference']))
    {
        if($_POST['password']=="" || $_POST['confirm_password']=="")
    {
        $insert_query = "UPDATE users set USERNAME='$user',EMAIL='$email' WHERE USER_ID='$user_id'";
        $insert_query_result = mysqli_query($conn , $insert_query) or die(mysqli_error($conn));
        $error_1 = $lang["Success! User updated"];
        $_SESSION['username']=$user;
        header("location:../admin/profile.php?type=success&message=".$error_1);
        exit();

    }
else{
        $hash_password=password_hash($_POST['password'],PASSWORD_DEFAULT);
         $username=$_POST['Username'];
        $email=$_POST['Email'];

        $insert_query = "UPDATE users set USERNAME='$username',EMAIL='$email',PASSWORD='$hash_password' WHERE USER_ID='$user_id'";
         $insert_query_result = mysqli_query($conn , $insert_query) or die(mysqli_error($conn));
  
         $_SESSION['username']=$user;
         $error_1 = $lang["Success! User updated"];
         header("location:../admin/profile.php?type=success&message=".$error_1);
         exit();
    }}

    
    else{
        echo $lang["401 UnAuthorized"];
  }

}
else
{
    $conn->close();
    $error_1 = $lang["Unable to update profile, try again"];
    header("location:../admin/profile.php?type=danger&message=".$error_1);
    exit();
}
?>