<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Student Login</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url();?>/assets/skin_user/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url();?>/assets/skin_user/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url();?>/assets/skin_user/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url();?>/assets/skin_user/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
								<?php

								if($this->session->flashdata('message') != ''){
									 
									 echo '<h4 class="alert_success">'.$this->session->flashdata('message').' </h4>';
								}else{
									 echo 'ผู้ใช้งานทั่วไป Students ';
								}

								?>						
						</h3>
                    </div>
                    <div class="panel-body">
                        <form id="login" action="<?php echo base_url();?>front_login/login_user" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="std_cardid"  autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="std_password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>


								<script>

								function testAPI() {

										FB.api('/me', { locale: 'en_US', fields: 'name, email' }, function(response) {
										  //console.log('Successful login for: ' + response.name);
										  document.getElementById('status').innerHTML =
											'Thanks for logging in, ' + response.email + '!';
											//window.location = '<?php echo base_url();?>front_login/login_user';
										});
								}

								  // This is called with the results from from FB.getLoginStatus().
								  function statusChangeCallback(response) {
									console.log('statusChangeCallback');
									console.log(response);
									// The response object is returned with a status field that lets the
									// app know the current login status of the person.
									// Full docs on the response object can be found in the documentation
									// for FB.getLoginStatus().
									if (response.status === 'connected') {
									  // Logged into your app and Facebook.
									  testAPI();
									} else if (response.status === 'not_authorized') {
									  // The person is logged into Facebook, but not your app.
									  document.getElementById('status').innerHTML = 'Please log ' +
										'into this app.';
									} else {
									  // The person is not logged into Facebook, so we're not sure if
									  // they are logged into this app or not.
									  document.getElementById('status').innerHTML = 'Please log ' +
										'into Facebook.';
									}
								  }

								  // This function is called when someone finishes with the Login
								  // Button.  See the onlogin handler attached to it in the sample
								  // code below.
								  function checkLoginState() {
									FB.getLoginStatus(function(response) {
									  statusChangeCallback(response);
									});
								  }

								  window.fbAsyncInit = function() {
									FB.init({
									  appId      : '869302506520584',
									  xfbml      : true,
									  version    : 'v2.2'
									});


									  FB.getLoginStatus(function(response) {
										statusChangeCallback(response);
									  });

								  };

								  (function(d, s, id){
									 var js, fjs = d.getElementsByTagName(s)[0];
									 if (d.getElementById(id)) {return;}
									 js = d.createElement(s); js.id = id;
									 js.src = "//connect.facebook.net/en_US/sdk.js";
									 fjs.parentNode.insertBefore(js, fjs);
								   }(document, 'script', 'facebook-jssdk'));

								</script>

								<fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
								</fb:login-button>

								<div id="status">
								</div>

                                <!-- Change this to a button or input when using this as a form -->
                                
								 <input type="submit" class="btn btn-lg btn-success btn-block" id="submit" value="Log in">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo base_url();?>/assets/skin_user/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url();?>/assets/skin_user/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url();?>/assets/skin_user/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url();?>/assets/skin_user/dist/js/sb-admin-2.js"></script>

</body>

</html>
