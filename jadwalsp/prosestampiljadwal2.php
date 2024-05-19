<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $jenisusers == 1 && $caridosen == 1 )
{
    $qfield .= " AND jadwalkuliahsp.TIM LIKE '%{$users}%'";
    $qjudul .= " NIDN Dosen  {$users} <br>";
    $qinput .= " <input type=hidden name=caridosen value='{$caridosen}'>";
    $href .= "caridosen={$caridosen}&";
}
if ( $semester != "" )
{
    $qfield .= " AND jadwalkuliahsp.SEMESTER='{$semester}'";
    $qjudul .= " Semester  ".$arraysemester[$semester]."  <br>";
    $qinput .= " <input type=hidden name=semester value='{$semester}'>";
    $href .= "semester={$semester}&";
}
if ( $tahun != "" )
{
    $qfield .= " AND jadwalkuliahsp.TAHUN='{$tahun}'";
    $qjudul .= " Tahun Akademik  ".( $tahun - 1 )."/{$tahun}  <br>";
    $qinput .= " <input type=hidden name=tahun value='{$tahun}'>";
    $href .= "tahun={$tahun}&";
}
if ( $iddepartemen != "" )
{
    $qfield .= " AND jadwalkuliahsp.IDPRODI='{$iddepartemen}'";
    $qjudul .= " Jurusan/Program Studi '".$arrayprodidep[$iddepartemen]."' <br>";
    $qinput .= " <input type=hidden name=iddepartemen value='{$iddepartemen}'>";
    $href .= "iddepartemen={$iddepartemen}&";
}
if ( $makul != "" )
{
    $qfield .= " AND IDMAKUL = '{$makul}'";
    $qjudul .= " ID MAKUL = {$makul} (".getnamafromtabel( $makul, "makul" ).") <br>";
    $qinput .= " <input type=hidden name=makul value='{$makul}'>";
    $href .= "makul={$makul}&";
}
if ( $kelasjadwal != "" )
{
    $qfield .= " AND KELAS = '{$kelasjadwal}'";
    $qjudul .= " Kelas = '{$kelasjadwal}' <br>";
    $qinput .= " <input type=hidden name=kelasjadwal value='{$kelasjadwal}'>";
    $href .= "kelasjadwal={$kelasjadwal}&";
}
if ( $hari != "" )
{
    $qfield .= " AND HARI='{$hari}'";
    $qjudul .= " Hari '".$arrayhari[$hari]."' <br>";
    $qinput .= " <input type=hidden name=hari value='{$hari}'>";
    $href .= "hari={$hari}&";
}
if ( $sort == "" )
{
    $sort = " ID";
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT jadwalkuliahsp.* \r\n   FROM jadwalkuliahsp \r\n\t WHERE 1=1  \r\n\t {$qfield}\r\n\tORDER BY  ".$arraykcf[$jeniscetak].", MULAI,SELESAI";
$h = mysqli_query($koneksi,$q);
echo mysqli_error($koneksi);
if ( 0 < sqlnumrows( $h ) )
{
    if ( $aksi != "cetak" )
    {
        printjudulmenu( "Data Jadwal Kuliah SP" );
        printmesg( $qjudul );
    }
    else
    {
        printjudulmenucetak( "Data Jadwal Kuliah SP" );
        printmesgcetak( $qjudul );
    }
    echo "<br><br>     \t\t\t\r\n <table  {$border} class=data{$aksi}>\r\n";
    $i = 1;
    $kodelama = "";
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        if ( $kodelama != $d[$arraykcf[$jeniscetak]] )
        {
            if ( $jeniscetak == 2 )
            {
                $namakelompok = $arrayhari[$d[HARI]];
            }
            else
            {
                $namakelompok = $d[$arraykcf[$jeniscetak]]." - ".getnamafromtabel( $d[$arraykcf[$jeniscetak]], $arraykct[$jeniscetak] );
            }
            echo "\r\n    \t\t  <tr>\r\n    \t\t    <td colspan=8>\r\n    \t\t <b> \r\n         {$namakelompok}</b> \r\n         </td>\r\n         </tr>\r\n         \r\n    \t\t\t<tr class=juduldata{$aksi} align=center>";
            if ( $jeniscetak != 0 )
            {
                echo "\r\n     \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=IDMAKUL'>Kode MK</td>\r\n    \t\t\t\t<td>Mata Kuliah</td>";
            }
            echo "\r\n    \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=KELAS'>Kelas</td>";
            if ( $jeniscetak != 1 )
            {
                echo "\r\n    \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=IDRUANGAN'>Ruangan</td>";
            }
            if ( $jeniscetak != 2 )
            {
                echo "\r\n    \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=HARI'>Hari</td>";
            }
            echo "\r\n    \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=MULAI'>Jam Mulai</td>\r\n    \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=SELESAI'>Jam Selesai</td>\r\n    \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=RENCANA'>Rencana<br>Tatap<br>Muka</td>\r\n    \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=TIM'>Tim<br>Pengajar</td>\r\n     \r\n    \t\t\t</tr>\r\n    \t\t";
            $kodelama = $d[$arraykcf[$jeniscetak]];
        }
        $tmp = explode( "\n", $d[TIM] );
        $timpengajar = "";
        foreach ( $tmp as $k => $v )
        {
            $timpengajar .= "{$v} / ".getfield( "NAMA", "dosen", "WHERE ID='".trim( $v )."'" )."<br>";
        }
        echo "\r\n\t\t\t\t<tr valign=top align=center {$kelas}{$aksi}>";
        if ( $jeniscetak != 0 )
        {
            echo "\r\n  \t\t\t\t\t<td align=left> {$d['IDMAKUL']}</td>\r\n \t\t\t\t\t<td align=left  >".getnamafromtabel( $d[IDMAKUL], "makul" )."</td>";
        }
        echo "\r\n  \t\t\t\t\t<td > {$d['KELAS']}</td>";
        if ( $jeniscetak != 1 )
        {
            echo "\r\n \t\t\t\t\t<td  align=left>".$arrayruangan[$d[IDRUANGAN]]."</td>";
        }
        if ( $jeniscetak != 2 )
        {
            echo "\r\n \t\t\t\t\t<td  >".$arrayhari[$d[HARI]]."</td>";
        }
        echo "\r\n  \t\t\t\t\t<td > {$d['MULAI']}</td>\r\n  \t\t\t\t\t<td > {$d['SELESAI']}</td>\r\n  \t\t\t\t\t<td > {$d['RENCANA']}</td>\r\n  \t\t\t\t\t<td align=left> {$timpengajar}</td>\r\n \t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
    echo "</table>";
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Jadwal Kuliah SP Tidak Ada";
    $aksi = "";
}
?>
