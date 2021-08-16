<?PHP
session_start();
if(!isset($_SESSION['username']))
{
    header('location:../login.php');
    exit();
}
$api=true;
require_once('../config.php');

if(isset($_GET['delete']))
{
  $id = $_GET['delete'];
  $up = "delete from api WHERE ID=".$id;
  $up = mysqli_query($conn,$up);
  $error_1 = "Success! API Key Deleted";
  header("location: api.php?type=success&message=".$error_1);
  exit();
}




$sql = "SELECT * from api";
    $result = mysqli_query($conn , $sql) or die(mysqli_error($conn));
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <title>API</title>
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
    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#links" type="button" role="tab" aria-controls="home" aria-selected="true">All Keys</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#new" type="button" role="tab" aria-controls="profile" aria-selected="false">Add New Key</button>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="profile-tab" href="https://www.kaustubh.codes/blog/how-to-use-easyurls/#API" target="_blank">API Guide</a>
  </li>
  <iframe id="txtArea1" style="display:none"></iframe>

</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="links" role="tabpanel" aria-labelledby="home-tab">

  <table id="myTable" class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">KEY NAME</th>
      <th scope="col">API KEY</th>
      <th scope="col">Delete </th>
    </tr>
  </thead>
  <tbody>
    
    <?PHP
    
    while($row = mysqli_fetch_array($result))
    {
        echo "<tr><th scope='row'>".$row['ID']."</th>";
        echo "<td>".$row['KEY_NAME']."</td>";
        echo "<td>".$row['API_KEY']."</td>";
        echo "<td><a class='btn btn-danger' href=javascript:AlertIt('api.php?delete".$row['ID']."');>Delete</a></td> </tr>";
    }
    
    ?>
     
   
    <tr>
  </tbody>
</table>
  </div>
  <div class="tab-pane fade" id="new" role="tabpanel" aria-labelledby="profile-tab">
    <div class="col-12 col-lg-4 my-1 p-4 rounded form-login">
    <form method="POST"  class="login-form" action="../API/add-new-key.php">
    <input type="hidden" id="reference" name="reference" value="<?php echo $Auth_Hash;?>">

       <div class="form-group my-2">
         <label for="KEY_NAME">KEY NAME</label>
         <input type="text" onblur="makeid(30);" required  class="form-control my-2" id="KEY_NAME" name="KEY_NAME" placeholder="">
         <span id="KEY_NAME-availability-status">This is for your reference</span> 

        </div>
       <div class="form-group my-2">
         <label for="API_KEY"> KEY</label>
         <input type="text" readonly required onBlur="checkAvailability('API_KEY')"   class="form-control my-2" id="API_KEY" name="API_KEY" placeholder="">
         <span id="API_KEY-availability-status"></span> 

        </div>

       <button  type="submit" name="submit" id="submit" class="btn btn-success my-2 login-submit-btn">Add New Key</button>
    <br><br>
     </form>

    </div>
</div>
</div>
    

    
<?Php require('footer.php');?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
 <script type="text/javascript">
   function AlertIt(link) {
var answer = confirm ("Are you sure want to delete this API Key? Apps using this key wouldn't work");
if (answer)
link=link.replace("delete","delete=");
window.location=link;
}

function makeid(length) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * 
 charactersLength));
   }
   document.getElementById('API_KEY').value=result;
   checkAvailability('API_KEY');
}
 </script>
  </body>
</html>