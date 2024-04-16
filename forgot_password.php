<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// $mail->isSMTP();
// $mail->Host = 'smtp.gmail.com';
// $mail->SMTPAuth = true;
// $mail->Username = 'liefalzaa@gmail.com'; // Your Gmail email address
// $mail->Password = 'jnzw guiv sksl vcjy'; // Your Gmail password
// $mail->SMTPSecure = 'tls';
// $mail->Port = 587;


// Your PHPMailer configuration
$mail = new PHPMailer(true); // true enables exceptions
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'liefalzaa@gmail.com';
$mail->Password = 'jnzw guiv sksl vcjy';
$mail->SMTPSecure = 'tls'; // Enable TLS encryption; `ssl` also accepted
$mail->Port = 587; // TCP port to connect to

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve email address from form
    $email = $_POST["email"];

    // Generate a unique token
    $token = bin2hex(random_bytes(16));

    // Store the token in the database along with the user's email
    // Code for storing the token in the database goes here...

    // Send an email to the user with a link to reset their password
    $mail->setFrom('liefalzaa@gmail.com', 'Daffa');
    $mail->addAddress('liefalzaa@gmail.com', 'Daffa'); // Your email address

    $mail->Subject = 'Reset your password';
    $mail->Body = 'Click the following link to reset your password: http://localhost/griya/reset_password.php?token=' . $token . '&email=' . urlencode($email);

    if (!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'An email with instructions to reset your password has been sent to your email address.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>

<body>
    <h2>Forgot Password</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="email">Enter your email address:</label><br>
        <input type="email" id="email" name="email" required><br>
        <button type="submit">Reset Password</button>
    </form>
</body>

</html>