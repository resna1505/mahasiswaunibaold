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
    if ( $aksi2 == "Hapus" )
    {
        $q = "delete from trpid WHERE NIMHSTRPID='{$idupdate}'";
        mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Data Status Mahasiswa berhasil dihapus";
        }
        else
        {
            $errmesg = "Data Mahasiswa tidak dihapus";
        }
    }
    else
    {
        $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$idprodi}'";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            $d = sqlfetcharray( $h );
            $kodept = $d[KDPTIMSPST];
            $kodejenjang = $d[KDJENMSPST];
            $kodeps = $d[KDPSTMSPST];
        }
        $q = "SELECT * FROM trpid WHERE NIMHSTRPID='{$idupdate}'";
        $h2 = mysqli_query($koneksi,$q);
        if ( sqlnumrows( $h2 ) <= 0 )
        {
            $q = "INSERT INTO trpid (KDPTITRPID,KDJENTRPID,KDPSTTRPID,NIMHSTRPID) \r\n      VALUES ('{$kodept}','{$kodejenjang}','{$kodeps}','{$idupdate}') ";
            mysqli_query($koneksi,$q);
        }
        if ( $bulanawal < 10 )
        {
            $bulanawal = "0{$bulanawal}";
        }
        if ( $bulanakhir < 10 )
        {
            $bulanakhir = "0{$bulanakhir}";
        }
        if ( $status != "L" )
        {
            $individu = $skripsi = $bulanawal = $bulanakhir = $tahunawal = $tahunakhir = $dosen1 = $dosen2 = $dosen3 = $dosen4 = $dosen5 = "";
            $data = "";
            $dtk = "";
            $tglsk = "";
        }
        $q = "\r\n      UPDATE trpid\r\n      SET\r\n       KDPTITRPID ='{$kodept}',KDPSTTRPID ='{$kodeps}',KDJENTRPID='{$kodejenjang}',\r\n       NMPTITRPID='{$ptasal}',NMPSTTRPID='{$psasal}' \r\n       \r\n       WHERE NIMHSTRPID = '{$idupdate}'\r\n     ";
        mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $ketlog = "Update data Mahasiswa dengan ID={$idupdate} ({$data['nama']})";
            buatlog( 13 );
            $errmesg = "Data Mahasiswa berhasil diupdate";
        }
        else
        {
            $errmesg = "Data Mahasiswa tidak diupdate";
        }
    }
}
if ( $aksi == "formupdate" )
{
    cekhaktulis( $kodemenu );
    $q = "SELECT \r\n\tmahasiswa.IDPRODI,mahasiswa.ID,mahasiswa.NAMA,\r\n  prodi.JENIS \r\n\tFROM mahasiswa,prodi WHERE \r\n\tmahasiswa.ID='{$idupdate}'\r\n\tAND prodi.ID=mahasiswa.IDPRODI\r\n\t";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        printmesg( $errmesg );
        $d = sqlfetcharray( $h );
        $q = "SELECT * FROM trpid WHERE NIMHSTRPID='{$idupdate}'";
        $h2 = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h2 ) )
        {
            $d2 = sqlfetcharray( $h2 );
        }
        else
        {
            echo "<br>";
            printmesg( "Data Pindahan belum ada." );
        }
        $tmp = explode( "-", $d2[TGLLSTRLSM] );
        $dtk[thn] = $tmp[0];
        $dtk[tgl] = $tmp[2];
        $dtk[bln] = $tmp[1];
        $tmp = explode( "-", $d2[TGLRETRLSM] );
        $tglsk[thn] = $tmp[0];
        $tglsk[tgl] = $tmp[2];
        $tglsk[bln] = $tmp[1];
        $tmp = $d2[THSMSTRLSM];
        $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
        $semester = $tmp[4];
        $tmp = $d2[BLAWLTRLSM];
        $bulanawal = $tmp[0].$tmp[1];
        $tahunawal = $tmp[2].$tmp[3].$tmp[4].$tmp[5];
        if ( file_exists( "foto/{$d['ID']}" ) )
        {
            $fotosaatini = "\r\n\t\t\t\r\n\t\t\t<img src='foto/{$d['ID']}' border=0 width=100><br>\r\n\t\t\t";
        }
        echo "\r\n\t\t<br>\r\n\t\t<form name=form action=index.php method=post  ENCTYPE='MULTIPART/FORM-DATA'>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "idprodi", $d[IDPRODI], "" ).createinputhidden( "tab", "{$tab}", "" )."<tr class=judulform>\r\n\t\t\t<td>Jurusan/Program Studi</td>\r\n\t\t\t<td>".$arrayprodidep[$d[IDPRODI]]."\r\n      </td>\r\n\t\t</tr> \r\n    <tr class=judulform>\r\n\t\t\t<td>NIM </td>\r\n\t\t\t<td>{$d['ID']}</td>\r\n\t\t</tr> \t\t \r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Nama  </td>\r\n\t\t\t<td>{$d['NAMA']}</td>\r\n\t\t</tr> \r\n \r\n    <tr class=judulform>\r\n\t\t\t<td>Nama Perguruan Tinggi Asal</td>\r\n\t\t\t<td>".createinputtext( "ptasal", $d2[NMPTITRPID], " class=masukan  size=50" )."</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Nama Program Studi Asal</td>\r\n\t\t\t<td>".createinputtext( "psasal", $d2[NMPSTTRPID], " class=masukan  size=40" )."</td>\r\n\t\t</tr>\r\n \r\n \r\n    \t\r\n \t\t<tr class=judulform>\r\n\t\t\t<td colspan=2><hr></td>\r\n\t\t</tr>\r\n  \t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Update' class=masukan>\r\n\t\t\t\t\t<input type=submit name=aksi2 value='Hapus' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t\t";
    }
    else
    {
        $errmesg = "Data Mahasiswa dengan ID = '{$idupdate}' tidak ada";
        $aksi = "";
    }
}
?>
