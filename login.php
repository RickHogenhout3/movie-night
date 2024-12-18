<?php
// Include the configuration file to initialize the database connection
include_once "config.php";

// Start the session if it's not already active
if (session_status() === PHP_SESSION_NONE) {
    session_name('unieke_sessie_naam');
    session_start();
}

$errors = []; // Array to store errors

// Function to safely sanitize user input
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $emailOrUsername = test_input($_POST['emailOrUsername']);
    $password = test_input($_POST['password']);

    try {
        // Check if the user exists in the database
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email OR username = :username");
        $stmt->execute([
            ':email' => $emailOrUsername,
            ':username' => $emailOrUsername,
        ]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verify the provided password against the hashed password in the database
            if (password_verify($password, $user['password_hash'])) {
                // Password is correct, log the user in

                // Regenerate the session ID for security
                session_regenerate_id(true);

                // Set session variables
                $_SESSION['loggedin'] = true;
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // Immediately save session variables
                session_write_close();

                // Redirect to the homepage or another page
                header("Location: index.php");
                exit();
            } else {
                $errors[] = "Incorrect password. Please try again.";
            }
        } else {
            $errors[] = "User not found. Check your email/username and try again.";
        }
    } catch (PDOException $e) {
        $errors[] = "Error during login: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>Movie Night</title>
</head>
<body>
<?php include_once "header.php"; ?>
<div class="wrapper">
    <section class="form signup container">
        <?php
        // Display errors in red text
        if (!empty($errors)) {
            echo '<div class="errors text-center" style="color: red; font-weight: bold;">';
            foreach ($errors as $error) {
                echo $error . '<br>';
            }
            echo '</div>';
        }
        ?>
        <form action="login.php" method="post">
            <div class="field input">
                <label for="emailOrUsername">Email or Username</label>
                <input type="text" name="emailOrUsername" placeholder="Email or Username" required>
            </div>
            <div class="field input">
                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="field button">
                <input type="submit" value="Continue to Chat">
            </div>
            <p class="welcome">No account yet? Then please <a href="signup.php">signup</a></p>
        </form>
    </section>
</div>
</body>
</html>
