<?php 
if( isset($_SESSION) )
{
    session_destroy();
}
else
{
    session_start();
    session_destroy();   
}

// echo password_hash("SparesDOAdmin",PASSWORD_DEFAULT);
include("../config.php");

if(isset($_POST['submit']))
{
    $uname = $_POST['uname'];
    $chk_login = $db->getRow("select password from sp_admin where username='".$uname."' Limit 1 ");
        if(count($chk_login) > 0){ 
            if(password_verify($_POST['psw'], $chk_login["password"])){
                $_SESSION["SPARESDO_adminlogin"]="yes";
                $_SESSION["SPARESDO_subadminlogin"]= "superadmin";
                redirect('index.php');
            }   
            else{
                echo "<script>alert('Invalid Password')</script>";
            }         
        }
        else
        {
            $chk_employ_login = $db->getRow("select sb_id,password from sp_subadmin where ( username = '".$uname."') Limit 1");
            if(count($chk_employ_login) > 0){ 
                if(password_verify($_POST['psw'], $chk_employ_login["password"])){
                    $sb_id = $chk_employ_login["sb_id"];
                    $_SESSION["SPARESDO_subadminlogin"]= $sb_id;
                    redirect('index.php');
                }
                else{
                    echo "<script>alert('Invalid Password')</script>";
                }
            }
            else
            {
            echo "<script>alert('Please Enter Valid Username and Password')</script>";
            }
        }
}

if(isset($_POST['resetlogin']) && isset($_POST['otp']))
{
    if($_POST['otp'] != '' && !empty($_POST['otp'])){

        $update_array = array(
              'username' => $_POST['uname'],
              'password' => password_hash($_POST['psw'],PASSWORD_DEFAULT),
            );


          $action_result = $db->updateAry('sp_admin', $update_array, "where id='1'");
        if(!is_null($action_result)){ 
            echo "<script>alert('Updated Successfully');</script>";
        }
        else
        {
            echo "<script>alert('Update Failed')</script>";
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Admin</title>
   <meta charset="utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1"/>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Bootstrap core CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
<!-- Material Design Bootstrap -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.16/css/mdb.min.css" rel="stylesheet">

<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.16/js/mdb.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="MDB/css/compiled.min.css" rel="stylesheet" />


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<style type="text/css">
.navbar.navbar-dark .navbar-nav .nav-item .nav-link {
    color: #000;
    -webkit-transition: .35s;
    -o-transition: .35s;
    transition: .35s;
}    
 .navbar.navbar-dark .navbar-nav .nav-item .nav-link:hover {
    color: #000;
    font-weight: 500;
}  
.Reset{
    display: none;
}
</style>
</head>
<body style="background-color: #e9e9e9">
    <div class="main-wrapper">
    <div class="container-fluid">
        <div class="row">
        <!--Main column-->
            <div class="col-lg-10 col-md-12">

                <!--Documentation file-->
                <div class="documentation">
                    <form id="myForm" method="post" runat="server">
                    <section id="form-h">

                    <br>
                    <br>                   
                     <br>
                    <br>                   
                     <br>
                    <br>

                    <!-- Live preview-->
                    <div class="row">
                        <div class="col-md-5 col-sm-2 col-xs-12"></div>
                            <div class="col-lg-5 col-md-7">
                            <!--Form with header-->
                            <div class="card">
                                <div class="card-block">
                                    <!--Header-->
                                    <div class="form-header  purple darken-4">
                                        <h3>Login</h3>
                                    </div>

                                    <!--Body-->
                                    <div class="md-form">
                                        <i class="fa fa-user prefix"></i>
                                        <input type="text" id="uname" name="uname"  class="form-control">
                                        <label for="uname">User Name</label>
                                    </div>

                                    <div class="md-form Reset">
                                        <i class="fa fa-check prefix"></i>
                                        <input type="text" id="otp" name="otp"  class="form-control">
                                        <label for="uname">Enter OTP</label>
                                    </div>

                                    <div class="md-form ">
                                        <i class="fa fa-lock prefix"></i>
                                        <input type="password" id="psw"  name="psw" class="form-control">
                                        <label for="psw">Password</label>
                                    </div>
                                      <div class="options normallogin">
                                        <p style="text-align: center;cursor: pointer;" onclick="showreset()"><i class="fa fa-unlock-alt" style="color: red"></i> Reset Password?</p>
                                    </div>

                                     <div class="options Reset">
                                        <p style="text-align: center;cursor: pointer;" onclick="shownormal()"><i class="fa fa-arrow-left" style="color: red"></i> Login?</p>
                                    </div>

                                    <div class="text-center normallogin Loginbutton">
                                        <button type="submit"  name="submit" class="btn btn-deep-purple waves-effect waves-light">Login</button>
                                    </div>

                                    <div class="Reset text-center">
                                        <button type="button" name="sendotp" class="btn btn-deep-orange waves-effect waves-light">Send OTP</button>
                                   
                                        <button type="button" onclick="verifyotp()" id="resetlogin"  name="resetlogin" class="btn btn-deep-purple waves-effect waves-light">Submit</button>
                                   
                                </div>
                                </div>
                                <!--Footer-->
                            </div>
                            <!--/Form with header-->
                        </div>
                    </div>
                    <!-- /.Live preview-->
                </section>
                <!-- SECTION-->
                </form>
            </div>
            <!--/.Documentation file-->                            
            </div>
            <!--/.Main column-->
        </div>
    </div>
</div>   
</body>
    <!-- JQuery -->
    <script type="text/javascript" src="MDB/js/compiled.min.js"></script>
    <script>
        
        // SideNav init
        $(".button-collapse").sideNav();

        // Custom scrollbar init
        var el = document.querySelector('.custom-scrollbar');
        Ps.initialize(el);
        
        //Sticky
        $(function () {
            $(".sticky").sticky({
                topSpacing: 90
                , zIndex: 2
                , stopper: "#footer"
            });
        });
        
        //ScrollSpy
        $('body').scrollspy({
            target: '#scrollspy'
        });
    
    function showreset(){
        $('.normallogin').hide();
        $('.normallogin').find('button').prop('disabled',true);
        $('.Reset').show();
        $('.Reset').find('button').prop('disabled',false);

    }

 function shownormal(){
        $('.normallogin').show();
        $('.normallogin').find('button').prop('disabled',false);
        $('.Reset').hide();
        $('.Reset').find('button').prop('disabled',false);
    }   

 </script>
  <script type="text/javascript">
    if(window.history.replacestate){
        window.history.replacestate(null,null,window.location.href);
    }
    </script>
 <script type="text/javascript">    
$(document).on('click', '.btn-deep-orange', function() {
$('.btn-deep-orange').prop('disabled',true);
     var datas="action=sendotp";  
     $.ajax({
        url:'ajax_submit.php',
        method:'post',
        data:datas,
        success:function(data){
            var response = $.parseJSON(data);
            if( response.message == 'success' )
            { localStorage.setItem('validnumber', response.number);
            $('.btn-deep-orange').prop('disabled',false);
            alert("OTP Sent");
            }
            else{
                alert("Failed To Send");
            }
        }
    });
});

          function verifyotp(){
        var otp = $('#otp').val();
            if(otp != undefined && otp != ''){
                
            var  old_signup_otp = window.atob(localStorage.getItem('validnumber'));
          
            if(otp != old_signup_otp )
            {
                alert('Please enter a valid OTP');
                return false;
            }
            else
            {
              $('.Loginbutton').remove();  
               localStorage.removeItem('validnumber'); 
               $('#resetlogin').prop('type','submit');
               $("#resetlogin").prop('onclick', null)
               $("#resetlogin").click();
            }
        }
        else{
            alert("Please Enter OTP");
        }
}  
 </script>
</html>