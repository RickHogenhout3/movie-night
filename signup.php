<?php
include 'config.php';

// Function to safely get user input
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$errors = []; // Array to store errors

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Generate a unique ID
    $unique_id = generateUniqueID();

    // Retrieve form data
    $username = test_input($_POST['username']);
    $password = test_input($_POST['password']);
    $email = test_input($_POST['email']);

    // Hash the password using BCRYPT
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    try {
        // Check if the username or email already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingUser) {
            $errors[] = "Username or email already exists. Please choose a different one.";
        } else {
            // Your SQL query using prepared statements to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO users (id, username, password_hash, email) 
                                    VALUES (?, ?, ?, ?)");

            // Execute the query with the provided values
            $stmt->execute([$unique_id, $username, $hashed_password, $email]);

            // Optionally, you can redirect the user to the login page after successful registration
            header("Location: login.php");
            exit();
        }
    } catch (PDOException $e) {
        $errors[] = "Error during registration: " . $e->getMessage();
    }

    // Close the connection (optional, as PDO closes automatically when the script ends)
    $conn = null;
}

// Function to generate a unique ID as a random number
function generateUniqueID() {
    // You can customize the logic for generating a unique ID based on your requirements
    return mt_rand(10000000, 99999999); // Adjust the range as needed
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <link rel="icon" type="image-x-icon" href="img/Screenshot_2023-11-15_124317-removebg-preview.png">
    <title>Inalink</title>
</head>
<body>
    <?php include 'header.php' ?> <br>
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

            <form method="post" onsubmit="return validateForm();">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                    <div class="field button">
                        <input type="submit" value="Continue to Chat">
                    </div>
                <p class="welcome">already have an account? then please <a href="login.php">login</a></p>
                </div>
            </form>
        </section>
    </div>
</body>
</html>
