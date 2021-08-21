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

error_reporting(0);
if(!file_exists('../config.php'))
{
    if(isset($_POST['host']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['dbName']))
    {
        $conn= mysqli_connect($_POST['host'],$_POST['username'],$_POST['password'],$_POST['dbName']);
        // Check connection
        if (!$conn) 
        {
            $m=$lang["Invalid Database details, Please check if username and password is correct and it has access to database"];
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
        $text= str_replace("sample_token",randomPassword(),$text);

        $file = fopen("../config.php","w"); 
        fwrite($file,$text);
        fclose($file);
        header('location:../install2.php');
        exit();
        }
    }
    else
    {
        echo $lang["Invalid Arguments"];
    }
}
else
{
    echo $lang["Installation already completed"];
}
function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890-+@!';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 50; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

?>