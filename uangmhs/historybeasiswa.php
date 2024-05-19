<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

printjudulmenu( "History Beasiswa Mahasiswa" );
$q = "SELECT * FROM diskonbeasiswa WHERE IDMAHASISWA='{$idmahasiswaupdate}' AND IDKOMPONEN='{$idkomponenupdate}' AND\r\n      TAHUN='{$tahunupdate}' AND SEMESTER='{$semesterupdate}'     ";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
    $idkomponen = $idkomponenupdate;
    printmesg( $errmesg );
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    echo "\r\n\t\t<form name=form action=cetakhistorybeasiswa.php target=_blank method=post>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", "{$token}", "" ).createinputhidden( "idmahasiswaupdate", "{$idmahasiswaupdate}", "" ).createinputhidden( "idkomponenupdate", "{$idkomponenupdate}", "" ).createinputhidden( "diskonlama", "{$d['DISKON']}", "" ).createinputhidden( "ketlama", "{$d['KET']}", "" )."<tr class=judulform>\r\n\t\t\t<td class=judulform class=loseborder>NIM / Nama </td>\r\n\t\t\t<td class=loseborder><b>{$d['IDMAHASISWA']} / ".getnamafromtabel( $idmahasiswaupdate, "mahasiswa" )."   \r\n\t\t\t</td>\r\n\t\t</tr> \r\n\t\t<tr valign=top>\r\n\t\t\t<td width=150 class=loseborder>Komponen Pembayaran</td>\r\n\t\t\t<td class=loseborder><b>{$d['IDKOMPONEN']} / ".$arraykomponenpembayaran[$d[IDKOMPONEN]]." \r\n\t\t\t</td>\r\n\t\t\t</tr>\t";
    if ( $arrayjeniskomponenpembayaran[$idkomponen] == 0 || $arrayjeniskomponenpembayaran[$idkomponen] == 1 || $arrayjeniskomponenpembayaran[$idkomponen] == 4 )
    {
    }
    else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 2 )
    {
        echo "\r\n            <tr id=pertahun  >\r\n              <td>Tahun Ajaran</td>\r\n               <td>".( $d[TAHUN] - 1 )."/{$d['TAHUN']}\r\n                  </td>\r\n            </tr>\r\n            \r\n            ";
    }
    else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 3 )
    {
        echo "\r\n        <tr id=persemester  >\r\n          <td>Tahun Ajaran/Semester</td>\r\n           <td>".( $d[TAHUN] - 1 )."/{$d['TAHUN']} / ".$arraysemester[$d[SEMESTER]]."\r\n              </td>\r\n        </tr>";
    }
    else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 6 )
    {
        echo "\r\n        <tr id=persemester  >\r\n          <td>Tahun Ajaran/Semester</td>\r\n           <td>".( $d[TAHUN] - 1 )."/{$d['TAHUN']} / ".$arraysemester[$d[SEMESTER]]." \r\n             </td>\r\n        </tr>";
    }
    else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 5 )
    {
        echo "\r\n        <tr id=perbulan  >\r\n          <td>Bulan-Tahun</td>\r\n           <td> ".$arraybulan[$d[SEMESTER] - 1]." {$d['TAHUN']} \r\n             </td>\r\n        </tr>";
    }
    echo "\t\t\r\n\r\n      <tr class=judulform>\r\n      \t\t\t<td class=judulform class=loseborder>Diskon Pembayaran  </td>\r\n      \t\t\t<td class=loseborder> {$d['DISKON']} \r\n      \t\t\t</td>\r\n      \t\t</tr> \r\n\r\n      <tr class=judulform>\r\n      \t\t\t<td class=judulform class=loseborder>Keterangan</td>\r\n      \t\t\t<td class=loseborder> {$d['KET']} \r\n      \t\t\t</td>\r\n      \t\t</tr> \r\n\r\n\r\n\r\n\r\n\r\n      ";
    if ( $aksi != "cetak" )
    {
        echo "\r\n      <tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit name=aksi value='Cetak' class=masukan>\r\n\t\t\t\t\t \r\n\t\t\t\t</td>\r\n\t\t\t</tr>";
    }
    echo "\r\n\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n \r\n \t\t";
    $q = "SELECT diskonbeasiswa_log.*,DATE_FORMAT(TANGGALUPDATE,'%d-%m-%y pukul %h:%i:%s') AS TANGGAL FROM diskonbeasiswa_log \r\n     \r\n     WHERE IDMAHASISWA='{$idmahasiswaupdate}' AND IDKOMPONEN='{$idkomponenupdate}'\r\n     ORDER BY ID";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        echo "\r\n      <table>\r\n        <tr align=center>\r\n          <td><b>No</td>\r\n          <td><b>Tanggal Entri</td>\r\n          <td><b>Operator</td>\r\n          <td><b>Keterangan</td>\r\n        </tr>\r\n      \r\n      ";
        $i = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            ++$i;
            echo "\r\n             <tr>\r\n              <td align=center>{$i}</td>\r\n              <td>{$d['TANGGAL']}</td>\r\n              <td>{$d['UPDATER']}</td>\r\n              <td>";
            if ( $d[JENIS] == 0 )
            {
                echo "\r\n                Menambah <br>\r\n                Prosentase : {$d['DISKON']}<br>\r\n                Keterangan: {$d['KET']}\r\n                ";
            }
            else if ( $d[JENIS] == 1 )
            {
                echo "\r\n                Mengupdate <br>\r\n                Prosentase : {$d['DISKONLAMA']}<br>\r\n                Keterangan: {$d['KETLAMA']}\r\n                Menjadi <br>\r\n                Prosentase : {$d['DISKON']}<br>\r\n                Keterangan: {$d['KET']}\r\n                ";
            }
            echo " </td>\r\n            </tr>\r\n          \r\n          ";
        }
        echo "</table>";
    }
}
else
{
    printmesg( "Data beasiswa tidak ada." );
}
?>
