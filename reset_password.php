<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require('server/connection.php');

// Your PHPMailer configuration
$mail = new PHPMailer(true); // true enables exceptions
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'liefalzaa@gmail.com';
$mail->Password = 'jnzw guiv sksl vcjy'; // Enter your Gmail password here
$mail->SMTPSecure = 'tls'; // Enable TLS encryption; `ssl` also accepted
$mail->Port = 587; // TCP port to connect to

$passwords_match = true; // Initialize passwords_match variable to true

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve token and new password from form
    $token = $_POST["token"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    // Verify if new password matches the confirmed password
    if ($new_password !== $confirm_password) {
        $passwords_match = false; // Set passwords_match to false if passwords don't match
    } else {
        // Retrieve the user's email address from the GET parameter
        $email = isset($_GET['email']) ? $_GET['email'] : '';

        // Update the user's password in the database
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_query = "UPDATE users SET password = '$hashed_password' WHERE email = '$email'";
        $update_result = mysqli_query($conn, $update_query);

        if ($update_result && mysqli_affected_rows($conn) > 0) {
            // Password successfully updated
            // Notify user of successful password reset
            $mail->setFrom('liefalzaa@gmail.com', 'Daffa');
            $mail->addAddress('liefalzaa@gmail.com', 'Daffa'); // Your email address

            $mail->Subject = 'Password Reset Successful';
            $mail->Body = 'Your password has been successfully reset.';

            if (!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                // Password successfully updated and email sent
                echo '<script>alert("Your password has been successfully reset."); window.location = "login.php";</script>';
                exit(); // Ensure that no further code is executed after the redirection
            }
        } else {
            echo 'Failed to update password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        .error-message {
            color: red;
            font-style: italic;
        }
    </style>
</head>

<body>
    <h2>Reset Password</h2>
    <?php if (!$passwords_match) : ?>
        <p class="error-message">Passwords do not match.</p>
    <?php endif; ?>
    <form action="" method="post">
        <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
        <label for="new_password">Enter your new password:</label><br>
        <input type="password" id="new_password" name="new_password" required><br>
        <label for="confirm_password">Confirm new password:</label><br>
        <input type="password" id="confirm_password" name="confirm_password" required><br>
        <button type="submit">Reset Password</button>
    </form>
</body>

</html>