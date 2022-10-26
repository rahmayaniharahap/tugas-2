<?php 
// Menghubungkan file ini dengan file database
include 'koneksi.php';
// Mengecek apakah ID ada datanya atau tidak
if (isset($_POST['id'])) {
    if ($_POST['id'] != "") {
        // Mengambil data dari form lalu ditampung didalam variabel
        $id = $_POST['id'];
        $nim = $_POST['nim'];
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $jurusan = $_POST['jurusan'];
        $fakultas = $_POST['fakultas'];
        $foto_nama = $_FILES['pas_foto']['name'];
        $foto_size = $_FILES['pas_foto']['size'];

    }else{
        header("location:index.php");
    }

    // Mengecek apakah file lebih besar 2 MB atau tidak
    if ($foto_size > 2097152) {
	   // Jika File lebih dari 2 MB maka akan gagal mengupload File
       header("location:index.php?pesan=size");

    }else{

	   // Mengecek apakah Ada file yang diupload atau tidak
       if ($foto_nama != "") {

		  // Ekstensi yang diperbolehkan untuk diupload boleh diubah sesuai keinginan
          $ekstensi_izin = array('png','jpg','jepg');
		  // Memisahkan nama file dengan Ekstensinya
          $pisahkan_ekstensi = explode('.', $foto_nama); 
          $ekstensi = strtolower(end($pisahkan_ekstensi));
		  // Nama file yang berada di dalam direktori temporer server
          $file_tmp = $_FILES['pas_foto']['tmp_name'];   
		  // Membuat angka/huruf acak berdasarkan waktu diupload
          $tanggal = md5(date('Y-m-d h:i:s'));
		  // Menyatukan angka/huruf acak dengan nama file aslinya
          $foto_nama_new = $tanggal.'-'.$foto_nama; 

		  // Mengecek apakah Ekstensi file sesuai dengan Ekstensi file yg diuplaod
          if(in_array($ekstensi, $ekstensi_izin) === true)  {

            // Mengambil data gambar didalam table siswa
            $get_foto = "SELECT gambar FROM mahasiswa WHERE nim='$id'";
            $data_foto = mysqli_query($koneksi, $get_foto); 
            // Mengubah data yang diambil menjadi Array
            $foto_lama = mysqli_fetch_array($data_foto);

            // Menghapus Foto lama didalam folder FOTO
            unlink("foto/".$foto_lama['gambar']);    

			// Memindahkan File kedalam Folder "FOTO"
            move_uploaded_file($file_tmp, 'foto/'.$foto_nama_new);

            // Query untuk memasukan data kedalam table SISWA
            $query = mysqli_query($koneksi, "UPDATE mahasiswa SET nim='$nim',nama='$nama', email='$email', jurusan='$jurusan',fakultas='$fakultas', gambar='$foto_nama_new' WHERE nim='$id'");

            // Mengecek apakah data gagal diinput atau tidak
            if($query){
            	header("location:index.php?pesan=berhasil");
            } else {
                header("location:index.php?pesan=gagal");
            }

        } else { 
        	// Jika ekstensinya tidak sesuai dengan apa yg kita tetapkan maka error
        	header("location:index.php?pesan=ekstensi");        }

        }else{

    	// Apabila tidak ada file yang diupload maka akan menjalankan code dibawah ini
          $query = mysqli_query($koneksi, "UPDATE mahasiswa SET nim='$nim',nama='$nama', email='$email', jurusan='$jurusan', fakultas='$fakultas' WHERE nim='$id'");

            // Mengecek apakah data gagal diinput atau tidak
            if($query){
                header("location:index.php?pesan=berhasil");
            }else {
                header("location:index.php?pesan=gagal");
            }
        }

    }
}else{
    // Apabila ID tidak ditemukan maka akan dikembalikan ke halaman index
    header("location:index.php");
}
?>