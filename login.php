<?php
if (isset($_POST['submit'])) {
     // Include your database connection script

    // Get the username and password from the POST request and sanitize them
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // Prepare a SQL statement to find the user by username
    $sql = "SELECT * FROM loginpr WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user with the given username exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the password with the hash stored in the database
        if (password_verify($password, $row['password'])) {
            // If the password is correct, display a success message
            echo "Login successful! Welcome, " . htmlspecialchars($username) . ".";
            // Here you can start a session or redirect the user to another page
        } else {
            // If the password is incorrect, display a failure message
            echo "Login failed! Incorrect password.";
        }
    } else {
        // If no user with the given username is found, display a failure message
        echo "Login failed! Username not found.";
    }

    // Close the statement and the database connection
    $stmt->close();
    mysqli_close($conn);
}
?>
