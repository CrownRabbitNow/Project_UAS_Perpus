<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/global_style.css">
    <title>Rak Buku</title>
</head>
<?php include("layout/header.php") ?>
<div class="col-10 container">
    <h1>Daftar Koleksi Buku</h1>
    <table border="2" class="table">
        <div class="row">
            <div class="col-5">
                <a id="tombolUbah" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah buku</a>
                <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Buku</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php
                                include 'koneksi.php';
                                $query = mysqli_query($koneksi, "select max(kd_buku) as kodeTerbesar from buku");
                                $data = mysqli_fetch_array($query);
                                $kodeBuku = $data['kodeTerbesar'];
                                $urutan = (int) substr($kodeBuku, 3, 3);

                                $urutan++;
                                $huruf = "BK";
                                $kodeBuku = $huruf . sprintf("%03s", $urutan);
                                ?>
                                <form method="post" action="insert_buku.php" autocomplete="off">
                                    <label class="form-group">Kode Buku</label><br />
                                    <input class="form-control" type="text" name="kd_buku" required="required" value="<?php echo $kodeBuku ?>" readonly>

                                    <br>

                                    <label class="form-group">Judul Buku</label><br />
                                    <input class="form-control" type="text" name="judul_buku" required="required">

                                    <br>


                                    <label class="form-group">Pengarang</label><br />
                                    <input class="form-control" type="text" name="pengarang" required="required">

                                    <br>

                                    <label class="form-group">Kategori Buku</label><br />
                                    <select class="form-select" name="kategori">
                                        <option selected>Pilih Kategori Buku</option>
                                        <?php
                                        include 'koneksi.php';
                                        $data = mysqli_query($koneksi, "select * from kategori");
                                        while ($d = mysqli_fetch_array($data)) {
                                            echo "<option value='" . $d['id_kategori'] . "'>" . $d['nama_kategori'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                    <br>
                                    <label class="form-group">Rak</label><br />
                                    <select class="form-select" name="rak">
                                        <option selected>Pilih Rak</option>
                                        <?php
                                        include 'koneksi.php';
                                        $data = mysqli_query($koneksi, "select * from rak");
                                        while ($d = mysqli_fetch_array($data)) {
                                            echo "<option value='" . $d['id_rak'] . "'>" . $d['nama_rak'] . "</option>";
                                        }
                                        ?>
                                    </select>

                                    <br>

                                    <label class="form-group">penerbit</label><br />
                                    <input class="form-control" type="text" name="penerbit" required="required">
                                    <div class="modal-footer">

                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-2">
            </div>
            <div class="col-5">
                <form action="rak_buku.php" method="get">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="cari"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" placeholder="cari judul buku" name="cari">
                        <button class="btn btn-primary" type="submit" value="cari">Cari</button>
                    </div>
                </form>
            </div>
        </div>
        <tr class="text-center">
            <th>No.</th>
            <th>Kode Buku</th>
            <th>Judul Buku</th>
            <th>Pengarang</th>
            <th>Kategori Buku</th>
            <th>Penerbit</th>
            <th>Rak</th>
            <th>Aksi</th>
        </tr>
        <?php
        include 'koneksi.php';
        if (isset($_GET['cari'])) {
            $cari = $_GET['cari'];
            $data = mysqli_query($koneksi, "select * from buku where judul_buku like '%" . $cari . "%'");
        } else {
            $data = mysqli_query($koneksi, "select buku.kd_buku, buku.judul_buku, buku.pengarang, buku.kategori ,kategori.nama_kategori, buku.penerbit, buku.rak, rak.nama_rak from buku
            inner join kategori on buku.kategori = kategori.id_kategori
            inner join rak on buku.rak = rak.id_rak");
        }
        $no = 1;
        while ($d = mysqli_fetch_array($data)) {
        ?>
            <tr class="text-center">
                <td><?php echo $no++; ?></td>
                <td><?php echo $d['kd_buku']; ?></td>
                <td><?php echo $d['judul_buku']; ?></td>
                <td><?php echo $d['pengarang']; ?></td>
                <td><?php echo $d['nama_kategori']; ?></td>
                <td><?php echo $d['penerbit']; ?></td>
                <td><?php echo $d['nama_rak']; ?></td>
                <td>
                    <a id="tombolUbah" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ubahModal<?php echo $d['kd_buku'] ?>">Ubah</a>
                    |
                    <a id="tombolhapus" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#hapusModal<?php echo $d['kd_buku'] ?>">Hapus</a>

                    <div class="modal fade" id="ubahModal<?php echo $d['kd_buku'] ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Form Ubah Data Buku</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="update_buku.php">
                                        <label class="form-group">Kode Buku</label><br />
                                        <input class="form-control" readonly name="kd_buku" value="<?php echo $d['kd_buku']; ?>">

                                        <br>

                                        <label class="form-group">Judul Buku</label><br />
                                        <input class="form-control" type="text" name="judul_buku" value="<?php echo $d['judul_buku']; ?>">

                                        <br>

                                        <label class="form-group">Pengarang</label><br />
                                        <input class="form-control" type="text" name="pengarang" value="<?php echo $d['pengarang']; ?>">

                                        <br>

                                        <label class="form-group">Kategori Buku</label><br />
                                        <select class="form-select" name="kategori">
                                            <option selected value="<?php echo $d['kategori']; ?>"><?php echo $d['nama_kategori']; ?></option>
                                            <?php
                                            include 'koneksi.php';
                                            $kategori = mysqli_query($koneksi, "select * from kategori");
                                            while ($k = mysqli_fetch_array($kategori)) {
                                                echo "<option value='" . $k['id_kategori'] . "'>" . $k['nama_kategori'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                        <br>

                                        <label class="form-group">penerbit</label><br />
                                        <input class="form-control" type="text" name="penerbit" value="<?php echo $d['penerbit']; ?>">

                                        <br>

                                        <label class="form-group">Rak</label><br />
                                        <select class="form-select" name="rak">
                                            <option selected value="<?php echo $d['rak']; ?>"><?php echo $d['nama_rak']; ?></option>
                                            <?php
                                            include 'koneksi.php';
                                            $rak = mysqli_query($koneksi, "select * from rak");
                                            while ($r = mysqli_fetch_array($rak)) {
                                                echo "<option value='" . $r['id_rak'] . "'>" . $r['nama_rak'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Ubah</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="hapusModal<?php echo $d['kd_buku'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus Data</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Apakah anda yakin ingin menghapus <?php echo $d['judul_buku'] ?> ?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <a href="delete_buku.php?id=<?php echo $d['kd_buku']; ?>" class="btn btn-outline-danger">Hapus</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>

        <?php
        }
        ?>
    </table>
</div>

<?php include('layout/footer.php') ?>