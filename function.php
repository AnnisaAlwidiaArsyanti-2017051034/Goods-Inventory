<?php
session_start();
//membuat koneksi ke database
$conn = mysqli_connect("sql108.epizy.com", "epiz_31988616", "0zzj8DAHyk", "epiz_31988616_stockbarang");

//register
if(isset($_POST['register'])){
    $email = $_POST['inputEmailAddress'];
    $password = $_POST['inputpassword'];
    
    $cekemail = mysqli_query($conn, "SELECT * FROM login WHERE email='$email'");
    $cek = mysqli_fetch_array($cekemail);
    if($cek==0){
        $tambahakun = mysqli_query($conn, "INSERT INTO login (email, password) values ('$email', '$password')");
        if($tambahakun){
            header('location:index.php');
        } else{
            echo 'Gagal Register';
            header('location:register.php');
        };
    } else{
        echo 'Email sudah terdaftar';
    }
    
};

//menambah barang baru
if(isset($_POST['inputbarang'])){
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];

    $cekbarang = mysqli_query($conn, "SELECT * FROM stock WHERE namabarang='$namabarang'");
    $cek = mysqli_fetch_array($cekbarang);
    if($cek==0){
        $tambahbarang = mysqli_query($conn, "INSERT INTO stock (namabarang, deskripsi, stock) values ('$namabarang', '$deskripsi', '$stock')");
        if($tambahbarang){
            header('location:stockbarang.php');
        } else{
            echo 'Gagal Menambah Data Barang';
            header('location:stockbarang.php');
        };
    } else{
        echo 'Barang sudah terdata';
    }
};

if(isset($_POST['inputbarangmasuk'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahstock = $stocksekarang + $qty;

    $tambahbarangmasuk = mysqli_query($conn, "INSERT INTO masuk (idbarang, penerima, qty) values ('$barangnya', '$penerima', '$qty')");
    $updatestockmasuk = mysqli_query($conn, "UPDATE stock set stock='$tambahstock' WHERE idbarang='$barangnya'");
    if($tambahbarangmasuk&&$updatestockmasuk){
        header('location:barangmasuk.php');
    } else{
        echo 'Gagal Menambah Data Barang Masuk';
        header('location:barangmasuk.php');
    };
};
if(isset($_POST['inputbarangkeluar'])){
    $barangnya = $_POST['barangnya'];
    $keterangan = $_POST['keterangan'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $kurangistock = $stocksekarang - $qty;

    $tambahbarangkeluar = mysqli_query($conn, "INSERT INTO keluar (idbarang, keterangan, qty) values ('$barangnya', '$keterangan', '$qty')");
    $updatestockkeluar = mysqli_query($conn, "UPDATE stock set stock='$kurangistock' WHERE idbarang='$barangnya'");
    if($tambahbarangkeluar&&$updatestockkeluar){
        header('location:barangkeluar.php');
    } else{
        echo 'Gagal Menambah Data Barang Keluar';
        header('location:barangkeluar.php');
    };
};

//update info barang
if(isset($_POST['editbarang'])){
    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];

    $edit = mysqli_query($conn, "UPDATE stock set namabarang='$namabarang', deskripsi='$deskripsi' WHERE idbarang='$idb'");
    if($edit){
        header('location:stockbarang.php');
    } else{
        echo 'Gagal Mengedit Data Stock Barang';
        header('location:stockbarang.php');
    };
}

//hapus barang dari stock
if(isset($_POST['hapusbarang'])){
    $idb = $_POST['idb'];
    $hapus = mysqli_query($conn, "DELETE FROM stock WHERE idbarang='$idb'");
    if($hapus){
        header('location:stockbarang.php');
    } else{
        echo 'Gagal Menghapus Data Stock Barang';
        header('location:stockbarang.php');
    };
}

//update info barang masuk
if(isset($_POST['editbarangmasuk'])){
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);
    $stocksekarang = $ambildatanya['stock'];

    $cekqtyskrg = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk='$idm'");
    $dataqty = mysqli_fetch_array($cekqtyskrg);
    $qtyskrg = $dataqty['qty'];

    $selisih = $qty - $qtyskrg;
    $updatestock = $stocksekarang + $selisih;
            
    $updatestocknya = mysqli_query($conn, "UPDATE stock SET stock='$updatestock' WHERE idbarang='$idb'");
    $updatenya = mysqli_query($conn, "UPDATE masuk SET qty='$qty', penerima='$penerima' WHERE idmasuk='$idm'");
    if($updatestocknya&&$updatenya){
        header('location:barangmasuk.php');
    } else{
        echo 'Gagal Mengedit Data Barang Masuk';
        header('location:barangmasuk.php');
    };
}
//hapus info barang masuk
if(isset($_POST['hapusbarangmasuk'])){    
    $idm = $_POST['idm'];
    $idb = $_POST['idb'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $getdatastock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];
    $selisih = $stock-$qty;
    
    $update = mysqli_query($conn, "UPDATE stock SET stock='$selisih' WHERE idbarang='$idb'");    
    $hapusdata = mysqli_query($conn, "DELETE FROM masuk WHERE idmasuk = '$idm'");
    if($update&&$hapusdata){
        header('location:barangmasuk.php');
    } else{
        echo 'Gagal Menghapus Data Barang Masuk';
        header('location:barangmasuk.php');
    };
}

//update info barang keluar
if(isset($_POST['editbarangkeluar'])){
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $keterangan = $_POST['keterangan'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);
    $stocksekarang = $ambildatanya['stock'];

    $cekqtyskrg = mysqli_query($conn, "SELECT * FROM keluar WHERE idkeluar='$idk'");
    $dataqty = mysqli_fetch_array($cekqtyskrg);
    $qtyskrg = $dataqty['qty'];

    $selisih = $qty - $qtyskrg;
    $updatestock = $stocksekarang - $selisih;
            
    $updatestocknya = mysqli_query($conn, "UPDATE stock SET stock='$updatestock' WHERE idbarang='$idb'");
    $updatenya = mysqli_query($conn, "UPDATE keluar SET qty='$qty', keterangan='$keterangan' WHERE idkeluar='$idk'");
    if($updatestocknya&&$updatenya){
        header('location:barangkeluar.php');
    } else{
        echo 'Gagal Mengedit Data Barang Keluar';
        header('location:barangkeluar.php');
    };
}
//hapus info barang keluar
if(isset($_POST['hapusbarangkeluar'])){    
    $idk = $_POST['idk'];
    $idb = $_POST['idb'];
    $keterangan = $_POST['keterangan'];
    $qty = $_POST['qty'];

    $getdatastock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];
    $selisih = $stock+$qty;
    
    $update = mysqli_query($conn, "UPDATE stock SET stock='$selisih' WHERE idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "DELETE FROM keluar WHERE idkeluar = '$idk'");
    if($update&&$hapusdata){
        header('location:barangkeluar.php');
    } else{
        echo 'Gagal Menghapus Data Barang Keluar';
        header('location:barangkeluar.php');
    };
}
?>