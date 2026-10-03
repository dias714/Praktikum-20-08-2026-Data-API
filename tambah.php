<?php

require_once "koneksi.php";

$pesan = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"]);
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $street = trim($_POST["street"]);
    $suite = trim($_POST["suite"]);
    $city = trim($_POST["city"]);
    $zipcode = trim($_POST["zipcode"]);

    if (
        $name === "" ||
        $username === "" ||
        $email === "" ||
        $street === "" ||
        $city === "" ||
        $zipcode === ""
    ) {

        $pesan = "Data wajib diisi.";

    } else {

        $stmt = $koneksi->prepare("
            INSERT INTO users
            (name, username, email, street, suite, city, zipcode)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "sssssss",
            $name,
            $username,
            $email,
            $street,
            $suite,
            $city,
            $zipcode
        );

        if ($stmt->execute()) {
            header("Location: index.html");
            exit;
        } else {
            $pesan = "Gagal menambahkan data.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">

    <title>Tambah Data</title>

    <style>

        body {
            font-family: Arial;
            background: #f5f7fb;
            padding: 30px;
        }

        .form-box {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,.08);
        }

        h2 {
            margin-top: 0;
        }

        label {
            display: block;
            margin-top: 12px;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button,
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
        }

        button {
            background: #198754;
            color: white;
        }

        a {
            background: #6c757d;
            color: white;
        }

        .error {
            color: red;
        }

    </style>

</head>

<body>

<div class="form-box">

    <h2>Tambah Data User</h2>

    <?php if ($pesan !== ""): ?>
        <p class="error">
            <?= htmlspecialchars($pesan) ?>
        </p>
    <?php endif; ?>

    <form method="POST">

        <label>Nama</label>
        <input type="text" name="name" required>

        <label>Username</label>
        <input type="text" name="username" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Street</label>
        <input type="text" name="street" required>

        <label>Suite</label>
        <input type="text" name="suite">

        <label>City</label>
        <input type="text" name="city" required>

        <label>Zipcode</label>
        <input type="text" name="zipcode" required>

        <button type="submit">
            Simpan
        </button>

        <a href="index.html">
            Kembali
        </a>

    </form>

</div>

</body>
</html>