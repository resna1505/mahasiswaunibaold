<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi == "hapus" )
{
    cekhaktulis( $kodemenu );
    if ( $_SESSION['token'] != $_GET['sessid'] )
    {
        $errmesg = token_err_mesg( "Jadwal Kuliah", HAPUS_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $q = "DELETE FROM ruangan WHERE ID='{$idhapus}'";
        mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Data Ruangan dengan Kode = '{$idhapus}' berhasil dihapus";
        }
        else
        {
            $errmesg = "Data Ruangan dengan Kode = '{$idhapus}' tidak berhasil dihapus";
        }
    }
    $aksi = "";
}
if ( $aksi == "update" && $REQUEST_METHOD == POST )
{
    cekhaktulis( $kodemenu );
    if ( $_SESSION['token'] != $_POST['sessid'] )
    {
        $errmesg = token_err_mesg( "Ruangan", SIMPAN_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditaskode( "Kode Ruangan", $id, 10, false );
        $vld[] = cekvaliditasnama( "Nama Ruangan", $data['nama'], 40, false );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
            unset( $vld );
        }
        else if ( trim( $id ) == "" )
        {
            $errmesg = "Kode Ruangan harus diisi";
        }
        else if ( trim( $data[nama] ) == "" )
        {
            $errmesg = "Nama Ruangan harus diisi";
        }
        else
        {
            $q = "\r\n\t\t\tUPDATE ruangan SET \r\n\t\t\tID='{$id}',\r\n\t\t\tNAMA='{$data['nama']}',\r\n \t\t\tKET='{$data['ket']}'\r\n\t\t\tWHERE ID='{$idupdate}'\r\n\t\t";
            mysqli_query($koneksi,$q);
            buatlog( 1 );
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $idupdate = $id;
            }
            else
            {
                $errmesg = "Data Ruangan tidak diupdate";
            }
        }
    }
    $aksi = "formupdate";
}
if ( $aksi == "formupdate" )
{
    cekhaktulis( $kodemenu );
    $token = md5( uniqid( rand( ), true ) );
    $_SESSION['token'] = $token;
    $q = "SELECT * FROM ruangan WHERE ID='{$idupdate}'";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        printjudulmenu( "Update Data Ruangan" );
        printmesg( $errmesg );
        $d = sqlfetcharray( $h );
        echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "idupdate", "{$idupdate}", "" )."<tr class=judulform>\r\n\t\t\t<td>Kode Ruangan *</td>\r\n\t\t\t<td>".createinputtext( "id", $d[ID], " class=masukan size=10 maxlength=10" )."</td>"."<tr class=judulform>\r\n\t\t\t<td>Nama Ruangan *</td>\r\n\t\t\t<td>".createinputtext( "data[nama]", $d[NAMA], " class=masukan  size=40" )."</td>\r\n      </tr>\r\n      <tr class=judulform>\r\n\t\t\t<td>Keterangan</td>\r\n\t\t\t<td>".createinputtextarea( "data[ket]", $d[KET], " class=masukan cols=50 rows=3" )."</td>"."\r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t".IKONUPDATE48."\r\n\t\t\t\t\t<input type=submit value='Update' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t\t";
    }
    else
    {
        $errmesg = "Data Ruangan dengan Kode = '{$idupdate}' tidak ada";
        $aksi = "";
    }
}
if ( $aksi == "tambah" && $REQUEST_METHOD == POST )
{
    cekhaktulis( $kodemenu );
    if ( $_SESSION['token'] != $_POST['sessid'] )
    {
        $errmesg = token_err_mesg( "Ruangan", TAMBAH_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditaskode( "Kode Ruangan", $id, 10, false );
        $vld[] = cekvaliditasnama( "Nama Ruangan", $data['nama'], 40, false );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, TAMBAH_DATA );
            unset( $vld );
        }
        else if ( trim( $id ) == "" )
        {
            $errmesg = "Kode Ruangan harus diisi";
        }
        else if ( trim( $data[nama] ) == "" )
        {
            $errmesg = "Nama Ruangan harus diisi";
        }
        else
        {
            $q = "\r\n\t\t\tINSERT INTO ruangan (ID,NAMA,KET) \r\n\t\t\tVALUES ('{$id}','{$data['nama']}','{$data['ket']}' )\r\n\t\t";
            mysqli_query($koneksi,$q);
            buatlog( 0 );
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Data Ruangan berhasil ditambah";
                $data = "";
                $id = "";
            }
            else
            {
                $errmesg = "Data Ruangan tidak berhasil ditambah";
            }
        }
    }
    $aksi = "formtambah";
}
if ( $aksi == "formtambah" )
{
    cekhaktulis( $kodemenu );
    $token = md5( uniqid( rand( ), true ) );
    $_SESSION['token'] = $token;
    printjudulmenu( "Tambah Data Ruangan" );
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi", "tambah", "" )."<tr class=judulform>\r\n\t\t\t<td>Kode Ruangan *</td>\r\n\t\t\t<td>".createinputtext( "id", $id, " class=masukan  size=10 maxlength=10" )."</td>"."<tr class=judulform>\r\n\t\t\t<td>Nama Ruangan *</td>\r\n\t\t\t<td>".createinputtext( "data[nama]", $data[nama], " class=masukan  size=40" )."</td>  \r\n      </tr>\r\n      <tr class=judulform>\r\n\t\t\t<td>Keterangan</td>\r\n\t\t\t<td>".createinputtextarea( "data[ket]", $data[ket], " class=masukan cols=50 rows=3" )."</td>"."\r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t".IKONUPDATE48."\r\n\t\t\t\t\t<input type=submit value='Tambah' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t\t";
}
if ( $aksi == "" )
{
    include( "prosestampilruangan.php" );
}
?>
