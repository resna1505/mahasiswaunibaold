<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $aksi == "update" && $REQUEST_METHOD == POST )
{
    cekhaktulis( $kodemenu );
    $ketlog = "Update data ijazah/transkrip Mahasiswa dengan ID={$idupdate}  ";
    buatlog( 13 );
    $errmesg = "Data Mahasiswa berhasil diupdate";
    if ( $transkrip != "" )
    {
        move_uploaded_file( $transkrip, "transkrip/{$idupdate}" );
    }
    if ( $ijazah != "" )
    {
        move_uploaded_file( $ijazah, "ijazah/{$idupdate}" );
    }
}
if ( $aksi == "formupdate" )
{
    cekhaktulis( $kodemenu );
    $q = "SELECT \r\n\tmahasiswa.*,prodi.JENIS \r\n\tFROM mahasiswa,prodi WHERE \r\n\tmahasiswa.ID='{$idupdate}'\r\n\tAND prodi.ID=mahasiswa.IDPRODI\r\n\t";
    $h = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        printmesg( $errmesg );
        $d = sqlfetcharray( $h );
        $tmp = explode( "-", $d[TANGGAL] );
        $d[thn] = $tmp[0];
        $d[tgl] = $tmp[2];
        $d[bln] = $tmp[1];
        $tmp = explode( "-", $d[TANGGALMASUK] );
        $dtm[thn] = $tmp[0];
        $dtm[tgl] = $tmp[2];
        $dtm[bln] = $tmp[1];
        $tmp = explode( "-", $d[TANGGALKELUAR] );
        $dtk[thn] = $tmp[0];
        $dtk[tgl] = $tmp[2];
        $dtk[bln] = $tmp[1];
        $idprodi = getfield( "IDPRODI", "mahasiswa", " WHERE ID='{$idupdate}'" );
        $namamakul = getfield( "NAMA", "mahasiswa", " WHERE ID='{$idupdate}'" );
        echo "\r\n<br>\r\n  <table class=form>\r\n     <tr class=judulform>\r\n\t\t\t<td width=150>Jurusan/Program Studi</td>\r\n\t\t\t<td>".$arrayprodidep[$idprodi]."\r\n      </td>\r\n\t\t</tr> \r\n    <tr>\r\n      <td>NIM Mahasiswa</td>\r\n      <td><b>{$idupdate}</td>\r\n    </tr>\r\n    <tr>\r\n      <td>Nama Mahasiswa</td>\r\n      <td><b>".$namamakul."</td>\r\n    </tr>\r\n    </table>\r\n";
        if ( file_exists( "transkrip/{$idupdate}" ) )
        {
            $transkripsaatini = "\r\n        <img src='transkrip/{$idupdate}' width=600><br>\r\n      ";
        }
        if ( file_exists( "ijazah/{$idupdate}" ) )
        {
            $ijazahsaatini = "\r\n        <img src='ijazah/{$idupdate}' width=600><br>\r\n      ";
        }
        echo "\r\n\t\t<br>\r\n\t\t<form name=form action=index.php method=post  ENCTYPE='MULTIPART/FORM-DATA'>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tab", "{$tab}", "" )." <tr class=judulform>\r\n\t\t\t<td>File Transkrip</td>\r\n\t\t\t<td>\r\n\t\t\t{$transkripsaatini}\r\n\t\t\t<input type=file name=transkrip class=masukan> \r\n\t\t\t</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>File Ijazah</td>\r\n\t\t\t<td>\r\n\t\t\t{$ijazahsaatini}\r\n\t\t\t<input type=file name=ijazah class=masukan> \r\n\t\t\t</td>\r\n\t\t</tr>    \r\n \r\n\t\r\n \t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Update' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t\t";
    }
    else
    {
        $errmesg = "Data Mahasiswa dengan ID = '{$idupdate}' tidak ada";
        $aksi = "";
    }
}
?>
