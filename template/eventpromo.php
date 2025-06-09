<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Event & Promo | HiStore</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    /* Tambahan styling khusus untuk harga promo */
    .price-normal {
      text-decoration: line-through;
      color: gray;
      margin-right: 10px;
    }
    .price-promo {
      color: #e63946; /* merah promo */
      font-weight: bold;
    }
  </style>
</head>
<body>
  <header>
  <?php include 'navbar.php';
  ?>
  </header>

  <main>
    <section class="filters">
      <button>Harga ↓</button>
      <button>Kategori ↓</button>
      <button>Diskon ↓</button>
    </section>

    <section class="products">
      <div class="card">
        <img src="images/ipadpro12.png" alt="iPad Pro 12.9 inch" />
        <h3>iPad Pro 12.9” M2</h3>
        <p>
          <span class="price-normal">Rp.20.000.000</span>
          <span class="price-promo">Rp.17.500.000</span>
        </p>
        <a href="#" class="btn">Selengkapnya</a>
        <p class="favorite">25 terfavorite</p>
      </div>

      <div class="card">
        <img src="images/iphone14.png" alt="iPhone 14" />
        <h3>iPhone 14</h3>
        <p>
          <span class="price-normal">Rp.15.000.000</span>
          <span class="price-promo">Rp.13.200.000</span>
        </p>
        <a href="#" class="btn">Selengkapnya</a>
        <p class="favorite">30 terfavorite</p>
      </div>

      <div class="card">
        <img src="images/airpodspro.png" alt="AirPods Pro" />
        <h3>AirPods Pro</h3>
        <p>
          <span class="price-normal">Rp.4.000.000</span>
          <span class="price-promo">Rp.3.300.000</span>
        </p>
        <a href="#" class="btn">Selengkapnya</a>
        <p class="favorite">40 terfavorite</p>
      </div>

      <div class="card">
        <img src="images/macbookair.png" alt="MacBook Air M2" />
        <h3>MacBook Air M2</h3>
        <p>
          <span class="price-normal">Rp.18.000.000</span>
          <span class="price-promo">Rp.16.000.000</span>
        </p>
        <a href="#" class="btn">Selengkapnya</a>
        <p class="favorite">20 terfavorite</p>
      </div>
    </section>
  </main>
</body>
</html>
