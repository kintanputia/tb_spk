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
    case 'penginapan':
        $query="DELETE FROM jenis_penginapan WHERE id_jenispenginapan='$id'";
        $crud->delete($query,$konek);
        break;
    case 'perusahaan':
        $query="DELETE FROM perusahaan WHERE id_perusahaan='$id'";
        $crud->delete($query,$konek);
        break;
    case 'kriteria':
        $query="DELETE FROM kriteria WHERE id_kriteria='$id'";
        $crud->delete($query,$konek);
        break;
    case 'subkriteria':
        $query="DELETE FROM nilai_kriteria WHERE id_nilaikriteria='$id'";
        $crud->delete($query,$konek);
        break;
    case 'bobot':
        $query="DELETE FROM bobot_kriteria WHERE id_jenispenginapan='$id'";
        $crud->delete($query,$konek);
        break;
    case 'nilai':
        $query="DELETE FROM nilai_perusahaan WHERE id_perusahaan='$id'";
        $crud->delete($query,$konek);
        break;
}