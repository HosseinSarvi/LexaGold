    </main>
    <footer class="container" style="padding:28px 0;justify-self: center;color:#9a9a9a;font-size:13px;border-top:1px solid rgba(255,255,255,.08)">
      © <?php echo date('Y'); ?> Lexa Gold — همه حقوق محفوظ است.
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
      const navToggle = document.getElementById('navToggle');
      const siteNav = document.getElementById('siteNav');
      if(navToggle && siteNav){
        navToggle.addEventListener('click',()=>{
          siteNav.classList.toggle('open');
          const expanded = navToggle.getAttribute('aria-expanded') === 'true';
          navToggle.setAttribute('aria-expanded', String(!expanded));
        });
      }

      if (typeof Swiper !== 'undefined'){
        new Swiper('.hero-swiper',{
          loop:true,
          autoplay:{ delay:3500, disableOnInteraction:false },
          pagination:{ el:'.hero-swiper .swiper-pagination', clickable:true },
          navigation:{ nextEl:'.hero-swiper .swiper-button-next', prevEl:'.hero-swiper .swiper-button-prev' }
        });

        new Swiper('.products-swiper',{
          slidesPerView:2.2,
          spaceBetween:12,
          breakpoints:{
            640:{ slidesPerView:3, spaceBetween:14 },
            820:{ slidesPerView:4, spaceBetween:16 },
            1024:{ slidesPerView:5, spaceBetween:16 }
          },
          scrollbar:{ el:'.products-swiper .swiper-scrollbar', draggable:true }
        });
      }
    </script>
  </body>
  </html>

