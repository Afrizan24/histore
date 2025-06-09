<?php include 'navbar.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Produk | HiStore</title>
  <style>
    .product-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      padding: 20px;
    }
    .card {
      width: 250px;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 15px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .card img {
      width: 100%;
      height: 180px;
      object-fit: contain;
      border-radius: 5px;
      margin-bottom: 10px;
    }
    .btn {
      display: inline-block;
      padding: 8px 15px;
      background-color: #4CAF50;
      color: white;
      text-decoration: none;
      border-radius: 4px;
      margin-top: 10px;
    }
    .btn-favorite {
      padding: 8px 12px;
      background-color: #f8f9fa;
      border: 1px solid #ddd;
      border-radius: 5px;
      cursor: pointer;
      margin-top: 8px;
      transition: all 0.3s;
      width: 100%;
    }
    .btn-favorite:hover {
      background-color: #ffebee;
      border-color: #f44336;
      color: #f44336;
    }
    .btn-favorite.active {
      background-color: #f44336;
      color: white;
      border-color: #f44336;
    }
    .favorite {
      color: #f44336;
      font-size: 14px;
      margin-top: 5px;
    }
  </style>
</head>
<body>
  <h1>Daftar Produk</h1>
  
  <div class="product-container">
    <!-- Produk 1 -->
    <div class="card" data-product-id="prod001">
      <img src="images/ipadpro11.jpg" alt="iPad Pro 11 inch">
      <h3>iPad Pro 11” M2</h3>
      <p>Rp.15.000.000</p>
      <a href="ipad/ipadpro11.php" class="btn">Selengkapnya</a>
      <button class="btn-favorite" onclick="addToFavorites(this)">
        ❤️ Tambah ke Favorit
      </button>
      <p class="favorite">12 terfavorite</p>
    </div>
    
    <!-- Produk 2 -->
    <div class="card" data-product-id="prod002">
      <img src="images/macbook-air.jpg" alt="MacBook Air">
      <h3>MacBook Air M1</h3>
      <p>Rp.12.500.000</p>
      <a href="mac/macbook-air.php" class="btn">Selengkapnya</a>
      <button class="btn-favorite" onclick="addToFavorites(this)">
        ❤️ Tambah ke Favorit
      </button>
      <p class="favorite">8 terfavorite</p>
    </div>
    
    <!-- Tambahkan produk lainnya di sini -->
  </div>

  <script>
    // Fungsi untuk menambah ke favorit
    function addToFavorites(button) {
      const card = button.closest('.card');
      const product = {
        id: card.getAttribute('data-product-id'),
        name: card.querySelector('h3').textContent,
        price: card.querySelector('p').textContent.replace('Rp.', '').replace('.', '').trim(),
        img: card.querySelector('img').src
      };

      let favorites = JSON.parse(localStorage.getItem('favorites')) || [];
      
      // Cek apakah produk sudah ada di favorit
      const existingIndex = favorites.findIndex(item => item.id === product.id);
      
      if (existingIndex === -1) {
        // Tambahkan ke favorit
        favorites.push(product);
        button.textContent = '❤️ Favorit';
        button.classList.add('active');
      } else {
        // Hapus dari favorit
        favorites.splice(existingIndex, 1);
        button.textContent = '❤️ Tambah ke Favorit';
        button.classList.remove('active');
      }
      
      localStorage.setItem('favorites', JSON.stringify(favorites));
      
      // Update counter favorit
      updateFavoriteCount();
    }

    // Fungsi untuk memeriksa status favorit saat halaman dimuat
    function checkFavoriteStatus() {
      const favorites = JSON.parse(localStorage.getItem('favorites')) || [];
      
      document.querySelectorAll('.card').forEach(card => {
        const productId = card.getAttribute('data-product-id');
        const favoriteButton = card.querySelector('.btn-favorite');
        
        if (favorites.some(item => item.id === productId)) {
          favoriteButton.textContent = '❤️ Favorit';
          favoriteButton.classList.add('active');
        }
      });
    }

    // Fungsi untuk update counter favorit
    function updateFavoriteCount() {
      const favorites = JSON.parse(localStorage.getItem('favorites')) || [];
      const counter = document.getElementById('favorite-count');
      if (counter) {
        counter.textContent = favorites.length;
      }
    }

    // Panggil saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
      checkFavoriteStatus();
      updateFavoriteCount();
    });
  </script>
</body>
</html>