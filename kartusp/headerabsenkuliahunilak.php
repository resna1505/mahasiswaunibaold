<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$bodycetak .= "\r\n    <tr>\r\n    <td width=50% align=left valign=top class=loseborder>\r\n    <table  class=form > \r\n    ";
$bodycetak .= "\r\n     <tr   valign=top>\r\n\t\t\t<td class=judulform>Fakultas</td>\r\n\t\t\t<td>: {$dx['NAMAF']}</td>\r\n\t\t</tr>\r\n     <tr   valign=top>\r\n\t\t\t<td class=judulform>Jurusan</td>\r\n\t\t\t<td>: {$dx['NAMAJ']}</td>\r\n\t\t</tr>\r\n     <tr   valign=top>\r\n\t\t\t<td class=judulform>Prodi</td>\r\n\t\t\t<td>: {$dx['NAMAP']}</td>\r\n\t\t</tr>\r\n     <tr   valign=top>\r\n\t\t\t<td class=judulform>Jenjang</td>\r\n\t\t\t<td>: ".$arrayjenjang[$dx[TINGKAT]]."</td>\r\n\t\t</tr>\r\n    <!--\r\n     <tr  >\r\n\t\t\t<td class=judulform>Kode Mata Kuliah</td>\r\n\t\t\t<td>: {$idmakulupdate}</td>\r\n\t\t</tr>\r\n\t\t-->\r\n     <tr   valign=top>\r\n\t\t\t<td class=judulform>Kode & Mata Kuliah</td>\r\n\t\t\t<td>: {$idmakulupdate} {$dx['NAMA']}</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>SMT/SKS/Kelas</td>\r\n\t\t\t<td>: {$dx['SEMESTER']}/{$dx['SKS']}/{$kelasupdate}</td>\r\n\t\t</tr>"."\r\n\t\t</table>\r\n\t\t</td><td width=50% align=left  class=loseborder valign=top>\r\n\t\t<table class=form width=100%>\r\n\t\t      <tr class=judulform>\r\n\t\t\t<td  >Tahun Akademik</td>\r\n\t\t\t<td>: ".$arraysemester[$semesterupdate]."\t ".( $tahunupdate - 1 )."/{$tahunupdate}\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>\r\n    <!--\r\n    ";
if ( $jenis == "Kuliah" )
{
    $q = "SELECT * FROM jadwalkuliahkurikulum WHERE \r\n    IDPRODI='{$idprodiupdate}' AND\r\n    IDMAKUL='{$idmakulupdate}' AND\r\n    KELAS='{$kelasupdate}' AND\r\n    TAHUN='{$tahunupdate}' AND\r\n    SEMESTER='{$semesterupdate}'\r\n    LIMIT 0,1\r\n    \r\n    ";
    $jam = $hari = $ruangan = "";
    $hk = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $hk ) )
    {
        $dk = sqlfetcharray( $hk );
        $jam = $dk[JAM];
        $hari = $dk[HARI];
        $ruangan = $dk[RUANGAN];
    }
}
$bodycetak .= "<tr class=judulform>\r\n\t\t\t<td>Hari/Tanggal</td>\r\n\t\t\t<td>: \t\t{$hari}\t\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t-->\r\n    <tr class=judulform>\r\n\t\t\t<td>Pukul</td>\r\n\t\t\t<td>: \t{$jam}\t\t\r\n\t\t\t</td>\r\n\t\t</tr>\r\n    <tr class=judulform  valign=top>\r\n\t\t\t<td>Ruang</td>\r\n\t\t\t<td>: \t\t{$ruangan}\t\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t\r\n    <tr class=judulform  valign=top>\r\n\t\t\t<td class=judulform nowrap>{$LABEL_DOSEN_PENGASUH}</td>\r\n\t\t\t<td>: <!-- {$iddosenupdate}, --> ".getnamafromtabel( $iddosenupdate, "dosen" )."</td>\r\n\t\t</tr>\r\n   \r\n    <tr class=judulform>\r\n\t\t\t<td>Pengawas</td>\r\n\t\t\t<td>: \t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>\r\n \r\n\t\t</table>\r\n\t\t </td></tr>";
?>
