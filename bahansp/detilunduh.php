<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\n\n\ttd {\n\t\tpadding:3px 5px;\n\t\t}\n\t\t\n\t.form td{\n\t\tborder:0px;\n\t\t}\n\t\t\n\t.judulmenukecil td {\n\t\tfont-size:14px;\n\t\tborder:none;\n\t\tfont-weight:bold;\n\t\t}\n</style>\n";
if ( $jenisusers == 1 )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    printjudulmenu( "Rincian Pengunduh Bahan Kuliah SP" );
    printmesg( $errmesg );
    $q = "SELECT bahankuliahsp.* FROM bahankuliahsp WHERE \n    IDBAHAN='{$idupdate}' AND\n    IDMAKUL='{$idmakulupdate}' AND\n    TAHUN='{$tahunupdate}' AND\n    SEMESTER='{$semesterupdate}' AND\n    KELAS='{$kelasupdate}'\n    ";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    echo "\n\t\t \n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" )."<tr class=judulform>\n\t\t\t<td width=200>Mata Kuliah</td>\n\t\t\t<td>{$idmakulupdate}, ".getnamafromtabel( $idmakulupdate, "makul" )."</td>\n\t\t</tr>"."<tr class=judulform>\n\t\t\t<td>Tahun Ajaran</td>\n\t\t\t<td>".( $tahunupdate - 1 )."/{$tahunupdate}\t\t\t\n\t\t\t</td>\n\t\t</tr> \n\t\t<tr>\n\t\t\t<td class=judulform>Semester</td>\n\t\t\t<td >  ".$arraysemester[$semesterupdate]."  </td>\n\t\t</tr>\n  \t\t<tr class=judulform>\n\t\t\t<td class=judulform>Dosen Pengajar </td>\n\t\t\t<td>{$iddosenupdate}, ".getnamafromtabel( $iddosenupdate, "dosen" )."</td>\n\t\t</tr>"."<tr class=judulform>\n\t\t\t<td>Kode Kelas</td>\n\t\t\t<td>".$arraylabelkelas[$kelasupdate]."</td>\n\t\t</tr>"."\n\t\t</table>\n\t\t<br>\n\t\t";
    printjudulmenukecil( "Bahan Kuliah SP " );
    echo "\n\t\t<table class=form>\n \t\t <tr valign=top class=judulform>\n\t\t\t<td width=200 class=judulform><b>Nama Bahan</td>\n\t\t\t<td>{$d['NAMA']}</td>\n\t\t</tr> \n    <tr valign=top  class=judulform>\n\t\t\t<td><b>Keterangan</td>\n\t\t\t<td>".htmlspecialchars_decode( $d[KET] )."</td>\n\t\t\t</td>\n\t\t</tr>  \n\n \n\n \n \n\t\t\t</table>\n\t\t\t \n \n<br><br>\n \t\t";
    printjudulmenukecil( "Daftar Pengunduh Bahan Kuliah SP" );
    $q = "\n\t\t\tSELECT statusunduhbahankuliahsp.*,mahasiswa.NAMA \n      FROM statusunduhbahankuliahsp,mahasiswa\n\t\t\tWHERE IDMAKUL='{$idmakulupdate}'\n\t\t\tAND TAHUN='{$tahunupdate}'\n\t\t\tAND SEMESTER='{$semesterupdate}'\n\t\t\tAND statusunduhbahankuliahsp.KELAS='{$kelasupdate}'\n\t\t\tAND IDBAHAN='{$idupdate}'\n\t\t\tAND mahasiswa.ID=statusunduhbahankuliahsp.IDMAHASISWA\n\t\t\tORDER BY IDMAHASISWA\n\t\t";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        echo "\n \t\t\t <table table {$border} class=form{$aksi}>\n \n\t\t\t\t<tr class=juduldata align=center>\n\t\t\t\t\t<td>No</td>\n\t\t\t\t\t<td>NIM Mahasiswa</td>\n\t\t\t\t\t<td>Nama</td> \n\t\t\t\t\t<td>Tanggal Unduh Terakhir</td>\n\t\t\t\t\t<td>Jumlah Unduhan</td> \n\t\t\t\t</tr>\n\t\t\t";
        $i = 1;
        $totalbobot = 0;
        $rata2 = 0;
        $total = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            $total += $d[NILAI];
            echo "\n\t\t\t\t\t<tr {$kelas} valign=top align=center>\n\t\t\t\t\t\t<td align=center>{$i}</td>\n\t\t\t\t\t\t<td align=left >{$d['IDMAHASISWA']}</td>\n\t\t\t\t\t\t<td align=left >{$d['NAMA']}</td>\n    \t\t\t\t\t<td nowrap>{$d['TANGGAL']}</td>\n \t\t\t\t\t\t<td align=center>{$d['JUMLAH']} x</td>\n \n\t\t\t\t\t</tr>\n\t\t\t\t";
            ++$i;
        }
        echo "\n \n       </table>\n ";
        if ( $aksi != "cetak" )
        {
            echo "\n            <form target=_blank action=cetakdetilunduhbahankuliah.php method=post>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" )."   \n           <input type=submit value=Cetak>\n            </form>\n            \n            ";
        }
    }
    else
    {
        $errmesg = "Rincian Pengunduh Bahan Kuliah SP belum ada";
        printmesg( $errmesg );
    }
}
?>
