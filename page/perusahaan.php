<div class="panel">
    <div class="panel-middle" id="judul">
        <div id="judul-text">
            <h2 class="text-green">Perusahaan</h2>
            Halamanan Administrator Perusahaan
        </div>
    </div>
</div>
<!-- judul -->
<div class="row">
    <div class="col-4">
        <div class="panel">
            <?php
            if (@htmlspecialchars($_GET['aksi'])=='ubah'){
                include 'ubahperusahaan.php';
            }else{
                include 'tambahperusahaan.php';
            }
            ?>
        </div>
    </div>
    <div class="col-8">
        <div class="panel">
            <div class="panel-top">
                <b class="text-green">Daftar Perusahaan</b>
            </div>
            <div class="panel-middle">
                <div class="table-responsive">
                    <table>
                        <thead><tr><th>No</th><th>Nama</th><th>Aksi</th></tr></thead>
                        <tbody>
                        <?php
                        $query="SELECT * FROM perusahaan";
                        $execute=$konek->query($query);
                        if ($execute->num_rows > 0){
                            $no=1;
                            while($data=$execute->fetch_array(MYSQLI_ASSOC)){
                                echo"
                                <tr id='data'>
                                    <td>$no</td>
                                    <td>$data[namaPerusahaan]</td>
                                    <td>
                                    <div class='norebuttom'>
                                    <a class=\"btn btn-light-green\" href='./?page=perusahaan&aksi=ubah&id=".$data['id_perusahaan']."'><i class='fa fa-pencil-alt'></i></a>
                                    <a class=\"btn btn-yellow\" data-a=".$data['namaPerusahaan']." id='hapus' href='./proses/proseshapus.php/?op=perusahaan&id=".$data['id_perusahaan']."'><i class='fa fa-trash-alt'></i></a>
                                    </div></td>
                                </tr>";
                                $no++;
                            }
                        }else{
                            echo "<tr><td  class='text-center text-green' colspan='3'>Kosong</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-bottom"></div>
        </div>
    </div>
</div>