<?php
require './connect.php';
?>
<!-- judul -->
<div class="panel">
    <div class="panel-middle" id="judul">
        <div id="judul-text">
            <h2 class="text-green">BOBOT</h2>
            Halamanan Administrator Bobot Kriteria
        </div>
    </div>
</div>
<!-- judul -->
<div class="row">
    <div class="col-4">
        <div class="panel">
            <?php
            if (@htmlspecialchars($_GET['aksi'])=='ubah'){
                include 'ubahbobot2.php';
            }elseif (@htmlspecialchars($_GET['aksi'])=='lihat'){
                include 'lihatbobot.php';
            }else{
                include 'tambahbobot2.php';
            }
            ?>
        </div>
    </div>
    <div class="col-8">
        <div class="panel">
            <div class="panel-top">
                <b class="text-green">Daftar Bobot</b>
            </div>
            <div class="panel-middle">
                <div class="table-responsive">
                    <table>
                        <thead><tr><th>No</th><th>Nama Penginapan</th><th>Aksi</th></tr></thead>
                        <tbody>
                        <?php
                        $query="SELECT bobot_kriteria.id_jenispenginapan AS idpenginapanbobot,jenis_penginapan.namaPenginapan AS namaPenginapan FROM bobot_kriteria INNER JOIN jenis_penginapan WHERE bobot_kriteria.id_jenispenginapan=jenis_penginapan.id_jenispenginapan GROUP BY idpenginapanbobot ORDER BY idpenginapanbobot ASC";
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
                                    <a class=\"btn btn-green\" href='./?page=bobot&aksi=lihat&id=".$data['idpenginapanbobot']."'><i class='fa fa-eye'></i></a>
                                    <a class=\"btn btn-light-green\" href='./?page=bobot&aksi=ubah&id=".$data['idpenginapanbobot']."'><i class='fa fa-pencil-alt'></i></a>
                                    <a class=\"btn btn-yellow\" data-a=".$data['namaPenginapan']." id='hapus' href='./proses/proseshapus.php/?op=bobot&id=".$data['idpenginapanbobot']."'><i class='fa fa-trash-alt'></i></a></td>
                                </div></tr>";
                                $no++;
                            }
                        }else{
                            echo "<tr><td  class='text-center text-green' colspan='4'><b>Kosong</b></td></tr>";
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