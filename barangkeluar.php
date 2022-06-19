<?php
require 'function.php';
require 'cek.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Barang Keluar - Goods Inventory</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="stockbarang.php">Goods Inventory</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                    <div class="nav">
                            <a class="nav-link" href="stockbarang.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Stock Barang
                            </a>
                            <a class="nav-link" href="barangmasuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Barang Masuk
                            </a>
                            <a class="nav-link" href="barangkeluar.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Barang Keluar
                            </a>
                            <a class="nav-link" href="logout.php">
                                Logout
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Barang Keluar</h1><br>
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#input">
                                    <i class="fas fa-plus"></i> Tambah Barang Keluar
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Nama Barang</th>
                                                <th>Keterangan</th>
                                                <th>Quantity</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $ambilsemuadatakeluar = mysqli_query($conn, "SELECT * FROM keluar k, stock s where s.idbarang=k.idbarang");
                                            while($data=mysqli_fetch_array($ambilsemuadatakeluar)){
                                                $idb = $data['idbarang'];
                                                $idk = $data['idkeluar'];
                                                $tanggal = $data['tanggal'];
                                                $namabarang = $data['namabarang'];  
                                                $keterangan = $data['keterangan'];
                                                $qty = $data['qty'];                                     
                                            ?>
                                                <tr>
                                                    <td><?=$tanggal;?></td>
                                                    <td><?=$namabarang;?></td>
                                                    <td><?=$keterangan;?></td>
                                                    <td><?=$qty;?></td>
                                                    <td align="center">
                                                        <button class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$idb;?>">
                                                            <i class="fas fa-edit"></i> Edit</button>
                                                        <button class="btn btn-danger" data-toggle="modal" data-target="#hapus<?=$idb;?>">
                                                            <i class="fas fa-trash"></i> Hapus</button>
                                                    </td>
                                                </tr>
                                                <!-- The Modal-->
                                                <div class="modal fade" id="edit<?=$idb;?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">

                                                            <!-- Modal Header-->
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Edit Barang Keluar</h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>

                                                            <form method="post"> 
                                                                <!-- Modal Body-->                              
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label class="control-label" for="keterangan">Keterangan</label>
                                                                        <input type="text" name="keterangan" value="<?=$keterangan;?>" class="form-control" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="control-label" for="qty">Quantity</label>
                                                                        <input type="text" name="qty" value="<?=$qty;?>" class="form-control" required>
                                                                    </div>
                                                                    <input type="hidden" name="idb" value="<?=$idb;?>">
                                                                    <input type="hidden" name="idk" value="<?=$idk;?>">
                                                                </div>
                                                                <!-- Modal Footer-->
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-success" name="editbarangkeluar">
                                                                        <i class="fas fa-save"></i> Simpan
                                                                    </button>
                                                                </div>                
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- The Modal-->
                                                <div class="modal fade" id="hapus<?=$idb;?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">

                                                            <!-- Modal Header-->
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Hapus Barang Keluar?</h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>

                                                            <form method="post"> 
                                                                <!-- Modal Body-->                              
                                                                <div class="modal-body">
                                                                    Apakah anda yakin ingin menghapus <?=$namabarang;?>?
                                                                    <input type="hidden" name="idk" value="<?=$idk;?>">
                                                                    <input type="hidden" name="idb" value="<?=$idb;?>">
                                                                    <input type="hidden" name="qty" value="<?=$qty;?>">
                                                                </div>
                                                                <!-- Modal Footer-->
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-danger" name="hapusbarangkeluar">
                                                                        <i class="fas fa-trash"></i> Hapus
                                                                    </button>
                                                                </div>                
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            };
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2022</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
    <!-- The Modal-->
    <div class="modal fade" id="input">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header-->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Barang Keluar</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form method="post"> 
                    <!-- Modal Body-->                              
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label" for="barangnya">Nama Barang</label>
                            <select name="barangnya" class="form-control" required>
                                <?php
                                $ambildata = mysqli_query($conn, "SELECT * FROM stock");
                                while($fetcharray = mysqli_fetch_array($ambildata)){
                                    $namabarangnya = $fetcharray['namabarang'];
                                    $idbarangnya = $fetcharray['idbarang'];
                                ?>
                                <option value="<?=$idbarangnya;?>"><?=$namabarangnya;?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="qty">Quantity</label>
                            <input type="number" name="qty" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="keterangan">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" required>
                        </div>
                    </div>
                    <!-- Modal Footer-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="inputbarangkeluar">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>                
                </form>
            </div>
        </div>
    </div>
</html>