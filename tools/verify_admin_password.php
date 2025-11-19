<?php
$dsn = 'mysql:host=127.0.0.1;port=3306;dbname=db_myfurniture';
$user = 'root';
$pass = '';
$email = 'admin@example.com';
$try = 'password';
try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $stmt = $pdo->prepare('SELECT password FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        echo "NO USER\n";
        exit;
    }
    $hash = $row['password'];
    $ok = password_verify($try, $hash);
    echo json_encode(['email'=>$email, 'password_is'=>'password', 'matches'=>$ok], JSON_PRETTY_PRINT);
} catch (Exception $e) {
    echo 'ERROR: ' . $e->getMessage();
}
