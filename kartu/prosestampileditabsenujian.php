<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
set_time_limit(0);
periksaroot( );
$pakaiborder = "\r\nstyle='\r\n            border-collapse:collapse; border:1px solid black;\r\n            '\r\n";
$stylecetak = "\r\n<style type=\"text/css\">\r\n\r\n.form td{\r\n\tborder:none;\r\n\tpadding:2px 5px;\r\n\t}\r\n \r\n\t\r\n@media print {\r\n   thead {display: table-header-group;}\r\n}\r\n\r\n\r\n</style>\r\n";
$q = "SELECT dosenpengajar.DOSENLAIN,makul.ID,makul.SKS,makul.SEMESTER,\r\n prodi.NAMA as NAMAP ,prodi.TINGKAT,prodi.ID AS IDPRODI,prodi.NIPPIMPINAN,prodi,NAMAPIMPINAN,\r\n  \r\n fakultas.NAMA as NAMAF, \r\n fakultas.NAMAPIMPINAN as DEKAN \r\n FROM makul,prodi,departemen LEFT JOIN fakultas ON departemen.IDFAKULTAS=fakultas.ID\r\n\r\nWHERE 1=1 \r\nAND\r\nmakul.IDPRODI=prodi.ID\r\nAND\r\ndepartemen.ID=prodi.IDDEPARTEMEN\r\nAND makul.ID='{$idmakulupdate}'\r\n ";
$q = "SELECT tbkmk.NAKMKTBKMK NAMA,makul.ID,\r\n      mspst.IDX AS IDPRODI,\r\n     tbkmk.*,SKSMKTBKMK AS SKS ,     \r\n      SEMESTBKMK  +0 AS SEMESTER ,\r\n prodi.NAMA as NAMAP ,prodi.TINGKAT,prodi.ID AS IDPRODI,prodi.NIPPIMPINAN,prodi.NAMAPIMPINAN,fakultas.ID as FID, fakultas.NAMA as NAMAF, \r\n fakultas.NAMAPIMPINAN as DEKAN ,fakultas.NAMAPD1,fakultas.NIPPD1,\r\n departemen.NAMA AS NAMAJ\r\n      \r\n      FROM makul,mspst,tbkmk, prodi,departemen LEFT JOIN fakultas ON departemen.IDFAKULTAS=fakultas.ID\r\n      \r\n\tWHERE makul.ID=tbkmk.KDKMKTBKMK AND\r\n \r\n  mspst.KDPSTMSPST=tbkmk.KDPSTTBKMK AND\r\n  mspst.KDJENMSPST=tbkmk.KDJENTBKMK AND\r\n  mspst.KDPTIMSPST=tbkmk.KDPTITBKMK\r\n  AND makul.ID='{$idmakulupdate}'\r\nAND mspst.IDX=prodi.ID\r\nAND departemen.ID=prodi.IDDEPARTEMEN\r\nAND tbkmk.THSMSTBKMK='".( $tahunupdate - 1 )."{$semesterupdate}'\r\nAND mspst.IDX='{$idprodiupdate}'";
#echo $q;
$hx = mysqli_query($koneksi,$q);
echo mysqli_error($koneksi);
if ( 0 < sqlnumrows($hx))
{
    $dx = sqlfetcharray($hx);
    $namapimpinan = $dx[NAMAPIMPINAN];
    $nippimpinan = $dx[NIPPIMPINAN];
    $dosenpengampu = $dx[NODOSTBKMK];
	$qdosen = "SELECT dosenpengajar.*,makul.NAMA AS NAMAMAKUL,dosen.NAMA AS NAMADOSEN FROM dosenpengajar,makul,dosen WHERE 1=1 ".
	"AND dosen.ID=dosenpengajar.IDDOSEN AND makul.ID=dosenpengajar.IDMAKUL AND makul.ID='{$idmakulupdate}' AND dosenpengajar.SEMESTER = '{$semesterupdate}' AND TAHUN='$tahunupdate' AND dosenpengajar.IDPRODI='{$idprodiupdate}' AND dosenpengajar.KELAS='{$kelasupdate}'";
    #echo $qdosen;
	$hdosen = doquery($koneksi,$qdosen);
    $ddosen = sqlfetcharray($hdosen);
	
    if ( trim( $ddosen[DOSENLAIN] ) != "" )
            {
                #$dosenlain = "<br>";
		$dosenlain = "";
                $tmp = explode( "\n", $ddosen[DOSENLAIN] );
                foreach ( $tmp as $k => $v )
                {
                    $tmp2 = explode( " ", $v );
                    $tmpnama = $tmp2[0];
                    unset( $tmp2[0] );
                    $tmpnama .= " / ".implode( " ", $tmp2 );
                    $dosenlain .= " {$tmpnama}<br>";
                }
            }
}
if ( $aksi != "cetak" )
{
	#echo "mm";exit();
    if ( $jenis == "UTS" )
    {
        $jenis2 = "UJIAN TENGAH SEMESTER";
    }
    else if ( $jenis == "UAS" )
    {
        $jenis2 = " UJIAN AKHIR SEMESTER";
    }
    else
    {
        $jenis2 = " KULIAH";
    }
    printjudulmenu( "{$LABEL_ABSENSI} {$jenis2}" );
    printmesg( $errmesg );
}
else
{
	#echo "kk";exit();
    $tmpkop = "";
    if ( $kopsurat == 1 )
    {
        include("../nilai/proseskop.php");
    }
    $bodycetak .= $tmpcetakawal = "<div style='page-break-after:always'>\r\n        ".$tmpkop;
    $judulcetak = " \r\n       ";
    if ( $jenis == "UTS" )
    {
        $judulcetak .= "DAFTAR HADIR UJIAN TENGAH SEMESTER";
    }
    else if ( $jenis == "UAS" )
    {
        $judulcetak .= "DAFTAR HADIR UJIAN AKHIR SEMESTER";
    }
    else
    {
        $judulcetak .= "DAFTAR HADIR ABSENSI KULIAH  ";
    }
    $judulcetak .= "\r\n    <br><br>";
}
if ( $jenis == "Kuliah" )
{
    $rowspan = "rowspan=3";
}
if ( $UNIVERSITAS == "STIKES SAMARINDA" && $jenis == "Kuliah" && $aksi == "cetak" )
{
    $bodycetak .= "\r\n    <div align=center >\r\n    <table width=100%>\r\n    <tr>\r\n    <td  class=loseborder width=10%><img src='logosamarinda.jpg'   height=100>\r\n    </td>\r\n    <td nowrap align=center  class=loseborder style='font-weight:bold;font-size:12pt;' width=80%> ABSENSI PERKULIAHAN<BR>\r\n    SEKOLAH TINGGI ILMU KESEHATAN MUHAMMADIYAH SAMARINDA<BR>\r\n    PROGRAM STUDI ".$arrayjenjang[$dx[TINGKAT]]." {$dx['NAMAP']}<BR>\r\n    TAHUN AKADEMIK ".( $tahunupdate - 1 )."/{$tahunupdate}\r\n    </td>\r\n\t<td class='loseborder' width=10%></tr></table>\r\n    </div>";
}
else
{
    $bodycetak .= "\r\n    <div align=center  style='font-weight:bold;font-size:20pt;'>{$judulcetak}</div>";
}
$bodycetak .= " \r\n\r\n    \r\n    <table width=100%>\r\n    <thead valign=bottom  style='display: table-header-group;'>";
if ( $UNIVERSITAS == "STIKES SAMARINDA" )
{
    include( "headerabsenkuliahstikessamarinda.php" );
}
else if ( $UNIVERSITAS == "UNILAK" )
{
    include( "headerabsenkuliahunilak.php" );
}
else
{
	#echo "lll";exit();
    $bodycetak .= "\r\n    <tr>\r\n    <td width=50% align=left valign=top class=loseborder>\r\n    <table  class=form > \r\n    ";
    $bodycetak .= "\r\n     <tr  >\r\n\t\t\t<td class=judulform>{$LABEL_JURUSAN}</td>\r\n\t\t\t<td>: {$dx['NAMAP']} </td>\r\n\t\t</tr>\r\n     <tr  >\r\n\t\t\t<td class=judulform>Jenjang</td>\r\n\t\t\t<td>: ".$arrayjenjang[$dx[TINGKAT]]."</td>\r\n\t\t</tr>\r\n     <tr  >\r\n\t\t\t<td class=judulform>Kode Mata Kuliah</td>\r\n\t\t\t<td>: {$idmakulupdate}</td>\r\n\t\t</tr>\r\n     <tr  >\r\n\t\t\t<td class=judulform>Mata Kuliah</td>\r\n\t\t\t<td>: {$dx['NAMA']}</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>SMT/SKS/Kelas</td>\r\n\t\t\t<td>: {$dx['SEMESTER']}/{$dx['SKS']}/".$arraylabelkelas[$kelasupdate]."</td>\r\n\t\t</tr>"."\r\n\t\t</table>\r\n\t\t</td><td width=50% align=left  class=loseborder>\r\n\t\t<table class=form width=100%>\r\n\t\t      <tr class=judulform>\r\n\t\t\t<td  >Tahun Akademik</td>\r\n\t\t\t<td>: ".$arraysemester[$semesterupdate]."\t ".( $tahunupdate - 1 )."/{$tahunupdate}\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>";
    if ( $jenis == "Kuliah" )
    {
		#echo "jjj";exit();
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
    $bodycetak .= "<tr class=judulform>\r\n\t\t\t<td>Hari/Tanggal</td>\r\n\t\t\t<td>: \t\t{$hari}\t\r\n\t\t\t</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Jam</td>\r\n\t\t\t<td>: \t{$jam}\t\t\r\n\t\t\t</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Ruang</td>\r\n\t\t\t<td>: \t\t{$ruangan}\t\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t\r\n    <tr class=judulform>\r\n\t\t\t<td class=judulform nowrap>{$LABEL_DOSEN_PENGASUH}</td>\r\n\t\t\t<td>: <!-- {$iddosenupdate}, --> ".getnamafromtabel( $iddosenupdate, "dosen" )." / ".$dosenlain."</td>\r\n\t\t</tr>\r\n    <!--\r\n    <tr class=judulform>\r\n\t\t\t<td>Pengawas</td>\r\n\t\t\t<td>: \t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t-->\r\n\t\t</table>\r\n\t\t </td></tr>";
}
$bodycetak .= "\r\n\t \r\n\t\t</thead>\r\n\t\t</table>\r\n\t\t<!-- <tr>\r\n\t\t<td colspan=2 style= border:none;>\r\n\t\t\r\n\t\t-->\r\n\t\t";
if ( $jeniskelas != "" )
{
    $qfield .= " AND mahasiswa.JENISKELAS='{$jeniskelas}'";
    $qjudul .= " Jenis Kelas '".$arraykelasstei["{$jeniskelas}"]."' <br>";
    $qinput .= " <input type=hidden name=jeniskelas value='{$jeniskelas}'>";
    $href .= "jeniskelas={$jeniskelas}&";
}
$q = "\r\n\t\t\t\tSELECT mahasiswa.NAMA,mahasiswa.ID \r\n\t\t\t\tFROM mahasiswa,pengambilanmk\r\n\t\t\t\tWHERE \r\n\t\t\t\tmahasiswa.ID=pengambilanmk.IDMAHASISWA\r\n\t\t\t\tAND pengambilanmk.IDMAKUL='{$idmakulupdate}'\r\n\t\t\t\tAND pengambilanmk.TAHUN='{$tahunupdate}'\r\n\t\t\t\tAND pengambilanmk.SEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND pengambilanmk.KELAS='{$kelasupdate}'\r\n\t\t\t\t\r\n\t\t\t\tand mahasiswa.IDPRODI='{$dx['IDPRODI']}'\r\n\t\t\t\t{$qfield}\r\n\t\t\t\tORDER BY mahasiswa.ID\r\n\t\t\t";
#echo $q;
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    if ( $aksi != "cetak" )
    {
		#echo "kkk";exit();
        $colorbox = "jQuery('a.lihatjadwal.colorbox();";
        $bodycetak .= "\r\n\t\t\t\t\t\t<table class=form>\r\n\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t<form target=_blank action='cetakabsenujian.php' method=post>\r\n\t\t \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'><script>\r\n            jQuery(document).ready(function () {\r\n                jQuery('a.settingpdf').colorbox();\r\n            });\r\n        </script>\r\n\r\n             ".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" ).createinputhidden( "idprodiupdate", "{$dx['IDPRODI']}", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" ).createinputhidden( "jenis", "{$jenis}", "" ).createinputhidden( "datakuliah", "{$datakuliah}", "" ).createinputhidden( "kopsurat", "{$kopsurat}", "" )."\r\n\t\t\t\t{$qinput}\r\n\t\t\t\t\t</form>\r\n\t\t\t\t\t\t</td></tr></table>";
    }
	#echo "lll";exit();
    $bodycetak .= "\r\n        <div>\r\n        <table {$border} class=data{$cetak} width=100% cellpadding=0 cellspacing=0>";
    $bodycetakhead = "\r\n\t\t\t\t \r\n\t\t\t\t\t <tr class=juduldata{$cetak} align=center>";
    if ( $UNIVERSITAS == "STIKES SAMARINDA" )
    {
        $bodycetakhead .= "\r\n\t\t\t\t\t\t<td {$rowspan}  align=center width=25><b>NO</td>\r\n\t\t\t\t\t\t<td {$rowspan} align=center  width=350><b>NAMA MAHASISWA</td> \r\n\t\t\t\t\t\t<td {$rowspan} align=center width=100><b>NIM</td>\r\n\t\t\t\t\t\t";
    }
    else
    {
        $bodycetakhead .= "\r\n\t\t\t\t\t\t<td {$rowspan}  align=center  width=25><b>NO</td>\r\n\t\t\t\t\t\t<td {$rowspan} align=center   width=100><b>NIM</td>\r\n\t\t\t\t\t\t<td {$rowspan} align=center   width=350><b>Nama</td> \r\n\t\t\t\t\t\t";
    }
    if ( $jenis == "UTS" )
    {
		#echo "iii";exit();
        $bodycetakhead .= "<td align=center><b>Nilai </td>\r\n              <td align=center><b>Tanda Tangan </td>";
    }
    else
    {
		#echo "mmm";exit();
        if ( $jenis == "UAS" )
        {
            if ( $UNIVERSITAS == "UNILAK" )
            {
                $bodycetakhead .= "\r\n                <td align=center><b>Tanda Tangan </td>\r\n                <td align=center><b>KEHADIRAN<br>\r\n                </td>\r\n                <td align=center><b>QUIS<br>5%</td>\r\n                <td align=center><b>TUGAS<br>25%</td>\r\n                <td align=center><b>UTS<br>30%</td>\r\n                <td align=center><b>UAS<br>40%</td>\r\n                <td align=center><b>RATA2<br>100%</td>\r\n                <td align=center><b>NILAI AKHIR</td>\r\n                ";
            }
            else
            {
                $bodycetakhead .= "\r\n                <td align=center><b>Tanda Tangan </td>\r\n \r\n                <td align=center><b>QUIS </td>\r\n                <td align=center><b>TUGAS </td>\r\n                <td align=center><b>UTS </td>\r\n                <td align=center><b>UAS </td>\r\n                <td align=center><b>RATA2 </td>\r\n                <td align=center><b>NILAI AKHIR</td>\r\n                ";
            }
        }
        else
        {
            if ( $datakuliah + 0 <= 0 )
            {
                $datakuliah = 16;
            }
            if ( $UNIVERSITAS == "STIKES SAMARINDA" )
            {
                $ii = 1;
                while ( $ii <= $datakuliah )
                {
                    $bodycetakhead .= "<td align=center width=30 align=center><b>{$ii}</td>";
                    ++$ii;
                }
            }
            $bodycetakhead .= " \r\n                  <td align=center colspan='{$datakuliah}'   align=center><b> PERTEMUAN KE </td>\r\n                  ";
        }
    }
    $bodycetakhead .= "\r\n            </tr>\r\n \t\t\t\t";
    if ( $jenis == "Kuliah" )
    {
		#echo "g";exit();
        $bodycetakhead .= "\r\n   \t\t\t\t\t <tr class=juduldata{$cetak} align=center>\r\n               \r\n              ";
        if ( $UNIVERSITAS == "STIKES SAMARINDA" )
        {
            $bodycetakhead .= " \r\n                  <td align=center colspan='{$datakuliah}'   align=center><b> TANGGAL PERTEMUAN </td>\r\n                  ";
        }
        else
        {
            $ii = 1;
            while ( $ii <= $datakuliah )
            {
                $bodycetakhead .= "<td align=center width=30 align=center><b>{$ii}</td>";
                ++$ii;
            }
        }
        $bodycetakhead .= "\r\n            </tr>\r\n           ";
        $bodycetakhead .= "\r\n \t\t\t\t\t <tr class=juduldata{$cetak} align=center>\r\n             ";
        $ii = 1;
        while ( $ii <= $datakuliah )
        {
            $bodycetakhead .= "<td align=center width=30 align=center>Hr: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>Tgl:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
            ++$ii;
        }
        $bodycetakhead .= "\r\n            </tr>\r\n          ";
    }
    $bodycetakhead .= "\r\n         \r\n        ";
    $bodycetak .= " {$bodycetakhead} <tbody>";
    $q = "SELECT * FROM aturan ";
	#echo $q;exit();
    $h2 = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h2 ) )
    {
        $d2 = sqlfetcharray( $h2 );
        $aturankeuangan = $d2[KRSONLINE];
    }
	#echo $aturankeuangan;exit();
    $stylestrike = "\r\n        style='  text-decoration:line-through; background: #DDDDDD; '\r\n        ";
    $i = 1;
    $totalbobot = 0;
    while ( $d = sqlfetcharray( $h ) )
    {
        if ( $UNIVERSITAS == "STIKES SAMARINDA" && ( $i % 11 == 0 && $i == 11 || is_int( ( $i - 1 - 10 ) / 15 ) && 16 < $i ) )
        {
            $bodycetak .= "\r\n\t\t\t\t\t       </tbody>\r\n\t\t\t\t\t       </table>\r\n\t\t\t\t\t       </div>\r\n\t\t\t\t\t        \r\n\t\t\t\t\t       <div style='page-break-before:always'>\r\n       \t\t\t\t\t  <table {$border} class=data{$cetak} width=100% cellpadding=0 cellspacing=0>\r\n      \t\t\t\t\t  \r\n                    {$bodycetakhead}\r\n                    <tbody>\r\n      \t\t\t\t\t \r\n             ";
        }
        $strikeit = "";
        $lunas = 0;
        if ( $aturankeuangan == 3 && ( $jenis == "UTS" || $jenis == "UAS" ) )
        {
			#echo "lain";exit();
            #$lunas = getstatusminimalpembayaransppmahasiswa( $d[ID], $tahunupdate, $semesterupdate, $jenis );
	    $lunas = getstatusminimalpembayaranmahasiswa( $d[ID], $tahunupdate, $semesterupdate, $jenis );	
            if ( $lunas[LUNAS] < 0 )
            {
                $strikeit = $stylestrike;
            }
        }
        $bodycetak .= "\r\n\t\t\t\t\t\t<tr {$kelas}{$cetak} {$heightrow} align=center  {$strikeit} \r\n            style='\r\n            border-collapse:collapse; border:1px solid black;\r\n            '>";
        if ( $UNIVERSITAS == "STIKES SAMARINDA" )
        {
            $bodycetak .= "\r\n\t\t\t\t\t\t\t<td  {$pakaiborder} align=center nowrap>{$i} </td>\r\n\t\t\t\t\t\t\t<td  {$pakaiborder} align=left nowrap>{$d['NAMA']}</td>\r\n\t\t\t\t\t\t\t<td  {$pakaiborder} align=left nowrap>{$d['ID']}</td> \r\n \t\t\t\t\t\t\t";
        }
        else
        {
            $bodycetak .= "\r\n\t\t\t\t\t\t\t<td  {$pakaiborder} align=center nowrap>{$i} </td>\r\n\t\t\t\t\t\t\t<td  {$pakaiborder} align=left nowrap>{$d['ID']}</td> \r\n\t\t\t\t\t\t\t<td  {$pakaiborder} align=left nowrap >{$d['NAMA']}</td>\r\n \t\t\t\t\t\t\t";
        }
        if ( $jenis == "UTS" )
        {
			#echo "kadieu";exit();
            $bodycetak .= "\r\n              <td {$pakaiborder}> </td>\r\n              <td {$pakaiborder}> </td>";
        }
        else if ( $jenis == "UAS" )
        {
            if ( $UNIVERSITAS == "UNILAK" )
            {
                $bodycetak .= "\r\n              <td {$pakaiborder}> </td>\r\n              <td {$pakaiborder}> </td>\r\n              <td {$pakaiborder} width=40> </td>\r\n              <td {$pakaiborder} width=40> </td>\r\n              <td {$pakaiborder} width=40> </td>\r\n              <td {$pakaiborder} width=40> </td>\r\n              <td {$pakaiborder} width=40> </td>\r\n              <td {$pakaiborder} nowrap align=center>A B C D E</td>\r\n              ";
                break;
            }
            else
            {
                #$bodycetak .= "\r\n              <td {$pakaiborder}> </td>\r\n              <td {$pakaiborder} width=40> </td>\r\n              <td {$pakaiborder} width=40> </td>\r\n              <td {$pakaiborder} width=40> </td>\r\n              <td {$pakaiborder} width=40> </td>\r\n              <td {$pakaiborder} width=40> </td>\r\n              <td {$pakaiborder} nowrap align=center>A B C D E</td>\r\n              ";
            	if($dx['TINGKAT']=="B" || $dx['TINGKAT']=="A"){
			$bodycetak .= "\r\n              <td {$pakaiborder}> </td>\r\n              <td {$pakaiborder} width=40> </td>\r\n              <td {$pakaiborder} width=40> </td>\r\n              <td {$pakaiborder} width=40> </td>\r\n              <td {$pakaiborder} width=40> </td>\r\n              <td {$pakaiborder} width=40> </td>\r\n              <td {$pakaiborder} nowrap align=center>A A- B+ B C+ C D E</td>\r\n              ";
		}else{
			$bodycetak .= "\r\n              <td {$pakaiborder}> </td>\r\n              <td {$pakaiborder} width=40> </td>\r\n              <td {$pakaiborder} width=40> </td>\r\n              <td {$pakaiborder} width=40> </td>\r\n              <td {$pakaiborder} width=40> </td>\r\n              <td {$pakaiborder} width=40> </td>\r\n              <td {$pakaiborder} nowrap align=center>A B C D E</td>\r\n              ";
		}
	    }
        }
        else
        {
			#echo "mana";exit();
            $ii = 1;
            while ( $ii <= $datakuliah )
            {
                $bodycetak .= "<td {$pakaiborder} align=center style=''>&nbsp;  </td>";
                ++$ii;
            }
        }
        $bodycetak .= "\r\n \t\t\t\t\t\t\t\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
        $totalbobotsemua += $nilaiekakhir;
        $totalbobot += $d[BOBOT];
        ++$i;
    }
	#echo "aaaa";exit();
    if ( $jenis == "Kuliah" && $aksi == "cetak" )
    {
        $bodycetak .= "\r\n\t\t\t\t\t\t<tr {$kelas}{$cetak} {$heightrow} align=center>\r\n\t\t\t\t\t\t\t \r\n\t\r\n\t\t\t\t\t\t\t<td  {$pakaiborder} colspan=2 align=center nowrap style='padding:15px 0;'>PARAF DOSEN</td>\r\n\t\t\t\t\t\t\t<td  {$pakaiborder} align=left nowrap> </td>\r\n  \t\t\t\t\t\t\t";
        $ii = 1;
        while ( $ii <= $datakuliah )
        {
            $bodycetak .= "<td {$pakaiborder} align=center >&nbsp; </td>";
            ++$ii;
        }
        $bodycetak .= "\r\n \t\t\t\t\t\t\t\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
    }
    $bodycetak .= "</tbody></table> \r\n\t\t\t\t</div>\r\n\t\t\t\t<br><br>\r\n        \r\n        ";
    if ( $aksi == "cetak" )
    {
        if ( $UNIVERSITAS == "STIKES SAMARINDA" && $jenis == "Kuliah" )
        {
            $bodycetak .= "\r\n          <table width=100%>\r\n          <tr>\r\n            <td class=loseborder valign=top style=font-size:10px;>\r\n          PERHATIAN :\t\t<br>\r\n1. Mahasiswa Dilarang Menambah Nama Pada Lembar Absen Yang Telah Disediakan\t\t<br>\r\n2. Mahasiswa Yang Tidak Mengumpulkan Kartu Rencana Studi Tidak Berhak Mengikuti Perkuliahan \t\t<br>\r\n3. Mahasiswa Yang Namanya Tidak Tercantum Dalam Lembar Absen Kehadirannya Dianggap Alpa \t\t<br>\r\n4. Kehadiran Kurang Dari 75% Mahasiswa Tidak Dapat Mengikuti Ujian Semester \t\t\r\n            </td>\r\n            <td class=loseborder valign=top>\r\n            Samarinda,  <br>\r\n                Ketua program Studi\r\n                <br><br><br> <br> \r\n                <u>{$namapimpinan}</u><br>\r\n                {$nippimpinan}\r\n            </td>\r\n            </tr>\r\n            </table>\r\n          \r\n          ";
        }
        else
        {
            if ( $UNIVERSITAS == "UNILAK" && $jenis == "Kuliah" )
            {
                $bodycetak .= "\r\n          <table width=100%>\r\n          <tr>\r\n            <td class=loseborder valign=top width=50% >\r\n              Pembantu Dekan I<br>\r\n                 <br><br><br> <br> \r\n                <u>{$dx['NAMAPD1']}</u><br>\r\n                NIP. {$dx['NIPPD1']}\r\n             </td>\r\n            <td class=loseborder valign=top>\r\n            Pekanbaru, {$w['mday']} ".$arraybulan[$w[mon] - 1]." {$w['year']} <br>\r\n                Dosen Pengampu\r\n                <br><br><br> <br> \r\n                <u>".getnamafromtabel( "{$dosenpengampu}", "dosen" )."</u><br>\r\n                NIP. {$dosenpengampu}\r\n            </td>\r\n            </tr>\r\n            </table>\r\n          \r\n          ";
            }
            else
            {
                if ( $UNIVERSITAS == "UNILAK" && ( $jenis == "UTS" || $jenis == "UAS" ) )
                {
                    $bodycetak .= "\r\n          <table width=100%>\r\n          <tr>\r\n            <td class=loseborder valign=top  width=50%>\r\n               Pengawas<br><br><br>\r\n               1. .............................<br><br><br> \r\n               2. .............................<br><br>\r\n                  \r\n             </td>\r\n            <td class=loseborder valign=top>\r\n            Pekanbaru, {$w['mday']} ".$arraybulan[$w[mon] - 1]." {$w['year']} <br>\r\n                Dosen Pengampu\r\n                <br><br><br> <br> \r\n                <u>".getnamafromtabel( "{$dosenpengampu}", "dosen" )."</u><br>\r\n                NIP. {$dosenpengampu}\r\n            </td>\r\n            </tr>\r\n            </table>\r\n          \r\n          ";
                }
                else
                {
                    $bodycetak .= "\r\n          <table width=100% border=0>\r\n            <tr valign=top align=left>\r\n                <td width=60% align=left style=border:none;>  ";
                    if ( $aturankeuangan == 3 && ( $jenis == "UTS" || $jenis == "UAS" ) )
                    {
                        #$bodycetak .= "\r\n                 Ket : mahasiswa yang belum menyelesaikan pembayaran namanya akan tercoret";
					#	$bodycetak .= "\r\n                 Ket : <br><br><br><br><br>Berdasarkan Penilaian Acuan Patokan (PAP)<br>Lebih Dari 7,6 : A<br>6,6 - 7,5 : B<br>5,6 - 6,5 : C<br>4,6 - 5,5 : D<br>Kurang Dari 4,5 : E";
						if($dx['FID']=="02" && $dx['TINGKAT']=="C"){
						
							$bodycetak .= "\r\n                 Ket : <br><br><br><br><br>Berdasarkan Penilaian Acuan Patokan (PAP)<br>Lebih Dari 85 - 100 : A<br>79 - 84 : B<br>69 - 78 : C<br>59 - 68 : D<br>0 - 48 : E";				
						
						}elseif($dx['TINGKAT']=="B" || $dx['TINGKAT']=="A"){
							$bodycetak .= "\r\n                 Ket : <br><br><br><br><br>Berdasarkan Penilaian Acuan Patokan (PAP)<br>90 - 100 : A<br>80 - 89 : A-<br>75 - 79 : B+<br>70 - 74 : B<br>65 - 69 : C+<br>60 - 64 : C<br>55 - 59 : D<br>< 54 : E";				
							
							#$bodycetak .= "\r\n                 Ket : <br><br><br><br><br>Berdasarkan Penilaian Acuan Patokan (PAP)<br>90 - 100 : A<br>80 - 89 : A-<br>75 - 79 : B+<br>70 - 74 : B<br>60 - 69 : B-";				
							#$bodycetak .= "\r\n                 Ket : <br><br><br><br><br>Berdasarkan Penilaian Acuan Patokan (PAP)<br>85 - 100 : A<br>75 - 84 : B<br>65 - 74 : C";				
						
						}elseif($dx['FID']=="03" && $dx['TINGKAT']=="C"){
						
							$bodycetak .= "\r\n                 Ket : <br><br><br><br><br>Berdasarkan Penilaian Acuan Patokan (PAP)<br>85 - 100 : A<br>75 - 84 : B<br>65 - 74 : C<br>55 - 64 : D<br><54 : E";				
						
						
						}else{
							$bodycetak .= "\r\n                 Ket : <br><br><br><br><br>Berdasarkan Penilaian Acuan Patokan (PAP)<br>Lebih Dari 80 - 100 : A<br>68 - 79 : B<br>56 - 67 : C<br>45 - 55 : D<br>0 - 44 : E";				
					
						}
		   }
                    $Pengawas = "Pengawas";
                    if ( $UNIVERSITAS == "UNIVERSITAS BATAM" )
                    {
                        $Pengawas = "Dosen";
                    }
                    $bodycetak .= "\r\n                  </td>\r\n \r\n                 <td style=border:none;>{$lokasikantor}, <br>\r\n                {$Pengawas}\r\n                <br><br><br><br> <br>\r\n                ....................................\r\n                 </td>\r\n              </tr>\r\n          </table>\r\n          ";
                }
            }
        }
    }
}
else
{
    $errmesg = "Data mahasiswa yang mengambil mata kuliah ini belum ada";
    printmesg( $errmesg );
}
if ( $pdf == 1 )
{
    cetakpdf( $bodycetak, $stylecetak );
}
else
{
    echo $stylecetak.$bodycetak;
}
?>
