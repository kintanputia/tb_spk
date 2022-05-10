<?php
$a=htmlspecialchars(@$_GET['a']);
$b=htmlspecialchars(@$_GET['b']);
$querylihat="SELECT id_nilaiperusahaan,kriteria.namaKriteria AS namaKriteria,nilai_kriteria.keterangan AS keterangan FROM nilai_perusahaan
INNER JOIN kriteria USING (id_kriteria)
INNER JOIN nilai_kriteria USING (id_nilaikriteria)
WHERE nilai_perusahaan.id_perusahaan='$a' AND nilai_perusahaan.id_jenispenginapan='$b'";
$execute2=$konek->query($querylihat);
if ($execute2->num_rows == 0){
    header('location:./?page=penilaian');
}
?>
<!-- judul -->
<div class="panel-top">
    <b class="text-green">Detail data</b>
</div>
<form>
    <div class="panel-middle">
        <div class="group-input">
            <?php
            $query="SELECT namaPerusahaan FROM perusahaan WHERE id_perusahaan='$a'";
            $execute=$konek->query($query);
            $data=$execute->fetch_array(MYSQLI_ASSOC);
            ?>
            <div class="group-input">
                <label for="jenispenginapan">Nama Perusahaan</label>
                <input class="form-custom" value="<?php echo $data['namaPerusahaan'];?>" disabled type="text" autocomplete="off" required name="jenispenginapan" id="jenispenginapan">
            </div>
        </div>
        <div class="group-input">
            <?php
            $query="SELECT namaPenginapan FROM jenis_penginapan WHERE id_jenispenginapan='$b'";
            $execute=$konek->query($query);
            $data=$execute->fetch_array(MYSQLI_ASSOC);
            ?>
            <div class="group-input">
                <label for="jenispenginapan">Jenis Penginapan</label>
                <input class="form-custom" value="<?php echo $data['namaPenginapan'];?>" disabled type="text" autocomplete="off" required name="jenispenginapan" id="jenispenginapan" placeholder="jenispenginapan">
            </div>
        </div>
        <?php
        $execute2=$konek->query($querylihat);
        while($data2=$execute2->fetch_array(MYSQLI_ASSOC)){
            echo "<div class=\"group-input\">
                        <label for=\"\">$data2[namaKriteria]</label>
                        <input class=\"form-custom\" value=\"$data2[keterangan]\" disabled type=\"text\" autocomplete=\"off\" required name=\"bobot[]\">
                      </div>
                ";
        }
        ?>
    </div>
    <div class="panel-bottom">
        <button type="submit" class="btn btn-green">Simpan</button>
        <button type="reset" class="btn btn-second">Reset</button>
    </div>
</form>