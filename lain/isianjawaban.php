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
printjudulmenu( "Tabel Isian Jawaban Pertanyaan" );
printmesg( $errmesg );
if ( $aksi == Hapus )
{
    if ( $_GET['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Tabel Isian Jawaban Pertanyaan", HAPUS_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $q = "DELETE FROM trppg \r\n      WHERE KDPTITRPPG='{$kodept}' AND\r\n      KDPSTTRPPG='{$kodeps}' AND\r\n      KDJENTRPPG='{$kodejenjang}' \r\n      AND THSMSTRPPG='{$tahun}{$semester}' AND\r\n      KDTESTRPPG='{$idupdate}' AND\r\n      NORUTTRPPG='{$urutan}'\r\n      ";
        mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Data berhasil dihapus";
        }
        else
        {
            $errmesg = "Data tidak dihapus";
        }
    }
    $aksi = "";
    $aksi2 = "Tampilkan2";
}
if ( $aksi != "" )
{
    include( "formisianjawaban.php" );
}
if ( $aksi == "" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    printjudulmenukecil( "<b>".IKONTAMBAH." Entri Data Baru" );
    echo "\r\n <form action=index.php method=post>\r\n  <input type=hidden name=pilihan value='{$pilihan}'>\r\n  <table>\r\n    <tr>\r\n      <td>Jurusan/Program Studi</td>\r\n      <td>\r\n      <select name=idprodi>";
    foreach ( $arrayprodidep as $k => $v )
    {
        echo "<option value='{$k}' >{$v}</option>";
    }
    echo "\r\n      </select>\r\n      \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>Semester/Tahun Pelaporan</td>\r\n      <td>\r\n";
    $waktu = getdate( );
    echo "\r\n\r\n\t\t\t\t\t\t<select name=semester class=masukan> \r\n\t\t\t\t\t\t ";
    unset( $arraysemester[3] );
    foreach ( $arraysemester as $k => $v )
    {
        if ( $k == $semester )
        {
            $selected = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$selected}>{$v}</option>\r\n\t\t\t\t\t\t\t";
        $selected = "";
    }
    echo "\r\n\t\t\t\t\t\t</select>/\r\n\t\t\t\t\t\t<select name=tahun class=masukan> \r\n\t\t\t\t\t\t ";
    $selected = "";
    $i = 1901;
    while ( $i <= $waktu[year] + 5 )
    {
        if ( $i == $waktu[year] )
        {
            $selected = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t<option value='{$i}'  {$selected}>".$i."/".( $i + 1 )."</option>\r\n\t\t\t\t\t\t\t";
        $selected = "";
        ++$i;
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n      <input type=submit name=aksi value='Lanjutkan'>\r\n      </td>\r\n    </tr>\r\n  </table>\r\n  </form>\r\n  <hr>\r\n ";
    printjudulmenukecil( "<b>".IKONUPDATE." Edit Data Isian Jawaban Pertanyaan" );
    echo "\r\n <form action=index.php method=post>\r\n  <input type=hidden name=pilihan value='{$pilihan}'>\r\n  <table>\r\n    <tr>\r\n      <td>Jurusan/Program Studi</td>\r\n      <td>\r\n      <select name=idprodi>";
    $selected = "";
    foreach ( $arrayprodidep as $k => $v )
    {
        if ( $idprodi == $k )
        {
            $selected = "selected";
        }
        echo "<option value='{$k}' {$selected}>{$v}</option>";
        $selected = "";
    }
    echo "\r\n      </select>\r\n      <input type=submit name=aksi2 value='Tampilkan'>\r\n      </td>\r\n    </tr>\r\n  </table>\r\n  </form>\r\n ";
    if ( $aksi2 == "Tampilkan" )
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
        $q = "SELECT  THSMSTRPPG,KDTESTRPPG,COUNT(NORUTTRPPG) AS JML    FROM trppg \r\n      WHERE KDPTITRPPG='{$kodept}' AND\r\n      KDPSTTRPPG='{$kodeps}' AND\r\n      KDJENTRPPG='{$kodejenjang}'\r\n      GROUP BY THSMSTRPPG,KDTESTRPPG\r\n      ORDER BY\r\n      THSMSTRPPG DESC,KDTESTRPPG DESC\r\n      ";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            echo "\r\n    <br>\r\n      <table class=form>\r\n        <tr class=juduldata align=center>\r\n          <td>Semester/Tahun pelaporan</td>\r\n          <td>Kode Tes</td>\r\n          <td>Jml Data</td>\r\n            <td colspan=2>Aksi</td>\r\n        </tr>";
            $i = 0;
            while ( $d = sqlfetcharray( $h ) )
            {
                $tmp = $d[THSMSTRPPG];
                $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
                $semester = $tmp[4];
                $idupdate = $d[KDTESTRPPG];
                ++$i;
                $kelas = kelas( $i );
                echo "\r\n          <tr {$kelas} valign=top>\r\n            <td align=center>".$arraysemester[$semester]." {$tahun}/".( $tahun + 1 )."</td>\r\n            <td align=center>{$d['KDTESTRPPG']}</td>\r\n            <td align=center>{$d['JML']}</td>\r\n            <td align=center><a href='index.php?pilihan={$pilihan}&aksi2=Tampilkan2&idprodi={$idprodi}&tahun={$tahun}&semester={$semester}&kodept={$kodept}&kodeps={$kodeps}&kodejenjang={$kodejenjang}&idupdate={$idupdate}'>".IKONUPDATE."</td>\r\n\t\t\t <td  align=center><a onClick='return confirm(\"Hapus data?\");' href='index.php?idprodi={$idprodi}&pilihan={$pilihan}&aksi=Hapus&idprodi={$idprodi}&tahun={$tahun}&semester={$semester}&kodept={$kodept}&kodeps={$kodeps}&kodejenjang={$kodejenjang}&idupdate={$idupdate}&urutan={$d['NORUTTRPPG']}&sessid={$_SESSION['token']}'>".IKONHAPUS."</td>\r\n          </tr>\r\n          ";
            }
            echo "\r\n      </table>\r\n    ";
        }
        else
        {
            printmesg( "Data isian Jawaban untuk Program Studi ".$arrayprodidep[$idprodi]." tidak ada" );
        }
    }
    if ( $aksi2 == "Tampilkan2" )
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
        $q = "SELECT   THSMSTRPPG,KDTESTRPPG,NORUTTRPPG    \r\n      FROM trppg \r\n      WHERE KDPTITRPPG='{$kodept}' AND\r\n      KDPSTTRPPG='{$kodeps}' AND\r\n      KDJENTRPPG='{$kodejenjang}' AND\r\n      KDTESTRPPG='{$idupdate}'\r\n      ORDER BY\r\n      THSMSTRPPG DESC,KDTESTRPPG DESC\r\n      ";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            echo "\r\n    <br>\r\n      <table class=data>\r\n        <tr class=juduldata align=center>\r\n          <td>Semester/Tahun pelaporan</td>\r\n          <td>Kode Tes</td>\r\n          <td>Urutan</td>\r\n            <td colspan=2>Aksi</td>\r\n        </tr>";
            while ( $d = sqlfetcharray( $h ) )
            {
                $tmp = $d[THSMSTRPPG];
                $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
                $semester = $tmp[4];
                $idupdate = $d[KDTESTRPPG];
                echo "\r\n          <tr valigm=top>\r\n            <td align=center>".$arraysemester[$semester]." {$tahun}/".( $tahun + 1 )."</td>\r\n            <td align=center>{$d['KDTESTRPPG']}</td>\r\n            <td align=center>{$d['NORUTTRPPG']}</td>\r\n            <td ><a href='index.php?pilihan={$pilihan}&aksi=Tampilkan&idprodi={$idprodi}&tahun={$tahun}&semester={$semester}&kodept={$kodept}&kodeps={$kodeps}&kodejenjang={$kodejenjang}&idupdate={$idupdate}&urutan={$d['NORUTTRPPG']}&sessid={$_SESSION['token']}'>Update</td>\r\n            <td ><a onClick='return confirm(\"Hapus data?\");' href='index.php?idprodi={$idprodi}&pilihan={$pilihan}&aksi=Hapus&idprodi={$idprodi}&tahun={$tahun}&semester={$semester}&kodept={$kodept}&kodeps={$kodeps}&kodejenjang={$kodejenjang}&idupdate={$idupdate}&urutan={$d['NORUTTRPPG']}&sessid={$_SESSION['token']}'>Hapus</td>\r\n          </tr>\r\n          ";
            }
            echo "\r\n      </table>\r\n    ";
        }
        else
        {
            printmesg( "Data isian Jawaban untuk Program Studi ".$arrayprodidep[$idprodi]." dengan Kode Tes {$idupdate} tidak ada" );
        }
    }
}
?>
