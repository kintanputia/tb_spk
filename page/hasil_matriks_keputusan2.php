<?php
$cookiePilih=@$_COOKIE['pilih'];
//$cookiePilih=null;
if (isset($cookiePilih) && !empty($cookiePilih)){
/***************awal set variabel************/
    $valueMinMax=array(); $kriteriaArray=array(); $perusahaanArray=array(); $forminmax=array(); $simpanNormalisasi=array(); $bobotArray=array();
    $querykriteria="SELECT namaKriteria FROM kriteria";//query tabel kriteria
    //query get data alternative
    $queryAlternative="SELECT perusahaan.namaPerusahaan AS namaPerusahaan,id_perusahaan FROM nilai_perusahaan INNER JOIN perusahaan USING(id_perusahaan) WHERE id_jenispenginapan='$cookiePilih' GROUP BY id_perusahaan ";
    //query get data bobot
    $queryBobot="SELECT id_kriteria,bobot FROM bobot_kriteria WHERE id_jenispenginapan='$cookiePilih'";
    //query get data nilai
    $indexArray=0;//variabel index array
/***************akhir set variabel************/
    $executeBobot=$konek->query($queryBobot);
    if ($executeBobot->num_rows>0) {
        while ($dataBobot=$executeBobot->fetch_array(MYSQLI_ASSOC)) {
            $bobotArray[$dataBobot['id_kriteria']]=@$dataBobot['bobot'];
        }
    }
/////////////////////////////////////////////////////////////////awal set header table matriks keputusan
$executeQueryTabel=$konek->query( $querykriteria);
echo "<div class='panel-middle'>";
echo "<p><b>Matriks Keputusan</b></p><table><tr><th rowspan='2'>Alternative</th><th colspan='$executeQueryTabel->num_rows'>Kriteria</th></tr><tr>";
while ($data=$executeQueryTabel->fetch_array(MYSQLI_ASSOC)){
    echo "<th>$data[namaKriteria]</th>";
    array_push($kriteriaArray,$data['namaKriteria']);//simpan nama nama kriteria ke array
}
echo "</tr>";
/////////////////////////////////////////////////////////////////akhir set header table matriks keputusan
/******awal isi table matriks keputusan****/
$executeGetAlternative=$konek->query($queryAlternative);
$colspan=$executeQueryTabel->num_rows+1;
if ($executeGetAlternative->num_rows > 0){
    while ($dataAlternative=$executeGetAlternative->fetch_array(MYSQLI_ASSOC)){
        echo"<tr id=\"data\"><td>$dataAlternative[namaPerusahaan]</td>";
        $queryGetNilai="SELECT nilai_kriteria.nilai AS nilai,kriteria.sifat AS sifat,nilai_perusahaan.id_kriteria AS id_kriteria FROM nilai_perusahaan JOIN kriteria ON kriteria.id_kriteria=nilai_perusahaan.id_kriteria JOIN nilai_kriteria ON nilai_kriteria.id_nilaikriteria=nilai_perusahaan.id_nilaikriteria WHERE (id_jenispenginapan='$cookiePilih' AND id_perusahaan='$dataAlternative[id_perusahaan]')";
        $executeNilai=$konek->query($queryGetNilai);
        $i=0;
        while ($dataNilai=$executeNilai->fetch_array(MYSQLI_ASSOC)){
            echo "<td>$dataNilai[nilai]</td>";
            $nilaiPerusahaan[$indexArray][$i]=array("sifat"=>$dataNilai['sifat'],"id_kriteria"=>$dataNilai['id_kriteria']);
            $forminmax[$dataNilai['id_kriteria']][$indexArray]=$dataNilai['nilai'];
            $i++;
        }
            echo "</tr>";
            $perusahaanArray[$indexArray]=["namaPerusahaan"=>$dataAlternative['namaPerusahaan'],"id_perusahaan"=>$dataAlternative['id_perusahaan']];
            $indexArray++;
    }
}else{
    echo "<tr class='text-center'><td colspan=\"$colspan\">Data Kosong</td></tr>";
}
echo "</table>";
/******akhir isi table matriks keputusan****/
/////////////////////////////////////////////////////////////////awal set header table normalisasi
echo "<p><b>Normalisasi Matriks Keputusan</b></p><table><tr><th rowspan='2'>Alternative</th><th colspan='$executeQueryTabel->num_rows'>Kriteria</th></tr><tr>";
foreach ($kriteriaArray as $namaKriteria) {
    echo "<th>$namaKriteria</th>";
}
echo "</tr>";
/////////////////////////////////////////////////////////////////akhir set header table normalisasi
/******awal isi table normalisasi****/
if (!empty($perusahaanArray)){
    $simpanrangking=array();
    if (!empty($bobotArray)) {
        for ($j=0; $j< count($perusahaanArray); $j++) { 
            echo "<tr id=\"data\"><td>".$perusahaanArray[$j]['namaPerusahaan']."</td>";
                for ($k=0; $k<count($nilaiPerusahaan[$j]) ; $k++) {
                    $idKriteria=$nilaiPerusahaan[$j][$k]['id_kriteria'];
                    echo "<td>".$hasil=normalisasi($forminmax[$idKriteria][$j],$forminmax[$idKriteria],$nilaiPerusahan[$j][$k]["sifat"])."</td>";
                    $simpanrangking[$j][$k]=floatval($hasil)*$bobotArray[$idKriteria];
                }
            echo"</tr>";
        }
    }else{
        echo "<tr class='text-center'><td colspan=\"$colspan\"><b>Bobot Kriteria tidak boleh kosong</b></td></tr>";
    }
}else{
    echo "<tr class='text-center'><td colspan=\"$colspan\">Data Kosong</td></tr>";
}
echo "</table>";
/******akhir isi table normalisasi****/
/////////////////////////////////////////////////////////////////awal set header table perangkingan
echo "<p><b>Normalisasi Matriks Keputusan</b></p> <table> <tr><th rowspan='2'>Alternative</th><th colspan='$executeQueryTabel->num_rows'>Kriteria</th><th rowspan='2'>Hasil</th></tr><tr>";
foreach ($kriteriaArray as $namaKriteria) {
    echo "<th>$namaKriteria</th>";
}
echo "</tr>";
/////////////////////////////////////////////////////////////////akhir set header table perangkingan
/******awal isi table perangkingan****/
if (!empty($perusahaanArray)){
    if (!empty($bobotArray)) {
        for ($j=0; $j< count($perusahaanArray); $j++) {
            $hasilakhir=0;
            echo "<tr id=\"data\"><td>".$perusahaanArray[$j]['namaPerusahaan']."</td>";
                for ($k=0; $k<count($simpanrangking[$j]) ; $k++) {
                    echo "<td>".$hasil=$simpanrangking[$j][$k]."</td>";
                    $hasilakhir+=floatval($hasil);
                }
                    echo "<td>".round($hasilakhir,3)."</td>";
            echo"</tr>";
        }
    }else{
        echo "<tr class='text-center'><td colspan=\"$colspan\"><b>Bobot Kriteria tidak boleh kosong</b></td></tr>";
    }
}else{
    echo "<tr class='text-center'><td colspan=\"$colspan\">Data Kosong</td></tr>";
}
echo "</table>";
    $queryHasil="SELECT hasil.hasil AS hasil,jenis_penginapan.namaPenginapan,perusahaan.namaPerusahaan AS namaPerusahaan FROM hasil JOIN jenis_penginapan ON jenis_penginapan.id_jenispenginapan=hasil.id_jenispenginapan JOIN perusahaan ON perusahaan.id_perusahaan=hasil.id_perusahaan WHERE hasil.hasil=(SELECT MAX(hasil) FROM hasil WHERE id_jenispenginapan='$cookiePilih')";
    $execute=$konek->query($queryHasil)->fetch_array(MYSQLI_ASSOC);
    echo "<p>Jadi rekomendasi pemilihan perusahaan <i>$execute[namaPenginapan]</i> jatuh pada <i>$execute[namaPerusahaan]</i> dengan Nilai <b>".round($execute['hasil'],3)."</b></p>";
echo "</div>";
}