<?PHP
error_reporting(0);
if(!file_exists('../config.php'))
{
    if(isset($_POST['host']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['dbName']))
    {
        $conn= mysqli_connect($_POST['host'],$_POST['username'],$_POST['password'],$_POST['dbName']);
        // Check connection
        if (!$conn) 
        {
            $m="Invalid Database details, Please check if username and password is correct and it has access to database";
            header('location:../install.php?type=danger&message='.$m);
            exit();
          
        }
        else
        {
        $text=file_get_contents("../config-sample.txt");
        $text= str_replace("root",$_POST['username'],$text);
        $text=str_replace("localhost",$_POST['host'],$text);
        $text=str_replace("db_password",$_POST['password'],$text);
        $text= str_replace("db_name",$_POST['dbName'],$text);
        $file = fopen("../config.php","w"); 
        fwrite($file,$text);
        fclose($file);
        header('location:../install2.php');
        exit();
        }
    }
    else
    {
        echo 'Invalid Arguments';
    }
}
else
{
    echo 'Installation already completed';
}


?>