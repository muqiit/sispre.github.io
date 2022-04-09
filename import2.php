<?php

// Load file koneksi.php
include "koneksi.php";

if(isset($_POST['import2'])){ // Jika user mengklik tombol Import
	$nama_file_baru = 'data.xlsx';

	// Load librari PHPExcel nya
	require_once 'PHPExcel/PHPExcel.php';

	$excelreader = new PHPExcel_Reader_Excel2007();
	$loadexcel = $excelreader->load('tmp2/'.$nama_file_baru); // Load file excel yang tadi diupload ke folder tmp
	$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

	$numrow = 1;
	foreach($sheet as $row){
		// Ambil data pada excel sesuai Kolom
		$no = $row['A']; // Ambil data NIS
		$nama = $row['B']; // Ambil data nama
		$sks_2 = $row['C']; // Ambil data jenis kelamin
		$sks_3 = $row['D']; // Ambil data telepon
		$sks_4 = $row['E']; // Ambil data alamat
		$ips_2 = $row['F']; // Ambil data alamat
		$ips_3 = $row['G']; // Ambil data alamat
		$ips_4 = $row['H']; // Ambil data alamat
		$ket = $row['I']; // Ambil data alamat

		// Cek jika semua data tidak diisi
		if($no == "" && $nama == "" && $sks_2 == "" && $sks_3 == "" && $sks_4 == "" && $ips_2 == "" && $ips_3 == "" && $ips_4 == "" && $ket == "")
			continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

		// Cek $numrow apakah lebih dari 1
		// Artinya karena baris pertama adalah nama-nama kolom
		// Jadi dilewat saja, tidak usah diimport
		if($numrow > 1){
            // Buat query Insert
            if($ips_4>3.50)
            {
			$query = "INSERT INTO tbl_prediksi VALUES('".$no."','".$nama."','".$sks_2."','".$sks_3."','".$sks_4."','".$ips_2."','".$ips_3."','".$ips_4."','Lebih Cepat')";
            }  
            elseif($ips_4<=3.50 and $ips_4>=3.00 and $ips_2>3.50 and $ips_3>3.50)
            {
                $query = "INSERT INTO tbl_prediksi VALUES('".$no."','".$nama."','".$sks_2."','".$sks_3."','".$sks_4."','".$ips_2."','".$ips_3."','".$ips_4."','Lebih Cepat')";
            }  
            elseif($ips_4<=3.50 and $ips_4>=3.00 and $ips_2>3.50 and $ips_3>=3.00 and $ips_3<=3.50)
            {
                $query = "INSERT INTO tbl_prediksi VALUES('".$no."','".$nama."','".$sks_2."','".$sks_3."','".$sks_4."','".$ips_2."','".$ips_3."','".$ips_4."','Tepat Waktu')";
            }
            elseif($ips_4<=3.50 and $ips_4>=3.00 and $ips_2>=3.00 and $ips_2<=3.50 and $sks_4>=18 and $ips_3>=3.00)
            {
                $query = "INSERT INTO tbl_prediksi VALUES('".$no."','".$nama."','".$sks_2."','".$sks_3."','".$sks_4."','".$ips_2."','".$ips_3."','".$ips_4."','Tepat Waktu')";
            }
            elseif($ips_4<=3.50 and $ips_4>=3.00 and $ips_2>=3.00 and $ips_2<=3.50 and $sks_4>=18 and $ips_3<3.00)
            {
                $query = "INSERT INTO tbl_prediksi VALUES('".$no."','".$nama."','".$sks_2."','".$sks_3."','".$sks_4."','".$ips_2."','".$ips_3."','".$ips_4."','Tidak Tepat Waktu')";
            }
            elseif ($ips_4<=3.50 and $ips_4>=3.00 and $ips_2>=3.00 and $ips_2<=3.50 and $sks_4<18) 
            {
                $query = "INSERT INTO tbl_prediksi VALUES('".$no."','".$nama."','".$sks_2."','".$sks_3."','".$sks_4."','".$ips_2."','".$ips_3."','".$ips_4."','Tidak Tepat Waktu')";
            }
            elseif ($ips_4<=3.50 and $ips_4>=3.00 and $ips_2<3.00) 
            {
                $query = "INSERT INTO tbl_prediksi VALUES('".$no."','".$nama."','".$sks_2."','".$sks_3."','".$sks_4."','".$ips_2."','".$ips_3."','".$ips_4."','Tidak Tepat Waktu')";
            }
            elseif ($ips_4<3.00 and $ips_2>3.50) 
            {
                $query = "INSERT INTO tbl_prediksi VALUES('".$no."','".$nama."','".$sks_2."','".$sks_3."','".$sks_4."','".$ips_2."','".$ips_3."','".$ips_4."','Tepat Waktu')";
            }
            elseif ($ips_4<3.00 and $ips_2<=3.50) 
            {
                $query = "INSERT INTO tbl_prediksi VALUES('".$no."','".$nama."','".$sks_2."','".$sks_3."','".$sks_4."','".$ips_2."','".$ips_3."','".$ips_4."','Tidak Tepat Waktu')";
            }
			// Eksekusi $query
			mysqli_query($connect, $query);
		}

		$numrow++; // Tambah 1 setiap kali looping
	}
}

header('location: index.php?id=11'); // Redirect ke halaman awal
?>
