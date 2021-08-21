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
session_start();
if(!isset($_SESSION['username']))
{
    header('location:../login.php');
    exit();
}
require_once('../config.php');
$username=$_SESSION['username'];
$profile=true;
$sql = "SELECT * from users WHERE USERNAME='$username' OR EMAIL='$username'";
    $result = mysqli_query($conn , $sql) or die(mysqli_error($conn));
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <title><?php echo $lang["Manage Profile"];?></title>
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
          $row = mysqli_fetch_array($result); 
          $_SESSION['USER_ID']=$row['USER_ID'];
?>
   
  
   <div class="col-12 col-lg-4 my-1 p-4 rounded form-login">
   <h4><?php echo $lang["Your Profile"];?></h4>
   <p><?php echo $lang["Change fields you want to edit and click on update."];?></p>
    <form method="POST"  class="login-form" action="../API/profile-update.php">
    <input type="hidden" id="reference" name="reference" value="<?php echo $Auth_Hash;?>">

    <div class="form-group my-2">
         <label for="Email"><?php echo $lang["Email"];?></label>
         <input type="text" readonly  required onBlur="checkAvailability('Email')" class="form-control my-2" id="Email" name="Email" value="<?php echo $row['EMAIL'];?>" placeholder="">
         <p style="color:blue;" onclick="enableBtn('Email',this);"><?php echo $lang["Edit"]; ?></p>
         <span id="Email-availability-status"></span> 

        </div>
       <div class="form-group my-2">
         <label for="Username"><?php echo $lang["Username"];?> </label>
         <input type="text" readonly required onBlur="checkAvailability('Username')"   class="form-control my-2" id="Username"  value="<?php echo $row['USERNAME'];?>" name="Username" placeholder="">
         <p class="text-xs-right" onclick="enableBtn('Username',this);" style="color:blue;"><?php echo $lang["Edit"]; ?></p>
         <span id="Username-availability-status"></span> 

        </div>
        <div class="form-group my-2">
         <label for="password"><?php echo $lang["New Password"];?> </label>
         <input type="password" minlength="8" onkeyup="validatePassword();"   class="form-control my-2" id="password" name="password" placeholder="">

        </div>
        <div class="form-group my-2">
         <label for="confirm_password"><?php echo $lang["Confirm Password"];?> </label>
         <input type="password" onkeyup="validatePassword();" class="form-control my-2" id="confirm_password" name="confirm_password" placeholder="">
         <span id="password-confirmation"></span> 

        </div>
       <button  type="submit" name="submit" id="submit" class="btn btn-success my-2 login-submit-btn"><?php echo $lang["Update Profile"];?></button>
    <br><br>
     </form>

    </div>
</div>


<?Php require('footer.php');?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

 
    <script type="text/javascript">
function enableBtn(ele,acceptor)
{
  if(acceptor.innerHTML=="<?php echo $lang["Edit"]; ?>")
{  var element=document.getElementById(ele);
  element.readOnly=false;
  acceptor.innerHTML="<?php echo $lang["Close"]; ?>";
}
else if(acceptor.innerHTML=="<?php echo $lang["Close"]; ?>")
{
  var element=document.getElementById(ele);
  element.readOnly=true;
  acceptor.innerHTML="<?php echo $lang["Edit"]; ?>";
}
}

function validatePassword()
{
  var response=document.getElementById('password-confirmation');
  var new_pass=document.getElementById('password');
  var conf_password=document.getElementById('confirm_password');
  if(new_pass.value== "" || conf_password.value=="")
  {
    response.innerHTML="<?php echo $lang["New and confirm password are not matching"];?>";
    response.style.color="Red";
  }
  else if(new_pass.value===conf_password.value)
  {
    response.innerHTML="<?php echo $lang["Passwords matched"];?>";
    response.style.color="Green";
  }
  else
  {response.innerHTML="<?php echo $lang["New and confirm password are not matching"];?>";
    response.style.color="Red";
    
  }
}

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
    if(flag_email || flag_username)
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
var answer = confirm ("<?php echo $lang["Are you sure want to delete this User?"];?>")
if (answer)
link=link.replace("delete","delete=");

window.location=link;
}
function AlertItReset(link) {
var answer = confirm ("<?php echo $lang["Are you sure want to reset this User?"];?>")
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