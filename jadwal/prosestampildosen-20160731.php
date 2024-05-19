<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\n\t.form {\n\t\tborder-top:1px solid #D5D5D5;\n\t\tborder-right:1px solid #D5D5D5;\n\t\t}\n\t\t\n\t.form td {\n\t\tborder-bottom:1px solid #D5D5D5;\n\t\tborder-left:1px solid #D5D5D5;\n\t\t}\n</style>\n\n";
periksaroot( );
unset( $arraysort );
$arraysort[0] = "jadwalkuliah.IDMAKUL";
$arraysort[1] = "jadwalkuliah.KELAS";
$arraysort[2] = "jadwalkuliah.IDRUANGAN";
$arraysort[3] = "jadwalkuliah.HARI";
$arraysort[4] = "jadwalkuliah.MULAI";
$arraysort[5] = "jadwalkuliah.SELESAI";
$arraysort[6] = "jadwalkuliah.RENCANA";
$arraysort[7] = "jadwalkuliah.TIM";
$arraysort[8] = "jadwalkuliah.IDPRODI";
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSIOn['token'] = $token;
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&sessid={$token}&asal={$asal}&";
if ( $jenisusers == 1 && $caridosen == 1 )
{
    $qfield .= " AND jadwalkuliah.TIM LIKE '%{$users}%'";
    $qjudul .= " NIDN Dosen  {$users} <br>";
    $qinput .= " <input type=hidden name=caridosen value='{$caridosen}'>";
    $href .= "caridosen={$caridosen}&";
}
if ( $semester != "" )
{
    $qfield .= " AND jadwalkuliah.SEMESTER='{$semester}'";
    $qjudul .= " Semester  ".$arraysemester[$semester]."  <br>";
    $qinput .= " <input type=hidden name=semester value='{$semester}'>";
    $href .= "semester={$semester}&";
}
if ( $tahun != "" )
{
    $qfield .= " AND jadwalkuliah.TAHUN='{$tahun}'";
    $qjudul .= " Tahun Akademik  ".( $tahun - 1 )."/{$tahun}  <br>";
    $qinput .= " <input type=hidden name=tahun value='{$tahun}'>";
    $href .= "tahun={$tahun}&";
}
if ( $iddepartemen != "" )
{
    $qfield .= " AND jadwalkuliah.IDPRODI='{$iddepartemen}'";
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
    $qjudul .= " Kelas = '".$arraylabelkelas[$kelasjadwal]."' <br>";
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
if ( $arraysort[$sort] == "" )
{
    $sort = 0;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT jadwalkuliah.* \n   FROM jadwalkuliah \n\t WHERE 1=1  \n\t {$qfield}\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    if ( $aksi != "cetak" )
    {
        printjudulmenu( "Data Jadwal Kuliah" );
        printmesg( $errmesg );
        printmesg( $qjudul );
    }
    else
    {
        printjudulmenucetak( "Data Jadwal Kuliah" );
        printmesgcetak( $qjudul );
    }
    if ( $aksi != "cetak" && $_SESSION['asal'] != "depan" )
    {
        echo "\t{$tpage} {$tpage2}\n\t\t\t\t<table cellpadding=0 cellspacing=0 width=80%>\n\t\t\t\t<tr><td>\n\t\t\t<form target=_blank action='cetakjadwal.php'>\n\t\t\t".IKONCETAK32."\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\n \t\t\t\t<input type=checkbox name=pilihcetak value=1 > Dikelompokkan berdasarkan \n \t\t\t\t<select name=jeniscetak >\n \t\t\t\t";
        foreach ( $arraykelompokcetak as $k => $v )
        {
            echo "<option value={$k} >{$v}</option>";
        }
        echo "\n \t\t\t\t</select>\n \t\t\t\t{$qinput}\n \t\t\t\t{$input}\n \t\t\t \n\t\t\t</form>\n\t\t\t\t</td></tr></table>";
    }
    echo "\n \t\t\t<table class=form{$aksi} cellpadding=0 cellspacing=0 width=80%>\n\t\t\t<tr align=center>\n\t\t\t\t<td>No</td>\n \n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=8'>Prodi</td>\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>Kode MK</td>\n\t\t\t\t<td>Mata Kuliah</td>\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Kelas</td>\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>Ruangan</td>\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Hari</td>\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>Jam Mulai</td>\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Jam Selesai</td>\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=6'>Rencana<br>Tatap<br>Muka</td>\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=7'>Tim<br>Pengajar</td>\n\t\t\t ";
    if ( $tingkataksesusers[$kodemenu] == "T" )
    {
        echo "\n\t\t\t\t\t\t\t<td nowrap colspan=3  >Aksi</td>\n\t\t\t\t\t\t\t";
    }
    echo "\n\t\t\t</tr>\n\t\t";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        $tmp = explode( "\n", $d[TIM] );
        $timpengajar = "";
        foreach ( $tmp as $k => $v )
        {
            $timpengajar .= "{$v} / ".getfield( "NAMA", "dosen", "WHERE ID='".trim( $v )."'" )."<br>";
        }
        echo "\n\t\t\t\t<tr valign=top align=center>\n\t\t\t\t\t<td>{$i}</td>\n \t\t\t\t \n  \t\t\t\t\t<td align=left> ".$arrayprodidep[$d[IDPRODI]]."</td>\n  \t\t\t\t\t<td align=left> {$d['IDMAKUL']}</td>\n \t\t\t\t\t<td align=left  >".getnamafromtabel( $d[IDMAKUL], "makul" )."</td>\n  \t\t\t\t\t<td nowrap> ".$arraylabelkelas[$d[KELAS]]."</td>\n \t\t\t\t\t<td nowrap>".$arrayruangan[$d[IDRUANGAN]]."</td>\n \t\t\t\t\t<td nowrap>".$arrayhari[$d[HARI]]."</td>\n  \t\t\t\t\t<td > {$d['MULAI']}</td>\n  \t\t\t\t\t<td > {$d['SELESAI']}</td>\n  \t\t\t\t\t<td > {$d['RENCANA']}</td>\n  \t\t\t\t\t<td align=left> {$timpengajar}</td>\n \t\t\t\t ";
        if ( $tingkataksesusers[$kodemenu] == "T" )
        {
            echo "\n\t\t\t\t\t\t\t\t<td   align=center><a href='index.php?pilihan={$pilihan}&aksi=formupdate&idupdate={$d['ID']}'>".IKONUPDATE."</td>\n\t\t\t\t\t\t\t\t<td   align=center ><a onclick=\"return confirm('Hapus Data Jadwal Kuliah  ? ');\"\n\t\t\t\t\t\t\t\thref='{$href}&aksi=hapus&idhapus={$d['ID']}&sessid={$_SESSION['token']}'>".IKONHAPUS."</td>\n\n\t\t\t\t\t\t\t\t<td   align=center><a alt='Klik di sini untuk menentukan tanggal-tanggal kuliah berdasarkan Jadwal Kuliah untuk kepentingan absensi' href='index.php?pilihan=detiljadwal&idupdate={$d['ID']}'>Detil Tanggal Jadwal</td>\n\n\t\t\t\t\t\t\t\t";
        }
        echo "\n\t\t\t\t</tr>\n\t\t\t";
        ++$i;
    }
    echo "</table>";
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Jadwal Kuliah Tidak Ada";
    $aksi = "";
}
?>
