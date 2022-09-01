<?php
	function index_navbar_session_isset() {
		echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
        echo '<img src="../assets/user.png" width="30" height="30" class="d-inline-block align-top" alt=""> Username</a>';
        echo '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">';
        echo '<a class="dropdown-item" href="#">Go to the dashboard</a>';
        echo '<a class="dropdown-item" href="#">Log out</a>';
        echo '</div>';
	}

    function index_navbar_session_not_set() {
		echo '<a class="nav-link" href="#"> Log in or create an account</a>';
	}
?>
