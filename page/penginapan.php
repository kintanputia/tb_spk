<!-- judul -->
<div class="panel">
    <div class="panel-middle" id="judul">
        <div id="judul-text">
            <h2 class="text-green">PENGINAPAN</h2>
            Halamanan Administrator Penginapan
        </div>
    </div>
</div>
<!-- judul -->
<div class="row">
    <div class="col-4">
        <div class="panel">
            <?php
            if (@htmlspecialchars($_GET['aksi'])=='ubah'){
                include 'ubahpenginapan.php';
            }else{
                include 'tambahpenginapan.php';
            }
            ?>
        </div>
    </div>
    <div class="col-8">
        <div class="panel">
            <div class="panel-top">
                <b class="text-green">Daftar Penginapan</b>
            </div>
            <div class="panel-middle">
                <div class="table-responsive">
                    <table>
                        <thead><tr><th>No</th><th>Nama</th><th>Aksi</th></tr></thead>
                        <tbody>
                        <?php
                        $query="SELECT * FROM jenis_penginapan";
                        $execute=$konek->query($query);
                        if ($execute->num_rows > 0){
                            $no=1;
                            while($data=$execute->fetch_array(MYSQLI_ASSOC)){
                                echo"
                                <tr id='data'>
                                    <td>$no</td>
                                    <td>$data[namaPenginapan]</td>
                                    <td>
                                    <div class='norebuttom'>
                                    <a class=\"btn btn-light-green\" href='./?page=penginapan&aksi=ubah&id=".$data['id_jenispenginapan']."'><i class='fa fa-pencil-alt'></i></a>
                                    <a class=\"btn btn-yellow\" data-a=".$data['namaPenginapan']." id='hapus' href='./proses/proseshapus.php/?op=penginapan&id=".$data['id_jenispenginapan']."'><i class='fa fa-trash-alt'></i></a></td>
                                </div></tr>";
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