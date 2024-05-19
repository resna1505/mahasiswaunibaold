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
$q = "SELECT skm.* \n   FROM skm \n\t WHERE 1=1  \n\t {$qfield}\n\tORDER BY tanggal";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
        printjudulmenu( "Data SKM" );
        printmesg( $errmesg );
        printmesg( $qjudul );
    echo "\n \t\t\t<table class=form{$aksi} cellpadding=0 cellspacing=0 width=80%>\n\t\t\t<tr align=center>\n\t\t\t\t<td>No</td>\n \n\t\t\t\t<td>NIM</td>\n\t\t\t\t<td>NAMA</td>\n\t\t\t\t<td>Fakultas</td>\n\t\t\t\t<td>Jurusan</td>\n\t\t\t\t<td>Semester</td>\n\t\t\t\t<td>Jenis Surat</td>";
    echo "\n\t\t\t</tr>\n\t\t";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        #$tmp = explode( "\n", $d[TIM] );
        $timpengajar = "";
        foreach ( $arrayskm as $k => $v )
        {
			#echo $v."aaaa".$k;
			if($d['jns_surat']==$k){
				$surat=$v;
			}
            #$timpengajar .= "{$v} / ".getfield( "NAMA", "dosen", "WHERE ID='".trim( $v )."'" )."<br>";
        }
		#echo $surat;
        echo "\n\t\t\t\t<tr valign=top align=center>\n\t\t\t\t\t<td>{$i}</td>\n \t\t\t\t \n  \t\t\t\t\t<td align=left>{$d['nim']}</td>\n  \t\t\t\t\t<td align=left> {$d['nama']}</td>\n \t\t\t\t\t<td align=left  >{$d['fakultasskm']}</td>\n  \t\t\t\t\t<td nowrap>{$d['jurusanskm']}</td>\n \t\t\t\t\t<td nowrap>{$d['semesterskm']}</td>\n \t\t\t\t\t<td nowrap>".$surat."</td>";
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
