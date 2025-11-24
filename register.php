<?php
require_once 'DBController.php';
// există un controller pentru baza de date
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Criptăm parola
    $db = new DBController();
    $query = "INSERT INTO users (username, password) VALUES (?, ?)";
    try {
        $db->updateDB($query, [$username, $password]);
        echo "Înregistrare reușită!";
    } catch (Exception $e) {
        echo "Eroare: " . $e->getMessage();
    }
}
?>
<form method="post">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit">Register</button>
</form>