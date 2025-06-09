<?php include 'navbar.php'; ?>

<div class="container py-5">
  <h2 class="text-center mb-4">Daftar Kontak Sales Kami</h2>

  <div class="row">
    <?php
    // Data sales (bisa dari database, tapi di sini contoh statis)
    $sales = [
      [
        'nama' => 'Obrey',
        'nohp' => '0821-0000-0000',
        'foto' => 'obrey.jpg',
      ]
    ];
    ?>

    <?php foreach ($sales as $salesperson): ?>
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
          <img src="images/<?php echo $salesperson['foto']; ?>" class="card-img-top" alt="<?php echo $salesperson['nama']; ?>" onerror="this.src='../images/obrey.jpg'">
          <div class="card-body text-center">
            <h5 class="card-title"><?php echo $salesperson['nama']; ?></h5>
            <p class="card-text">📞 <?php echo $salesperson['nohp']; ?></p>
            <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $salesperson['nohp']); ?>" target="_blank" class="btn btn-success">
              Hubungi via WhatsApp
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- Tambahkan CSS jika tidak pakai Bootstrap -->
<style>
  body {
    font-family: Arial, sans-serif;
  }
  .card-img-top {
    height: 220px;
    object-fit: cover;
  }
</style>
