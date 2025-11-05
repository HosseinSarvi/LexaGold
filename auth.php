<?php 
#---DataBase Connection---
$pdo = new pdo("mysql:host=localhost;dbname=lexadb;charset=utf8mb4","root","");

// $emailyamobile = "09154826763"
// $sql = "SELECT id FROM users WHERE username = ?";
// $stmt = $pdo->prepare($sql);
// $stmt->execute();
// $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
// // نمایش کاربران
// foreach ($users as $user) {
//     echo "ID: {$user['id']}, Email: {$user['email']}, Phone: {$user['phone']}<br>";
// }
?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Handle form submissions
$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        #---login---
        if ($_POST['action'] === 'login') {
          $identifier = trim($_POST['email']); // کاربر می‌تونه ایمیل یا شماره وارد کنه
          $password = $_POST['password'];
          
          if (empty($identifier) || empty($password)) {
              $error_message = 'لطفاً تمام فیلدها را پر کنید';
          } else {
              // تشخیص اینکه کاربر ایمیل وارد کرده یا شماره
              if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
                  $query = "SELECT * FROM users WHERE email = ?";
              } else {
                  $query = "SELECT * FROM users WHERE phone = ?";
              }
      
              $stmt = $pdo->prepare($query);
              $stmt->execute([$identifier]);
              $user = $stmt->fetch(PDO::FETCH_ASSOC);          

              if ($user && password_verify($password, $user['password'])) {
                  // ورود موفق
                  $_SESSION['user_id'] = $user['id'];
                  $_SESSION['user_email'] = $user['email'];
                  $_SESSION['user_name'] = $user['username']; // یا هر ستونی که داری
                  
                  header('Location: /');
                  exit;
              } else {
                  $error_message = 'ایمیل، شماره یا رمز عبور اشتباه است';
              }
          }
      }
      
        #---register---
        elseif ($_POST['action'] === 'register') {
          if (!empty($_POST['website'])) {
              die("پات رو گذاشتی رو عسلا");
          }
      
          $fullname = trim($_POST['name']); // این فیلد از فرم ثبت‌نام میاد
          $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
          $password = $_POST['password'];
          $confirm_password = $_POST['confirm_password'];
          $phone = $_POST['phone'];
      
          if (empty($fullname) || empty($email) || empty($password) || empty($confirm_password)) {
              $error_message = 'لطفاً تمام فیلدها را پر کنید';
          } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              $error_message = 'ایمیل معتبر نیست';
          } elseif (strlen($password) < 6) {
              $error_message = 'رمز عبور باید حداقل ۶ کاراکتر باشد';
          } elseif (strlen($phone) != 11) {
              $error_message = 'شماره همراه معتبر نیست';
          } elseif ($password !== $confirm_password) {
              $error_message = 'رمز عبور و تکرار آن یکسان نیستند';
          } else {
              // بررسی تکراری نبودن ایمیل یا شماره
              $check = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email OR phone = :phone");
              $check->execute(['email' => $email, 'phone' => $phone]);
              if ($check->fetchColumn() > 0) {
                  $error_message = 'کاربری با این ایمیل یا شماره همراه وجود دارد';
              } else {
                  // درج در دیتابیس
                  $sql = "INSERT INTO users (username, email, phone, password, created_at, status)
                          VALUES (:username, :email, :phone, :password, NOW(), :status)";
                  $stmt = $pdo->prepare($sql);
      
                  $stmt->bindValue(':username', $fullname, PDO::PARAM_STR);
                  $stmt->bindValue(':email', $email, PDO::PARAM_STR);
                  $stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
                  $stmt->bindValue(':password', password_hash($confirm_password, PASSWORD_DEFAULT), PDO::PARAM_STR);
                  $stmt->bindValue(':status', 0, PDO::PARAM_INT);
      
                  $stmt->execute();
      
                  $_SESSION['user_id'] = $pdo->lastInsertId();
                  $_SESSION['user_email'] = $email;
                  $_SESSION['user_name'] = $fullname;
      
                  $success_message = 'ثبت نام با موفقیت انجام شد';
                  echo '<script>setTimeout(function(){ window.location.href = "/"; }, 1000);</script>';
              }
          }
        }
    }
}
?>

<!doctype html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ورود و ثبت نام - Lexa Gold</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
  <link rel="stylesheet" href="./assets/css/style.css" />
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='64' height='64' viewBox='0 0 64 64'%3E%3Cdefs%3E%3ClinearGradient id='g' x1='0' y1='0' x2='1' y2='1'%3E%3Cstop offset='0' stop-color='%23f7e9a8'/%3E%3Cstop offset='0.35' stop-color='%23d4af37'/%3E%3Cstop offset='0.7' stop-color='%23b9922e'/%3E%3Cstop offset='1' stop-color='%23f4d984'/%3E%3C/linearGradient%3E%3C/defs%3E%3Crect x='8' y='12' width='48' height='40' rx='10' fill='url(%23g)'/%3E%3C/svg%3E">
  <style>
    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
    }

    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh; /* حداقل ارتفاع کل صفحه */
    }

    main.container {
      flex: 1; /* فضای باقی‌مانده بین هدر و فوتر را پر می‌کند */
    }
    .auth-container {
      max-width: 450px;
      margin: 60px auto;
      padding: 0 20px;
    }
    
    .auth-card {
      background: linear-gradient(0deg, rgba(0,0,0,.25), rgba(0,0,0,.25)), var(--glass-bg);
      border: 1px solid var(--glass-stroke);
      border-radius: 20px;
      padding: 40px 30px;
      box-shadow: var(--shadow);
      backdrop-filter: saturate(140%) blur(16px);
      -webkit-backdrop-filter: saturate(140%) blur(16px);
    }
    
    .auth-tabs {
      display: flex;
      margin-bottom: 30px;
      background: rgba(255,255,255,.05);
      border-radius: 12px;
      padding: 4px;
    }
    
    .auth-tab {
      flex: 1;
      padding: 12px 16px;
      text-align: center;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.2s ease;
      color: var(--muted);
      font-weight: 500;
    }
    
    .auth-tab.active {
      background: var(--gold-grad);
      color: #000;
      font-weight: 700;
    }
    
    .auth-form {
      display: none;
    }
    
    .auth-form.active {
      display: block;
    }
    
    .form-group {
      margin-bottom: 20px;
    }
    
    .form-label {
      display: block;
      margin-bottom: 8px;
      color: var(--text);
      font-weight: 500;
      font-size: 14px;
    }
    
    .form-input {
      width: 100%;
      padding: 14px 16px;
      border: 1px solid var(--glass-stroke);
      border-radius: 12px;
      background: rgba(255,255,255,.05);
      color: var(--text);
      font-size: 16px;
      transition: all 0.2s ease;
      font-family: 'DoranFaNum', system-ui, sans-serif;
    }
    
    .form-input:focus {
      outline: none;
      border-color: var(--gold-500);
      background: rgba(255,255,255,.08);
      box-shadow: 0 0 0 3px rgba(212,175,55,.1);
    }
    
    .form-input::placeholder {
      color: var(--muted);
    }
    
    .btn {
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
    
    .btn-primary {
      background: var(--gold-grad);
      color: #000;
      margin-bottom: 16px;
    }
    
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(212,175,55,.3);
    }
    
    .alert {
      padding: 12px 16px;
      border-radius: 10px;
      margin-bottom: 20px;
      font-size: 14px;
    }
    
    .alert-error {
      background: rgba(220, 53, 69, 0.1);
      border: 1px solid rgba(220, 53, 69, 0.3);
      color: #ff6b6b;
    }
    
    .alert-success {
      background: rgba(40, 167, 69, 0.1);
      border: 1px solid rgba(40, 167, 69, 0.3);
      color: #51cf66;
    }
    
    .forgot-password {
      text-align: center;
      margin-top: 16px;
    }
    
    .forgot-password a {
      color: var(--gold-500);
      text-decoration: none;
      font-size: 14px;
    }
    
    .forgot-password a:hover {
      text-decoration: underline;
    }
    
    @media (max-width: 480px) {
      .auth-container {
        margin: 40px auto;
        padding: 0 16px;
      }
      
      .auth-card {
        padding: 30px 20px;
        margin: 0px -30px;
      }
    }
  </style>
</head>
<body>
  <?php
    include 'inc/header.php';
  ?>
  <main class="container">
    <div class="auth-container">
      <div class="auth-card">
        <div class="auth-tabs">
          <div class="auth-tab active" data-tab="login">ورود</div>
          <div class="auth-tab" data-tab="register">ثبت نام</div>
        </div>

          <?php if ($error_message): ?>
            <div class="alert alert-error"><?php echo $error_message; ?></div>
          <?php endif; ?>

          <?php if ($success_message): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
          <?php endif; ?>

          <!-- Login Form -->
          <form class="auth-form active" id="loginForm" method="POST">
            <input type="hidden" name="action" value="login">
            
            <div class="form-group">
              <label class="form-label" for="login-email">ایمیل/شماره همراه</label>
              <input type="text" id="login-email" name="email" class="form-input" placeholder="ایمیل/شماره همراه خود را وارد کنید" required>
            </div>
            
            <div class="form-group">
              <label class="form-label" for="login-password">رمز عبور</label>
              <input type="password" id="login-password" name="password" class="form-input" placeholder="رمز عبور خود را وارد کنید" required>
            </div>
            
            <button type="submit" class="btn btn-primary">ورود</button>
            
            <div class="forgot-password">
              <a href="#" onclick="alert('این قابلیت به زودی اضافه خواهد شد')">فراموشی رمز عبور؟</a>
            </div>
          </form>

          <!-- Register Form -->
          <form class="auth-form" id="registerForm" method="POST">
            <input type="hidden" name="action" value="register">
            
            <div class="form-group">
              <label class="form-label" for="register-name">نام و نام خانوادگی</label>
              <input type="text" id="register-name" name="name" class="form-input" placeholder="نام و نام خانوادگی خود را وارد کنید" required>
            </div>
            
            <div class="form-group">
              <label class="form-label" for="register-email">ایمیل</label>
              <input type="email" id="register-email" name="email" class="form-input" placeholder="ایمیل خود را وارد کنید" required>
            </div>

            <div class="form-group">
              <label class="form-label" for="register-phone">شماره همراه</label>
              <input type="text" id="register-phone" name="phone" class="form-input" placeholder="شماره همراه خود را وارد کنید" required>
            </div>
            
            <div class="form-group">
              <label class="form-label" for="register-password">رمز عبور</label>
              <input type="password" id="register-password" name="password" class="form-input" placeholder="رمز عبور خود را وارد کنید" required>
            </div>
            
            <div class="form-group">
              <label class="form-label" for="register-confirm-password">تکرار رمز عبور</label>
              <input type="password" id="register-confirm-password" name="confirm_password" class="form-input" placeholder="رمز عبور را مجدداً وارد کنید" required>
            </div>

            <div style="display:none;">
              <label>اینجا عسل ریخته</label>
              <input type="text" name="website" value="">
            </div>
            
            <button type="submit" class="btn btn-primary">ثبت نام</button>
          </form>
        </div>
      </div>
    </div>
  </main>

  <?php
    include 'inc/footer.php';
  ?>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // --- Tab switching ---
    const tabs = document.querySelectorAll('.auth-tab');
    const forms = document.querySelectorAll('.auth-form');

    tabs.forEach(tab => {
      tab.addEventListener('click', function() {
        // Remove active from all tabs and forms
        tabs.forEach(t => t.classList.remove('active'));
        forms.forEach(f => f.classList.remove('active'));

        // Activate clicked tab and corresponding form
        this.classList.add('active');
        const targetForm = document.getElementById(this.dataset.tab + 'Form');
        if(targetForm) targetForm.classList.add('active');
      });
    });

    // --- Keep tab after POST ---
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])): ?>
      const action = "<?php echo $_POST['action']; ?>";
      tabs.forEach(t => t.classList.remove('active'));
      forms.forEach(f => f.classList.remove('active'));
      const activeTab = document.querySelector('.auth-tab[data-tab="'+action+'"]');
      const activeForm = document.getElementById(action+'Form');
      if(activeTab) activeTab.classList.add('active');
      if(activeForm) activeForm.classList.add('active');
    <?php endif; ?>

    // --- Register form validation ---
    const registerForm = document.getElementById('registerForm');
    if(registerForm){
      registerForm.addEventListener('submit', function(e) {
        const password = document.getElementById('register-password').value;
        const confirmPassword = document.getElementById('register-confirm-password').value;

        if(password !== confirmPassword){
          e.preventDefault();
          alert('رمز عبور و تکرار آن یکسان نیستند');
          return false;
        }
      });
    }

    // --- Google login placeholder ---
    window.signInWithGoogle = function() {
      alert('ورود با گوگل به زودی فعال خواهد شد');
    }

    // --- Mobile menu toggle ---
    const navToggle = document.getElementById('navToggle');
    const siteNav = document.getElementById('siteNav');
    if(navToggle && siteNav){
      navToggle.addEventListener('click',()=>{
        siteNav.classList.toggle('open');
        const expanded = navToggle.getAttribute('aria-expanded') === 'true';
        navToggle.setAttribute('aria-expanded', String(!expanded));
      });
    }

  });
</script>

</body>
</html>
