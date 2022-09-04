<!doctype html>
<html lang="en-gb">

<head>
	<title>Yet another task manager</title>
    <link rel="icon" href="../assets/list.png">

	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://getbootstrap.com/docs/4.1/dist/css/bootstrap.min.css">
	
	<!-- Custom styles for this template -->
	<link rel="stylesheet" href="https://getbootstrap.com/docs/4.1/examples/sticky-footer-navbar/sticky-footer-navbar.css">

</head>

<?php
	include './php_functions/php_functions.php';

    session_start();

    $_SESSION['entry_to_delete'] = null;
?>

<body>
    <header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="#">YATM</a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <?php
                    if(isset($_SESSION['active_user'])){
                        echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                        echo ''.$_SESSION['active_user'].' <img src="../assets/user.png" width="24" height="24" class="d-inline-block align-top" alt=""></a>';
                        echo '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">';
                        echo '<a class="dropdown-item" href="./task_management/dashboard.php">Go to the dashboard</a>';
                        echo '<a class="dropdown-item" href="./user_management/logout.php">Log out</a>';
                        echo '</div>';
                    }
                    else {
                        echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Log in or create an account</a>';
                        echo '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">';
                        echo '<a class="dropdown-item" href="./user_management/login.php">Log in</a>';
                        echo '<a class="dropdown-item" href="./user_management/create_account.php">Create account</a>';
                        echo '</div>';
                    }
                ?>
            </li>
        </ul>
    </div>

    </nav>
    </header>

    <!-- Begin page content -->
    <main role="main" class="container">
        <h1 class="mt-5">Yet another task manager</h1>
        <?php
            if(isset($_SESSION['active_user'])){
                echo '<p class="lead"><a href="./task_management/dashboard.php">Go to your dashboard, '.$_SESSION['active_user'].'.</a></p>';
            }
            else {
                echo '<p class="lead"><a href="./user_management/login.php">Log in</a> or <a href="./user_management/create_account.php">create a new account</a> to use this application.</p>';
            }
        ?>
        <div class="alert alert-info mt-5" role="alert">This website uses cookies. By using it you accept that.</div>
    </main>

    <footer class="footer">
    <div class="container">
        <span class="text-muted">On <a href="https://github.com/ManelAC/Yet-another-task-manager">GitHub</a> by @ManelAC</span>
    </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="https://getbootstrap.com/docs/4.1/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="https://getbootstrap.com/docs/4.1/assets/js/vendor/popper.min.js"></script>
    <script src="https://getbootstrap.com/docs/4.1/dist/js/bootstrap.min.js"></script>
</body>
</html>
