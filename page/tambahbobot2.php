
<!-- judul -->
<div class="panel-top">
    <b class="text-green"><i class="fa fa-plus-circle text-green"></i> Tambah data</b>
</div>
<form id="form" action="./proses/prosestambah.php" method="POST">
    <input type="hidden" value="bobot" name="op">
    <div class="panel-middle">
        <div class="group-input">
            <label for="penginapan">Jenis Penginapan</label>
            <select class="form-custom" required name="penginapan" id="penginapan">
                <option selected disabled>--Pilih Jenis Penginapan--</option>
                <?php
                $query="SELECT * FROM jenis_penginapan";
                $execute=$konek->query($query);
                if ($execute->num_rows > 0){
                    while($data=$execute->fetch_array(MYSQLI_ASSOC)){
                        echo "<option value=\"$data[id_jenispenginapan]\">$data[namaPenginapan]</option>";
                    }
                }else {
                    echo "<option value=\"\">Belum ada Jenis Penginapan</option>";
                }
                ?>
            </select>
        </div>
        <?php
$listWeight=array(
    array("nama"=>"1","nilai"=>1),
    array("nama"=>"2","nilai"=>2),
    array("nama"=>"3","nilai"=>3),
    array("nama"=>"4","nilai"=>4),
    array("nama"=>"5","nilai"=>5),
);
        $query="SELECT * FROM kriteria";
        $execute=$konek->query($query);
        if ($execute->num_rows > 0){
            while($data=$execute->fetch_array(MYSQLI_ASSOC)){
                echo "<div class=\"group-input\">
                        <label for=\"$data[namaKriteria]\">$data[namaKriteria]</label>
                        <input type='hidden' value=$data[id_kriteria] name='kriteria[]'>
                            <select class=\"form-custom\" required name=\"bobot[]\" id=\"$data[namaKriteria]\">
                            <option selected disabled>--Pilih Bobot $data[namaKriteria]--</option>";
                            foreach ($listWeight as $key) {
                                echo "<option value=\"$key[nilai]\">$key[nama]</option>";
                            }
                echo "      </select>
                      </div>
                ";
            }
        }
        ?>
    </div>
    <div class="panel-bottom">
        <button type="submit" id="buttonsimpan" class="btn btn-green"><i class="fa fa-save"></i> Simpan</button>
        <button type="reset" id="buttonreset" class="btn btn-second">Reset</button>
    </div>
</form>