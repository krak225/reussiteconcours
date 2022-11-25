<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Site ivoirien de vente de documents des concours de cafop, infas, infs, ena, ... en ligne">
    <meta name="author" content="KR">
    <link rel="icon" href="{{ asset('images/favicon.ico') }}">

    <title>VENTE DE DOCUMENTS DES CONCOURS DE CAFOP, INFAS, INFS, ENA, ... EN LIGNE</title>
    
	<!-- Vendors Style-->
	<link rel="stylesheet" href="{{ asset('css/vendors_css.css') }}">
	  
	<!-- Style-->  
	<link rel="stylesheet" href="{{ asset('css/style.css') }}">
	<link rel="stylesheet" href="{{ asset('css/skin_color.css') }}">
    <script src="https://cdn.cinetpay.com/seamless/main.js"></script>
    <style>
        .sdk {
            display: block;
            position: absolute;
            background-position: center;
            text-align: center;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
  </head>
<body class="theme-primary">
	
	<!-- The social media icon bar -->
	<!--div class="icon-bar-sticky">
	  <a href="#" class="waves-effect waves-light btn btn-social-icon btn-facebook"><i class="fa fa-facebook"></i></a>
	  <a href="#" class="waves-effect waves-light btn btn-social-icon btn-twitter"><i class="fa fa-twitter"></i></a>
	  <a href="#" class="waves-effect waves-light btn btn-social-icon btn-linkedin"><i class="fa fa-linkedin"></i></a>
	  <a href="#" class="waves-effect waves-light btn btn-social-icon btn-youtube"><i class="fa fa-youtube-play"></i></a>
	</div-->
	<header class="top-bar">
		<div class="topbar">

		  <div class="container">
			<div class="row justify-content-end">
			  <div class="col-lg-6 col-12 d-lg-block d-none">
				<div class="topbar-social text-center text-md-left topbar-left">
				  <ul class="list-inline d-md-flex d-inline-block">
					<li class="ml-10 pr-10"><a href="#"><i class="text-white fa fa-question-circle"></i> Infoline</a></li>
					<li class="ml-10 pr-10"><a href="#"><i class="text-white fa fa-envelope"></i> info@reussiteconcours.com</a></li>
					<li class="ml-10 pr-10"><a href="#"><i class="text-white fa fa-phone"></i> +(225) 05 05 882 822</a></li>
				  </ul>
				</div>
			  </div>
			  <div class="col-lg-6 col-12 xs-mb-10">
				<div class="topbar-call text-center text-lg-right topbar-right">
				  <ul class="list-inline d-lg-flex justify-content-end">
					 <li class="mr-10 pl-10 lng-drop">
					  	<select class="header-lang-bx selectpicker">
							<option data-icon="flag-icon flag-icon-fr">Français</option>
							<option data-icon="flag-icon flag-icon-gb">Anglais</option>
						</select>
					 </li>
					 <li class="mr-10 pl-10"><a href="{{ route('panier') }}"><i class="text-white fa fa-list d-md-inline-block d-none"></i> Mon panier (<span class="badge badge-warning round" id="in-cart-items-num">0</span>)</a></li>
					 @guest
					 <li class="mr-10 pl-10"><a href="{{ route('inscription') }}"><i class="text-white fa fa-user d-md-inline-block d-none"></i> S'inscrire</a></li>
					 <li class="mr-10 pl-10"><a href="{{ route('login') }}"><i class="text-white fa fa-sign-in d-md-inline-block d-none"></i> Se connecter</a></li>
					 @else
					 <li class="mr-10 pl-10"><a href="#"><i class="text-white fa fa-dashboard d-md-inline-block d-none"></i> Mon compte</a></li>
					 @endguest
				  </ul>
				</div>
			  </div>
			 </div>
		  </div>
		</div>

		<nav hidden class="nav-white nav-transparent">
			<div class="nav-header">
				<a href="{{ route('home') }}" class="brand">
					<img src="{{ asset('images/logo-light-text2.png') }}" alt=""/>
				</a>
				<button class="toggle-bar">
					<span class="ti-menu"></span>
				</button>	
			</div>								
			<ul class="menu">				
				<li>
					<a href="{{ route('home') }}">Accueil</a>
				</li>	
				@auth	
				<li>
					<a href="{{ route('telechargements') }}">Téléchargements</a>
				</li>
				@endauth
				<li class="dropdown">
					<a href="{{ route('home') }}">DOCUMENTS CONCOURS</a>
					<ul class="dropdown-menu">
						<li><a href="#">INHP</a></li>
						<li><a href="#">INFS</a></li>
						<li><a href="#">INFAS</a></li>
						<li><a href="#">CAFOP</a></li>
						<li><a href="#">POLICE</a></li>
						<li><a href="#">GENDARMERIE</a></li>
					</ul>
				</li>
				<li>
					<a href="#cp">COURS DE PREPARATION</a>
				</li>	
				<li>
					<a href="{{ route('home') }}">A propos de nous</a>
				</li>	
				<li>
					<a href="{{ route('home') }}">Contacts</a>
				</li>
			</ul>
			<div class="wrap-search-fullscreen">
				<div class="container">
					<button class="close-search"><span class="ti-close"></span></button>
					<input type="text" placeholder="Rechercher..." />
				</div>
			</div>
		</nav>
	</header>

	<!----> 
							
	@yield('content')
	
	<!---->
    
	<footer class="footer_three">
		<div class="footer-top bg-dark3 pt-50">
            <div class="container">
                <div class="row">
					<div class="col-lg-4 col-12">
                        <div class="widget">
                            <h4 class="footer-title">A propos de nous</h4>
							<hr class="bg-primary mb-10 mt-0 d-inline-block mx-auto w-60">
							<p class="text-capitalize mb-20">K.Rol Productions est spécialisé dans l'élaboration de documents de concours depuis plus de ans </p> 
                        </div>
                    </div>											
					<div class="col-lg-4 col-12">
						<div class="widget">
							<h4 class="footer-title">Nos Contacts</h4>
							<hr class="bg-primary mb-10 mt-0 d-inline-block mx-auto w-60">
							<ul class="list list-unstyled mb-30">
								<li> <i class="fa fa-map-marker"></i> Abidjan , Côte d'Ivoire<br></li>
								<li> <i class="fa fa-phone"></i> <span>+(225) 05 05 882 822 </span><br><span>+(225) 05 05 882 822 </span></li>
								<li> <i class="fa fa-envelope"></i> <span>info@reussiteconcours.com </span></li>
							</ul>
						</div>
					</div>
					<div class="col-lg-4 col-12">
                        <div class="widget">
                            <h4 class="footer-title">Moyens de paiement</h4>
							<hr class="bg-primary mb-10 mt-0 d-inline-block mx-auto w-60">
							<ul class="payment-icon list-unstyled d-flex gap-items-1">
								<li class="pl-0">
									<a href="javascript:;"><i class="fa fa-cc-visa" aria-hidden="true"></i></a>
								</li>
								<li>
									<a href="javascript:;"><i class="fa fa-cc-mastercard" aria-hidden="true"></i></a>
								</li>
								<li>
									<a href="javascript:;"><i class="fa fa-cc-paypal" aria-hidden="true"></i></a><a href="javascript:;">
								</li>
								<li>
									<a href="javascript:;"><i class="fa fa-credit-card-alt" aria-hidden="true"></i></a>
								</li>
								<li>
									<i class="fa fa-cc-amex" aria-hidden="true"></i></a>
								</li>
							</ul>
                            <h4 class="footer-title mt-20">Newsletter</h4>
							<hr class="bg-primary mb-4 mt-0 d-inline-block mx-auto w-60">
                            <div class="mb-20">
								<form class="" action="" method="post">
									<div class="input-group">
										<input name="email" required="required" class="form-control" placeholder="Votre adresse e-mail" type="email">
										<div class="input-group-append">
											<button name="submit" value="Submit" type="submit" class="btn btn-primary"> <i class="fa fa-envelope"></i> </button>
										</div>
									</div>
								</form>
							</div>
                        </div>
                    </div>
                </div>				
            </div>
        </div>
		<div class="footer-bottom bg-dark3">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 col-12 text-md-left text-center"> © 2022 <span class="text-white">reussiteconcours.com</span> | Tous droits reservés.</div>
					<div class="col-md-6 mt-md-0 mt-20">
						<div class="social-icons">
							<ul class="list-unstyled d-flex gap-items-1 justify-content-md-end justify-content-center">
								<li><a href="#" class="waves-effect waves-circle btn btn-social-icon btn-circle btn-facebook"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#" class="waves-effect waves-circle btn btn-social-icon btn-circle btn-twitter"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#" class="waves-effect waves-circle btn btn-social-icon btn-circle btn-linkedin"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#" class="waves-effect waves-circle btn btn-social-icon btn-circle btn-youtube"><i class="fa fa-youtube"></i></a></li>
							</ul>
						</div>
					</div>
                </div>
            </div>
        </div>
	</footer>
	
	
	<!-- Vendor JS -->
	<script src="{{ asset('js/vendors.min.js') }}"></script>	
	<!-- Corenav Master JavaScript -->
    <script src="{{ asset('corenav-master/coreNavigation-1.1.3.js') }}"></script>
    <script src="{{ asset('js/nav.js') }}"></script>
	<script src="{{ asset('assets/vendor_components/OwlCarousel2/dist/owl.carousel.js') }}"></script>
	<script src="{{ asset('assets/vendor_components/bootstrap-select/dist/js/bootstrap-select.js') }}"></script>
	
	 
	<script src="{{ asset('js/noty/jquery.noty.js') }}"></script>
	<script src="{{ asset('js/noty/layouts/bottomCenter.js') }}"></script>
	<script src="{{ asset('js/noty/layouts/topRight.js') }}"></script>
	<script src="{{ asset('js/noty/layouts/top.js') }}"></script>
	<script src="{{ asset('js/noty/layouts/center.js') }}"></script>
	<script src="{{ asset('js/noty/themes/default.js') }}"></script>
	
	<!-- EduAdmin front end -->
	<script src="{{ asset('js/template.js') }}"></script>
	
	<!-- Personnel au site -->
	<script src="{{ asset('js/reussiteconcours.js') }}"></script>
	
	
</body>
</html>
