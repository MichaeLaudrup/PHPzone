<?php
    require_once "pdo.php";
    session_start(); 
    if ( !isset($_SESSION['name']) ) {
        die('Not logged in');
    }
    if(!isset($_GET['profile_id'])){
        $_SESSION['error'] = 'Missing profile_id'; 
        header('Location: index.php'); 
        return; 
    }
    if ( isset($_POST['cancel']) ) {
        header('Location: index.php');
        return;
    }

    if ( isset($_POST['delete']) && isset($_POST['profile_id']) ) {
        $sql = "DELETE FROM profile WHERE profile_id = :pid ;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':pid' => $_POST['profile_id']));
        $_SESSION['success'] = 'Record deleted';
        header( 'Location: index.php' ) ;
        return;
    }
    $stmt = $pdo->prepare("SELECT * FROM profile WHERE profile_id = :pf_id");
    $stmt->execute(array(":pf_id" => $_GET['profile_id']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ( $row === false) {
        $_SESSION['error'] = 'Could not load profile';
        header( 'Location: index.php' ) ;
        return;
    }
    ?>
<!DOCTYPE html>
<html>
<head>
<title>Michael Laudrup's Profile Add</title>
<!-- bootstrap.php - this is HTML -->

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" 
    integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" 
    crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" 
    integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" 
    crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <h1>Deleting Profile</h1>
    <p>First Name: <?= $row['first_name']?></p>
    <p>Last Name: <?= $row['last_name']?></p>
    <form method="post">
        <input type="hidden" name="profile_id" value="<?= $row['profile_id']?>"/>
        <input type="submit" name="delete" value="Delete">
        <input type="submit" name="cancel" value="Cancel">
    </form>
</div>
</body>
</html>








?>