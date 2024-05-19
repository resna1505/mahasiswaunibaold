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
    if ( $_SESSION['token'] == $_GET['sessid'] )
    {
        unset( $_SESSION['token'] );
        cekhaktulis( $kodemenu );
        $q = "DELETE FROM deposit WHERE ID='{$idhapus}' ";
        mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Deposit Mahasiswa berhasil dihapus";
        }
        else
        {
            $errmesg = "Deposit Mahasiswa tidak berhasil dihapus";
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Deposit Mahasiswa", HAPUS_DATA );
    }
    $aksi = "tampilkan";
}
if ( $aksi == "update" )
{
    if ( $_SESSION['token'] == $_POST['sessid'] )
    {
        unset( $_SESSION['token'] );
        cekhaktulis( $kodemenu );
        if ( trim( $idmahasiswa ) == "" )
        {
            $errmesg = "NIM harus diisi";
        }
        else
        {
            if ( getfield( "ID", "mahasiswa", "WHERE ID='{$idmahasiswa}'" ) == "" )
            {
                $errmesg = "Tidak ada mahasiswa dengan NIM {$idmahasiswa}";
            }
            else
            {
                $q = "\r\n\t\t\tUPDATE deposit SET \r\n \t\t\tJUMLAH='{$jumlah}',\r\n    \tIDMAHASISWA='{$idmahasiswa}' ,\r\n    \tTANGGALENTRI='{$tglentri['thn']}-{$tglentri['bln']}-{$tglentri['tgl']}' ,\r\n    \tTANGGALBAYAR='{$tglbayar['thn']}-{$tglbayar['bln']}-{$tglbayar['tgl']}' ,\r\n    \tKET='{$ket}' ,\r\n    \tUPDATER='{$users}',\r\n    \tLASTUPDATE=NOW()\r\n  \r\n  \t\t\tWHERE \r\n        \tID='{$idupdate}' \r\n\t\t";
                mysqli_query($koneksi,$q);
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    $errmesg = "Deposit Mahasiswa berhasil diupdate";
                }
                else
                {
                    $errmesg = "Deposit Mahasiswa tidak diupdate";
                }
            }
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Deposit Mahasiswa", UPDATE_DATA );
    }
    $aksi = "formupdate";
}
if ( $aksi == "formupdate" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    cekhaktulis( $kodemenu );
    $q = "SELECT *\r\n\tFROM deposit  WHERE \r\n\tID='{$idupdate}' \r\n\t \r\n\t";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        printjudulmenu( "Update Deposit Mahasiswa" );
        printmesg( $errmesg );
        $d = sqlfetcharray( $h );
        $tmp = explode( "-", $d[TANGGALBAYAR] );
        $tglbayar[tgl] = $tmp[2];
        $tglbayar[bln] = $tmp[1];
        $tglbayar[thn] = $tmp[0];
        $tmp = explode( "-", $d[TANGGALENTRI] );
        $tglentri[tgl] = $tmp[2];
        $tglentri[bln] = $tmp[1];
        $tglentri[thn] = $tmp[0];
        echo "\r\n\t\t<form name=form action=index.php method=post  ENCTYPE='MULTIPART/FORM-DATA'>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" )."\r\n       \r\n  \t\t<tr >\r\n\t\t\t<td class=judulform>NIM</td>\r\n\t\t\t<td>".createinputtext( "idmahasiswa", $d[IDMAHASISWA], " class=masukan  size=20" )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftarmhs('form,wewenang,idmahasiswa',\r\n\t\t\tdocument.form.idmahasiswa.value)\" >\r\n\t\t\tdaftar mahasiswa\r\n\t\t\t</a>\r\n\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr> \r\n\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t<td>Tanggal Pembayaran</td>\r\n\t\t\t\t\t\t<td>".createinputtanggal( "tglbayar", $tglbayar, " class=masukan" )."</td>\r\n\t\t\t\t\t\t</tr>\t\t\t\t\r\n \r\n  \t\t <tr class=judulform>\r\n\t\t\t<td>Jumlah Deposit (Rp.)</td>\r\n\t\t\t<td>".createinputtext( "jumlah", $d[JUMLAH], " class=masukan  size=10 style='font-size:14pt;'" )."</td>\r\n\t\t</tr> \r\n\r\n  \t\t <tr class=judulform>\r\n\t\t\t<td>Keterangan</td>\r\n\t\t\t<td>".createinputtextarea( "ket", $d[KET], "cols=40 rows=3  class=masukan    " )."</td>\r\n\t\t</tr> \r\n\r\n\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t<td>Tanggal Entri</td>\r\n\t\t\t\t\t\t<td>".createinputtanggal( "tglentri", $tglentri, " class=masukan" )."</td>\r\n\t\t\t\t\t\t</tr>\t\t\t\t\r\n\r\n\r\n \t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Update' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n\t\t";
    }
    else
    {
        $errmesg = "Deposit Mahasiswa  tidak ada";
        $aksi = "";
    }
}
if ( $aksi == "tambah" )
{
    if ( $_SESSION['token'] == $_POST['sessid'] )
    {
        unset( $_SESSION['token'] );
        cekhaktulis( $kodemenu );
        if ( trim( $idmahasiswa ) == "" )
        {
            $errmesg = "NIM harus diisi";
        }
        else
        {
            if ( getfield( "ID", "mahasiswa", "WHERE ID='{$idmahasiswa}'" ) == "" )
            {
                $errmesg = "Tidak ada mahasiswa dengan NIM {$idmahasiswa}";
            }
            else
            {
                $q = "\r\n\t\t\tINSERT INTO deposit (ID,IDMAHASISWA,JUMLAH,TANGGALBAYAR,TANGGALENTRI,KET,UPDATER,LASTUPDATE) \r\n\t\t\tVALUES ('0','{$idmahasiswa}','{$jumlah}',\r\n      '{$tglbayar['thn']}-{$tglbayar['bln']}-{$tglbayar['tgl']}',\r\n      '{$tglentri['thn']}-{$tglentri['bln']}-{$tglentri['tgl']}',\r\n      '{$ket}','{$users}',NOW())\r\n\t\t";
                mysqli_query($koneksi,$q);
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    $errmesg = "Deposit Mahasiswa berhasil ditambah";
                    $data = $biaya = $jumlah = $ket = "";
                    $id = "";
                }
                else
                {
                    $errmesg = "Deposit Mahasiswa tidak berhasil ditambah";
                }
            }
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Deposit Mahasiswa", TAMBAH_DATA );
    }
    $aksi = "formtambah";
}
if ( $aksi == "formtambah" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    cekhaktulis( $kodemenu );
    printjudulmenu( "Tambah Deposit Mahasiswa" );
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" ).createinputhidden( "sessid", $_SESSION['token'], "" )."\r\n \r\n  \t\t<tr >\r\n\t\t\t<td class=judulform>NIM</td>\r\n\t\t\t<td>".createinputtext( "idmahasiswa", $idmahasiswa, " class=masukan  size=20 id='inputString' onkeyup=\"lookup(this.value,'','');\" " )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftarmhs('form,wewenang,idmahasiswa',\r\n\t\t\tdocument.form.idmahasiswa.value)\" >\r\n\t\t\tdaftar mahasiswa\r\n\t\t\t</a>\r\n             <div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">\r\n               <div class=\"suggestionList\" id=\"autoSuggestionsList\">\r\n\t\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr> \r\n\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t<td>Tanggal Pembayaran</td>\r\n\t\t\t\t\t\t<td>".createinputtanggal( "tglbayar", $tglbayar, " class=masukan" )."</td>\r\n\t\t\t\t\t\t</tr>\t\t\t\t\r\n \r\n  \t\t <tr class=judulform>\r\n\t\t\t<td>Jumlah Deposit (Rp.)</td>\r\n\t\t\t<td>".createinputtext( "jumlah", $jumlah, " class=masukan  size=10 style='font-size:14pt;'" )."</td>\r\n\t\t</tr> \r\n\r\n  \t\t <tr class=judulform>\r\n\t\t\t<td>Keterangan</td>\r\n\t\t\t<td>".createinputtextarea( "ket", $ket, "cols=40 rows=3  class=masukan    " )."</td>\r\n\t\t</tr> \r\n\r\n\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t<td>Tanggal Entri</td>\r\n\t\t\t\t\t\t<td>".createinputtanggal( "tglentri", $tglentri, " class=masukan" )."</td>\r\n\t\t\t\t\t\t</tr>\t\t\t\t\r\n\r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Tambah' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n  \t\t";
    if ( $idmahasiswa != "" )
    {
        $q = "SELECT deposit.*,mahasiswa.NAMA, \r\n      \tDATE_FORMAT(deposit.TANGGALBAYAR,'%d-%m-%Y') TANGGALBAYAR2\r\n         FROM deposit,mahasiswa\r\n      \tWHERE deposit.IDMAHASISWA=mahasiswa.ID AND\r\n      \tmahasiswa.ID='{$idmahasiswa}'\r\n      \tORDER BY deposit.ID DESC LIMIT 0,10";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            echo "\r\n       \t\t<br>\r\n       \t\t\t<table {$border} class=form >\r\n      \t\t\t<tr  align=center>\r\n      \t\t\t\t \r\n        \t\t\t\t<td colspan=5 align=right><b>SALDO : Rp. ".cetakuang( get_deposit_mahasiswa( $idmahasiswa ) )."</td>\r\n       \t\t\t</tr>\r\n      \t\t\t<tr class=juduldata  align=center>\r\n      \t\t\t\t<td>No</td>\r\n       \t\t\t\t<td>NIM</td>\r\n      \t\t\t\t<td>Nama</td>\r\n      \t\t\t\t<td>Tanggal Bayar</td>\r\n       \t\t\t\t<td>Jumlah (Rp.)</td>\r\n       \t\t\t</tr>\r\n      \t\t";
            $i = 1;
            $total = 0;
            while ( $d = sqlfetcharray( $h ) )
            {
                $kelas = kelas( $i );
                echo "\r\n      \t\t\t\t<tr align=center {$kelas} >\r\n      \t\t\t\t\t<td>{$i}</td>\r\n        \t\t\t\t<td  >{$d['IDMAHASISWA']}</td>\r\n       \t\t\t\t\t<td align=left>{$d['NAMA']}</td>\r\n        \t\t\t\t\t<td  >{$d['TANGGALBAYAR2']}</td>\r\n        \t\t\t\t\t<td align=right><b>".cetakuang( $d[JUMLAH] )."</td>\r\n        \t\t\t\t</tr>\r\n      \t\t\t";
                ++$i;
            }
            echo "</table>";
        }
    }
}
if ( $aksi == "tampilkan" )
{
    $aksi = " ";
    include( "prosestampildeposit.php" );
}
if ( $aksi == "" )
{
    printjudulmenu( "Lihat Deposit Mahasiswa " );
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>\r\n\t\t<table class=form>\r\n\r\n  \t\t<tr >\r\n\t\t\t<td class=judulform>NIM</td>\r\n\t\t\t<td>".createinputtext( "idmahasiswa", $idmahasiswa, " class=masukan  size=20 id='inputString' onkeyup=\"lookup(this.value,'','');\" " )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftarmhs('form,wewenang,idmahasiswa',\r\n\t\t\tdocument.form.idmahasiswa.value)\" >\r\n\t\t\tdaftar mahasiswa\r\n\t\t\t</a>\r\n             <div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">\r\n               <div class=\"suggestionList\" id=\"autoSuggestionsList\">\r\n\t\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr> \r\n\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t<td>Tanggal Pembayaran</td>\r\n\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t<input type=checkbox name=iftglbayar value=1>\r\n            ".createinputtanggal( "tglbayar1", $tglbayar1, " class=masukan" )." s.d\r\n            ".createinputtanggal( "tglbayar2", $tglbayar2, " class=masukan" )."\r\n            </td>\r\n\t\t\t\t\t\t</tr>\t\t\t\t\r\n\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t<td>Tanggal Entri</td>\r\n\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t<input type=checkbox name=iftglentri value=1>\r\n            ".createinputtanggal( "tglentri1", $tglentri1, " class=masukan" )." s.d\r\n            ".createinputtanggal( "tglentri2", $tglentri2, " class=masukan" )."\r\n            </td>\r\n\t\t\t\t\t\t</tr>\t\t\t\t\r\n\r\n\r\n \t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Tampilkan' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table>\r\n\t\t</form>\r\n\t";
}
?>
