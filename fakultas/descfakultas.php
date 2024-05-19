<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$tabel = "fakultas";
include( "judulfakultas.php" );
$dataform[nama] = "form";
$dataform[metod] = "post";
$dataform[action] = "index.php";
$dataform[attr] = "";
$datatabel[a][jenis] = "hidden";
$datatabel[a][nama] = "pilihan";
$datatabel[a][value] = "{$pilihan}";
$datatabel[x][jenis] = "hidden";
$datatabel[x][nama] = "aksi";
$datatabel[x][value] = "tambah";
$datatabel[2][jenis] = "text";
$datatabel[2][nama] = "id";
$datatabel[2][attr] = "size=8 class=masukan";
$datatabel[2][judul] = "Kode {$JUDULFAKULTAS}";
$datatabel[2][td1][attr] = "class=judulform";
$datatabel[2][periksa] = 1;
$datatabel[2][tipe] = $TIPE_STRING;
$datatabel[3][jenis] = "text";
$datatabel[3][nama] = "nama";
$datatabel[3][attr] = "class=masukan size=30";
$datatabel[3][judul] = "Nama {$JUDULFAKULTAS}";
$datatabel[3][td1][attr] = "class=judulform";
$datatabel[3][periksa] = 1;
$datatabel[3][tipe] = $TIPE_STRING;
$datatabel[1][jenis] = "text";
$datatabel[1][nama] = "nippimpinan";
$datatabel[1][attr] = "class=masukan size=30";
$datatabel[1][judul] = "NIP Dekan/Pimpinan";
$datatabel[1][td1][attr] = "class=judulform";
$datatabel[1][periksa] = 1;
$datatabel[1][tipe] = $TIPE_STRING;
$datatabel[4][jenis] = "text";
$datatabel[4][nama] = "namapimpinan";
$datatabel[4][attr] = "class=masukan size=30";
$datatabel[4][judul] = "Nama Dekan/Pimpinan";
$datatabel[4][td1][attr] = "class=judulform";
$datatabel[4][periksa] = 1;
$datatabel[4][tipe] = $TIPE_STRING;
$datatabel[5][jenis] = "textarea";
$datatabel[5][nama] = "alamat";
$datatabel[5][attr] = "class=masukan cols=50 rows=3";
$datatabel[5][judul] = "Alamat {$JUDULFAKULTAS}";
$datatabel[5][td1][attr] = "class=judulform";
$datatabel[5][periksa] = 1;
$datatabel[5][tipe] = $TIPE_STRING;
?>
