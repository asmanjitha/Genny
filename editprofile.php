<?php
session_start();
include('dbconnection.php'); //$conn
include('User.php');
include('basicTemp.php');

if(!isset($_SESSION['logged']) || !isset($_SESSION['user'])){
  header('location:login.php');
}
$pages = $_SESSION['pages'];
$user = unserialize($_SESSION['user']);


$pages = $_SESSION['pages'];
$user = unserialize($_SESSION['user']);
$user_name = $user-> getUname();
$previous_u_name;
$user_id;
$bool = false;
$query = "select password,u_id from genny.users where u_name = '$user_name'";
$ins = mysqli_query($conn,$query);
if ($is_run = mysqli_query($conn,$query)){
  $is_run = mysqli_fetch_array($is_run,MYSQLI_ASSOC);
  $previous_u_name = $user_name;
  $previous_pass = $is_run['password'];
  //echo $previous_pass;
  $user_id = $is_run['u_id'];
}

function is_empty(...$paras){
  foreach ($paras as $para){
    if (($para == null) || ($para=='')){
      return true;
    }
  }
  return false;
}
$error = false;

$nameErr = $passwordErr = $cpasswordErr= $cnpasswordErr = '';
$password = $previous_pass;
$cpassword = $password;
$cnpassword = $password;



  if (isset($_REQUEST["submitb"]) ){

      $changed = false;
      $u_name = $user_name;

   if ((isset($_REQUEST["cpassword"])) && (!is_empty($_REQUEST["cpassword"]) || !is_empty($_REQUEST["cpassword"]) )){
    $cpassword = $_REQUEST["cpassword"];
    $cnpassword = $_REQUEST["cnpassword"];
    $changed = true;
  }
  //      echo '<script type="text/javascript">alert();</script>';

        if(isset($_REQUEST["cpassword"]) && strlen($_REQUEST["cpassword"])<4 ){
          $error = true;
          $cpasswordErr = "* Atleast 4 characters!";
        
        if (is_empty($_REQUEST["cpassword"]) && isset($_REQUEST["cnpassword"])){
          $error = true;
          $cpasswordErr = "* Please enter new password";
        }elseif( $_REQUEST["cpassword"] != $_REQUEST["cnpassword"]){
          $error = true;
          $cnpasswordErr = "* password miss match!";
          $cpasswordErr = "*password miss match";
        }
        if (is_empty($_REQUEST["cnpassword"]) && isset($_REQUEST["cpassword"])){
          $error = true;
          $cnpasswordErr = "* Please confirm new password";
        }}
    //  }
      
      if (is_empty($user_name)){
        $error = true;
        $user_nameErr = "* Required";
      }elseif($user_name != $previous_u_name){
        $changed = true;
      }
      
      
      if (!$error){
        
          $sql = "UPDATE genny.users
            SET u_name='$u_name',password = '$cnpassword'
            WHERE u_id='$user_id'";
        
  
        $ins = mysqli_query($conn,$sql);

        if ($ins){
          $user ->setUName($user_name);
          if($changed){
            $_SESSION['userEdited'] = true;
          }
          $_SESSION['user'] = serialize($user);
          
          //header('location:editprofile.php');
          //header("Refresh:0");
          if($changed){
          echo '<script type="text/javascript">',
     'swal("Changes Saved!","" ,"success");',
     '</script>';
          echo '<script type="text/javascript">','setTimeout("refreshFun()",1500);','</script>';
          }
          
        }else{
          echo "sql wrong</br>".mysqli_error($conn)."</br>";
        }
      }
    }
 


?>


<html>
<head>
<link rel="stylesheet" type="text/css" href="assests/library/sweetalert-master/dist/sweetalert.css">
</head>
<body>
<div class='container-fluid'>
  <div class='row'>
    <div class='col-md-2 col-md-2-height1' id="sideB">
    <div class = "row">
      <ul class="nav nav-pills nav-stacked">
      <input type="hidden" value="<?php echo sizeof($pages);?>" id="nop">
      <?php
      foreach( $pages as $tempPag ) {?>
        <li><a style="color : black; font-family:Verdana,sans-serif;font-size:15px;line-height:1.5" href="<?php echo $tempPag[1]; ?>"><?php echo $tempPag[0]; ?></a></li>
      <?php      
      }; 
?>
    </ul>
    </div>
    </div>
    <div class='col-md-10' id="mb">
    <div class="row">
    <!-- Put Anything-->
 <h1 class="well">Edit Profile</h1>
    <div class="col-lg-12 well">
  <div class="row">
        <form method ='POST' action="editprofile.php">
          <div class="col-sm-12">
            <div class="row">
              <div class="col-sm-6 form-group">
                <label>user Name<span style = "color:red"><?php echo "*";?></label>
                <input disabled = "true" name= "user_name" type="text" value="<?php echo htmlspecialchars($previous_u_name);?>" class="form-control">
                <label><span style = "color:red"><?php echo $nameErr;?></span></label>
              </div>
              
            </div>
           
          <button class="btn btn-info" name = "change_pass" type="button"  onclick= 'mewFD("<?php echo $previous_pass; ?>");'> Change Password</button>

         
          <div>
          <label></label>
          <label></label>
          <label></label>
          </div>
          

          <div class="form-group">
            <label>New Password<span style = "color:red"><?php echo "*";?></label>
            <input id = "p2" name="cpassword" type="password"  placeholder="Enter New Password here..." class="form-control"  disabled="true">
            <label><span style = "color:red"><?php echo $cpasswordErr;?></span></label>
          </div>
           <div class="form-group">
            <label>Confirm New Password<span style = "color:red"><?php echo "*";?></label>
            <input id = "p3" name= "cnpassword" type="password"   placeholder="Re-enter New Password here..." class="form-control" disabled="true">
            <label><span style = "color:red"><?php echo $cnpasswordErr;?></span></label>
          </div>
          
          <div class="row">
          <div class="col-md-10">
          <button  type="Submit" class="btn btn-lg btn-info" name="submitb"  >Submit</button>
          </div>
          <div class="col-md-2">
          </div>
          </div>       
          </div>

        </form> 
        </div>
  </div>      
    
    
    <!-- Put Anything-->
    </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function mewFD(pword){
    swal({
  title: "Please Enter The Password",
  text: "",
  type: "input",
  showCancelButton: true,
  closeOnConfirm: false,
  animation: "slide-from-top",
  inputPlaceholder: "Enter Password Here"
},
function(inputValue){
  if (inputValue === false) return false;
  
  if (inputValue != pword) {
    swal.showInputError("Please Enter Correct Password");
    return false
  }else{
    document.getElementById("p3").disabled = false ;
    document.getElementById("p2").disabled = false ;
    var setpass = true;
  }
  
  swal("Password Confirmed!", " " , "success");
});
  }

function refreshFun(){
  //alert();
  window.location.href = "editprofile.php";
}
</script>
</body>
</html>

<!--document.getElementById("p3").disabled = false ;
document.getElementById("p2").disabled = false ;
document.getElementById("p1").disabled = false;-->
<!-- onclick = '<? php $_SESSION['change_pass'] = true ?>'-->
