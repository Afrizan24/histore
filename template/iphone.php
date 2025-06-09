<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>iPhone | HiStore</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <header>
  <?php include 'navbar.php';
  ?>
  </header>

  <main>
    <section class="filters">
      <button>Harga ↓</button>
      <button>Warna ↓</button>
      <button>Kondisi ↓</button>
      <button>Storage ↓</button>
      <button>Seri ↓</button>
    </section>

    <section class="products">
      <div class="card">
        <img src="images/iphone15pm.jpg" alt="iPhone 15 Pro Max" />
        <h3>iPhone 15 Pro Max</h3>
        <p>Rp.23.000.000</p>
        <a href="#" class="btn">Selengkapnya</a>
        <p class="favorite">18 terfavorite</p>
      </div>

      <div class="card">
        <img src="images/iphone14pro.webp" alt="iPhone 14 Pro" />
        <h3>iPhone 14 Pro</h3>
        <p>Rp.18.000.000</p>
        <a href="#" class="btn">Selengkapnya</a>
        <p class="favorite">14 terfavorite</p>
      </div>

      <div class="card">
        <img src="images/iphone13.jpg" alt="iPhone 13" />
        <h3>iPhone 13</h3>
        <p>Rp.13.000.000</p>
        <a href="#" class="btn">Selengkapnya</a>
        <p class="favorite">11 terfavorite</p>
      </div>

      <div class="card">
        <img src="images/iphone11.jpg" alt="iPhone 11" />
        <h3>iPhone 11</h3>
        <p>Rp.8.500.000</p>
        <a href="#" class="btn">Selengkapnya</a>
        <p class="favorite">9 terfavorite</p>
      </div>
    </section>
  </main>
</body>
</html>
