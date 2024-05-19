<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $aksi == "hapus" )
{
    cekhaktulis( $kodemenu );
    $q = "DELETE FROM tbpst WHERE KDPSTTBPST='{$idhapus}'";
    doquery($koneksi, $q );
    buatlog( 14 );
    if ( 0 < sqlaffectedrows( $koneksi ) )
    {
        $ketlog = "Hapus Data PS dengan \r\n\t\tKDPSTTBPST ='{$idhapus}'\r\n\t\t";
        buatlog( 47 );
        $errmesg = "Data Program Studi dengan KDPSTTBPST = '{$idhapus}' berhasil dihapus";
    }
    else
    {
        $errmesg = "Data Program Studi dengan KDPSTTBPST = '{$idhapus}' tidak berhasil dihapus";
    }
    $aksi = "tampilkan";
}
if ( $aksi == "update" )
{
    cekhaktulis( $kodemenu );
    if ( trim( $id ) == "" )
    {
        $errmesg = "Kode Program Studi harus diisi";
    }
    else if ( trim( $data[nama] ) == "" )
    {
        $errmesg = "Nama Program Studi harus diisi";
    }
    else
    {
        $q = "\r\n\t\t\tUPDATE tbpst SET \r\n \t\t\tNMPSTTBPST='{$data['nama']}',\r\n\t\t\tKDPSTTBPST='{$id}' \r\n\t\t\tWHERE KDPSTTBPST='{$idupdate}'\r\n\t\t";
        doquery($koneksi, $q );
        buatlog( 13 );
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $ketlog = "Update Data PS dengan \r\n\t\t\tKDPSTTBPST ={$idupdate}  \r\n\t\t\t";
            buatlog( 46 );
            $errmesg = "Data Program Studi berhasil diupdate";
            if ( $id != $idupdate )
            {
                $idupdate = $id;
            }
            $data[password] = "";
        }
        else
        {
            $errmesg = "Data Program Studi tidak diupdate";
        }
    }
    $aksi = "formupdate";
}
if ( $aksi == "formupdate" )
{
    cekhaktulis( $kodemenu );
    $q = "SELECT *\r\n\tFROM tbpst  WHERE \r\n\ttbpst.KDPSTTBPST='{$idupdate}'\r\n\t \r\n\t";
    $h = doquery($koneksi, $q );
    if ( 0 < sqlnumrows( $h ) )
    {
        printjudulmenu( "Update Data Program Studi" );
        printmesg( $errmesg );
        $d = sqlfetcharray( $h );
        echo "\r\n\t\t<form name=form action=index.php method=post  ENCTYPE='MULTIPART/FORM-DATA'>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "idupdate", "{$idupdate}", "" )."<tr class=judulform>\r\n\t\t\t<td>Kode Program Studi *</td>\r\n\t\t\t<td>".createinputtext( "id", "{$idupdate}", " class=masukan  size=10" )."</td>\r\n\t\t</tr> \r\n  \t\t <tr class=judulform>\r\n\t\t\t<td>Nama Program Studi *</td>\r\n\t\t\t<td>".createinputtext( "data[nama]", $d[NMPSTTBPST], " class=masukan  size=50" )."</td>\r\n\t\t</tr> \r\n \t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Update' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t\t";
    }
    else
    {
        $errmesg = "Data Program Studi dengan Kode = '{$idupdate}' tidak ada";
        $aksi = "";
    }
}
if ( $aksi == "tambah" )
{
    cekhaktulis( $kodemenu );
    if ( trim( $id ) == "" )
    {
        $errmesg = "Kode Program Studi harus diisi";
    }
    else if ( trim( $data[nama] ) == "" )
    {
        $errmesg = "Nama Program Studi harus diisi";
    }
    else
    {
        $q = "\r\n\t\t\tINSERT INTO tbpst (KDPSTTBPST,NMPSTTBPST) \r\n\t\t\tVALUES ('{$id}','{$data['nama']}')\r\n\t\t";
        doquery($koneksi, $q );
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $ketlog = "Tambah Data PS dengan \r\n\t\t\tKode ={$id}  \r\n\t\t\t";
            buatlog( 45 );
            $errmesg = "Data Program Studi berhasil ditambah";
            $data = "";
            $id = "";
        }
        else
        {
            $errmesg = "Data Program Studi tidak berhasil ditambah";
        }
    }
    $aksi = "formtambah";
}
if ( $aksi == "formtambah" )
{
    cekhaktulis( $kodemenu );
    printjudulmenu( "Tambah Data Program Studi" );
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" )."<tr class=judulform>\r\n\t\t\t<td>Kode Program Studi *</td>\r\n\t\t\t<td>".createinputtext( "id", $id, " class=masukan  size=10" )."</td>\r\n\t\t</tr> \r\n  \t\t <tr class=judulform>\r\n\t\t\t<td>Nama Program Studi *</td>\r\n\t\t\t<td>".createinputtext( "data[nama]", $data[nama], " class=masukan  size=50" )."</td>\r\n\t\t</tr> \r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Tambah' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n \t\t";
}
if ( $aksi == "tampilkan" )
{
    $aksi = " ";
    include( "prosestampilprodi.php" );
}
if ( $aksi == "" )
{
    printjudulmenu( "Lihat Data Program Studi " );
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>\r\n\t\t<table class=form>\r\n  \t\t<tr class=judulform>\r\n\t\t\t<td>Kode</td>\r\n\t\t\t<td>".createinputtext( "id", $id, " class=masukan  size=20" )."\r\n \t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Nama</td>\r\n\t\t\t<td>".createinputtext( "nama", $nama, " class=masukan  size=50" )."</td>\r\n\t\t</tr> \r\n \t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Tampilkan' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table>\r\n\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t";
}
?>
