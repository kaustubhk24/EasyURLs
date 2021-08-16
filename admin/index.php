<?PHP
session_start();
if(!isset($_SESSION['username']))
{
    header('location:../login.php');
    exit();
}
$base_url= (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//$base_url=str_replace("admin/index.php","",$base_url);
$base_url=explode('admin/index.php',$base_url)[0];

$index=true;
require_once('../config.php');
// deleting

if(isset($_GET['delete']))
{
  $id = $_GET['delete'];
  $up = "delete from urls WHERE ID=".$id;
  $up = mysqli_query($conn,$up);
  $error_1 = "Success! Link deleted";
  header("location: index.php?type=success&message=".$error_1);
  exit();
}


$sql = "SELECT * from urls";
    $result = mysqli_query($conn , $sql) or die(mysqli_error($conn));

 

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <title>Manage Links</title>
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
    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#links" type="button" role="tab" aria-controls="home" aria-selected="true">All Links</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#new" type="button" role="tab" aria-controls="profile" aria-selected="false">Add New Link</button>
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
      <th scope="col">Short URL</th>
      <th scope="col">Long URL</th>
      <th scope="col">Click Count</th>
      <th scope="col">Delete </th>
    </tr>
  </thead>
  <tbody>
    
    <?PHP
    
    while($row = mysqli_fetch_array($result))
    {
        echo "<tr><th scope='row'>".$row['ID']."</th>";
        echo "<td><a target=_blank href=".$base_url.$row['SHORT_URL'].">".$row['SHORT_URL']."</a></td>";
        echo "<td><a target=_blank href=".$row['LONG_URL'].">".$row['LONG_URL']."</a></td>";
        echo "<td>".$row['COUNT']."</td>";
        echo "<td><a class='btn btn-danger' href=javascript:AlertIt('index.php?delete".$row['ID']."');>Delete</a></td> </tr>";
    }
    
    ?>
     
   
    <tr>
  </tbody>
</table>
  </div>
  <div class="tab-pane fade" id="new" role="tabpanel" aria-labelledby="profile-tab">
    <div class="col-12 col-lg-4 my-1 p-4 rounded form-login">
    <form method="POST"  class="login-form" action="../API/add-new.php">
    <input type="hidden" id="reference" name="reference" value="<?php echo $Auth_Hash;?>">

       <div class="form-group my-2">
         <label for="long_url">Long URL</label>
         <input type="text" onblur="makeid(6);" required  class="form-control my-2" id="long_url" name="long_url" placeholder="">
         <span id="long_url-availability-status"></span> 

        </div>
       <div class="form-group my-2">
         <label for="short_url"> Short URL</label>
         <input type="text" required onBlur="checkAvailability('short_url')"   class="form-control my-2" id="short_url" name="short_url" placeholder="">
         <span id="short_url-availability-status"></span> 

        </div>

       <button disabled type="submit" name="submit" id="submit" class="btn btn-success my-2 login-submit-btn">Add</button>
    <br><br>
     </form>

    </div>
</div>
</div>
    
<?Php require('footer.php');?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
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
function makeid(length) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * 
 charactersLength));
   }
   document.getElementById('short_url').value=result;
   checkAvailability('short_url');
}


var flag_username=false;
    var flag_mobile=false;
    var flag_email=false;

function checkAvailability(dt) 
{
    
    if (dt=='long_url')
    {
        jQuery.ajax({
        url: "../API/availability.php",
        data:{long_url:'$("#long_url").val()',reference:'$(#reference).val()'},
        type: "POST",
        success:function(data){
            if(data=='Available'){
                $("#long_url-availability-status").css("color", "green");
                $("#long_url-availability-status").html("Long URL "+data);
                flag_username=true;
                enable(flag_mobile,flag_email,flag_username);
            }
            else
            {
                $("#user-availability-status").css("color", "red");
                $("#user-availability-status").html("Long URL "+data);
                flag_username=false;
                enable(flag_mobile,flag_email,flag_username);
            }
        
        },
        error:function (){}
        });
    }

        else if(dt=='short_url')
        {
          var short_url=document.getElementById('short_url').value;
      var ref=document.getElementById('reference').value;
        
 

            jQuery.ajax({

  
                url: "../API/availability.php",
                data:{short_url:short_url,reference:ref},  
                type: "POST",
                success:function(data){
                    if(data=='Available'){
                        $("#short_url-availability-status").css("color", "green");
                        $("#short_url-availability-status").html("Short URL  "+data);
                        flag_email=true;
                        enable(flag_email);
                    }
                    else
                    {
                        $("#short_url-availability-status").css("color", "red");
                        $("#short_url-availability-status").html("Short URL "+data);
                        flag_email=false;
                        enable(flag_email);
                    }
                
                },
                error:function (){}
                });
                

        }
        
}
    
function enable(flag_email)
{
    if(flag_email )
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
var answer = confirm ("Are you sure want to delete this link? it will also delete link click counts.")
if (answer)
link=link.replace("delete","delete=");
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