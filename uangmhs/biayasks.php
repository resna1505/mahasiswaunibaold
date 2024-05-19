<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $STEIINDONESIA != 1 )
{
    exit( );
}
if ( $aksi == "hapus" )
{
    cekhaktulis( $kodemenu );
    $q = "DELETE FROM biayasks WHERE ANGKATAN='{$angkatanhapus}' AND GELOMBANG='{$gelombanghapus}' AND PRODI='{$idprodihapus}' AND KELAS='{$kelashapus}' AND TAHUN='{$tahunajaranhapus}'";
    mysqli_query($koneksi,$q);
    if ( 0 < sqlaffectedrows( $koneksi ) )
    {
        $errmesg = "Biaya SKS berhasil dihapus";
    }
    else
    {
        $errmesg = "Biaya SKS tidak berhasil dihapus";
    }
    $aksi = "tampilkan";
}
if ( $aksi == "update" )
{
    cekhaktulis( $kodemenu );
    if ( trim( $gelombang ) == "" )
    {
        $errmesg = "Gelombang Masuk harus diisi";
    }
    else
    {
        $q = "\r\n\t\t\tUPDATE biayasks SET \r\n \t\t\tBIAYA='{$biaya}',\r\n    \tANGKATAN='{$angkatan}' ,\r\n    \tGELOMBANG='{$gelombang}' ,\r\n    \tPRODI='{$idprodi}' ,\r\n    \tTAHUN='{$tahunajaran}',\r\n    \tKELAS='{$kelas}',    \t\r\n      UPDATER='{$users}',\r\n    \tLASTUPDATE=NOW()\r\n\r\n  \r\n  \t\t\tWHERE \r\n        \tANGKATAN='{$angkatanupdate}' AND\r\n        \tGELOMBANG='{$gelombangupdate}' AND\r\n        \tPRODI='{$idprodiupdate}' AND\r\n        \tTAHUN='{$tahunajaranupdate}' AND\r\n        \tKELAS='{$kelasupdate}'\r\n\t\t\t\r\n\t\t";
        mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Biaya SKS berhasil diupdate";
            $angkatanupdate = $angkatan;
            $gelombangupdate = $gelombang;
            $idprodiupdate = $idprodi;
            $tahunajaranupdate = $tahunajaran;
            $kelasupdate = $kelas;
        }
        else
        {
            $errmesg = "Biaya SKS tidak diupdate";
        }
    }
    $aksi = "formupdate";
}
if ( $aksi == "formupdate" )
{
    cekhaktulis( $kodemenu );
    $q = "SELECT *\r\n\tFROM biayasks  WHERE \r\n\tANGKATAN='{$angkatanupdate}' AND\r\n\tGELOMBANG='{$gelombangupdate}' AND\r\n\tPRODI='{$idprodiupdate}' AND\r\n\tTAHUN='{$tahunajaranupdate}' AND\r\n\tKELAS='{$kelasupdate}'\r\n\t \r\n\t";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        printjudulmenu( "Update Biaya SKS" );
        printmesg( $errmesg );
        $d = sqlfetcharray( $h );
        if ( file_exists( "foto/{$d['ID']}" ) )
        {
            $fotosaatini = "\r\n\t\t\t\r\n\t\t\t<img src='foto/{$d['ID']}' border=0 width=100><br>\r\n\t\t\t";
        }
        echo "\r\n\t\t<form name=form action=index.php method=post  ENCTYPE='MULTIPART/FORM-DATA'>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "angkatanupdate", "{$angkatanupdate}", "" ).createinputhidden( "gelombangupdate", "{$gelombangupdate}", "" ).createinputhidden( "tahunajaranupdate", "{$tahunajaranupdate}", "" ).createinputhidden( "idprodiupdate", "{$idprodiupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" )."\r\n       \r\n\r\n\t\t\t<tr class=judulform>\r\n\t\t\t\t<td>Angkatan</td>\r\n\t\t\t\t<td>";
        $waktu = getdate( );
        echo "\r\n\t\t\t\t\t\t<select name=angkatan class=masukan> \r\n\t\t\t\t\t\t ";
        $cek = "";
        $i = 1900;
        while ( $i <= $waktu[year] + 5 )
        {
            if ( $i == $d[ANGKATAN] )
            {
                $cek = "selected";
            }
            echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t\t\t\t\t";
            $cek = "";
            ++$i;
        }
        echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t<tr>\r\n\t\t\t\t<td>Program Studi / Program Pendidikan</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=idprodi>\r\n\t\t\t\t\t\t ";
        $cek = "";
        foreach ( $arrayprodidep as $k => $v )
        {
            if ( $k == $d[PRODI] )
            {
                $cek = "selected";
            }
            echo "<option value='{$k}' {$cek}>{$v}</option>";
            $cek = "";
        }
        echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  \t\t <tr class=judulform>\r\n\t\t\t<td>Gelombang Masuk</td>\r\n\t\t\t<td>".createinputtext( "gelombang", $d[GELOMBANG], " class=masukan  size=2" )."</td>\r\n\t\t</tr> \r\n\r\n\t\t\t<tr class=judulform>\r\n\t\t\t\t<td>Tahun Akademik</td>\r\n\t\t\t\t<td>";
        $waktu = getdate( );
        echo "\r\n\t\t\t\t\t\t<select name=tahunajaran class=masukan> \r\n\t\t\t\t\t\t ";
        $cek = "";
        $i = 1900;
        while ( $i <= $waktu[year] + 5 )
        {
            if ( $i == $d[TAHUN] )
            {
                $cek = "selected";
            }
            echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>".( $i - 1 )."/{$i}</option>\r\n\t\t\t\t\t\t\t";
            $cek = "";
            ++$i;
        }
        echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\r\n\t\t\t<tr>\r\n\t\t\t\t<td>Kelas</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=kelas>\r\n\t\t\t\t\t\t ";
        $cek = "";
        foreach ( $arraykelasstei as $k => $v )
        {
            if ( $k == $d[KELAS] )
            {
                $cek = "selected";
            }
            echo "<option value='{$k}' {$cek}>{$v}</option>";
            $cek = "";
        }
        echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\r\n  \t\t <tr class=judulform>\r\n\t\t\t<td>Biaya Per SKS (Rp.)</td>\r\n\t\t\t<td>".createinputtext( "biaya", $d[BIAYA], " class=masukan  size=10 style='font-size:14pt;'" )."</td>\r\n\t\t</tr> \r\n\r\n\r\n \t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Update' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n\t\t";
    }
    else
    {
        $errmesg = "Biaya SKS  tidak ada";
        $aksi = "";
    }
}
if ( $aksi == "tambah" )
{
    cekhaktulis( $kodemenu );
    if ( trim( $gelombang ) == "" )
    {
        $errmesg = "Gelombang Masuk harus diisi";
    }
    else
    {
        $q = "\r\n\t\t\tINSERT INTO biayasks (ANGKATAN,PRODI,GELOMBANG,TAHUN,KELAS,BIAYA,UPDATER,LASTUPDATE) \r\n\t\t\tVALUES ('{$angkatan}','{$idprodi}','{$gelombang}','{$tahunajaran}','{$kelas}','{$biaya}','{$users}',NOW())\r\n\t\t";
        mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Biaya SKS berhasil ditambah";
            $data = $biaya = "";
            $id = "";
        }
        else
        {
            $errmesg = "Biaya SKS tidak berhasil ditambah";
        }
    }
    $aksi = "formtambah";
}
if ( $aksi == "formtambah" )
{
    cekhaktulis( $kodemenu );
    printjudulmenu( "Tambah Biaya SKS" );
    printmesg( $errmesg );
    if ( $gelombang == "" )
    {
        $gelombang = 1;
    }
    echo "\r\n\t\t<form name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" )."\r\n\t\t\t<tr class=judulform>\r\n\t\t\t\t<td>Angkatan</td>\r\n\t\t\t\t<td>";
    $waktu = getdate( );
    echo "\r\n\t\t\t\t\t\t<select name=angkatan class=masukan> \r\n\t\t\t\t\t\t ";
    $cek = "";
    $i = 1900;
    while ( $i <= $waktu[year] + 5 )
    {
        if ( $i == $waktu[year] )
        {
            $cek = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t\t\t\t\t";
        $cek = "";
        ++$i;
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t<tr>\r\n\t\t\t\t<td>Program Studi / Program Pendidikan</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=idprodi>\r\n\t\t\t\t\t\t ";
    foreach ( $arrayprodidep as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  \t\t <tr class=judulform>\r\n\t\t\t<td>Gelombang Masuk</td>\r\n\t\t\t<td>".createinputtext( "gelombang", $gelombang, " class=masukan  size=2" )."</td>\r\n\t\t</tr> \r\n\r\n\t\t\t<tr class=judulform>\r\n\t\t\t\t<td>Tahun Akademik</td>\r\n\t\t\t\t<td>";
    $waktu = getdate( );
    echo "\r\n\t\t\t\t\t\t<select name=tahunajaran class=masukan> \r\n\t\t\t\t\t\t ";
    $cek = "";
    $i = 1900;
    if ( $i <= $waktu[year] + 5 )
    {
        if ( $i == $waktu[year] )
        {
            $cek = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>".( $i - 1 )."/{$i}</option>\r\n\t\t\t\t\t\t\t";
        $cek = "";
        ++$i;
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\r\n\t\t\t<tr>\r\n\t\t\t\t<td>Kelas</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=kelas>\r\n\t\t\t\t\t\t ";
    foreach ( $arraykelasstei as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\r\n  \t\t <tr class=judulform>\r\n\t\t\t<td>Biaya Per SKS (Rp.)</td>\r\n\t\t\t<td>".createinputtext( "biaya", $biaya, " class=masukan  size=10 style='font-size:14pt;'" )."</td>\r\n\t\t</tr> \r\n\r\n\r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Tambah' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.biaya.focus();\r\n\t\t\t</script>\r\n \t\t";
}
if ( $aksi == "tampilkan" )
{
    $aksi = " ";
    include( "prosestampilbiayasks.php" );
}
if ( $aksi == "" )
{
    printjudulmenu( "Lihat Biaya SKS " );
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>\r\n\t\t<table class=form>\r\n\r\n\t\t\t<tr class=judulform>\r\n\t\t\t\t<td>Angkatan</td>\r\n\t\t\t\t<td>";
    $waktu = getdate( );
    echo "\r\n\t\t\t\t\t\t<select name=angkatan class=masukan> \r\n\t\t\t\t\t\t\t<option value=''>Semua</option>\r\n\t\t\t\t\t\t ";
    $cek = "";
    $i = 1900;
    while ( $i <= $waktu[year] + 5 )
    {
        echo "\r\n\t\t\t\t\t\t\t<option value='{$i}'  >{$i}</option>\r\n\t\t\t\t\t\t\t";
        ++$i;
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t<tr>\r\n\t\t\t\t<td>Program Studi / Program Pendidikan</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=idprodi>\r\n\t\t\t\t\t\t\t<option value=''>Semua</option>\r\n\t\t\t\t\t\t ";
    foreach ( $arrayprodidep as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  \t\t <tr class=judulform>\r\n\t\t\t<td>Gelombang Masuk</td>\r\n\t\t\t<td>".createinputtext( "gelombang", $gelombang, " class=masukan  size=2" )."</td>\r\n\t\t</tr> \r\n\r\n\t\t\t<tr class=judulform>\r\n\t\t\t\t<td>Tahun Akademik</td>\r\n\t\t\t\t<td>";
    $waktu = getdate( );
    echo "\r\n\t\t\t\t\t\t<select name=tahunajaran class=masukan> \r\n\t\t\t\t\t\t\t<option value=''>Semua</option>\r\n\t\t\t\t\t\t ";
    $cek = "";
    $i = 1900;
    while ( $i <= $waktu[year] + 5 )
    {
        echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>".( $i - 1 )."/{$i}</option>\r\n\t\t\t\t\t\t\t";
        $cek = "";
        ++$i;
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\r\n\t\t\t<tr>\r\n\t\t\t\t<td>Kelas</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=kelas>\r\n\t\t\t\t\t\t\t<option value=''>Semua</option>\r\n\t\t\t\t\t\t ";
    foreach ( $arraykelasstei as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\r\n\r\n \t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Tampilkan' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table>\r\n\t\t</form>\r\n\t";
}
?>
