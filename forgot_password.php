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
$message = '';
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
        $message = ' Email dengan instruksi untuk me-reset password telah dikirim ke email anda sesuai dari email yang telah didaftarkan.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 2rem;
            align-items: center;
            height: 100vh;
        }

        .forgot-password-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            text-align: center;
        }

        .forgot-password-container h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .forgot-password-form input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .forgot-password-form button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .forgot-password-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <?php if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') echo $message; ?>
    <div class="forgot-password-container">
        <h2>Forgot Password</h2>
        <form class="forgot-password-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="email">Enter your email address:</label><br>
            <input type="email" id="email" name="email" required><br>
            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>

</html>