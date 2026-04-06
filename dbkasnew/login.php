<?php
session_start();
$server = "localhost";
$user   = "root";
$pass   = "";
$db     = "dbkasnew";
$con = mysqli_connect($server, $user, $pass, $db);
if (!$con) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
    $data  = mysqli_fetch_assoc($query);
    if ($data && password_verify($password, $data['password'])) {
        $_SESSION['login'] = true;
        $_SESSION['username'] = $data['username'];
        header("Location: projek.php");
        exit;
    } else {
        $error = "Username atau Password salah";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background-color: #1e90ff;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }
        .login-box {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            width: 320px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        h1 {
            margin-bottom: 25px;
            color: #1e90ff;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #1e90ff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #0f6fd6;
        }
        .error {
            margin-top: 15px;
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="login-box">
    <h1>Login kas Gadget</h1>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>
    <?php
    if (isset($error)) {
        echo "<div class='error'>$error</div>";
    }
    ?>
</div>
</body>
</html>