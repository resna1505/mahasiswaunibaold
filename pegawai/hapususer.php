<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

@cekuser( "AD" );
if ( $aksi == "hapususer" )
{
    if ( $iduser == "" )
    {
        $err = "idkosong";
    }
    else if ( $iduser != "superadmin" && $iduser != $admin )
    {
        $query = "DELETE FROM presensi WHERE IDUSER='{$iduser}' AND '{$iduser}'!='superadmin'";
        mysqli_query($koneksi,$query);
        $query = "DELETE FROM kegiatan WHERE IDUSER='{$iduser}' AND '{$iduser}'!='superadmin'";
        mysqli_query($koneksi,$query);
        $query = "DELETE FROM penugas WHERE ID='{$iduser}' AND '{$iduser}'!='superadmin'";
        mysqli_query($koneksi,$query);
        $query = "DELETE FROM pesan WHERE KE='{$iduser}' AND '{$iduser}'!='superadmin'";
        mysqli_query($koneksi,$query);
        $query = "DELETE FROM shiftbebas WHERE IDUSER='{$iduser}' AND '{$iduser}'!='superadmin'";
        mysqli_query($koneksi,$query);
        $query = "DELETE FROM gaji WHERE IDUSER='{$iduser}' AND '{$iduser}'!='superadmin'";
        mysqli_query($koneksi,$query);
        $query = "DELETE FROM pendapatanb WHERE IDUSER='{$iduser}' AND '{$iduser}'!='superadmin'";
        mysqli_query($koneksi,$query);
        $query = "SELECT ID FROM pengeluaranb WHERE IDUSER='{$iduser}' AND '{$iduser}'!='superadmin'";
        $h = mysqli_query($koneksi,$query);
		if(0 < sqlnumrows($h)){
			while ($dt = sqlfetcharray($h)){
				$query = "DELETE FROM detilpengeluaranb WHERE IDP='{$dt['ID']}'";
				mysqli_query($koneksi,$query);
			}
		}
        
        $query = "DELETE FROM pengeluaranb WHERE IDUSER='{$iduser}' AND '{$iduser}'!='superadmin'";
        mysqli_query($koneksi,$query);
        $query = "DELETE FROM penugasan WHERE IDUSER='{$iduser}' AND '{$iduser}'!='superadmin'";
        mysqli_query($koneksi,$query);
        $query = "DELETE FROM naikpangkat WHERE IDUSER='{$iduser}' AND '{$iduser}'!='superadmin'";
        mysqli_query($koneksi,$query);
        $query = "DELETE FROM belajar WHERE IDUSER='{$iduser}' AND '{$iduser}'!='superadmin'";
        mysqli_query($koneksi,$query);
        $query = "DELETE FROM ruangdiskusi WHERE PENGIRIM='{$iduser}'";
        mysqli_query($koneksi,$query);
        $query = "DELETE FROM topikdiskusi WHERE PENGIRIM='{$iduser}'";
        mysqli_query($koneksi,$query);
        $query = "DELETE FROM undangandiskusi WHERE UNDANGAN='{$iduser}'";
        mysqli_query($koneksi,$query);
        $query = "DELETE FROM pesertadiskusi WHERE IDUSER='{$iduser}'";
        mysqli_query($koneksi,$query);
        $query = "DELETE FROM user WHERE ID='{$iduser}' AND ID!='superadmin'";
       mysqli_query($koneksi,$query);
        if ( sqlaffectedrows( $koneksi ) == 0 )
        {
            $err = "nouser";
        }
        else
        {
            $err = "delok";
            removedir( "../file/p/{$iduser}" );
        }
    }
    else
    {
        $err = "idadmin";
    }
}
if ( $err == "idkosong" )
{
    $errmesg = "ID User harus diisi";
}
else if ( $err == "idadmin" )
{
    $errmesg = "ID User = superadmin atau ID Anda sendiri tidak bisa dihapus";
}
else if ( $err == "nouser" )
{
    $errmesg = "Tidak ada user dengan ID = {$iduser}";
}
else if ( $err == "delok" )
{
    $errmesg = "Data user dengan ID = {$iduser} telah terhapus";
}
printmesg( $errmesg );
echo "\r\n<CENTER>\r\n<table width=100% ";
echo $tabellatar;
echo ">\r\n<tr\tvalign=top>\r\n<td align=center>\t\r\n";
printman( $manhapuspegawai );
echo "\r\n<form name=form action=index.php?pilihan=hapus method=post>\r\n<input type=hidden name=pilihan value=hapus>\r\n<input type=hidden name=aksi value=hapususer>\r\n<table ";
echo $tabelisian2;
echo ">\r\n<tr>\r\n\t<td>ID User \r\n\t<input class=teksbox name=iduser type=text maxlength=20 size=20> \r\n\t\t\t<a \r\n\t\t\thref=\"javascript:showUserList('form,wewenang,iduser',\r\n\t\t\tdocument.form.iduser.value)\">\r\n\t\t\t<img align=top border=0 height=21 src='../gambar/p108.gif'>\r\n\t\t\t</a>\r\n\t<input class=tombol type=submit value=Hapus\r\n\t";
printconfirmjs( "Hapus data Operator? Data yang dihapus tidak dapat dikembalikan lagi" );
echo "></td>\r\n</tr>\r\n</table></form>\r\n</td>\r\n</tr>\r\n</table>\r\n";
?>
