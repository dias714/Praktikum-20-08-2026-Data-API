<?php

require_once "koneksi.php";

if (!isset($_GET["id"])) {
    die("ID tidak ditemukan.");
}

$id = (int) $_GET["id"];

$stmt = $koneksi->prepare("
    SELECT *
    FROM users
    WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Data tidak ditemukan.");
}

$data = $result->fetch_assoc();

$pesan = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"]);
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $street = trim($_POST["street"]);
    $suite = trim($_POST["suite"]);
    $city = trim($_POST["city"]);
    $zipcode = trim($_POST["zipcode"]);

    $stmt = $koneksi->prepare("
        UPDATE users
        SET
            name = ?,
            username = ?,
            email = ?,
            street = ?,
            suite = ?,
            city = ?,
            zipcode = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "sssssssi",
        $name,
        $username,
        $email,
        $street,
        $suite,
        $city,
        $zipcode,
        $id
    );

    if ($stmt->execute()) {

        header("Location: index.html");
        exit;

    } else {

        $pesan = "Gagal mengubah data.";
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Edit Data</title>

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
            background: #ffc107;
            color: black;
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

    <h2>Edit Data User</h2>

    <?php if ($pesan !== ""): ?>

        <p class="error">
            <?= htmlspecialchars($pesan) ?>
        </p>

    <?php endif; ?>

    <form method="POST">

        <label>Nama</label>

        <input
            type="text"
            name="name"
            value="<?= htmlspecialchars($data['name']) ?>"
            required
        >

        <label>Username</label>

        <input
            type="text"
            name="username"
            value="<?= htmlspecialchars($data['username']) ?>"
            required
        >

        <label>Email</label>

        <input
            type="email"
            name="email"
            value="<?= htmlspecialchars($data['email']) ?>"
            required
        >

        <label>Street</label>

        <input
            type="text"
            name="street"
            value="<?= htmlspecialchars($data['street']) ?>"
            required
        >

        <label>Suite</label>

        <input
            type="text"
            name="suite"
            value="<?= htmlspecialchars($data['suite']) ?>"
        >

        <label>City</label>

        <input
            type="text"
            name="city"
            value="<?= htmlspecialchars($data['city']) ?>"
            required
        >

        <label>Zipcode</label>

        <input
            type="text"
            name="zipcode"
            value="<?= htmlspecialchars($data['zipcode']) ?>"
            required
        >

        <button type="submit">
            Simpan Perubahan
        </button>

        <a href="index.html">
            Kembali
        </a>

    </form>

</div>

</body>
</html>