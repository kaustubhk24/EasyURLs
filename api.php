<?PHP

require('config.php');
if(isset($_GET['TYPE']) && isset($_GET['API_KEY']) && isset($_GET['USER_ID']) )
{
    $type=$_GET['TYPE'];
    $key=$_GET['API_KEY'];
    $user_id=$_GET['USER_ID'];

    if(valid($key,$conn))
    {
        switch($type)
        {
            case 'DELETE': DELETE($conn,$user_id);
            break;
            case 'VIEW':VIEW($conn,$user_id);
            break;
            default : echo 'Invalid Operation';
            break;
        }
    }
    else
    {
        echo 'Invalid API Key';  
    }
}
else if((isset($_GET['TYPE']) && isset($_GET['API_KEY']) && isset($_GET['LONG_URL']) && isset($_GET['SHORT_URL']) ))
{ 
    $type=$_GET['TYPE'];
    $key=$_GET['API_KEY'];

    if(valid($key,$conn))
    {
        if($type=='ADD')
        {
            $short_url=$_GET['SHORT_URL'];
            $long_url=$_GET['LONG_URL'];
          $insert_query = "INSERT INTO urls (LONG_URL,SHORT_URL,COUNT) VALUES ('$long_url','$short_url',0)";
           $insert_query_result = mysqli_query($conn , $insert_query) or die(mysqli_error($conn));
           echo "URL added";
            $sql = "SELECT * from urls WHERE SHORT_URL='$short_url'";
            $result = mysqli_query($conn , $sql) or die("Database Not Reachable");
            $users = array();
            while($row =mysqli_fetch_assoc($result))
            {
                $users[] = $row;
            }
            echo json_encode($users);
        
            
        }
        else
        {
            echo 'Invalid Operation';
        }
    }
    else
    {
        echo 'Invalid API Key';
    }
}
else if((isset($_GET['TYPE']) && isset($_GET['API_KEY']) && isset($_GET['LONG_URL']) ))
{
    $type=$_GET['TYPE'];
    $key=$_GET['API_KEY'];

    if(valid($key,$conn))
    {
        if($type=='ADD')
        {
            $short_url=generateShort(5);
            $long_url=$_GET['LONG_URL'];
            $insert_query = "INSERT INTO urls (LONG_URL,SHORT_URL,COUNT) VALUES ('$long_url','$short_url',0)";
            $insert_query_result = mysqli_query($conn , $insert_query) or die(mysqli_error($conn));
            echo "URL added";
            $sql = "SELECT * from urls WHERE SHORT_URL='$short_url'";
            $result = mysqli_query($conn , $sql) or die("Database Not Reachable");
            $users = array();
            while($row =mysqli_fetch_assoc($result))
            {
                $users[] = $row;
            }
            echo json_encode($users);
        
            
            
        }
        else
        {
            echo 'Invalid Operation';
        }
    }
    else
    {
        echo 'Invalid API Key';
    }
}
else if((isset($_GET['TYPE']) && isset($_GET['API_KEY']) && isset($_GET['EMAIL']) && isset($_GET['USERNAME']) && isset($_GET['PASSWORD']) ))
{
    $type=$_GET['TYPE'];
    $key=$_GET['API_KEY'];
    $email=$_GET['EMAIL'];
    $username=$_GET['USERNAME'];
    $hash_password=password_hash($_GET['PASSWORD'],PASSWORD_DEFAULT);

    if(valid($key,$conn))
    {
        if($type=='ADD')
        {
            $insert_query = "INSERT INTO users (USERNAME,EMAIL,PASSWORD) VALUES ('$username','$email' , '$hash_password')";
            $insert_query_result = mysqli_query($conn , $insert_query) or die(mysqli_error($conn));
            echo "User added";
            $sql = "SELECT USER_ID,USERNAME,EMAIL from users WHERE USERNAME='$username'";
            $result = mysqli_query($conn , $sql) or die("Database Not Reachable");
            $users = array();
            while($row =mysqli_fetch_assoc($result))
            {
                $users[] = $row;
            }
            echo json_encode($users);
        
            
            
        }
        else
        {
            echo 'Invalid Operation';
        }
    }
    else
    {
        echo 'Invalid API Key';
    }
}

else if(isset($_GET['TYPE']) && isset($_GET['API_KEY']) && isset($_GET['LINK_ID']) )
{
    $type=$_GET['TYPE'];
    $key=$_GET['API_KEY'];
    $link=$_GET['LINK_ID'];

    if(valid($key,$conn))
    {
        switch($type)
        {
            case 'DELETE': DELETE_LINK($conn,$link);
            break;
            case 'VIEW':VIEW_LINK($conn,$link);
            break;
            default : echo 'Invalid Operation';
            break;
        }
    }
    else
    {
        echo 'Invalid API Key';  
    }
}
//done
else  if(isset($_GET['TYPE']) && isset($_GET['API_KEY']))
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
            echo 'Invalid API Key';  
    }
}
else
{
    echo 'Invalid Arguments';
}


$conn->close();
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
function DELETE($conn,$user_id)
{
    $up = "delete from users WHERE USER_ID=".$user_id;
    $up = mysqli_query($conn,$up);
    echo "Deleted";
}
function DELETE_LINK($conn,$link)
{
    $up = "delete from urls WHERE ID=".$link;
    $up = mysqli_query($conn,$up);
    echo "Deleted";
}
function VIEW($conn,$user_id)
{
    $sql = "SELECT USER_ID,USERNAME,EMAIL from users WHERE USER_ID='$user_id'";
    $result = mysqli_query($conn , $sql) or die("Database Not Reachable");
    $users = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $users[] = $row;
    }
    echo json_encode($users);

    
}
function VIEW_LINK($conn,$link)
{
    $sql = "SELECT * from urls WHERE ID='$link'";
    $result = mysqli_query($conn , $sql) or die("Database Not Reachable");
    $users = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $users[] = $row;
    }
    echo json_encode($users);

    
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

    
}
function generateShort($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>