<?php
// check the request method
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // if the request method is GET, display the login form
    echo '<form method="post">';
    echo 'Username: <input type="text" name="username"><br>';
    echo 'Password: <input type="password" name="password"><br>';
    echo '<input type="submit" value="Login">';
    echo '</form>';
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // if the request method is POST, process the login request
    // connect to the database
    $dbhost = 'db';
    $dbuser = 'username';
    $dbpass = 'password';
    $dbname = 'database_name';
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    // check if the connection was successful
    if (!$conn) {
        die('Could not connect: ' . mysqli_connect_error());
    }

    // get the username and password from the POST parameters
    $username = mysqli_real_escape_string($conn, htmlspecialchars($_POST['username']));
    $password = $_POST['password'];

    // build the query and execute it using prepared statements
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // check if the query was successful
    if (!$result) {
        error_log('Error: ' . mysqli_error($conn));
        die('Invalid username or password');
    }

    // check if the username and password match
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            echo 'ok';
        } else {
            error_log('Invalid password for user ' . $username);
            die('Invalid username or password');
        }
    } else {
        error_log('User not found: '
