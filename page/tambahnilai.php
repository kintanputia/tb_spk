<!-- judul -->
<div class="panel-top">
    <b class="text-green"><i class="fa fa-plus-circle text-green"></i> Tambah data</b>
</div>
<form id="form" action="./proses/prosestambah.php" method="POST">
    <input type="hidden" value="nilai" name="op">
    <div class="panel-middle">
        <div class="group-input">
            <label for="perusahaan">Perusahaan</label>
            <select class="form-custom" required name="perusahaan" id="perusahaan">
                <option selected disabled>--Pilih Perusahaan--</option>
                <?php
                $query="SELECT id_perusahaan,namaPerusahaan FROM perusahaan";
                $execute=$konek->query($query);
                if ($execute->num_rows > 0){
                    while($data=$execute->fetch_array(MYSQLI_ASSOC)){
                        echo "<option value=\"$data[id_perusahaan]\">$data[namaPerusahaan]</option>";
                    }
                }else {
                    echo "<option disabled value=\"\">Belum ada Perusahaan</option>";
                }
                ?>
            </select>
        </div>
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
                    echo "<option disabled value=\"\">Belum ada Jenis Penginapan</option>";
                }
                ?>
            </select>
        </div>
        <?php
        $query="SELECT * FROM kriteria";
        $execute=$konek->query($query);
        if ($execute->num_rows > 0){
            while($data=$execute->fetch_array(MYSQLI_ASSOC)){
                echo "<div class=\"group-input\">";
                echo "<label for=\"nilai\">$data[namaKriteria]</label>";
                echo "<input type='hidden' value=$data[id_kriteria] name='kriteria[]'>";
                echo "<select class=\"form-custom\" required name=\"nilai[]\" id=\"nilai\">";
                echo "<option disabled selected>-- Pilih $data[namaKriteria] --</option>";
                $query2="SELECT id_nilaikriteria,keterangan FROM nilai_kriteria WHERE id_kriteria='$data[id_kriteria]'";
                $execute2=$konek->query($query2);
                    if ($execute2->num_rows > 0){
                        while ($data2=$execute2->fetch_array(MYSQLI_ASSOC)){
                            echo "<option value=\"$data2[id_nilaikriteria]\">$data2[keterangan]</option>";
                        }
                    }else{
                        echo "<option disabled value=\"\">Belum ada Nilai Kriteria</option>";
                    };
                echo "</select></div>";
            }
        }
        ?>
    </div>
    <div class="panel-bottom">
        <button type="submit" id="buttonsimpan" class="btn btn-green"><i class="fa fa-save"></i> Simpan</button>
        <button type="reset" id="buttonreset" class="btn btn-second">Reset</button>
    </div>
</form>