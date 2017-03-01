<!doctype html>
<html class="no-js" lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title>Regie - OR</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="apple-touch-icon" href="apple-touch-icon.png">
<!-- Place favicon.ico in the root directory -->


<link rel="stylesheet"
	href="<?php echo ROOT_PATH; ?>assets/css/vendor.css">
<link rel="stylesheet" id="theme-style"
	href="<?php echo ROOT_PATH; ?>assets/css/app.css">
<link id="bsdp-css"
	href="<?php echo ROOT_PATH; ?>assets/css/bootstrap-datepicker3.min.css"
	rel="stylesheet">

  
<!-- Them e initialization -->
<script>
            var themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) :
            {};
            var themeName = themeSettings.themeName || '';
            if (themeName)
            {
                document.write('<link rel="stylesheet" id="theme-style" href="<?php echo ROOT_PATH; ?>assets/css/app-' + themeName + '.css">');
            }
            else
            {
                document.write('<link rel="stylesheet" id="theme-style" href="<?php echo ROOT_PATH; ?>assets/css/app.css">');
            }
        </script>

</head>

<body>
	<div class="main-wrapper">
		<div class="app" id="app">
			<header class="header">
				<div class="header-block header-block-collapse hidden-lg-up">
					<button class="collapse-btn" id="sidebar-collapse-btn">
						<i class="fa fa-bars"></i>
					</button>
				</div>
				<div class="header-block header-block-search hidden-sm-down">
					<form role="search">
						<div class="input-container">
							<i class="fa fa-search"></i> <input type="search"
								placeholder="Search">
							<div class="underline"></div>
						</div>
					</form>
				</div>

				<div class="header-block header-block-nav">
					<ul class="nav-profile">

                            <?php if(isset($_SESSION['is_logged_in'])) : ?>


                            <li class="profile dropdown"><a
							class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
							role="button" aria-haspopup="true" aria-expanded="false">

                                    Bienvenue <?php echo $_SESSION['user_data']['name']; ?>
    			    </span>
						</a>
							<div class="dropdown-menu profile-dropdown-menu"
								aria-labelledby="dropdownMenu1">
								<a class="dropdown-item" href="#"> <i class="fa fa-user icon"></i>
									Profile
								</a> <a class="dropdown-item" href="#"> <i
									class="fa fa-bell icon"></i> Notifications
								</a> <a class="dropdown-item"
									href="<?php echo ROOT_URL; ?>users/register"> <i
									class="fa fa-gear icon"></i> Nouvelle Utilisateur
								</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item"
									href="<?php echo ROOT_URL; ?>users/logout"> <i
									class="fa fa-power-off icon"></i> Déconnecter
								</a>
							</div></li>
                            <?php else : ?>
                                <li class="profile dropdown"><a
							class="nav-link dropdown-toggle" data-toggle="dropdown"
							href="<?php echo ROOT_URL; ?>users/login" role="button"
							aria-haspopup="true" aria-expanded="false"> Se connecter </span>
						</a></li>
                              
                            <?php endif; ?>
                        </ul>
				</div>
			</header>