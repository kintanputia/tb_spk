<?php
require '../connect.php';
require '../class/crud.php';
$crud=new crud($konek);

if ($_SERVER['REQUEST_METHOD']=='GET') {
    $id=@$_GET['id'];
    $op=@$_GET['op'];
}else if ($_SERVER['REQUEST_METHOD']=='POST'){
    $id=@$_POST['id'];
    $op=@$_POST['op'];
}
$penginapan=@$_POST['penginapan'];
$perusahaan=@$_POST['perusahaan'];
$kriteria=@$_POST['kriteria'];
$sifat=@$_POST['sifat'];
$nilai=@$_POST['nilai'];
$keterangan=@$_POST['keterangan'];
$bobot=@$_POST['bobot'];
switch ($op){
    case 'penginapan'://tambah data penginapan
        $query="INSERT INTO jenis_penginapan (namaPenginapan) VALUES ('$penginapan')";
        $crud->addData($query,$konek);
    break;
    case 'perusahaan': //tambah data perusahaan
        $query="INSERT INTO perusahaan (namaPerusahaan) VALUES ('$perusahaan')";
        $crud->addData($query,$konek);
    break;
    case 'kriteria'://tambah data kriteria
        $cek="SELECT namaKriteria FROM kriteria WHERE namaKriteria='$kriteria'";
        $query=null;
        $query="INSERT INTO kriteria (namaKriteria,sifat) VALUES ('$kriteria','$sifat')";
        $crud->multiAddData($cek,$query,$konek);
    break;
    case 'subkriteria'://tambah data sub kriteria
        $cek="SELECT id_nilaikriteria FROM nilai_kriteria WHERE (id_kriteria='$kriteria' AND nilai ='$nilai') OR (id_kriteria='$kriteria' AND keterangan = '$keterangan')";
        $query=null;
        $query.="INSERT INTO nilai_kriteria (id_kriteria,nilai,keterangan) VALUES ('$kriteria','$nilai','$keterangan');";
        $crud->multiAddData($cek,$query,$konek);
    break;
    case 'bobot'://tambah data bobot
        $cek="SELECT id_bobotkriteria FROM bobot_kriteria WHERE id_jenispenginapan='$penginapan'";
        $query=null;
        for ($i=0;$i<count($kriteria);$i++){
            $query.="INSERT INTO bobot_kriteria (id_jenispenginapan,id_kriteria,bobot) VALUES ('$penginapan','$kriteria[$i]','$bobot[$i]');";
        }
        $crud->multiAddData($cek,$query,$konek);
    break;
    case 'nilai'://tambah data nilai
        $cek="SELECT id_perusahaan FROM nilai_perusahaan WHERE id_perusahaan='$perusahaan'";
        $query=null;
        for ($i=0;$i<count($nilai);$i++){
            $query.="INSERT INTO nilai_perusahaan (id_perusahaan,id_jenispenginapan,id_kriteria,id_nilaikriteria) VALUES ('$perusahaan','$penginapan','$kriteria[$i]','$nilai[$i]');";
        }
        $crud->multiAddData($cek,$query,$konek);
    break;
}