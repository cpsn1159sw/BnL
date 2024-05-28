<?php


?>
<!doctype html>
<html lang="en">
  <head>
  	<title>Sidebar 07</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		
		 <!-- Themefisher Icon font -->
         <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/plugins/themefisher-font/style.css">

		<link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/css/dashboard.css">
  </head>
  <body>
		
		<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar" class="active">
				<h1><a href="/BnL/public/home" class="logo">BnL</a></h1>
					<ul class="list-unstyled components mb-5">
            <li class="">
              <a href="dashboard"><span class="tf-ion-ios-home"></span> Home</a>
            </li>
            <li class="">
              <a href="hrm"><span class="tf-ion-android-people"></span> HRM</a>
            </li>
            <li class="">
              <a href="products"><span class="tf-basket"></span> Products</a>
            </li>
            <li class="active">
              <a href="customers"><span class="tf-ion-android-contacts"></span> Customers</a>
            </li>
            <li class="">
              <a href="feedback"><span class="tf-ion-android-chat"></span> Feedback</a>
            </li>
            <li class="">
              <a href="exchange"><span class="tf-ion-reply"></span> Exchange</a>
            </li>
            <li class="">
              <a href="orders"><span class="tf-ion-tshirt"></span> Orders</a>
            </li>
					</ul>
    	</nav>

        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">

            <button type="button" id="sidebarCollapse" class="btn btn-success">
              <i class="tf-ion-navicon-round"></i>
              <span class="sr-only">Toggle Menu</span>
            </button>

            <div class="nav navbar-nav">
              <ul class="nav navbar-nav ml-auto">
                    <span>Hi my Admin</span>
              </ul>
            </div>
          </div>
        </nav>

        <h2 class="mb-4">Sidebar #07</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      </div>
		</div>
  </body>
</html>

<?php layouts('footer_dashboard'); ?>