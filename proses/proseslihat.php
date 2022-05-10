<?php
require '../connect.php';
require '../class/crud.php';
if ($_SERVER['REQUEST_METHOD']=='GET') {
    $id=@$_GET['id'];
    $op=@$_GET['op'];
}else if ($_SERVER['REQUEST_METHOD']=='POST'){
    $id=@$_POST['id'];
    $op=@$_POST['op'];
}
$crud=new crud();
switch ($op){
    case 'subkriteria':
    if (!empty($id)) {
        $where="WHERE nilai_kriteria.id_kriteria='$id'";
    }else{
        $where=null;
    }
    $query="SELECT id_nilaikriteria,nilai,keterangan,namaKriteria,id_kriteria FROM nilai_kriteria INNER JOIN kriteria USING (id_kriteria) $where ORDER BY id_kriteria,nilai ASC";
    $execute=$konek ->query($query);
    if ($execute->num_rows > 0){
        $no=1;
        while($data=$execute->fetch_array(MYSQLI_ASSOC)){
            echo"
            <tr id='data'>
                <td>$no</td>
                <td>".$data['namaKriteria']."</td>
                <td>".$data['nilai']."</td>
                <td>".$data['keterangan']."</td>
                <td><div class='norebuttom'>
                <a class=\"btn btn-light-green\" href='./?page=subkriteria&aksi=ubah&id=".$data['id_nilaikriteria']."'><i class='fa fa-pencil-alt'></i></a>
                <a class=\"btn btn-yellow\" data-a=\"nilai $data[nilai] dalam $data[namaKriteria]\" id='hapus' href='./proses/proseshapus.php/?op=subkriteria&id=".$data['id_nilaikriteria']."'><i class='fa fa-trash-alt'</a></td></div>
            </tr>";
            $no++;
        }
    }else{
        echo "<tr><td  class='text-center text-green' colspan='4'><b>Kosong</b></td></tr>";
    }
        break;
    case 'nilai':
        if (!empty($id)) {
            $where="WHERE nilai_perusahaan.id_jenispenginapan='$id'";
        }else{
            $where=null;
        }
        $query="SELECT id_nilaiperusahaan,id_perusahaan,perusahaan.namaPerusahaan AS namaPerusahaan,jenis_penginapan.id_jenispenginapan AS id_jenispenginapan,jenis_penginapan.namaPenginapan AS namaPenginapan FROM nilai_perusahaan INNER JOIN perusahaan USING(id_perusahaan) INNER JOIN jenis_penginapan USING (id_jenispenginapan) $where GROUP BY id_perusahaan ORDER BY id_jenispenginapan,id_perusahaan ASC";
        $execute=$konek->query($query);
        if ($execute->num_rows > 0){
            $no=1;
            while($data=$execute->fetch_array(MYSQLI_ASSOC)){
               echo"
                <tr id='data'>
                    <td>$no</td>
                    <td>$data[namaPenginapan]</td>
                    <td>$data[namaPerusahaan]</td>
                    <td>
                    <div class='norebuttom'>
                    <a class=\"btn btn-green\" href=\"./?page=penilaian&aksi=lihat&a=$data[id_perusahaan]&b=$data[id_jenispenginapan]\"><i class='fa fa-eye'></i></a>
                    <a class=\"btn btn-light-green\" href=\"./?page=penilaian&aksi=ubah&a=$data[id_perusahaan]&b=$data[id_jenispenginapan]\"><i class='fa fa-pencil-alt'></i></a>
                    <a class=\"btn btn-yellow\" data-a=\".$data[namaPenginapan] - $data[namaPerusahaan]\" id='hapus' href='./proses/proseshapus.php/?op=nilai&id=".$data['id_perusahaan']."'><i class='fa fa-trash-alt'></i></a></td>
                </div></tr>";
                $no++;
            }
        }else{
            echo "<tr><td  class='text-center text-green' colspan='4'><b>Kosong</b></td></tr>";
        }
        break;
}