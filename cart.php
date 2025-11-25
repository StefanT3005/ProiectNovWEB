<?php
session_start();
require_once 'DBController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$db = new DBController();
$member_id = (int)$_SESSION['user_id'];

$cart_items = $db->getDBResult(
    "SELECT p.name, p.price, c.quantity, c.id
     FROM tbl_cart c
     JOIN tbl_product p ON c.product_id = p.id
     WHERE c.member_id = ?",
    [$member_id]
);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Cos de cumparaturi</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background: #1e1e1e;
            padding: 15px;
            display: flex;
            gap: 20px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 8px 12px;
        }

        .navbar a:hover {
            background: #333333;
            border-radius: 4px;
        }

        .content {
            padding: 20px;
        }
    </style>
</head>

<body>

    <div class="navbar">
        <a href="home.php">Acasa</a>
        <a href="vizualizare.php">Vizualizare Produse</a>
        <a href="index.php">Adaugare Produse In Cos</a>
        <a href="cart.php">Cos Cumparaturi</a>
        <a href="logout.php">Logout</a>
        <a href="register.php">Register</a>
    </div>

    <div class="content">
        <h2>Vizualizeaza cosul de cumparaturi!</h2>

        <h1>Cos de cumparaturi</h1>

        <?php if (empty($cart_items)) : ?>
            <p>Cosul tau este gol.</p>
        <?php else : ?>
            <?php foreach ($cart_items as $item) : ?>
                <div>
                    <?php
                    echo htmlspecialchars($item['name'])
                        . " - $" . htmlspecialchars($item['price'])
                        . " x " . (int)$item['quantity'];
                    ?>
                    <a href="removeFromCart.php?cart_id=<?php echo (int)$item['id']; ?>">Scoate</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <br>
        <a href="emptyCart.php">Goleste cosul</a>
    </div>

</body>

</html>