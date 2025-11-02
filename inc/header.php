<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!doctype html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lexa Gold</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
  <link rel="stylesheet" href="/lexagold/assets/css/style.css" />
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='64' height='64' viewBox='0 0 64 64'%3E%3Cdefs%3E%3ClinearGradient id='g' x1='0' y1='0' x2='1' y2='1'%3E%3Cstop offset='0' stop-color='%23f7e9a8'/%3E%3Cstop offset='0.35' stop-color='%23d4af37'/%3E%3Cstop offset='0.7' stop-color='%23b9922e'/%3E%3Cstop offset='1' stop-color='%23f4d984'/%3E%3C/linearGradient%3E%3C/defs%3E%3Crect x='8' y='12' width='48' height='40' rx='10' fill='url(%23g)'/%3E%3C/svg%3E">
</head>
<body>
  <div class="glass-header-wrap">
    <div class="container">
      <div class="glass-header">
        <div style="display: flex;gap: 40px;">
          <a href="/lexagold/" class="brand" aria-label="Lexa Gold Home">
            <span class="brand-mark" aria-hidden="true"></span>
            <span>
              <span class="brand-title">Lexa Gold</span>
              <span class="brand-sub">طلا و جواهر لکسا گلد</span>
            </span>
          </a>

          <nav class="nav" id="siteNav" aria-label="Main">
            <div style="display:flex;">
              <a href="/lexagold/" aria-label="صفحه اصلی">خانه</a>
              <a href="/lexagold/pages/products.php" aria-label="محصولات">محصولات</a>
              <a href="/lexagold/pages/about.php" aria-label="درباره ما">درباره</a>
            </div>
          </nav>
        </div>
        
        <nav class="nav" id="siteNav" aria-label="Main">
        <?php if (isset($_SESSION['user_name'])): ?>
            <a href="/lexagold/pages/account.php">
                حساب کاربری
            </a>
        <?php else: ?>
          <a href="/lexagold/auth.php">
            ورود / ثبت‌نام
          </a>
        <?php endif; ?>

          <span class="price-chip" id="gold18Chip" aria-live="polite" title="قیمت طلای 18 عیار">
            <span class="price-dot" aria-hidden="true"></span>
            <span>طلای ۱۸ عیار:</span>
            <span class="price-val" id="gold18Val">
                <?php
                    $curl = curl_init();
                    curl_setopt_array($curl, [
                    CURLOPT_URL => "https://api.alanchand.com/?type=golds&token=Rbx0KtfihFQSVZxPnF1X",
                    CURLOPT_RETURNTRANSFER => true,
                    ]);
                    $response = curl_exec($curl);
                    curl_close($curl);

                    $data = json_decode($response, true);

                    if (isset($data['18ayar']['price'])) {
                        echo number_format($data['18ayar']['price']) . " تومان";
                    } else {
                        echo "❌ اطلاعات قیمت در دسترس نیست.";
                    }
                ?>
            </span>
          </span>
        </nav>

        <button class="menu-toggle" id="navToggle" aria-label="باز و بسته کردن منو" aria-controls="siteNav" aria-expanded="false">☰</button>
      </div>
    </div>
  </div>
  <main class="container">