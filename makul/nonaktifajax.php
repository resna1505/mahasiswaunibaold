<?php
$root='../';
include_once( $root."db.php" );
$koneksi = mysqli_connect($hostsql, $loginsql, $passwordsql, $basisdatasql,$portsql );
if ( !$koneksi )
{
    echo "Error koneksi ke basis data. Periksa apakah server basis data telah dihidupkan.  Hubungi Administrator Anda";
    exit();
}
#mysqli_select_db( $basisdatasql, $koneksi );
#mysqli_query( $koneksi,"SET time_zone='{$offset}';" );
$id=$_POST['id'];
//sabar/
$q="update mahasiswa set STATUS='N' where ID='{$id}'";
if(mysqli_query($koneksi,$q)){
	echo 'berhasil';
}else{
	echo 'gagal';
}
?>