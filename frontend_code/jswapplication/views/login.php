<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo title;?></title>
    <link rel="shortcut icon" href="<?php echo asset_url()?>images/icon.png" type="image/png" />

    <!-- Bootstrap -->
    <link href="<?php echo asset_url()?>css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo asset_url()?>css/style.css" rel="stylesheet">
    <style>
		body{
			background-image:url(<?php echo asset_url()?>images/traintracks.png);
			background-position:center center;
			background-repeat:no-repeat;
			background-color:#2744a0;
			background-size:cover;
		}
		.login h1 {
    color: #2744a0;
    font-size: 16px;
    margin: 0 0 25px;
    text-align: center;
}
	</style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    
    <div class="login">
    	<div class="logo"><img src="<?php echo asset_url()?>images/logo.png"/></div>
        <h1>GPS Tracking System</h1>
    	<form class="login_form" method="post" action="<?php echo base_url();?>" onsubmit="return login();">
    	<div class="progress hidden" id="login-progress">
           <div id="login-progress-text" class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
              Please wait...
           </div>
        </div>
        <?php echo $this->session->flashdata('message'); ?>
        <div id="lmsgbox"></div>
          <div class="form-group">
            <input type="text" class="form-control popupvalues" placeholder="Username" name="username" id="username" required>
          </div>
          
          <div class="form-group">
            <input type="password" placeholder="Password" class="form-control popupvalues" value="" name="password" id="password" required />
          </div>

          <button type="submit" class="btn btn-primary btn-block bbtm">LOGIN</button>
        </form>
    </div><!-- login -->
    
    
    

    <script src="<?php echo asset_url()?>js/jquery.min.js"></script>
    <script src="<?php echo asset_url()?>js/bootstrap.js"></script>
    
    <script src="<?php echo asset_url();?>js/jquery.validationEngine.js"></script>
    <script src="<?php echo asset_url();?>js/jquery.validationEngine-en.js"></script>
    <script src="<?php echo asset_url();?>js/jquery.validate.min.js"></script>
    
    <script>
    
    function login(){
		var email = $("#username").val();
		var password = $("#password").val();		 
		$("#login-progress").removeClass("hidden");
		$("#lmsgbox").html('');
		//.removeClass().addClass("progress-bar-success");
		//$("#lmsgbox").html('<div class="alert alert-warning alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Please wait...</div>');
		if($.trim(email) == ""){
			//$("#lmsgbox").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Enter Email ID.</div>');
		}
		else if($.trim(password) == ""){
			//$("#lmsgbox").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Enter Password.</div>');			
		}
		else{
			//alert();
			 $.post('<?php echo base_url();?>userlogin/checklogin',{username:email,password:password},function(data) {			        	 
		              //  alert(data);
		                if(data == "1")
		                {
		                    //$("#lmsgbox").html('<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Login successful. Redirecting...</div>');
		                    $("#login-progress-text").removeClass("progress-bar-warning").addClass("progress-bar-success").html("Log in...");
		//
		                    location.reload();
		                    
		                    
		                }
		                else if(data == "2"){
		                	$("#login-progress").addClass("hidden");
		                	$("#lmsgbox").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Your account is temporarily deactivated. Please contact SuVeechi Team. support@suveechi.in.</div>');
		                }
		                else{
		                	$("#login-progress").addClass("hidden");
		                	$("#lmsgbox").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Invalid Credentials.</div>');
		                }
		     });
		}
		return false;
	}
	
    </script>
  </body>
</html>
