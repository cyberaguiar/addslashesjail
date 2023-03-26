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
    // $username = mysqli_real_escape_string($conn, addslashes($_POST['username']));
    $username = addslashes($_POST['username']);
    $password = $_POST['password'];

    // build the query and execute it
    $sql = "SELECT * FROM users WHERE username = '".$username."'";
    echo "SQL query: $sql<br>"; // print the SQL command before executing it
    $result = mysqli_query($conn, $sql);

    // check if the query was successful
    if (!$result) {
        die('Error: ' . mysqli_error($conn));
    }

    // check if the username and password match
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row['password'] == $password) {
            echo 'ok';
        } else {
            echo 'password does not match';
        }
    } else {
        echo 'username not found';
    }

    // close the connection
    mysqli_close($conn);
} else {
    // if the request method is neither GET nor POST, display an error message
    echo 'Error: unsupported request method';
}
?>
