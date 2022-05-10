<!-- judul -->
<div class="panel">
    <div class="panel-middle" id="judul">
        <div id="judul-text">
            <h2 class="text-green">HASIL</h2>
            Halamanan Utama Hasil Penilaian
        </div>
    </div>
</div>
<!-- judul -->
<div class="panel">
    <div class="panel-top">
        <div style="float:left;width: 300px;">
            <select class="form-custom" name="pilih"  id="pilihHasil">
                <option disabled selected value="">-- Pilih Jenis Penginapan --</option>;
                <?php
                $query="SELECT*FROM jenis_penginapan";
                $execute=$konek->query($query);
                if ($execute->num_rows > 0){
                    while ($data=$execute->fetch_array(MYSQLI_ASSOC)){
                        echo "<option value=$data[id_jenispenginapan]>$data[namaPenginapan]</option>";
                    }
                }else{
                    echo '<option disabled value="">Tidak ada data</option>';
                }
                ?>
            </select>
        </div>
        <div style="clear: both"></div>
    </div>
    <div class="panel-middle">
        <div id="valueHasil">
            <p class='text-center'><b>Pilih List Penginapan, untuk menampilkan hasil</b></p>
        </div>
    </div>
    <div class="panel-bottom"></div>
</div>