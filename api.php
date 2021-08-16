<?PHP

require('config.php');
if(isset($_GET['TYPE']) && isset($_GET['API_KEY']))
{
    $type=$_GET['TYPE'];
    $key=$_GET['API_KEY'];

    if(valid($key,$conn))
    {
        // Key is Valid start API

        switch($type)
        {
            case 'USERS': users($conn);
            break;
            case 'LINKS':links($conn);
            break;
            default : echo 'Invalid Operation';
            break;
        }

    }
    else
    {
        {
            echo 'Invalid API Key';
        }
    }
}
else
{
    echo 'Invalid Arguments';
}
function valid($key,$conn)
{
    $key = mysqli_real_escape_string($conn , $key);
    $sql = "SELECT * from api WHERE API_KEY = '$key'";
    $result = mysqli_query($conn , $sql) or die("Database Not Reachable");
    $total = mysqli_num_rows($result);
    if($total<1)
    {
        return false;
    }
    else
    {
        return true;
    }
}

function users($conn)
{
    
    $sql = "SELECT USER_ID,USERNAME,EMAIL from users";
    $result = mysqli_query($conn , $sql) or die("Database Not Reachable");
    $users = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $users[] = $row;
    }
    echo json_encode($users);

    $conn->close();
}

function links($conn)
{
    
    $sql = "SELECT * from urls";
    $result = mysqli_query($conn , $sql) or die("Database Not Reachable");
    $users = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $users[] = $row;
    }
    echo json_encode($users);

    $conn->close();
}
?>