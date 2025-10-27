<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Handle form submissions
$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'login') {
            // Handle login
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
            
            if (empty($email) || empty($password)) {
                $error_message = 'لطفاً تمام فیلدها را پر کنید';
            } else {
                // Simple authentication (you should implement proper database authentication)
                if ($email === 'admin@lexagold.com' && $password === '123456') {
                    $_SESSION['user_id'] = 1;
                    $_SESSION['user_email'] = $email;
                    $_SESSION['user_name'] = 'کاربر تست';
                    header('Location: /lexagold/');
                    exit;
                } else {
                    $error_message = 'ایمیل یا رمز عبور اشتباه است';
                }
            }
        } elseif ($_POST['action'] === 'register') {
            // Handle registration
            $name = trim($_POST['name']);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            
            if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
                $error_message = 'لطفاً تمام فیلدها را پر کنید';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error_message = 'لطفاً یک ایمیل معتبر وارد کنید';
            } elseif (strlen($password) < 6) {
                $error_message = 'رمز عبور باید حداقل ۶ کاراکتر باشد';
            } elseif ($password !== $confirm_password) {
                $error_message = 'رمز عبور و تکرار آن یکسان نیستند';
            } else {
                // Simple registration (you should implement proper database storage)
                $_SESSION['user_id'] = 2;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_name'] = $name;
                $success_message = 'ثبت نام با موفقیت انجام شد';
                // Redirect after 2 seconds
                echo '<script>setTimeout(function(){ window.location.href = "/lexagold/"; }, 2000);</script>';
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
  <link rel="stylesheet" href="/lexagold/assets/css/style.css" />
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='64' height='64' viewBox='0 0 64 64'%3E%3Cdefs%3E%3ClinearGradient id='g' x1='0' y1='0' x2='1' y2='1'%3E%3Cstop offset='0' stop-color='%23f7e9a8'/%3E%3Cstop offset='0.35' stop-color='%23d4af37'/%3E%3Cstop offset='0.7' stop-color='%23b9922e'/%3E%3Cstop offset='1' stop-color='%23f4d984'/%3E%3C/linearGradient%3E%3C/defs%3E%3Crect x='8' y='12' width='48' height='40' rx='10' fill='url(%23g)'/%3E%3C/svg%3E">
  <style>
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
    
    .btn-google {
      background: #fff;
      color: #333;
      border: 1px solid #ddd;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }
    
    .btn-google:hover {
      background: #f8f9fa;
      transform: translateY(-1px);
    }
    
    .google-icon {
      width: 20px;
      height: 20px;
    }
    
    .divider {
      text-align: center;
      margin: 20px 0;
      position: relative;
      color: var(--muted);
      font-size: 14px;
    }
    
    .divider::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 0;
      right: 0;
      height: 1px;
      background: var(--glass-stroke);
      z-index: 1;
    }
    
    .divider span {
      background: var(--bg-900);
      padding: 0 16px;
      position: relative;
      z-index: 2;
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
            <label class="form-label" for="login-email">ایمیل</label>
            <input type="email" id="login-email" name="email" class="form-input" placeholder="ایمیل خود را وارد کنید" required>
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
            <label class="form-label" for="register-password">رمز عبور</label>
            <input type="password" id="register-password" name="password" class="form-input" placeholder="رمز عبور خود را وارد کنید" required>
          </div>
          
          <div class="form-group">
            <label class="form-label" for="register-confirm-password">تکرار رمز عبور</label>
            <input type="password" id="register-confirm-password" name="confirm_password" class="form-input" placeholder="رمز عبور را مجدداً وارد کنید" required>
          </div>
          
          <button type="submit" class="btn btn-primary">ثبت نام</button>
        </form>

        <div class="divider">
          <span>یا</span>
        </div>

        <button class="btn btn-google" onclick="signInWithGoogle()">
          <svg class="google-icon" viewBox="0 0 24 24">
            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
          </svg>
          ورود با گوگل
        </button>
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
