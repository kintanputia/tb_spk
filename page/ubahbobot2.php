<?php
$listWeight=array(
    array("nama"=>"1","nilai"=>1),
    array("nama"=>"2","nilai"=>2),
    array("nama"=>"3","nilai"=>3),
    array("nama"=>"4","nilai"=>4),
    array("nama"=>"5","nilai"=>5),
);
$id=htmlspecialchars(@$_GET['id']);
$querylihat="SELECT id_jenispenginapan,bobot,id_bobotkriteria,kriteria.namaKriteria AS namaKriteria FROM bobot_kriteria INNER JOIN kriteria USING(id_kriteria) WHERE id_jenispenginapan='$id'";
$execute2=$konek->query($querylihat);
if ($execute2->num_rows == 0){
    header('location:./?page=bobot');
}
?>
<!-- judul -->
<div class="panel-top panel-top-edit">
    <b><i class="fa fa-pencil-alt"></i> Ubah data</b>
</div>
<form id="form" action="./proses/prosesubah.php" method="POST">
    <input type="hidden" value="bobot" name="op">
    <div class="panel-middle">
        <div class="group-input">
            <div class="group-input">
                <?php
                $query="SELECT namaPenginapan FROM jenis_penginapan WHERE id_jenispenginapan='$id'";
                $execute=$konek->query($query);
                $data=$execute->fetch_array(MYSQLI_ASSOC);
                ?>
                <div class="group-input">
                    <label for="jenispenginapan">Jenis Penginapan</label>
                    <input class="form-custom" value="<?php echo $data['namaPenginapan'];?>" disabled type="text" autocomplete="off" required name="penginapan" id="penginapan">
                </div>
            </div>
        </div>
        <?php
        $execute2=$konek->query($querylihat);
        while($data=$execute2->fetch_array(MYSQLI_ASSOC)){
            echo "<div class=\"group-input\">
                    <label for=\"$data[namaKriteria]\">$data[namaKriteria]</label>
                    <input type='hidden' value=\"$data[id_bobotkriteria]\" name=\"id[]\">
                    <select class=\"form-custom\" required name=\"bobot[]\" id=\"$data[namaKriteria]\">
                    <option selected disabled>--Pilih Bobot $data[namaKriteria]--</option>";
                foreach ($listWeight as $key) {
                    if ($key['nilai']==$data['bobot']) {
                        $selected="selected";
                    }else{
                        $selected=null;
                    }
                    echo "<option $selected value=\"$key[nilai]\">$key[nama]</option>";
                }
            echo "</select>
            </div>
                ";
        }
        ?>
    </div>
    <div class="panel-bottom">
        <button type="submit" id="buttonsimpan" class="btn btn-green"><i class="fa fa-save"></i> Simpan</button>
        <button type="reset" id="buttonreset" class="btn btn-second">Reset</button>
    </div>
</form>