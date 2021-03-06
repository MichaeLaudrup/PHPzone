<?php
    require_once "pdo.php";
    session_start();
    if(isset($_POST['email']) && isset($_POST['pass'])){
        $salt = 'XyZzy12*_'; 
        $check = hash('md5', $salt.$_POST['pass']);
        $stmt = $pdo->prepare('SELECT user_id, name FROM users
            WHERE email = :em AND password = :pw');
        $stmt->execute(array( ':em' => $_POST['email'], ':pw' => $check));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ( $row !== false ) {
            $_SESSION['name'] = $row['name'];
            $_SESSION['user_id'] = $row['user_id'];
            // Redirect the browser to index.php
            header("Location: index.php");
            return;
        }else{
            header("Location: login.php");
            $_SESSION['error'] = 'Incorrect password'; 
            return;
        }
    }
    
?>

<!DOCTYPE html>
<html>
<head>
<title>Michael Laudrup's Login Page</title>
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
        <h1>Please Log In</h1>
        <?php
            if(isset($_SESSION['error'])){
                echo('<p style="color: red;">'.$_SESSION['error']."</p>\n");
                unset($_SESSION['error']);
            }
        ?>
        <form method="POST" action="login.php">
            <label for="email">Email</label>
            <input type="text" name="email" id="email"><br/>
            <label for="pass">Password</label>
            <input type="password" name="pass" id="passw"><br/>
            <input type="submit" onclick="return doValidate();" value="Log In">
            <input type="submit" name="cancel" value="Cancel">
        </form>
    </div>
    <script>
    function doValidate() {
    console.log('Validating...');
    try {
        addr = document.getElementById('email').value;
        pw = document.getElementById('passw').value;
        console.log("Validating addr="+addr+" pw="+pw);
        if (addr == null || addr == "" || pw == null || pw == "") {
            alert("Both fields must be filled out");
            return false;
        }
        if ( addr.indexOf('@') == -1 ) {
            alert("Invalid email address");
            return false;
        }
        return true;
    } catch(e) {
        return false;
    }
    return false;
    }
</script>
</body>