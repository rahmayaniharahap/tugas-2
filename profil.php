<p class="nama">
    <a href="php/profil.php?id=<?php echo $mhs['id'] ?>"><?php echo $mhs['nama'] ?></a>
</p>

<?php

if (!isset($_GET['id'])) {
    header("Location: ../index.php");
    exit;
}
    require 'functions.php'; 
    $id = $_GET['id'];

$mhs = query("SELECT * FROM mahasiswa WHERE nim = $id")[0];

?>
<div class="content">
<div class="gambar">
<img src="../img/<?= $mhs['gambar'] ?>">
</div>
<div class="desc"> 
    <p class="nim"><?= $mhs['nim'] ?></p>
    <p><?= $mhs['nama'] ?></p> 
    <p><?= $mhs['email'] ?></p> 
    <p><?= $mhs['jurusan'] ?>, <?= $mhs['fakultas'] ?></p>
p><a href="../index.php">Kembali</a></p>
</div>
</div>