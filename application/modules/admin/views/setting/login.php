<!DOCTYPE html>
<html lang="ar">

<head>
    <title>Login</title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Favicon icon -->

    <link rel="icon" href="<?php echo base_url(); ?>uploads/site_setting/sema.png" type="image/x-icon">
    <!-- Google font--><link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap/css/bootstrap.min.css">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/icon/themify-icons/themify-icons.css">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/icon/icofont/css/icofont.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/icon/font-awesome/css/font-awesome.min.css">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/css/style.css">
	<style>
	.forget-form{
    display: none;
}
.theme-loader .loader-track {
  left: 35%;
  top: 35%;
  position: absolute;
  display: block;
  width:400px;
  height:183px;
  background-image:url('<?=DIR?>uploads/site_setting/sema.png');
      background-size: 100% 100%;
}
	</style>
</head>

<body class="fix-menu" style="direction: rtl;">
<!-- Pre-loader start -->
<div class="theme-loader">
    <div class="loader-track">
        <div class="loader-bar"></div>
    </div>
</div>
<!-- Pre-loader end -->

<!--<section class="login p-fixed d-flex text-center bg-primary common-img-bg">-->
<section class="login p-fixed d-flex text-center bg-primary">

    <!-- Container-fluid starts -->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
            
                <div class="login-card card-block auth-body mr-auto ml-auto">
                    <div class="md-float-material">
                        <!--<img src="https://active4web.com/radio/uploads/site_setting/GLSW.png" alt="logo" class="logo-default" >-->
                        <div class="auth-box">
                            <div class="bg-soft-primary">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="text-primary text-left p-4">
                                            <h5 class="text-primary">Welcome Back !</h5>
                                            <p>Sign in to continue to Volcano.</p>
                                        </div>
                                        <!--<h3 class="text-right txt-primary" style="text-align:center !important; font-weight:400 !important">Login</h3>-->
                                    </div>
                                    <div class="col-md-5">
                                        <img src="<?= base_url()?>uploads/site_setting/profile-img.ba4e037e.png" alt="welcome back" class="img-login-welcome" >
                                    </div>
                                </div>
                            </div>

                            <div>
                                <a href="/">
                                    <div class="avatar-md profile-user-wid mb-4 ml-4">
                                        <span class="avatar-title rounded-circle ">
                                            <img src="<?= base_url()?>uploads/site_setting/sema.png" alt="" class="" height="34">
                                        </span>
                                    </div>
                                </a>
                            </div>
                            
							<form action="<?=DIR?>admin/submit_login" method="post" class="login-form pl-4 pb-4 pr-4">
                          
                            <div class="form-group">
                                <label for="email" class="label-login">Username</label>
                                <input type="text" Required name="user_name" id="email" class="form-control" placeholder="Username">
                                <span class="md-line"></span>
                            </div>
                            <div class=" form-group">
                                <label for="password" class="label-login"> Password </label>
                                <input type="password" Required name="password" id="password" class="form-control" placeholder="Password">
                                <span class="md-line"></span>
                            </div>
                            <div class="row m-t-25 text-right">
                                <div class="col-12 text-left">
                                    <div class="checkbox-fade fade-in-primary d-">
                                        <label>
                                            <span class="text-inverse">Remember Me</span>
                                            <input type="checkbox" name="remember" value="1">
                                            <span class='cr'>
											<i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-30">
                                <div class="col-md-12">
                                    <input type="submit" name="do_login" class="btn btn-primary btn-md btn-block  text-center " value="Login" />
                                    <div class="forgot-phone">
                                        <i class="mdi mdi-lock mr-1"></i>
                                        <a href="javascript:;" id="forget-password" class="forget-password">Forget Password?</a>
                                    </div>
                            </div>
                        </div>
</form>

<form class="forget-form" action="<?php echo base_url();?>admin/ForgotPassword" method="post" onsubmit ='return validate()'>
                <h3 class="font-green">Forgot your password ?</h3>
                <p> Enter your email address below to reset your password. </p>
				<div class="text-danger pb-3 display-hide">
                    <button class="close" data-close="alert"></button>
                       <span> Please enter your email </span>
                </div>
                <div class="form-group p-3">
                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" required /> </div>
                <div class="form-actions d-flex justify-content-between p-3">
                    <button type="button" id="back-btn" class="btn green btn-outline">Back</button>
                    <button type="submit" class="btn btn-primary uppercase pull-right">Send</button>
                </div>
            </form>


                        </div>
                    </div>
                    <!-- end of form -->
                </div>
                <!-- Authentication card end -->
            </div>
            <!-- end of col-sm-12 -->
        </div>
        <!-- end of row -->
    </div>
    <!-- end of container-fluid -->
</section>
<!-- Warning Section Starts -->
<!-- Older IE warning message -->
<!--[if lt IE 10]>
<div class="ie-warning">
    <h1>Warning!!</h1>
    <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
    <div class="iew-container">
        <ul class="iew-download">
            <li>
                <a href="http://www.google.com/chrome/">
                    <img src="<?php echo base_url(); ?>assets/admin/images/browser/chrome.png" alt="Chrome">
                    <div>Chrome</div>
                </a>
            </li>
            <li>
                <a href="https://www.mozilla.org/en-US/firefox/new/">
                    <img src="<?php echo base_url(); ?>assets/admin/images/browser/firefox.png" alt="Firefox">
                    <div>Firefox</div>
                </a>
            </li>
            <li>
                <a href="http://www.opera.com">
                    <img src="<?php echo base_url(); ?>assets/admin/images/browser/opera.png" alt="Opera">
                    <div>Opera</div>
                </a>
            </li>
            <li>
                <a href="https://www.apple.com/safari/">
                    <img src="<?php echo base_url(); ?>assets/admin/images/browser/safari.png" alt="Safari">
                    <div>Safari</div>
                </a>
            </li>
            <li>
                <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                    <img src="<?php echo base_url(); ?>assets/admin/images/browser/ie.png" alt="">
                    <div>IE (9 & above)</div>
                </a>
            </li>
        </ul>
    </div>
    <p>Sorry for the inconvenience!</p>
</div>
<![endif]-->
<!-- Warning Section Ends -->
<!-- Required Jquery -->
<link href="<?=DIR?>design/assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css" />
<script  src="<?php echo base_url(); ?>assets/admin/bower_components/jquery/js/jquery.min.js"></script>
<script  src="<?php echo base_url(); ?>assets/admin/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
<script  src="<?php echo base_url(); ?>assets/admin/bower_components/popper.js/js/popper.min.js"></script>
<script  src="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap/js/bootstrap.min.js"></script>
<!-- jquery slimscroll js -->
<script  src="<?php echo base_url(); ?>assets/admin/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
<!-- modernizr js -->
<script  src="<?php echo base_url(); ?>assets/admin/bower_components/modernizr/js/modernizr.js"></script>
<script  src="<?php echo base_url(); ?>assets/admin/bower_components/modernizr/js/css-scrollbars.js"></script>
<!-- i18next.min.js -->
<script src="<?=DIR?>design/assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
<script  src="<?php echo base_url(); ?>assets/admin/bower_components/i18next/js/i18next.min.js"></script>
<script  src="<?php echo base_url(); ?>assets/admin/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script  src="<?php echo base_url(); ?>assets/admin/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
<script  src="<?php echo base_url(); ?>assets/admin/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
<script  src="<?php echo base_url(); ?>assets/admin/js/common-pages.js"></script>
<script  src="<?=DIR;?>design/assets/pages/scripts/login.min.js"></script>

<script>

jQuery("#forget-password").click(function(){
	 jQuery(".login-form").hide();
	 jQuery(".forget-form").show();
	});

jQuery("#back-btn").click(function(){
jQuery(".login-form").show();
jQuery(".forget-form").hide();
});


</script>
        <script>
            $(document).ready(function()
            {
                toastr.options = {
                "closeButton": false,
                "debug": false,
                "positionClass": "toast-top-left",
                "onclick": null,
                "showDuration": "1000",
                "progressBar": true,
                "hideDuration": "1000",
                "timeOut": "4000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
                $('#clickmewow').click(function()
                {
                    $('#radio1003').attr('checked', 'checked');
                });
            })
        </script>
<?php 
if(isset($_SESSION['msg'])){
?>
<script>
$(document).ready(function(e) {
 toastr.warning("<?php echo $_SESSION['msg']?>");
});
</script>

<?php }?>

</body>
</html>
