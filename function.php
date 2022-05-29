<?php
session_start();

//membuat koneksi ke db

$conn = mysqli_connect("localhost", "root", "", "db_yara");



//menambah barang baru
if (isset($_POST['tambahbarang'])) {
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];

    //soal gambar

    $allowed_extention = array('png', 'jpg');
    $nama = $_FILES['file']['name']; //ngambil nama gambar
    $dot = explode('.', $nama);
    $ekstensi = strtolower(end($dot)); //ngambil ekstensi
    $ukuran = $_FILES['file']['size']; //ngambil ukuran gambar
    $file_tmp = $_FILES['file']['tmp_name']; //ngambil lokasi filenya

    //penamaan file -> eskripsi
    $image = md5(uniqid($nama, true) . time()) . '.' . $ekstensi; //menghubungkan nama file yg dienskripsi dgn ekstensinya


    //validasi barang udah ada atau belum
    $cek = mysqli_query($conn, "select * from tb_stock where namabarang='$namabarang'");
    $hitung = mysqli_num_rows($cek);


    if ($hitung < 1) {
        //jika belum ada

        //proses upload gambar
        if (in_array($ekstensi, $allowed_extention) === true) {
            //validasi ukuran file
            if ($ukuran < 15000000) {
                move_uploaded_file($file_tmp, 'img/' . $image);
                $addtotable = mysqli_query($conn, "insert into tb_stock (namabarang, deskripsi, stock, image) values('$namabarang','$deskripsi','$stock', '$image')");
                if ($addtotable) {
                    header('location:index.php');
                } else {
                    echo 'Gagal';
                    header('location:index.php');
                }
            } else {
                //jika ukuran file melebihi 15mb 
                echo '
                <script>
                alert("Ukuran terlalu besar");
                window.location.href="index.php";
                </script>
                ';
            }
        } else {
            //kalau filenya tidak png / jpg
            echo '
            <script>
            alert("FIle harus PNG / JPG");
            window.location.href="index.php";
            </script>
    ';
        }
    } else {
        //jika sudah ada
        echo '
    <script>
    alert("Data barang sudah ada");
    window.location.href="index.php";
    </script>
    ';
    }
};



//barang masuk
if (isset($_POST['barangmasuk'])) {
    $barangnya = $_POST['barangnya'];
    $penerima  = $_POST['penerima'];
    $qty = $_POST['qty'];


    $cekstocksekarang = mysqli_query($conn, "select * from tb_stock where idbarang='$barangnya'");
    $ambildata = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildata['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang + $qty;



    $addtomasuk = mysqli_query($conn, "insert into tb_masuk (idbarang,keterangan,qty) values ('$barangnya','$penerima','$qty')");
    $updatestockmasuk = mysqli_query($conn, "update tb_stock set stock= '$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");
    if ($addtomasuk && $updatestockmasuk) {
        header('location:masuk.php');
    } else {
        echo 'Gagal';
        header('location:masuk.php');
    }
};

//barang keluar
if (isset($_POST['barangkeluar'])) {
    $barangnya = $_POST['barangnya'];
    $penerima  = $_POST['penerima'];
    $qty = $_POST['qty'];


    $cekstocksekarang = mysqli_query($conn, "select * from tb_stock where idbarang='$barangnya'");
    $ambildata = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildata['stock'];

    //jika barang cukup
    if ($stocksekarang >= $qty) {

        $tambahkanstocksekarangdenganquantity = $stocksekarang - $qty;

        $addtokeluar = mysqli_query($conn, "insert into tb_keluar (idbarang,penerima,qty) values ('$barangnya','$penerima','$qty')");
        $updatestockmasuk = mysqli_query($conn, "update tb_stock set stock= '$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");
        if ($addtokeluar && $updatestockmasuk) {
            header('location:keluar.php');
        } else {
            echo 'Gagal';
            header('location:keluar.php');
        }
    } else {
        //jika barang tidak cukup
        echo '
        <script>
        alert(" Tidak bisa mengeluarkan barang karena stock tidak mencukupi");
        window.location.href="keluar.php";
        </script>
        ';
    }
};



//update barang stock
if (isset($_POST['updatebarang'])) {
    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];

    //soal gambar

    $allowed_extention = array('png', 'jpg');
    $nama = $_FILES['file']['name']; //ngambil nama gambar
    $dot = explode('.', $nama);
    $ekstensi = strtolower(end($dot)); //ngambil ekstensi
    $ukuran = $_FILES['file']['size']; //ngambil ukuran gambar
    $file_tmp = $_FILES['file']['tmp_name']; //ngambil lokasi filenya

    //penamaan file -> eskripsi
    $image = md5(uniqid($nama, true) . time()) . '.' . $ekstensi; //menghubungkan nama file yg dienskripsi dgn ekstensinya
    if ($ukuran == 0) {
        //jika tidak ingin upload
        $update = mysqli_query($conn, "update tb_stock set namabarang='$namabarang', deskripsi='$deskripsi' where idbarang='$idb' ");
        if ($update) {
            header('location:index.php');
        } else {
            echo 'Gagal';
            header('location:index.php');
        }
    } else {
        //jika ingin upload
        move_uploaded_file(
            $file_tmp,
            'img/' . $image
        );

        $update = mysqli_query($conn, "update tb_stock set namabarang='$namabarang', deskripsi='$deskripsi', image='$image' where idbarang='$idb' ");
        if ($update) {
            header('location:index.php');
        } else {
            echo 'Gagal';
            header('location:index.php');
        }
    }
};


//hapus barang dari stock
if (isset($_POST['hapusbarang'])) {
    $idb = $_POST['idb']; // id barang

    $gambar = mysqli_query($conn, "select * from tb_stock where idbarang='$idb'");
    $get = mysqli_fetch_array($gambar);
    $img = 'img/' . $get['image'];
    unlink($img);

    $hapus = mysqli_query($conn, "delete from tb_stock where idbarang='$idb'");
    if ($hapus) {
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
};


//update barang masuk
if (isset($_POST['updatebarangmasuk'])) {
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $deskripsi = $_POST['keterangan'];
    $qty = $_POST['qty'];
    

    $lihatstock = mysqli_query($conn, "select * from tb_stock where idbarang ='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrng = $stocknya['stock'];

    $qtyskrng = mysqli_query($conn, "select * from tb_masuk where idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrng);
    $qtyskrng = $qtynya['qty'];

    if ($qty > $qtyskrng) {
        $selisih = $qty - $qtyskrng;
        $kurangin = $stockskrng + $selisih;
        $kurangistocknya = mysqli_query($conn, "update tb_stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update tb_masuk set qty='$qty', keterangan='$deskripsi',  where idmasuk ='$idm'");

        if ($kurangistocknya && $updatenya) {
            header('location:masuk.php');
        } else {
            echo 'Gagal';
            header('location:masuk.php');
        }
    } else {
        $selisih = $qtyskrng - $qty;
        $kurangin = $stockskrng - $selisih;
        $kurangistocknya = mysqli_query($conn, "update tb_stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update tb_masuk set qty='$qty', keterangan='$deskripsi'  where idmasuk='$idm'");

        if ($kurangistocknya && $updatenya) {
            header('location:masuk.php');
        } else {
            echo 'Gagal';
            header('location:masuk.php');
        }
    }
};

//delete barang masuk

if (isset($_POST['hapusbarangmasuk'])) {
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn, "select * from tb_stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok - $qty;

    $update = mysqli_query($conn, "update tb_stock set stock='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "delete from tb_masuk where idmasuk='$idm'");

    if ($update && $hapusdata) {
        header('location:masuk.php');
    } else {
        header('location:masuk.php');
    }
};


//mengubah data barang keluar
if (isset($_POST['updatebarangkeluar'])) {
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "select * from tb_stock where idbarang ='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrng = $stocknya['stock'];

    $qtyskrng = mysqli_query($conn, "select * from tb_keluar where idkeluar='$idk'");
    $qtynya = mysqli_fetch_array($qtyskrng);
    $qtyskrng = $qtynya['qty'];

    if ($qty > $qtyskrng) {
        $selisih = $qty - $qtyskrng;
        $kurangin = $stockskrng - $selisih;
        if ($selisih <= $stockskrng) {
            $kurangistocknya = mysqli_query($conn, "update tb_stock set stock='$kurangin' where idbarang='$idb'");
            $updatenya = mysqli_query($conn, "update tb_keluar set qty='$qty', penerima='$penerima' where idkeluar ='$idk'");

            if ($kurangistocknya && $updatenya) {
                header('location:keluar.php');
            } else {
                echo 'Gagal';
                header('location:keluar.php');
            }
        } else {
            echo '
            <script>alert("Stock tidak mencukupi");
            widow.location.href="keluar.php";
            </script>
            ';
        }
    } else {
        $selisih = $qtyskrng - $qty;
        $kurangin = $stockskrng + $selisih;
        $kurangistocknya = mysqli_query($conn, "update tb_stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update tb_keluar set qty='$qty', penerima='$penerima' where idkeluar='$idk'");

        if ($kurangistocknya && $updatenya) {
            header('location:keluar.php');
        } else {
            echo 'Gagal';
            header('location:keluar.php');
        }
    }
};


//delete barang keluar
if (isset($_POST['hapusbarangkeluar'])) {
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idk = $_POST['idk'];

    $getdatastock = mysqli_query($conn, "select * from tb_stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok + $qty;

    $update = mysqli_query($conn, "update tb_stock set stock='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "delete from tb_keluar where idkeluar='$idk'");

    if ($update && $hapusdata) {
        header('location:keluar.php');
    } else {
        header('location:keluar.php');
    }
};


//menambah admin baru
if (isset($_POST['addadmin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $queryinsert = mysqli_query($conn, "insert into tb_login (email, password) values ('$email', '$password' )");

    if ($queryinsert) {
        //jika berhasil
        header('location:admin.php');
    } else {
        //jika gagal
        header('location:admin.php');
    }
};



//edit data admin
if (isset($_POST['updateadmin'])) {
    $emailbaru = $_POST['emailadmin'];
    $passwordbaru = $_POST['passwordbaru'];
    $idnya = $_POST['id'];


    $queryupdate = mysqli_query($conn, "update tb_login set email='$emailbaru',password='$passwordbaru' where iduser='$idnya'");

    if ($queryupdate) {
        header('location:admin.php');
    } else {
        header('location:admin.php');
    }
};


//delete data admin

if (isset($_POST['hapusadmin'])) {
    $id = $_POST['id'];

    $querydelete = mysqli_query($conn, "delete from tb_login where iduser='$id'");
    if ($querydelete) {
        header('location:admin.php');
    } else {
        header('location:admin.php');
    }
}
