<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>HiStore</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    .carousel {
      position: relative;
      width: 100%;
      max-width: 1000px;
      margin: auto;
      overflow: hidden;
      border-radius: 10px;
    }

    .carousel img {
      width: 100%;
      display: block;
    }

    .dots {
      text-align: center;
      padding: 10px;
    }

    .dot {
      height: 12px;
      width: 12px;
      margin: 0 5px;
      background-color: #bbb;
      border-radius: 50%;
      display: inline-block;
      transition: background-color 0.6s ease;
      cursor: pointer;
    }

    .active {
      background-color: #717171;
    }

    .products {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      padding: 20px;
    }

    .card {
      border: 1px solid #ccc;
      border-radius: 10px;
      padding: 15px;
      text-align: center;
      background: #fff;
      box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
    }

    .card img {
      max-width: 100%;
      height: auto;
      border-radius: 8px;
    }

    .btn {
      display: inline-block;
      margin-top: 10px;
      padding: 8px 12px;
      background: #007bff;
      color: white;
      text-decoration: none;
      border-radius: 5px;
    }

    .favorite-count {
      font-size: 14px;
      color: #666;
    }
  </style>
</head>
<body>
  <header>
    <?php include 'navbar.php'; ?>
  </header>

  <main>
    <!-- Carousel -->
    <div class="carousel">
      <img src="bc522d90-b946-4695-8a55-f9ed9e394214.png" alt="Isra Mi'raj Promo" />
      <div class="dots">
        <span class="dot active"></span>
        <span class="dot"></span>
        <span class="dot"></span>
      </div>
    </div>

    <!-- Produk -->
    <section class="products" id="productContainer">
      <!-- Produk dari API akan muncul di sini -->
    </section>
  </main>

  <!-- Fetch Produk -->
  <script>
    fetch('produk.php')
      .then(response => response.json())
      .then(data => {
        const container = document.getElementById('productContainer');
        container.innerHTML = "";

        data.forEach(p => {
          container.innerHTML += `
            <div class="card">
              <img src="${p.gambar}" alt="${p.nama}" />
              <h3>${p.nama}</h3>
              <p>Rp.${p.harga.toLocaleString()}</p>
              <p>Warna: ${p.warna}</p>
              <p>Kondisi: ${p.kondisi}</p>
              <p>Storage: ${p.storage}</p>
              <p>Seri: ${p.seri}</p>
              <a href="produk-detail.php?id=${p.id}" class="btn">Selengkapnya</a>
              <p class="favorite-count">💖 ${p.total_favorite} difavoritkan</p>
            </div>
          `;
        });
      });
  </script>

</body>
</html>
