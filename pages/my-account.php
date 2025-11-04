<?php
session_start();

// بررسی وضعیت لاگین کاربر
if (!isset($_SESSION['user_id'])) { // فرض می‌کنیم user_id هنگام ورود ست می‌شود
    header("Location: /lexagold/auth.php");
    exit;
}

// لاگ‌اوت
if (isset($_POST['logout'])) {
    $_SESSION = [];
    session_destroy();
    header("Location: /lexagold/auth.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .logout-btn {
            width: 100%;
            padding: 14px 20px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: 'DoranFaNum', system-ui, sans-serif;
        }
        .logout-btn-primary {
            background: var(--gold-grad);
            color: #000;
            margin-bottom: 16px;
        }
        .logout-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(212,175,55,.3);
        }
    </style>
</head>
<body>

<?php include '../inc/header.php'; ?>

<h1>My Account</h1>
<form method="POST">
    <button type="submit" name="logout" class="logout-btn logout-btn-primary">خروج از حساب</button>
</form>

<?php include '../inc/footer.php'; ?>

</body>
</html>
