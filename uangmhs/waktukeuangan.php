<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
cekhaktulis( $kodemenu );
if ( $prodis == "" )
{
    cekhaktulis( $kodemenu );
    printjudulmenu( "Kalender Keuangan" );
    if ( $aksi == "hapus" )
    {
        if ( $_GET['sessid'] != $_SESSION['token'] )
        {
            $errmesg = token_err_mesg( "Kalender Keuangan", HAPUS_DATA );
        }
        else
        {
            unset( $_SESSION['token'] );
            $q = "DELETE FROm waktukeuangan WHERE TAHUN='{$tahunhapus}' AND SEMESTER='{$semesterhapus}'";
            mysqli_query($koneksi,$q);
        }
        $aksi = "";
    }
    if ( $aksi == "Simpan" )
    {
        if ( $_POST['sessid'] != $_SESSION['token'] )
        {
            $errmesg = token_err_mesg( "Kalender Keuangan", SIMPAN_DATA );
        }
        else
        {
            unset( $_SESSION['token'] );
            $vld[] = cekvaliditasthnajaran( "Tahun/Semester", $tahun, $semester );
            $vld[] = cekvaliditastanggal( "Tanggal Mulai", $mulai['tgl'], $mulai['bln'], $mulai['thn'] );
            $vld[] = cekvaliditastanggal( "Tanggal Selesai", $selesai['tgl'], $selesai['bln'], $selesai['thn'] );
            $vld = array_filter( $vld, "filter_not_empty" );
            if ( isset( $vld ) && 0 < count( $vld ) )
            {
                $errmesg = val_err_mesg( $vld, 1 );
            }
            else
            {
                unset( $_SESSION['token'] );
                $q = "INSERT INTO waktukeuangan \r\n  (TAHUN,SEMESTER,TANGGALMULAI,TANGGALSELESAI,LASTUPDATE,UPDATER,JENIS)\r\n  VALUES \r\n  ('{$tahun}','{$semester}',\r\n  '{$mulai['thn']}-{$mulai['bln']}-{$mulai['tgl']}',\r\n  '{$selesai['thn']}-{$selesai['bln']}-{$selesai['tgl']}',\r\n  NOW(),'{$users}','{$jenis}')\r\n  ";
                mysqli_query($koneksi,$q);
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    $errmesg = "Data Kalender Keuangan berhasil disimpan";
                }
                else
                {
                    $q = "UPDATE waktukeuangan \r\n        SET\r\n        TANGGALMULAI='{$mulai['thn']}-{$mulai['bln']}-{$mulai['tgl']}',JENIS='{$jenis}',\r\n        TANGGALSELESAI='{$selesai['thn']}-{$selesai['bln']}-{$selesai['tgl']}',\r\n        LASTUPDATE=NOW(),\r\n        UPDATER='{$users}'\r\n        WHERE\r\n        TAHUN='{$tahun}' AND\r\n         SEMESTER='{$semester}'\r\n        ";
                    mysqli_query($koneksi,$q);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        $errmesg = "Data Kalender Keuangan berhasil disimpan";
                    }
                    else
                    {
                        $errmesg = "Data Kalender Keuangan tidak disimpan";
                    }
                }
            }
        }
        $aksi = "";
    }
    if ( $aksi == "" )
    {
        $token = md5( uniqid( rand( ), TRUE ) );
        $_SESSION['token'] = $token;
        printmesg( $errmesg );
        echo "\r\n   <div class=\"page-content\">
            <div class=\"container\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\">KALENDER KEUANGAN</span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
        <div class=\"portlet-body form\"> <form action='index.php' method=post >\r\n      <input type=hidden name=pilihan class=memasukan value='{$pilihan}'>\r\n\t  <input type=hidden name=sessid value='{$token}'>\r\n\t  ".IKONTOOLS48."\r\n   <div style=overflow-x:auto;>   <table>\r\n         <tr>\r\n\t\t\t<td>Jenis</td>\r\n\t\t\t<td>\r\n\t\t\t <input type=radio name=jenis value='KRS' checked> KRS <input type=radio name=jenis value='UTS'> UTS <input type=radio name=jenis value='UAS'> UAS</td>\r\n\t\t</tr><tr>\r\n          <td>Tahun/Semester</td>\r\n          <td>\r\n            <select name=tahun>\r\n              ";
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
        echo "\r\n            </select>\r\n          </td>\r\n        </tr>\r\n        <tr>\r\n          <td>Tanggal Mulai</td>\r\n          <td>".createinputtanggal( "mulai", "", "" )."</td>\r\n        </tr>\r\n        <tr>\r\n          <td>Tanggal Selesai</td>\r\n          <td>".createinputtanggal( "selesai", "", "" )."</td>\r\n        </tr>\r\n        <tr>\r\n          <td></td>\r\n          <td><input type=submit name=aksi value='Simpan'></td>\r\n        </tr>\r\n      </table>\r\n    </form></div>\r\n  ";
        $q = "SELECT * FROM waktukeuangan ORDER BY TAHUN,SEMESTER";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            printjudulmenukecil( "<b>Data kalender Keuangan</b>" );
            echo "\r\n    <table>\r\n      <tr class=juduldata align=center>\r\n        <td>Tahun/Semester</td>\r\n        <td>Mulai</td>\r\n        <td>Selesai</td><td>Jenis</td><td>Tgl Update</td>\r\n        <td>Pengubah</td>\r\n        <td>Hapus</td>\r\n      </tr>\r\n    ";
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
                echo "\r\n      <tr {$kelas}>\r\n        <td>".( $d[TAHUN] - 1 )."/{$d['TAHUN']} ".$arraysemester[$d[SEMESTER]]."</td>\r\n        <td  align=center><b>{$tglmulai} ".$arraybulan[$blnmulai - 1]." {$thnmulai} </td>\r\n        <td  align=center><b>{$tglselesai} ".$arraybulan[$blnselesai - 1]." {$thnselesai} </td><td  align=center>{$d['JENIS']}</td><td  align=center>{$d['LASTUPDATE']}</td>\r\n        <td align=center>{$d['UPDATER']}</td>\r\n       <td align=center><a href='index.php?pilihan={$pilihan}&tahunhapus={$d['TAHUN']}&semesterhapus={$d['SEMESTER']}&aksi=hapus&sessid={$token}'\r\n       onClick=\"return confirm('Hapus Kalender Keuangan?');\">hapus</a></td>      \r\n       </tr>\r\n      ";
            }
            echo "</table></div>";
        }
        else
        {
            printmesg( "Data Kalender Keuangan Tidak Ada" );
        }
    }
}
else
{
    printmesg( "Operator Prodi tidak boleh mengakses fasilitas ini" );
}
?>
