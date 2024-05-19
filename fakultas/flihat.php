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
    $q = "DELETE FROM fakultas WHERE ID='{$idhapus}'";
    doquery($koneksi, $q );
    if ( 0 < sqlaffectedrows( $koneksi ) )
    {
        $errmesg = "Data {$JUDULFAKULTAS} dengan ID = '{$idhapus}' berhasil dihapus";
    }
    else
    {
        $errmesg = "Data {$JUDULFAKULTAS} dengan ID = '{$idhapus}' tidak berhasil dihapus";
    }
    $aksi = "";
}
if ( $aksi == "update" )
{
    if ( trim( $data[id] ) == "" )
    {
        $errmesg = "Kode {$JUDULFAKULTAS} harus diisi";
    }
    else if ( trim( $data[nama] ) == "" )
    {
        $errmesg = "Nama {$JUDULFAKULTAS} harus diisi";
    }
    else if ( trim( $data[nippimpinan] ) == "" )
    {
        $errmesg = "NIP Pimpinan harus diisi";
    }
    else
    {
        if ( trim( $data[namapimpinan] ) == "" )
        {
            $errmesg = "Nama Pimpinan harus diisi";
        }
        else
        {
            if ( trim( $data[alamat] ) == "" )
            {
                $errmesg = "Alamat {$JUDULFAKULTAS} harus diisi";
            }
            $q = "\r\n\t\t\tUPDATE fakultas SET \r\n\t\t\tID='{$data['id']}',\r\n\t\t\tNAMA='{$data['nama']}',\r\n\t\t\tNIPPIMPINAN='{$data['nippimpinan']}',\r\n\t\t\tNAMAPIMPINAN='{$data['namapimpinan']}',\r\n\t\t\tALAMAT='{$data['alamat']}'\r\n\t\t\tWHERE ID='{$idupdate}'\r\n\t\t";
            doquery($koneksi, $q );
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Data {$JUDULFAKULTAS} berhasil diupdate";
                $idupdate = $data[id];
            }
            else
            {
                $errmesg = "Data {$JUDULFAKULTAS} tidak diupdate";
            }
        }
    }
    $aksi = "formupdate";
}
if ( $aksi == "formupdate" )
{
    $q = "SELECT * FROM fakultas WHERE ID='{$idupdate}'";
    $h = doquery($koneksi, $q );
    if ( 0 < sqlnumrows( $h ) )
    {
        printjudulmenu( "Update Data {$JUDULFAKULTAS}" );
        printmesg( $errmesg );
        $d = sqlfetcharray( $h );
        echo "\r\n\t\t<form action=index.php method=post>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "idupdate", "{$idupdate}", "" )."<tr class=judulform>\r\n\t\t\t<td>Kode {$JUDULFAKULTAS} *</td>\r\n\t\t\t<td>".createinputtext( "data[id]", $d[ID], " class=masukan size=10" )."</td>"."<tr class=judulform>\r\n\t\t\t<td>Nama {$JUDULFAKULTAS} *</td>\r\n\t\t\t<td>".createinputtext( "data[nama]", $d[NAMA], " class=masukan  size=30" )."</td>"."<tr class=judulform>\r\n\t\t\t<td>NIP Dekan/Pimpinan *</td>\r\n\t\t\t<td>".createinputtext( "data[nippimpinan]", $d[NIPPIMPINAN], " class=masukan  size=30" )."</td>"."<tr class=judulform>\r\n\t\t\t<td>Nama Dekan/Pimpinan *</td>\r\n\t\t\t<td>".createinputtext( "data[namapimpinan]", $d[NAMAPIMPINAN], " class=masukan size=30" )."</td>"."<tr class=judulform>\r\n\t\t\t<td>Alamat {$JUDULFAKULTAS} *</td>\r\n\t\t\t<td>".createinputtextarea( "data[alamat]", $d[ALAMAT], " class=masukan cols=50 rows=3" )."</td>"."\r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Update' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n\t\t";
    }
    else
    {
        $errmesg = "Data {$JUDULFAKULTAS} dengan ID = '{$idupdate}' tidak ada";
        $aksi = "";
    }
}
if ( $aksi == "tambah" )
{
    if ( trim( $data[id] ) == "" )
    {
        $errmesg = "Kode {$JUDULFAKULTAS} harus diisi";
    }
    else if ( trim( $data[nama] ) == "" )
    {
        $errmesg = "Nama {$JUDULFAKULTAS} harus diisi";
    }
    else if ( trim( $data[nippimpinan] ) == "" )
    {
        $errmesg = "NIP Pimpinan harus diisi";
    }
    else if ( trim( $data[namapimpinan] ) == "" )
    {
        $errmesg = "Nama Pimpinan harus diisi";
    }
    else if ( trim( $data[alamat] ) == "" )
    {
        $errmesg = "Alamat {$JUDULFAKULTAS} harus diisi";
    }
    else
    {
        $q = "\r\n\t\t\tINSERT INTO fakultas (ID,NAMA,NIPPIMPINAN,NAMAPIMPINAN,ALAMAT) \r\n\t\t\tVALUES ('{$data['id']}','{$data['nama']}','{$data['nippimpinan']}',\r\n\t\t\t'{$data['namapimpinan']}','{$data['alamat']}')\r\n\t\t";
        doquery($koneksi, $q );
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Data {$JUDULFAKULTAS} berhasil ditambah";
            $data = "";
        }
        else
        {
            $errmesg = "Data {$JUDULFAKULTAS} tidak berhasil ditambah";
        }
    }
    $aksi = "formtambah";
}
if ( $aksi == "formtambah" )
{
    printjudulmenu( "Tambah Data {$JUDULFAKULTAS}" );
    printmesg( $errmesg );
    echo "\r\n\t\t<form action=index.php method=post>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" )."<tr class=judulform>\r\n\t\t\t<td>Kode {$JUDULFAKULTAS} *</td>\r\n\t\t\t<td>".createinputtext( "data[id]", $data[id], " class=masukan size=10" )."</td>"."<tr class=judulform>\r\n\t\t\t<td>Nama {$JUDULFAKULTAS} *</td>\r\n\t\t\t<td>".createinputtext( "data[nama]", $data[nama], " class=masukan  size=30" )."</td>"."<tr class=judulform>\r\n\t\t\t<td>NIP Dekan/Pimpinan *</td>\r\n\t\t\t<td>".createinputtext( "data[nippimpinan]", $data[nippimpinan], " class=masukan  size=30" )."</td>"."<tr class=judulform>\r\n\t\t\t<td>Nama Dekan/Pimpinan *</td>\r\n\t\t\t<td>".createinputtext( "data[namapimpinan]", $data[namapimpinan], " class=masukan size=30" )."</td>"."<tr class=judulform>\r\n\t\t\t<td>Alamat {$JUDULFAKULTAS} *</td>\r\n\t\t\t<td>".createinputtextarea( "data[alamat]", $data[alamat], " class=masukan cols=50 rows=3" )."</td>"."\r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Tambah' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n\t\t";
}
if ( $aksi == "" )
{
    include( "prosestampilfakultas.php" );
}
?>
