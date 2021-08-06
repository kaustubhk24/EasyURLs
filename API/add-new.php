<?PHP

require_once('../config.php');

if(isset($_POST['long_url']) && isset($_POST['short_url']))
{ 
 
     $short_url=$_POST['short_url'];
    $long_url=$_POST['long_url'];
      $insert_query = "INSERT INTO urls (LONG_URL,SHORT_URL,COUNT) VALUES ('$long_url','$short_url',0)";
       $insert_query_result = mysqli_query($conn , $insert_query) or die(mysqli_error($conn));


       $error_1 = "Success! Link saved";
       header("location:../admin/index.php?type=success&message=".$error_1);
       exit();

$conn->close();


}
else
{
   $conn->close();
        $error_1 = "Unable to add url, try again later";
        header("location:../admin/index.php?type=danger&message=".$error_1);
        exit();
}
?>