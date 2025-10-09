<?php
include 'inc/header.php';
?>

<div class="hero">
  <div class="swiper hero-swiper">
    <div class="swiper-wrapper">
      <div class="swiper-slide hero-slide">
        <img src="/lexagold/assets/image/1.webp" alt="گالری طلا Lexa - طرح‌های ویژه" />
        <div class="hero-caption">طرح‌های ویژه پاییز — <strong>کلکسیون جدید</strong></div>
      </div>
      <div class="swiper-slide hero-slide">
        <img src="/lexagold/assets/image/2.webp" alt="خرید آنلاین طلا - ارسال سریع" />
        <div class="hero-caption">ارسال سریع و بیمه مرسوله — <strong>خرید امن</strong></div>
      </div>
      <div class="swiper-slide hero-slide">
        <img src="/lexagold/assets/image/3.webp" alt="طراحی اختصاصی جواهرات" />
        <div class="hero-caption">سفارشی‌سازی انگشتر و گردنبند — <strong>طراحی اختصاصی</strong></div>
      </div>
    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-prev" aria-label="قبلی"></div>
    <div class="swiper-button-next" aria-label="بعدی"></div>
  </div>
</div>

<h2 class="section-title">محصولات منتخب</h2>
<div class="swiper products-swiper">
  <div class="swiper-wrapper">
    <div class="swiper-slide">
      <a class="product-card" href="/lexagold/pages/single-product.php?id=1">
        <img class="product-thumb" src="/lexagold/assets/image/product-1.jpg" alt="دستبند طلا زنانه" />
        <div class="product-info">
          <p class="product-name">دستبند ظریف طرح گندم</p>
          <div class="product-price">۷,۸۵۰,۰۰۰ تومان</div>
        </div>
      </a>
    </div>
    <div class="swiper-slide">
      <a class="product-card" href="/lexagold/pages/single-product.php?id=2">
        <img class="product-thumb" src="/lexagold/assets/image/product-2.jpg" alt="گردنبند طلا" />
        <div class="product-info">
          <p class="product-name">گردنبند لایت با پلاک قلب</p>
          <div class="product-price">۹,۳۲۰,۰۰۰ تومان</div>
        </div>
      </a>
    </div>
    <div class="swiper-slide">
      <a class="product-card" href="/lexagold/pages/single-product.php?id=3">
        <img class="product-thumb" src="/lexagold/assets/image/product-3.jpg" alt="انگشتر طلا" />
        <div class="product-info">
          <p class="product-name">انگشتر با نگین برلیان</p>
          <div class="product-price">۱۲,۴۰۰,۰۰۰ تومان</div>
        </div>
      </a>
    </div>
    <div class="swiper-slide">
      <a class="product-card" href="/lexagold/pages/single-product.php?id=4">
        <img class="product-thumb" src="/lexagold/assets/image/product-4.jpg" alt="گوشواره طلا" />
        <div class="product-info">
          <p class="product-name">گوشواره میخی طرح ستاره</p>
          <div class="product-price">۴,۹۰۰,۰۰۰ تومان</div>
        </div>
      </a>
    </div>
  </div>
  <div class="swiper-scrollbar"></div>
</div>

<h2 class="section-title">دسته‌بندی‌ها</h2>
<div class="categories-grid">
  <a class="cat-tile" href="/lexagold/pages/products.php?cat=bracelet" aria-label="دستبند">
    <img src="/lexagold/assets/image/category-bracelet.webp" alt="دسته‌بندی دستبند" />
    <span class="cat-label">دستبند</span>
  </a>
  <a class="cat-tile" href="/lexagold/pages/products.php?cat=necklace" aria-label="گردنبند">
    <img src="/lexagold/assets/image/category-necklace.webp" alt="دسته‌بندی گردنبند" />
    <span class="cat-label">گردنبند</span>
  </a>
  <a class="cat-tile" href="/lexagold/pages/products.php?cat=ring" aria-label="انگشتر">
    <img src="/lexagold/assets/image/category-ring.webp" alt="دسته‌بندی انگشتر" />
    <span class="cat-label">انگشتر</span>
  </a>
  <a class="cat-tile" href="/lexagold/pages/products.php?cat=earrings" aria-label="گوشواره">
    <img src="/lexagold/assets/image/category-earring.webp" alt="دسته‌بندی گوشواره" />
    <span class="cat-label">گوشواره</span>
  </a>
  <a class="cat-tile" href="/lexagold/pages/products.php?cat=set" aria-label="ست طلا">
    <img src="/lexagold/assets/image/category-set.webp" alt="دسته‌بندی ست" />
    <span class="cat-label">ست</span>
  </a>
  <a class="cat-tile" href="/lexagold/pages/products.php?cat=men" aria-label="طلا مردانه">
    <img src="/lexagold/assets/image/category-men.webp" alt="دسته‌بندی مردانه" />
    <span class="cat-label">مردانه</span>
  </a>
</div>

<?php
include 'inc/footer.php';
?>