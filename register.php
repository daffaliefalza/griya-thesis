<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        button {
            width: calc(100% - 20px);
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            height: 48px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        button:focus {
            outline: none;
            border-color: #007bff;
        }

        input::placeholder {
            color: #999;
        }

        ::-webkit-input-placeholder {
            color: #999;
        }

        :-ms-input-placeholder {
            color: #999;
        }

        :-moz-placeholder {
            color: #999;
        }

        ::placeholder {
            color: #999;
        }
    </style>
</head>

<body>

    <div style="position: absolute; left: 1rem; top: 3rem;">
        <a href="produk.php">Kembali</a>
    </div>

    <form action="register_process.php" method="post">
        <label>Username</label>
        <input type="text" name="username" placeholder="Username" required>
        <label>Nama Lengkap</label>
        <input type="text" name="fullname" required>
        <label>Email</label>

        <input type="email" name="email" placeholder="Email" required>
        <label>Password</label>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="register">Daftar</button>
        <span>Wah udah punya akun kak? </span>
        <a href="login.php">Login</a>
    </form>
</body>

</html>