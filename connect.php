<?php
$konek=new mysqli('localhost','root','','spksaw1');
if ($konek->connect_errno){
    "Database Error".$konek->connect_error;
}
?>