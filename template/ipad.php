<?php
// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "histore"); // ganti 'nama_database' dengan nama database kamu
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>iPad | HiStore</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    /* (Sama seperti CSS kamu sebelumnya) */
    .filters {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin: 20px;
      justify-content: center;
    }
    .filters select {
      padding: 10px 15px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 25px;
      background-color: #f5f5f5;
      cursor: pointer;
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
    .favorite {
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
    <section class="filters">
      <!-- Untuk sekarang tetap statis -->
      <select id="filterWarna">
        <option value="">Semua Warna</option>
        <option value="Silver">Silver</option>
        <option value="Space Gray">Space Gray</option>
        <option value="Pink">Pink</option>
      </select>

      <select id="filterKondisi">
        <option value="">Semua Kondisi</option>
        <option value="Baru">Baru</option>
        <option value="Bekas">Bekas</option>
      </select>

      <select id="filterStorage">
        <option value="">Semua Storage</option>
        <option value="64GB">64GB</option>
        <option value="128GB">128GB</option>
        <option value="256GB">256GB</option>
      </select>

      <select id="filterSeri">
        <option value="">Semua Seri</option>
        <option value="Pro">Pro</option>
        <option value="Air">Air</option>
        <option value="Mini">Mini</option>
        <option value="Gen">Gen</option>
      </select>
    </section>

    <section class="products">
      <?php
        $query = "SELECT * FROM produk WHERE kategori = 'ipad'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='card'>";
            echo "<img src='" . $row['gambar'] . "' alt='" . $row['nama'] . "'>";
            echo "<h3>" . $row['nama'] . "</h3>";
            echo "<p>Rp." . number_format($row['harga'], 0, ',', '.') . "</p>";
            echo "<p>Warna: " . $row['warna'] . "</p>";
            echo "<p>Kondisi: " . $row['kondisi'] . "</p>";
            echo "<p>Storage: " . $row['storage'] . "</p>";
            echo "<p>Seri: " . $row['seri'] . "</p>";
            echo "<a href='ipad/ipadpro11.php' class='btn'>Selengkapnya</a>";
            echo "<p class='favorite'>Belum ada favorite</p>";
            echo "</div>";
          }
        } else {
          echo "<p>Tidak ada produk iPad ditemukan.</p>";
        }
      ?>
    </section>
  </main>
</body>
</html>
