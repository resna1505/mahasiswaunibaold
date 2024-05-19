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
printjudulmenu( "Data Sarana dan Prasarana P.T." );
if ( $aksi == Hapus )
{
    if ( $_GET['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Sarana dan Prasarana", HAPUS_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $q = "DELETE FROM trfpa\r\n      WHERE KDPTITRFPA='{$kodept}' \r\n      AND THSMSTRFPA='{$tahun}{$semester}'\r\n      ";
        mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Data berhasil dihapus";
        }
        else
        {
            $errmesg = "Data tidak dihapus";
        }
        $aksi = "";
    }
}
printmesg( $errmesg );
if ( $aksi != "" )
{
    include( "formsarana.php" );
}
if ( $aksi == "" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    printjudulmenukecil( "<b>".IKONTAMBAH." Entri Data Baru" );
    echo "\r\n <form action=index.php method=post>\r\n  <input type=hidden name=pilihan value='{$pilihan}'>\r\n  <table>\r\n \r\n    <tr>\r\n      <td>Semester/Tahun Pelaporan</td>\r\n      <td>\r\n";
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
    echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t<input type=checkbox name=copy value='1' checked> Copy data sebelumnya\t\t\t\r\n      <input type=submit name=aksi value='Lanjutkan'>\r\n      </td>\r\n    </tr>\r\n  </table>\r\n  </form>\r\n  <hr>\r\n ";
    printjudulmenukecil( "<b>".IKONUPDATE." Edit Data Sarana dan Prasarana" );
    $q = "SELECT  KDPTIMSPTI FROM mspti  LIMIT 0,1";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $kodept = $d[KDPTIMSPTI];
    }
    $q = "SELECT THSMSTRFPA FROM trfpa\r\n      WHERE KDPTITRFPA='{$kodept}' \r\n      ";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        echo "\r\n    <br>\r\n      <table class=form>\r\n        <tr class=juduldata align=center>\r\n          <td>Semester/Tahun pelaporan</td>\r\n          <td colspan=2>Aksi</td>\r\n        </tr>";
        $i = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            $tmp = $d[THSMSTRFPA];
            $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
            $semester = $tmp[4];
            ++$i;
            $kelas = kelas( $i );
            echo "\r\n          <tr {$kelas}>\r\n            <td>".$arraysemester[$semester]." {$tahun}/".( $tahun + 1 )."</td>\r\n            <td align=center><a href='index.php?pilihan={$pilihan}&aksi=Lanjutkan&idprodi={$idprodi}&tahun={$tahun}&semester={$semester}'>".IKONUPDATE."</td>\r\n            <td align=center ><a onClick='return confirm(\"Hapus data?\");' href='index.php?pilihan={$pilihan}&aksi=Hapus&idprodi={$idprodi}&tahun={$tahun}&semester={$semester}&kodept={$kodept}&sessid={$_SESSION['token']}'>".IKONHAPUS."</td>\r\n          </tr>\r\n          ";
        }
        echo "\r\n      </table>\r\n    ";
    }
    else
    {
        printmesg( "Data Sarana dan Prasarana" );
    }
}
?>
