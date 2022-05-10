<?php
class saw {

    private $konek;
    private $idCookie;
    public $simpanNormalisasi=array();
    public function setconfig($konek,$idCookie){
        $this->konek=$konek;
        $this->idCookie=$idCookie;
    }
    public function getConnect(){
       return $this->konek;
    }
    //mendapatkan kriteria
    public function getKriteria(){
        $data=array();
        $querykriteria="SELECT namaKriteria FROM kriteria";//query tabel kriteria
        $execute=$this->getConnect()->query($querykriteria);
        while ($row=$execute->fetch_array(MYSQLI_ASSOC)) {
            array_push($data,$row['namaKriteria']);
        }
        return $data;
    }
    //mendapatkan alternative
    public function getAlternative(){
        $data=array();
        $queryAlternative="SELECT perusahaan.namaPerusahaan AS namaPerusahaan,id_perusahaan FROM nilai_perusahaan INNER JOIN perusahaan USING(id_perusahaan) WHERE id_jenispenginapan='$this->idCookie' GROUP BY id_perusahaan ";
        $execute=$this->getConnect()->query($queryAlternative);
        while ($row=$execute->fetch_array(MYSQLI_ASSOC)) {
            array_push($data,array("namaPerusahaan"=>$row['namaPerusahaan'],"id_perusahaan"=>$row['id_perusahaan']));
        }
        return $data;
    }
    public function getNilaiMatriks($id_perusahaan){
        $data=array();
        $queryGetNilai="SELECT nilai_kriteria.nilai AS nilai,kriteria.sifat AS sifat,nilai_perusahaan.id_kriteria AS id_kriteria FROM nilai_perusahaan JOIN kriteria ON kriteria.id_kriteria=nilai_perusahaan.id_kriteria JOIN nilai_kriteria ON nilai_kriteria.id_nilaikriteria=nilai_perusahaan.id_nilaikriteria WHERE (id_jenispenginapan='$this->idCookie' AND id_perusahaan='$id_perusahaan')";
        $execute=$this->getConnect()->query($queryGetNilai);
        while ($row=$execute->fetch_array(MYSQLI_ASSOC)) {
            array_push($data,array(
                "nilai"=>$row['nilai'],
                "sifat"=>$row['sifat'],
                "id_kriteria"=>$row['id_kriteria']
            ));
        }
        return $data;
    }
    public function getArrayNilai($id_kriteria){
        $data=array();
        $queryGetArrayNilai="SELECT nilai_kriteria.nilai AS nilai FROM nilai_perusahaan INNER JOIN nilai_kriteria ON nilai_perusahaan.id_nilaikriteria=nilai_kriteria.id_nilaikriteria WHERE nilai_perusahaan.id_kriteria='$id_kriteria' AND nilai_perusahaan.id_jenispenginapan='$this->idCookie'";
        $execute=$this->getConnect()->query($queryGetArrayNilai);
        while ($row=$execute->fetch_array(MYSQLI_ASSOC)) {
            array_push($data,$row['nilai']);
        }
        return $data;
    }
    //rumus normalisasai
    public function normalisasi($array,$sifat,$nilai){
        if ($sifat=='Benefit'){
            $result=$nilai/max($array);
        }elseif ($sifat=='Cost'){
            $result=min($array)/$nilai;
        }
        return round($result,3);
    }
    //mendapatkan bobot kriteria
    public function getBobot($id_kriteria){
        $queryBobot="SELECT bobot FROM bobot_kriteria WHERE id_jenispenginapan='$this->idCookie' AND id_kriteria='$id_kriteria' ";
        $row=$this->getConnect()->query($queryBobot)->fetch_array(MYSQLI_ASSOC);
        return $row['bobot'];
    }
    //meyimpan hasil perhitungan
    public function simpanHasil($id_perusahaan,$hasil){
        $queryCek="SELECT hasil FROM hasil WHERE id_perusahaan='$id_perusahaan' AND id_jenispenginapan='$this->idCookie'";
        $execute=$this->getConnect()->query($queryCek);
        if ($execute->num_rows > 0) {
            $querySimpan="UPDATE hasil SET hasil='$hasil' WHERE id_perusahaan='$id_perusahaan' AND id_jenispenginapan='$this->idCookie'";
        }else{
            $querySimpan="INSERT INTO hasil(hasil,id_perusahaan,id_jenispenginapan) VALUES ('$hasil','$id_perusahaan','$this->idCookie')";
        }
        $execute=$this->getConnect()->query($querySimpan);

    }
    //Kmencari kesimpulan
    public function getHasil(){
    $queryHasil     =   "SELECT hasil.hasil AS hasil,jenis_penginapan.namaPenginapan,perusahaan.namaPerusahaan AS namaPerusahaan FROM hasil JOIN jenis_penginapan ON jenis_penginapan.id_jenispenginapan=hasil.id_jenispenginapan JOIN perusahaan ON perusahaan.id_perusahaan=hasil.id_perusahaan WHERE hasil.hasil=(SELECT MAX(hasil) FROM hasil WHERE id_jenispenginapan='$this->idCookie')";
    $execute        =   $this->getConnect()->query($queryHasil)->fetch_array(MYSQLI_ASSOC);
    echo "<p>Jadi rekomendasi pemilihan perusahaan <i>$execute[namaPenginapan]</i> jatuh pada <i>$execute[namaPerusahaan]</i> dengan Nilai <b>".round($execute['hasil'],3)."</b></p>";
    }

}