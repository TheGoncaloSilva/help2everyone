<?php
  class Template{

  public function cabecalho(){
    return '
    <!DOCTYPE html>
    <html lang="pt">
    <head>
    <title>Help2Everyone</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Help2Everyone">
    <!--
    <meta name="description" content="Unicat project">-->
    <link rel="icon" href="./images/logo.ico">
    <link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
    <link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
    <link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/animate.css">
    <link rel="stylesheet" type="text/css" href="styles/main_styles.css">
    <link rel="stylesheet" type="text/css" href="styles/responsive.css">
    <link>
    </head>
    <body>

    <div class="super_container">

    	<!-- Header -->

    	<header class="header">

    		<!-- Top Bar -->
    		<div class="top_bar">
    			<div class="top_bar_container">
    				<div class="container">
    					<div class="row">
    						<div class="col">
    							<div class="top_bar_content d-flex flex-row align-items-center justify-content-start">
    								<ul class="top_bar_contact_list">
    									<li><div class="question">Tens alguma questão?</div></li>
    									<li>
    										<i class="fa fa-phone" aria-hidden="true"></i>
    										<div>351-232465159</div>
    									</li>
    									<li>
    										<i class="fa fa-envelope-o" aria-hidden="true"></i>
    										<div>info.deercreative@gmail.com</div>
    									</li>
    								</ul>
    								<div class="top_bar_login ml-auto">
    									<div class="login_button"><a href="#">Registar ou Login</a></div>
    								</div>
    							</div>
    						</div>
    					</div>
    				</div>
    			</div>
    		</div>

    		<!-- Header Content -->
    		<div class="header_container">
    			<div class="container">
    				<div class="row">
    					<div class="col">
    						<div class="header_content d-flex flex-row align-items-center justify-content-start">
    							<div class="logo_container">
    									<!--<div class="logo_text">Help <span style="color:green">2</span> <span> Everyone</span></div>-->
    									<a class="navbar-brand" href="./index.php">
    										<img src="./images/shortlogo.ico" class="d-inline-block align-top imgnav Logo_text" alt="Help2Everyone">
    								</a>
    							</div>
    							<nav class="main_nav_contaner ml-auto">
    								<ul class="main_nav">
    									<li class="active"><a href="#">Home</a></li>
    									<li><a href="about.php">About</a></li>
    									<li><a href="courses.php">Courses</a></li>
    									<li><a href="blog.php">Blog</a></li>
    									<li><a href="#">Page</a></li>
    									<li><a href="contact.php">Contact</a></li>
    								</ul>
    								<div class="search_button"><i class="fa fa-search" aria-hidden="true"></i></div>

    								<!-- Hamburger -->
    								<div class="hamburger menu_mm">
    									<i class="fa fa-bars menu_mm" aria-hidden="true"></i>
    								</div>
    							</nav>

    						</div>
    					</div>
    				</div>
    			</div>
    		</div>

    		<!-- Header Search Panel -->
    		<div class="header_search_container">
    			<div class="container">
    				<div class="row">
    					<div class="col">
    						<div class="header_search_content d-flex flex-row align-items-center justify-content-end">
    							<form action="#" class="header_search_form">
    								<input type="search" class="search_input" placeholder="Search" required="required">
    								<button class="header_search_button d-flex flex-column align-items-center justify-content-center">
    									<i class="fa fa-search" aria-hidden="true"></i>
    								</button>
    							</form>
    						</div>
    					</div>
    				</div>
    			</div>
    		</div>
    	</header>

    	<!-- Menu -->

    	<div class="menu d-flex flex-column align-items-end justify-content-start text-right menu_mm trans_400">
    		<div class="menu_close_container"><div class="menu_close"><div></div><div></div></div></div>
    		<div class="search">
    			<form action="#" class="header_search_form menu_mm">
    				<input type="search" class="search_input menu_mm" placeholder="Search" required="required">
    				<button class="header_search_button d-flex flex-column align-items-center justify-content-center menu_mm">
    					<i class="fa fa-search menu_mm" aria-hidden="true"></i>
    				</button>
    			</form>
    		</div>
    		<nav class="menu_nav">
    			<ul class="menu_mm">
    				<li class="menu_mm"><a href="index.php">Home</a></li>
    				<li class="menu_mm"><a href="#">About</a></li>
    				<li class="menu_mm"><a href="#">Courses</a></li>
    				<li class="menu_mm"><a href="#">Blog</a></li>
    				<li class="menu_mm"><a href="#">Page</a></li>
    				<li class="menu_mm"><a href="contact.php">Contact</a></li>
    			</ul>
    		</nav>
    	</div>';
  }
  public function rodape(){
    return '
    	<!-- Footer -->

    	<footer class="footer">
    		<div class="footer_background" style="background-image:url(images/footer_background.png)"></div>
    		<div class="container">
    			<div class="row footer_row">
    				<div class="col">
    					<div class="footer_content">
    						<div class="row">

    							<div class="col-lg-3 footer_col">

    								<!-- Footer About -->
    								<div class="footer_section footer_about">
    									<div class="footer_logo_container">
    										<a href="#">
    											<div class="footer_logo_text">Help2<span>Everyone</span></div>
    										</a>
    									</div>
    									<div class="footer_about_text">
    										<p>Acompanha novidades através das Redes Sociais</p>
    									</div>
    									<div class="footer_social">
    										<ul>
    											<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
    											<li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
    											<li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
    											<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
    										</ul>
    									</div>
    								</div>

    							</div>

    							<div class="col-lg-3 footer_col">

    								<!-- Footer Contact -->
    								<div class="footer_section footer_contact">
    									<div class="footer_title">Contacta-nos</div>
    									<div class="footer_contact_info">
    										<ul>
    											<li>Email: Info.deercreative@gmail.com</li>
    											<li>Phone:  +(88) 111 555 666</li>
    											<li>40 Baria Sreet 133/2 New York City, United States</li>
    										</ul>
    									</div>
    								</div>

    							</div>

    							<div class="col-lg-3 footer_col">

    								<!-- Footer links -->
    								<div class="footer_section footer_links">
    									<div class="footer_title">Navegação</div>
    									<div class="footer_links_container">
    										<ul>
    											<li><a href="index.php">Home</a></li>
    											<li><a href="about.php">About</a></li>
    											<li><a href="contact.php">Contact</a></li>
    											<li><a href="#">Features</a></li>
    											<li><a href="courses.php">Courses</a></li>
    											<li><a href="#">Events</a></li>
    											<li><a href="#">Gallery</a></li>
    											<li><a href="#">FAQs</a></li>
    										</ul>
    									</div>
    								</div>

    							</div>

    							<div class="col-lg-3 footer_col clearfix">

    								<!-- Footer links -->
    								<div class="footer_section footer_mobile">
    									<div class="footer_title">Mobile</div>
    									<div class="footer_mobile_content">
    										<div class="footer_image"><a href="#"><img src="images/mobile_1.png" alt=""></a></div>
    										<div class="footer_image"><a href="#"><img src="images/mobile_2.png" alt=""></a></div>
    									</div>
    								</div>

    							</div>

    						</div>
    					</div>
    				</div>
    			</div>

    			<div class="row copyright_row">
    				<div class="col">
    					<div class="copyright d-flex flex-lg-row flex-column align-items-center justify-content-start">
    						<div class="cr_text"><!-- Link back to Colorlib can not be removed. Template is licensed under CC BY 3.0. -->
    Copyright &copy;<script>document.write(new Date().getFullYear());</script> Help2Everyone - All rights reserved
    <!-- Link back to Colorlib can not be removed. Template is licensed under CC BY 3.0. --></div>
    						<div class="ml-lg-auto cr_links">
    							<ul class="cr_list">
    								<li><a href="#">Copyright notification</a></li>
    								<li><a href="#">Terms of Use</a></li>
    								<li><a href="#">Privacy Policy</a></li>
    							</ul>
    						</div>
    					</div>
    				</div>
    			</div>
    		</div>
    	</footer>
    </div>

    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="styles/bootstrap4/popper.js"></script>
    <script src="styles/bootstrap4/bootstrap.min.js"></script>
    <script src="plugins/greensock/TweenMax.min.js"></script>
    <script src="plugins/greensock/TimelineMax.min.js"></script>
    <script src="plugins/scrollmagic/ScrollMagic.min.js"></script>
    <script src="plugins/greensock/animation.gsap.min.js"></script>
    <script src="plugins/greensock/ScrollToPlugin.min.js"></script>
    <script src="plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
    <script src="plugins/easing/easing.js"></script>
    <script src="plugins/parallax-js-master/parallax.min.js"></script>
    <script src="js/custom.js"></script>
    </body>
    </html>';
  }

  }
?>
