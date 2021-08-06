<?PHP

require_once('../config.php');

if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']))
{
$sql="CREATE TABLE IF NOT EXISTS  `users` (
  `USER_ID` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `USERNAME` varchar(50) NOT NULL,
  `EMAIL` varchar(60) NOT NULL,
  `PASSWORD` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";


$sql2="CREATE TABLE  IF NOT EXISTS  `urls` (
    `ID` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `SHORT_URL` varchar(50) NOT NULL,
    `LONG_URL` varchar(150) NOT NULL,
    `COUNT` varchar(5) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
  
$r=mysqli_query($conn,$sql) or die("Fail");
$r2=mysqli_query($conn,$sql2) or die("Fail");
if($r&&$r2)
{
    $hash_password=password_hash($_POST['password'],PASSWORD_DEFAULT);
    $username=$_POST['username'];
    $email=$_POST['email'];
      $insert_query = "INSERT INTO users (USERNAME,EMAIL,PASSWORD) VALUES ('$username','$email' , '$hash_password')";
       $insert_query_result = mysqli_query($conn , $insert_query) or die(mysqli_error($conn));

       echo "Installation has been completed successfully, Taking you to login page, please wait..."; 
       header( "refresh:5;url=../login.php" );

    }
else
{
    echo 'Please delete config.php from root folder and retry installation';
}

$conn->close();


}
else
{
    header('location: ../install2.php');
        exit();
}
?>