<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $prodis == "" )
{
    cekhaktulis( $kodemenu );
    printjudulmenu( "Edit Waktu Perbaikan KRS Online" );
    if ( $aksi == "hapus" )
    {
        $q = "DELETE FROM waktupkrssp WHERE TAHUN='{$tahunhapus}' AND SEMESTER='{$semesterhapus}'";
        mysqli_query($koneksi,$q);
        $aksi = "";
    }
    if ( $aksi == "Simpan" )
    {
        $q = "INSERT INTO waktupkrssp \r\n  (TAHUN,SEMESTER,TANGGALMULAI,TANGGALSELESAI,LASTUPDATE,UPDATER)\r\n  VALUES \r\n  ('{$tahun}','{$semester}',\r\n  '{$mulai['thn']}-{$mulai['bln']}-{$mulai['tgl']}',\r\n  '{$selesai['thn']}-{$selesai['bln']}-{$selesai['tgl']}',\r\n  NOW(),'{$users}'\r\n  )\r\n  ";
        mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Data waktu KRS online berhasil disimpan";
        }
        else
        {
            $q = "UPDATE waktupkrssp \r\n        SET\r\n        TANGGALMULAI='{$mulai['thn']}-{$mulai['bln']}-{$mulai['tgl']}',\r\n        TANGGALSELESAI='{$selesai['thn']}-{$selesai['bln']}-{$selesai['tgl']}',\r\n        LASTUPDATE=NOW(),\r\n        UPDATER='{$users}'\r\n        WHERE\r\n        TAHUN='{$tahun}' AND\r\n         SEMESTER='{$semester}'\r\n        ";
            mysqli_query($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Data waktu KRS online berhasil disimpan";
            }
            else
            {
                $errmesg = "Data waktu KRS online tidak disimpan";
            }
        }
        $aksi = "";
    }
    if ( $aksi == "" )
    {
        echo "\r\n    <form action='index.php' method=post >\r\n      <input type=hidden name=pilihan value='{$pilihan}'>\r\n      <table>\r\n        <tr>\r\n          <td>Tahun/Semester</td>\r\n          <td>\r\n            <select name=tahun>\r\n              ";
        $i = 1901;
        while ( $i <= $waktu[year] + 5 )
        {
            if ( $i == $waktu[year] )
            {
                $selected = "selected";
            }
            echo "<option {$selected} value='{$i}'>".( $i - 1 )."/{$i}</option>";
            $selected = "";
            ++$i;
        }
        echo "\r\n            </select>/\r\n            <select name=semester>\r\n            ";
        foreach ( $arraysemester as $k => $v )
        {
            echo "<option value='{$k}'>{$v}</option>";
        }
        echo "\r\n            </select>\r\n          </td>\r\n        </tr>\r\n        <tr>\r\n          <td>Tanggal Mulai</td>\r\n          <td>".createinputtanggal( "mulai", "", "" )."</td>\r\n        </tr>\r\n        <tr>\r\n          <td>Tanggal Selesai</td>\r\n          <td>".createinputtanggal( "selesai", "", "" )."</td>\r\n        </tr>\r\n        <tr>\r\n          <td></td>\r\n          <td><input type=submit name=aksi value='Simpan'></td>\r\n        </tr>\r\n      </table>\r\n    </form>\r\n  ";
        $q = "SELECT * FROM waktupkrssp ORDER BY TAHUN,SEMESTER";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            printjudulmenukecil( "<b>Data Waktu Perbaikan KRS Online</b>" );
            echo "\r\n    <table>\r\n      <tr class=juduldata align=center>\r\n        <td>Tahun/Semester</td>\r\n        <td>Mulai</td>\r\n        <td>Selesai</td>\r\n        <td>Tgl Update</td>\r\n        <td>Pengubah</td>\r\n        <td>Hapus</td>\r\n      </tr>\r\n    ";
            $i = 0;
            while ( $d = sqlfetcharray( $h ) )
            {
                ++$i;
                $kelas = kelas( $i );
                $tmp = explode( "-", $d[TANGGALMULAI] );
                $tglmulai = $tmp[2];
                $blnmulai = $tmp[1];
                $thnmulai = $tmp[0];
                $tmp = explode( "-", $d[TANGGALSELESAI] );
                $tglselesai = $tmp[2];
                $blnselesai = $tmp[1];
                $thnselesai = $tmp[0];
                echo "\r\n      <tr {$kelas}>\r\n        <td>".( $d[TAHUN] - 1 )."/{$d['TAHUN']} ".$arraysemester[$d[SEMESTER]]."</td>\r\n        <td  align=center><b>{$tglmulai} ".$arraybulan[$blnmulai - 1]." {$thnmulai} </td>\r\n        <td  align=center><b>{$tglselesai} ".$arraybulan[$blnselesai - 1]." {$thnselesai} </td>\r\n        <td  align=center>{$d['LASTUPDATE']}</td>\r\n        <td align=center>{$d['UPDATER']}</td>\r\n       <td align=center><a href='index.php?pilihan={$pilihan}&tahunhapus={$d['TAHUN']}&semesterhapus={$d['SEMESTER']}&aksi=hapus'\r\n       onClick=\"return confirm('Hapus waktu KRS Online?');\">hapus</a></td>      \r\n       </tr>\r\n      ";
            }
            echo "</table>";
        }
        else
        {
            printmesg( "Data Waktu KRS Online Tidak Ada" );
        }
    }
}
else
{
    printmesg( "Operator Prodi tidak boleh mengakses fasilitas ini" );
}
?>
