<?php
// navbar.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>HiStore</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <style>
    /* RESET */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      color: #333;
    }

    /* TOPBAR */
    .topbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 15px 30px;
      background-color: #fff;
      border-bottom: 1px solid #ddd;
    }

    .logo {
      height: 55px;
    }

    .search-container {
      position: relative;
      display: flex;
      align-items: center;
      flex: 1;
      margin: 0 50px;
      max-width: 500px;
    }

    .search-bar {
      width: 100%;
      padding: 10px 20px;
      border-radius: 30px;
      border: 3px solid #ccc;
      font-size: 16px;
    }

    .search-icon {
      position: absolute;
      right: 40px;
      color: #888;
      font-size: 16px;
      cursor: pointer;
    }

    .icons .icon {
      font-size: 20px;
      margin-left: 15px;
      cursor: pointer;
    }

    /* NAVBAR */
    .navbar {
      display: flex;
      justify-content: center;
      gap: 20px;
      padding: 15px;
      background-color: #fff;
      border-bottom: 1px solid #eee;
    }

    .navbar a {
      text-decoration: none;
      color: #444;
      font-weight: 500;
      padding-bottom: 5px;
    }

    .navbar a:hover {
     color:#888;
     border-bottom: 2px solid #888;
     transition: all 0.1s ease;
}

    .navbar a.active {
      color: #d40000;
      border-bottom: 2px solid #d40000;
    }

    /* CAROUSEL */
    .carousel {
      text-align: center;
      margin: 20px auto;
    }

    .carousel img {
      width: 95%;
      border-radius: 10px;
      max-width: 1000px;
    }

    .dots {
      margin-top: 10px;
    }

    .dot {
      height: 10px;
      width: 10px;
      background-color: #bbb;
      border-radius: 50%;
      display: inline-block;
      margin: 0 4px;
    }

    .dot.active {
      background-color: #444;
    }

    /* FILTERS */
    .filters {
      text-align: center;
      margin: 25px 0;
    }

    .filters button {
      margin: 6px;
      padding: 10px 20px;
      border-radius: 20px;
      background-color: #fff;
      border: 2px solid #333;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .filters button:hover {
      background-color: #333;
      color: #fff;
    }

    /* PRODUCTS */
    .products {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 25px;
      padding: 30px 15px;
    }

    .card {
      width: 220px;
      background-color: #fff;
      border: 1.5px solid #ccc;
      border-radius: 15px;
      padding: 15px;
      text-align: center;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      transition: transform 0.2s;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .card img {
      width: 100%;
      border-radius: 10px;
      margin-bottom: 12px;
    }

    .card h3 {
      font-size: 1.1em;
      margin-bottom: 8px;
    }

    .price {
      font-weight: bold;
      color: #1e40af;
      margin-bottom: 10px;
    }

    .card .btn {
      display: inline-block;
      padding: 8px 16px;
      background-color: #1e40af;
      color: #fff;
      border-radius: 20px;
      text-decoration: none;
      margin-bottom: 8px;
      transition: background 0.3s;
    }

    .card .btn:hover {
      background-color: #122c8c;
    }

    .favorite {
      font-size: 0.85em;
      color: #777;
    }

    /* #favorite-count {
     background-color: #d40000;
      color: white;
      font-size: 12px;
      padding: 2px 6px;
      border-radius: 10px;
      margin-left: 4px;
} */

  </style>
</head>
<body>

<header>
  <div class="topbar">
    <img src="images/logohistore.png" alt="HiStore Logo" class="logo" />
    
    <div class="search-container">
      <input type="text" placeholder="Cari produk..." class="search-bar" />
      <i class="fas fa-search search-icon"></i>
    </div>

    <div class="icons">
    <a href="favorite.php" class="icon" title="Favorit" style="text-decoration:none; color:inherit; cursor:pointer;">
    ⭐ <span id="favorite-count">0</span>
    </a>


      <span class="icon" title="Profil">👤</span>
    </div>
  </div>

  <nav class="navbar">
    <a href="ipad.php">iPad</a>
    <a href="iphone.php">iPhone</a>
    <a href="iwatch.php">iWatch</a>
    <a href="macbook.php">MacBook</a>
    <a href="airphone.php">Airphone</a>
    <a href="aksesoris.php">Aksesoris</a>
    <a href="eventpromo.php">Event & Promo</a>
  </nav>
</header>

</body>
</html>
