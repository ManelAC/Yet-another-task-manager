<!doctype html>
<html lang="en-gb">

<head>
	<title>Yet another task manager</title>
    <link rel="icon" href="../../assets/list.png">

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
	include '../php_functions/php_functions.php';

    session_start();

    try {
        $database_connection = new PDO('mysql:host='.get_server_information().';dbname='.get_database_name().'', ''.get_database_user_name().'', ''.get_database_user_password().'', 
        array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
      }
      catch(PDOException $exception) {
        $_SESSION['cant_connect_to_database'] = true;
        $exception->getMessage();
      }

    foreach($database_connection->query('select * from tasks') as $temp_row) {
        if($temp_row['tasks_id'] == $_GET['id']) {
            if($temp_row['tasks_user_id'] != $_SESSION['active_user_id']) {
                $_SESSION['not_allowed_to_edit'] = true;
                header("Location: ./dashboard.php");
            }
            else {
                $row = $temp_row;
            }
        }
    }
?>

<body>
    <header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="../index.php">YATM</a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <?php
                    echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                    echo ''.$_SESSION['active_user'].' <img src="../../assets/user.png" width="24" height="24" class="d-inline-block align-top" alt=""></a>';
                    echo '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">';
                    echo '<a class="dropdown-item" href="./dashboard.php" onClick="javascript: return confirm(\'Are you sure you want to leave this window without editing the task?\');">Go to the dashboard</a>';
                    echo '<a class="dropdown-item" href="../user_management/logout.php" onClick="javascript: return confirm(\'Are you sure you want to log out without editing the task?\');">Log out</a>';
                    echo '</div>';
                ?>
            </li>
        </ul>
    </div>

    </nav>
    </header>

    <!-- Begin page content -->
    <main role="main" class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="mt-5 text-center">Edit task</h1>
            </div>
        </div>
        <?php
            if(isset($_SESSION["description_too_short"])) {
                echo '<div class="alert alert-danger" role="alert">The description doesn\'t have at least 3 characters.</div>';
                $_SESSION["description_too_short"] = null;
            }
            if(isset($_SESSION["description_too_long"])) {
                echo '<div class="alert alert-danger" role="alert">The description is more than 200 characters long.</div>';
                $_SESSION["description_too_long"] = null;
            }
            if(isset($_SESSION["detailed_description_too_long"])) {
                echo '<div class="alert alert-danger" role="alert">The description is more than 2000 characters long.</div>';
                $_SESSION["detailed_description_too_long"] = null;
            }
            if(isset($_SESSION["wrong_dates"])) {
                echo '<div class="alert alert-danger" role="alert">The end date can\'t be earlier than the start date.</div>';
                $_SESSION["detailed_description_too_long"] = null;
            }
            if(isset($_SESSION['task_successfully_edited'])) {
                echo '<div class="alert alert-success" role="alert">The task was succesfully updated.</div>';
                $_SESSION['task_successfully_edited'] = null;
            }
        ?>
        <div class="row">
            <div class="col-2">
                <div class="row mt-3"><a class="btn btn-primary" href="./new_task.php" role="button" onClick="javascript: return confirm('Are you sure you want to leave this window without editing the task?');">New task</a></div>
                <div class="row mt-3"><a class="btn btn-primary" href="./pending_tasks.php" role="button" onClick="javascript: return confirm('Are you sure you want to leave this window without editing the task?');">Pending tasks</a></div>
                <div class="row mt-3"><a class="btn btn-primary" href="./finished_tasks.php" role="button" onClick="javascript: return confirm('Are you sure you want to leave this window without editing the task?');">Finished tasks</a></div>
                <div class="row mt-3"><a class="btn btn-primary" href="./Dashboard.php" role="button" onClick="javascript: return confirm('Are you sure you want to leave this window without editing the task?');">Dashboard</a></div>
            </div>
            <div class="col-10">
                <form action="./task_edition.php" method="post">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" class="form-control" name="description" id="description" aria-describedby="description_help" placeholder="Enter description" required value="<?php echo $row['tasks_description'] ?>">
                                <small id="description_help" class="form-text text-muted">Description has to be at least 3 characters long and it can't have more than 200 characters.</small>
                            </div>
                        </div>   
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="start_date">Start date</label>
                                <input type="date" class="form-control" name="start_date" id="start_date" required value="<?php echo $row['tasks_start_date'] ?>">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="end_date">End date</label>
                                <input type="date" class="form-control" name="end_date" id="end_date" required value="<?php echo $row['tasks_end_date'] ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select class="form-control" name="category" id="category">
                                    <?php
                                        if($row['tasks_category'] == 1) {
                                            echo '<option value="1" selected>Personal</option>';
                                            echo '<option value="2">Work</option>';
                                        }
                                        else if($row['tasks_category'] == 2) {
                                        echo '<option value="1">Personal</option>';
                                        echo '<option value="2" selected>Work</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="state">State</label>
                                <select class="form-control" name="state" id="state">
                                    <?php
                                        if($row['tasks_state'] == 1) {
                                            echo '<option value="1" selected>To do</option>';
                                            echo '<option value="2">In progress</option>';
                                            echo '<option value="3">Finished</option>';
                                        }
                                        else if($row['tasks_state'] == 2) {
                                            echo '<option value="1">To do</option>';
                                            echo '<option value="2" selected>In progress</option>';
                                            echo '<option value="3">Finished</option>';
                                        }
                                        else if($row['tasks_state'] == 3) {
                                            echo '<option value="1">To do</option>';
                                            echo '<option value="2">In progress</option>';
                                            echo '<option value="3" selected>Finished</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="explanation">Detailed description</label>
                                <textarea name="explanation" id="explanation" style="min-width: 100%" rows="10" aria-describedby="explanation_help" placeholder="You can introduce a detailed description of the task here"><?php echo $row['tasks_explanation'] ?></textarea>
                                <small id="explanation_help" class="form-text text-muted">Detailed description can't be longer than 2000 characters.</small>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="task_id" name="task_id" value="<?php echo $row['tasks_id'] ?>">
                    <div class="row">
                        <div class="col text-left">
                            <button type="submit" class="btn btn-danger">Delete task</button>
                            
                        </div>
                        <div class="col text-right">
                            <button type="submit" class="btn btn-primary">Edit task</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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
