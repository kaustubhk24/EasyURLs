<?PHP
session_start();
if(!isset($_SESSION['username']))
{
    header('location:../login.php');
    exit();
}
$users=true;


require_once('../config.php');


if(isset($_GET['delete']))
{
  $id = $_GET['delete'];
  $up = "delete from users WHERE USER_ID=".$id;
  $up = mysqli_query($conn,$up);
  $error_1 = "Success! user deleted";
  header("location: users.php?type=success&message=".$error_1);
  exit();
}
if(isset($_GET['reset']))
{
  $id = $_GET['reset'];
  $new_pass=randomPassword();
  $hash_password=password_hash($new_pass,PASSWORD_DEFAULT);
  $up = "update users set PASSWORD='$hash_password' WHERE USER_ID=$id";
  echo $up;
  $up = mysqli_query($conn,$up);

  $error_1 = "Success! New password is '".$new_pass."'";
  header("location: users.php?type=success&message=".$error_1);
  exit();
}

$sql = "SELECT * from users";
    $result = mysqli_query($conn , $sql) or die(mysqli_error($conn));


    function randomPassword() {
      $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
      $pass = array(); //remember to declare $pass as an array
      $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
      for ($i = 0; $i < 8; $i++) {
          $n = rand(0, $alphaLength);
          $pass[] = $alphabet[$n];
      }
      return implode($pass); //turn the array into a string
  }

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <title>Manage Users</title>
    <style>
      <?PHP include('style.css'); ?>
    </style>
  </head>
  <body>
<?Php require('navbar.php');?>
<?PHP
          if(isset($_GET['type']) && isset($_GET['message']))
          {
            echo "<div class='alert alert-".$_GET['type']."' role='alert'>".$_GET['message']."</div>";
          }
          
          ?>
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#links" type="button" role="tab" aria-controls="home" aria-selected="true">All Users</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#new" type="button" role="tab" aria-controls="profile" aria-selected="false">Add New User</button>
  </li>
  <iframe id="txtArea1" style="display:none"></iframe>

</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="links" role="tabpanel" aria-labelledby="home-tab">
<center>  <input class="mt-2 mb-2" type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names..">
<button type="button" id="btnExport" onclick="fnExcelReport();" class="btn btn-success">Download Excel</button>
</center>
  <table id="myTable" class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Username</th>
      <th scope="col">Email</th>
      <th scope="col"> Password</th>
      <th scope="col">Delete </th>
    </tr>
  </thead>
  <tbody>
    
    <?PHP
    
    while($row = mysqli_fetch_array($result))
    {
        echo "<tr><th scope='row'>".$row['USER_ID']."</th>";
        echo "<td>".$row['USERNAME']."</td>";
        echo "<td><a target=_blank href=mailto:".$row['EMAIL'].">".$row['EMAIL']."</a></td>";
        echo "<td><a class='btn btn-warning' href=javascript:AlertItReset('users.php?reset".$row['USER_ID']."');>Reset</a></td> ";
        echo "<td><a class='btn btn-danger' href=javascript:AlertIt('users.php?delete".$row['USER_ID']."');>Delete</a></td> </tr>";
    }
    
    
    ?>
     
   
    <tr>
  </tbody>
</table>
  </div>
  <div class="tab-pane fade" id="new" role="tabpanel" aria-labelledby="profile-tab">
    <div class="col-12 col-lg-4 my-1 p-4 rounded form-login">
    <form method="POST"  class="login-form" action="../API/add-new-user.php">
    <input type="hidden" id="reference" name="reference" value="<?php echo $Auth_Hash;?>">

       <div class="form-group my-2">
         <label for="Email">Email</label>
         <input type="text"  required onBlur="checkAvailability('Email')" class="form-control my-2" id="Email" name="Email" placeholder="">
         <span id="Email-availability-status"></span> 

        </div>
       <div class="form-group my-2">
         <label for="Username"> Username</label>
         <input type="text" required onBlur="checkAvailability('Username')"   class="form-control my-2" id="Username" name="Username" placeholder="">
         <span id="Username-availability-status"></span> 

        </div>
        <div class="form-group my-2">
         <label for="password"> Password</label>
         <input type="password" required   class="form-control my-2" id="password" name="password" placeholder="">
         <span id="password-availability-status"></span> 

        </div>

       <button disabled type="submit" name="submit" id="submit" class="btn btn-success my-2 login-submit-btn">Add</button>
    <br><br>
     </form>

    </div>
</div>
</div>
    
    
<?Php require('footer.php');?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
 <script type="text/javascript">
function myFunction() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}



var flag_username=false;
    var flag_mobile=false;
    var flag_email=false;

function checkAvailability(dt) 
{
    
    if (dt=='Email')
    {
      var email=document.getElementById('Email').value;
      var ref=document.getElementById('reference').value;
        jQuery.ajax({
        url: "../API/user-availability.php",
        data:{Email:email,reference:ref},
        type: "POST",
 

        success:function(data){
            if(data=='Available'){
                $("#Email-availability-status").css("color", "green");
                $("#Email-availability-status").html("Email "+data);
                flag_email=true;
                enable(flag_email,flag_username);
            }
            else
            {
                $("#Email-availability-status").css("color", "red");
                $("#Email-availability-status").html("Email "+data);
                flag_email=false;
                enable(flag_email,flag_username);
            }
        
        },
        error:function (){}
        });
    }

        else if(dt=='Username')
        {
          var username=document.getElementById('Username').value;
          var ref=document.getElementById('reference').value;
            jQuery.ajax({
                url: "../API/user-availability.php",
                data:{Username:username,reference:ref},
                type: "POST",


                success:function(data){
                    if(data=='Available'){
                        $("#Username-availability-status").css("color", "green");
                        $("#Username-availability-status").html("username  "+data);
                        flag_username=true;
                        enable(flag_email,flag_username);
                    }
                    else
                    {
                        $("#Username-availability-status").css("color", "red");
                        $("#Username-availability-status").html("username "+data);
                        flag_email=false;
                        enable(flag_email,flag_username);
                    }
                
                },
                error:function (){}
                });
                

        }
        
}
    
function enable(flag_email,flag_username)
{
    if(flag_email && flag_username)
    {
        $('#submit').prop('disabled', false);
        $("#alert").css("display", "none");
    }
    else
    {
        $('#submit').prop('disabled', true);
        $("#alert").css("display", "block");
    }
    
}

function AlertIt(link) {
var answer = confirm ("Are you sure want to delete this User? ")
if (answer)
link=link.replace("delete","delete=");

window.location=link;
}
function AlertItReset(link) {
var answer = confirm ("Are you sure want to reset this User? ")
if (answer)
link=link.replace("reset","reset=");

window.location=link;
}
function fnExcelReport()
{
    var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
    var textRange; var j=0;
    tab = document.getElementById('myTable'); // id of table

    for(j = 0 ; j < tab.rows.length ; j++) 
    {     
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
    }

    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE "); 

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus(); 
        sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
    }  
    else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

    return (sa);
}



</script>
 
  </body>
</html>