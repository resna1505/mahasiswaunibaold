<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\r\n\r\n\ttd, p, table.form {\r\n\t\tfont-size:10px;\r\n\t\tfont-family:'trebuchet ms', arial;\r\n\t\tpadding-left:5px;\r\n\t\t}\r\n\t\t\r\n\t.noborder {\r\n\t\tborder-bottom:1px solid black;\r\n\t\tpadding-bottom:10px;\r\n\t\t}\t\r\n\t\t\r\n\t.noborder td{\r\n\t\tborder:none;\r\n\t\tpadding:2px;\r\n\t\t}\r\n\t\t\r\n\t.underline {\r\n\t\tfont-size:12px;\r\n\t\t}\r\n\t\t\r\n\t.borderh3 {\r\n\t\tfont-weight:bold;\r\n\t\tfont-size:16pt;\r\n\t\tpadding-bottom:10px; \r\n\t\tbor";
echo "der-bottom:1px solid black;\r\n\t\twidth:300px;\r\n\t\tmargin:auto;\r\n\t\t}\r\n\t\t\r\n\t.borderline {\r\n\t\tborder-top:1px solid black;\r\n\t\tborder-left:1px solid black;\r\n\t\t}\r\n\t\t\r\n\t.borderline td {\r\n\t\tborder-bottom:1px solid black;\r\n\t\tborder-right:1px solid black;\r\n\t\t}\r\n\r\n\t\t\r\n</style>\r\n";
periksaroot( );
$stylecetak = "\r\n<style type=\"text/css\">\r\n\r\n.form td{\r\n\tborder:none;\r\n\tpadding:2px 5px;\r\n\t}\r\n@media print {\r\n   thead {display: table-header-group;}\r\n}\r\n\r\n\r\n</style>\r\n";
$q = "SELECT makul.ID,makul.SKS,makul.SEMESTER,\r\n prodi.NAMA as NAMAP ,prodi.TINGKAT,prodi.ID AS IDPRODI,prodi.NIPPIMPINAN,prodi,NAMAPIMPINAN,\r\n  \r\n fakultas.NAMA as NAMAF, \r\n fakultas.NAMAPIMPINAN as DEKAN \r\n FROM makul,prodi,departemen LEFT JOIN fakultas ON departemen.IDFAKULTAS=fakultas.ID\r\n\r\nWHERE 1=1 \r\nAND\r\nmakul.IDPRODI=prodi.ID\r\nAND\r\ndepartemen.ID=prodi.IDDEPARTEMEN\r\nAND makul.ID='{$idmakulupdate}'\r\n ";
$q = "SELECT tbkmk.NAKMKTBKMK NAMA,makul.ID,\r\n      mspst.IDX AS IDPRODI,\r\n     tbkmk.*,SKSMKTBKMK AS SKS ,     \r\n      SEMESTBKMK  +0 AS SEMESTER ,\r\n prodi.NAMA as NAMAP ,prodi.TINGKAT,prodi.ID AS IDPRODI,prodi.NIPPIMPINAN,prodi.NAMAPIMPINAN,\r\n  \r\n fakultas.NAMA as NAMAF, \r\n fakultas.NAMAPIMPINAN as DEKAN ,fakultas.NAMAPD1,fakultas.NIPPD1,\r\n departemen.NAMA AS NAMAJ\r\n      \r\n      FROM makul,mspst,tbkmk, prodi,departemen LEFT JOIN fakultas ON departemen.IDFAKULTAS=fakultas.ID\r\n      \r\n\tWHERE \r\n  makul.ID=tbkmk.KDKMKTBKMK AND\r\n \r\n  mspst.KDPSTMSPST=tbkmk.KDPSTTBKMK AND\r\n  mspst.KDJENMSPST=tbkmk.KDJENTBKMK AND\r\n  mspst.KDPTIMSPST=tbkmk.KDPTITBKMK\r\n  AND makul.ID='{$idmakulupdate}'\r\nAND mspst.IDX=prodi.ID\r\nAND departemen.ID=prodi.IDDEPARTEMEN\r\nAND tbkmk.THSMSTBKMK='".( $tahunupdate - 1 )."{$semesterupdate}'\r\nAND mspst.IDX='{$idprodiupdate}'\r\n  ";
$hx = mysqli_query($koneksi,$q);
echo mysqli_error($koneksi);
if ( 0 < sqlnumrows( $hx ) )
{
    $dx = sqlfetcharray( $hx );
    $namapimpinan = $dx[NAMAPIMPINAN];
    $nippimpinan = $dx[NIPPIMPINAN];
    $dosenpengampu = $dx[NODOSTBKMK];
}
if ( $aksi != "cetak" )
{
    if ( $jenis == "UTS" )
    {
        $jenis2 = "UJIAN MID SEMESTER";
    }
    else if ( $jenis == "UAS" )
    {
        $jenis2 = " UJIAN AKHIR SEMESTER";
    }
    else
    {
        $jenis2 = " KULIAH";
    }
    printjudulmenu( "DAFTAR ABSENSI PESERTA {$jenis2}" );
    printmesg( $errmesg );
}
else
{
    $tmpkop = "";
    $bodycetak .= $tmpcetakawal = "<div style='page-break-after:always'>\r\n        ".$tmpkop;
    if ( $aksi == "cetak" )
    {
        $bodycetak .= "\r\n      <table style='line-height:1'   cellspacing=\"0\" cellpadding=\"0\">\r\n        <tr>\r\n          <td   >UNIVERSITAS BOROBUDUR</td>\r\n        </tr>\r\n        <tr>\r\n          <td   >Fakultas ".ucwords( strtolower( $dx[NAMAF] ) )."</td>\r\n        </tr>\r\n          <tr>\r\n          <td>Jln Raya kalimalang No. 1 Jakarta</td>\r\n        </tr>\r\n          <tr>\r\n          <td  ><hr style='color:#000000;'></td>\r\n        </tr>\r\n      </table>\r\n";
    }
    $judulcetak = " \r\n       ";
    if ( $jenis == "UTS" )
    {
        $judulcetak .= "DAFTAR ABSENSI PESERTA UJIAN MID SEMESTER";
    }
    else if ( $jenis == "UAS" )
    {
        $judulcetak .= "DAFTAR ABSENSI PESERTA UJIAN AKHIR SEMESTER";
    }
    $judulcetak .= "\r\n    <br><br>";
}
if ( $jenis == "Kuliah" )
{
    $rowspan = "rowspan=2";
}
if ( $jenis == "Kuliah" )
{
    $bodycetak .= "\r\n\r\n    \r\n    \r\n    <h3 align=center  style='font-weight:bold;font-size:16pt;'>\r\n    DAFTAR KEHADIRAN MAHASISWA<br>    \r\n    Semester ".$arraysemester[$semesterupdate]." <br>\r\n    Tahun Kuliah ".( $tahunupdate - 1 )."/{$tahunupdate}\t</h3>";
    $bodycetak .= " \r\n\r\n    \r\n    <table width=100%>\r\n    <thead valign=bottom  style='display: table-header-group;'> \r\n    <tr>\r\n    <td   align=left valign=top class=loseborder>\r\n\r\n    <table  class=form > \r\n       <tr  >\r\n\t\t\t<td class=judulform>Mata Kuliah</td>\r\n\t\t\t<td>: [ {$idmakulupdate} ] {$dx['NAMA']} </td>\r\n\t\t</tr>\r\n     <tr  >\r\n\t\t\t<td class=judulform>Jurusan </td>\r\n\t\t\t<td>: {$dx['NAMAP']} ".$arrayjenjang[$dx[TINGKAT]]."</td>\r\n\t\t</tr>\r\n\t\t</table>\r\n\t\t\r\n    </td>\r\n    <td   align=left valign=top class=loseborder>\r\n    \r\n    <table class=form>\r\n     <tr class=judulform>\r\n\t\t\t<td>Semester</td>\r\n\t\t\t<td>: ".$arrayromawi[$dx[SEMESTER]]." </td>\r\n\t\t</tr>   \r\n     <tr class=judulform>\r\n\t\t\t<td>SKS/Kelas</td>\r\n\t\t\t<td>: {$dx['SKS']} / ".$arraylabelkelas[$kelasupdate]." </td>\r\n\t\t</tr>   \r\n\t\t</table>\r\n\t\t\r\n    </td>\r\n    <td   align=left valign=top class=loseborder>\r\n    \r\n    <table class=form>\r\n \t\t\r\n    <tr class=judulform>\r\n\t\t\t<td class=judulform nowrap>Dosen Pengajar</td>\r\n\t\t\t<td>: <!-- {$iddosenupdate}, --> ".getnamafromtabel( $iddosenupdate, "dosen" )."</td>\r\n\t\t</tr>\r\n\r\n    <tr class=judulform>\r\n\t\t\t<td class=judulform nowrap>Tgl Awal dan Akhir Kuliah</td>\r\n\t\t\t<td>:  </td>\r\n\t\t</tr>\r\n\t\t</table>\r\n\t\t\r\n\t\t</td>\r\n </tr> \r\n\t \r\n\t\t</thead>\r\n\t\t</table>\r\n \r\n\t\t";
}
else
{
    $bodycetak .= "\r\n    <div align=center  style='font-weight:bold;font-size:14pt;text-decoration:underline;'>{$judulcetak}</div>";
    $bodycetak .= " \r\n\r\n    \r\n    <table width=90%>\r\n    <thead valign=bottom  style='display: table-header-group;'> \r\n    <tr>\r\n    <td   align=left valign=top class=loseborder>\r\n    <table  class=form style='margin:auto;'> \r\n\t\t  <tr class=judulform>\r\n\t\t\t<td>Th. Kuliah</td>\r\n\t\t\t<td>: ".$arraysemester[$semesterupdate]."\t ".( $tahunupdate - 1 )."/{$tahunupdate}\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>\r\n     <tr class=judulform>\r\n\t\t\t<td>Semester</td>\r\n\t\t\t<td>: ".$arrayromawi[$dx[SEMESTER]]." </td>\r\n\t\t</tr>   \r\n     <tr  >\r\n\t\t\t<td class=judulform>Jurusan </td>\r\n\t\t\t<td>: {$dx['NAMAP']} ".$arrayjenjang[$dx[TINGKAT]]."</td>\r\n\t\t</tr>\r\n      <tr  >\r\n\t\t\t<td class=judulform>Mata Kuliah</td>\r\n\t\t\t<td>: {$dx['NAMA']} ( {$idmakulupdate} )</td>\r\n\t\t</tr>\r\n    ";
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
    $bodycetak .= "<tr class=judulform>\r\n\t\t\t<td>Hari/Tanggal</td>\r\n\t\t\t<td>: \t\t{$hari}\t\r\n\t\t\t</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Ruang</td>\r\n\t\t\t<td>: \t\t{$ruangan}\t\r\n\t\t\t</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Waktu</td>\r\n\t\t\t<td>: \t{$jam}\t\t\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t\r\n    <tr class=judulform>\r\n\t\t\t<td class=judulform nowrap>Dosen</td>\r\n\t\t\t<td>: <!-- {$iddosenupdate}, --> ".getnamafromtabel( $iddosenupdate, "dosen" )."</td>\r\n\t\t</tr>\r\n\t\t</table>\r\n\t\t</td>\r\n </tr> \r\n\t \r\n\t\t</thead>\r\n\t\t</table>\r\n \r\n\t\t";
}
if ( $jeniskelas != "" )
{
    $qfield .= " AND mahasiswa.JENISKELAS='{$jeniskelas}'";
    $qjudul .= " Jenis Kelas '".$arraykelasstei["{$jeniskelas}"]."' <br>";
    $qinput .= " <input type=hidden name=jeniskelas value='{$jeniskelas}'>";
    $href .= "jeniskelas={$jeniskelas}&";
}
$q = "\r\n\t\t\t\tSELECT mahasiswa.NAMA,mahasiswa.ID \r\n\t\t\t\tFROM mahasiswa,pengambilanmk\r\n\t\t\t\tWHERE \r\n\t\t\t\tmahasiswa.ID=pengambilanmk.IDMAHASISWA\r\n\t\t\t\tAND pengambilanmk.IDMAKUL='{$idmakulupdate}'\r\n\t\t\t\tAND pengambilanmk.TAHUN='{$tahunupdate}'\r\n\t\t\t\tAND pengambilanmk.SEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND pengambilanmk.KELAS='{$kelasupdate}'\r\n\t\t\t\t\r\n\t\t\t\tand mahasiswa.IDPRODI='{$dx['IDPRODI']}'\r\n\t\t\t\t{$qfield}\r\n\t\t\t\tORDER BY mahasiswa.ID\r\n\t\t\t";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    if ( $aksi != "cetak" )
    {
        $colorbox = "jQuery('a.lihatjadwal.colorbox();";
        $bodycetak .= "\r\n\t\t\t\t\t\t<table class=form>\r\n\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t<form target=_blank action='cetakabsenujianborobudur.php' method=post>\r\n\t\t \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n             <input type=checkbox name=pdf value=1> PDF\r\n             <a class='settingpdf' href='../lib/settingpdf.php' >Setting</a> \r\n  \t\t\t\t\t\t\r\n  \t\t\t<script>\r\n            jQuery(document).ready(function () {\r\n                jQuery('a.settingpdf').colorbox();\r\n            });\r\n        </script>\r\n\r\n             ".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" ).createinputhidden( "idprodiupdate", "{$dx['IDPRODI']}", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" ).createinputhidden( "jenis", "{$jenis}", "" ).createinputhidden( "datakuliah", "{$datakuliah}", "" ).createinputhidden( "kopsurat", "{$kopsurat}", "" )."\r\n\t\t\t\t{$qinput}\r\n\t\t\t\t\t</form>\r\n\t\t\t\t\t\t</td></tr></table>";
    }
    $bodycetak .= "\r\n        <br>";
    if ( $jenis == "UAS" || $jenis == "UTS" )
    {
        $bodycetak .= "Kelas : ".$arraylabelkelas[$kelasupdate]."";
    }
    $bodycetak .= "\r\n        <table class=borderline width=100% cellpadding=0 cellspacing=0>";
    $bodycetak .= "\r\n\t\t\t\t\t<thead  style='display: table-header-group;' >\r\n\t\t\t\t\t <tr class=juduldata{$cetak} align=center> ";
    if ( $jenis == "UAS" || $jenis == "UTS" )
    {
        $bodycetak .= "\r\n    \t\t\t\t\t\t<td {$rowspan}  align=center><b>NO</td>\r\n    \t\t\t\t\t\t<td {$rowspan} align=center><b>POKOK</td>\r\n              ";
    }
    else
    {
        $bodycetak .= "\r\n    \t\t\t\t\t\t<td colspan=2 align=center><b>NOMOR</td>\r\n               ";
    }
    $bodycetak .= "\r\n\t\t\t\t\t\t<td {$rowspan} align=center><b>NAMA MAHASISWA</td> \r\n\t\t\t\t\t\t";
    if ( $jenis == "UTS" || $jenis == "UAS" )
    {
        $bodycetak .= "\r\n\r\n              <td align=center><b>Tanda Tangan </td>\r\n              <td align=center><b>Nilai </td>\r\n              <td align=center><b>Keterangan </td>\r\n              \r\n              ";
    }
    else
    {
        if ( $datakuliah + 0 <= 0 )
        {
            $datakuliah = 16;
        }
        $bodycetak .= " \r\n                  <td align=center colspan='{$datakuliah}'   align=center><b> Tanggal Pertemuan/Perkuliahan </td>\r\n                   <td align=center colspan='{$datakuliah}' {$rowspan}  align=center><b> Total Hadir</td>\r\n                 \r\n                  ";
    }
    $bodycetak .= "\r\n            </tr>\r\n \t\t\t\t";
    if ( $jenis == "Kuliah" )
    {
        $bodycetak .= "\r\n \t\t\t\t\t <tr class=juduldata{$cetak} align=center>\r\n \t\t\t\t\t     \t<td   align=center><b>URUT</td>\r\n    \t\t\t\t\t\t<td  align=center><b>POKOK</td>\r\n             ";
        $ii = 1;
        while ( $ii <= $datakuliah )
        {
            $bodycetak .= "<td align=center width=30 align=center>&nbsp; </td>";
            ++$ii;
        }
        $bodycetak .= "\r\n            </tr>\r\n          ";
    }
    $bodycetak .= "\r\n        </thead>\r\n        <tbody>";
    $q = "SELECT * FROM aturan ";
    $h2 = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h2 ) )
    {
        $d2 = sqlfetcharray( $h2 );
        $aturankeuangan = $d2[KRSONLINE];
    }
    $stylestrike = "\r\n        style='  text-decoration:line-through; background: #DDDDDD; '\r\n        ";
    $i = 1;
    $totalbobot = 0;
    while ( $d = sqlfetcharray( $h ) )
    {
        $strikeit = "";
        $lunas = 0;
        if ( $aturankeuangan == 3 && ( $jenis == "UTS" || $jenis == "UAS" ) )
        {
            $lunas = getstatusminimalpembayaranmahasiswa( $d[ID], $tahunupdate, $semesterupdate, $jenis );
            if ( $lunas[LUNAS] < 0 )
            {
                $strikeit = $stylestrike;
            }
        }
        $bodycetak .= "\r\n\t\t\t\t\t\t<tr {$kelas}{$cetak} {$heightrow} align=center  {$strikeit} >";
        $bodycetak .= "\r\n\t\t\t\t\t\t\t<td  align=center nowrap>{$i} &nbsp;</td>\r\n\t\t\t\t\t\t\t<td  align=left nowrap>{$d['ID']}&nbsp;</td> \r\n\t\t\t\t\t\t\t<td  align=left nowrap >{$d['NAMA']}&nbsp;</td>\r\n \t\t\t\t\t\t\t";
        if ( $jenis == "UTS" || $jenis == "UAS" )
        {
            if ( $i % 2 == 1 )
            {
                $bodycetak .= "\r\n                <td align=left>{$i}......... </td>\r\n                <td align=left>{$i}......... </td>";
            }
            else
            {
                $bodycetak .= "\r\n                <td  align=right>{$i}......... </td>\r\n                <td align=right>{$i}......... </td>";
            }
            $bodycetak .= "\r\n              <td>&nbsp; </td>\r\n              \r\n              ";
        }
        else
        {
            $ii = 1;
            while ( $ii <= $datakuliah )
            {
                $bodycetak .= "<td align=center >&nbsp; </td>";
                ++$ii;
            }
            $bodycetak .= "<td align=center > &nbsp; </td>";
        }
        $bodycetak .= "\r\n \t\t\t\t\t\t\t\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
        $totalbobotsemua += $nilaiekakhir;
        $totalbobot += $d[BOBOT];
        ++$i;
    }
    $labelpengawas = "Pengawas";
    if ( $jenis == "Kuliah" && $aksi == "cetak" )
    {
        $labelpengawas = "Dosen ybs";
        $bodycetak .= "\r\n\t\t\t\t\t\t<tr {$kelas}{$cetak} {$heightrow} align=center>\r\n\t\t\t\t\t\t\t \r\n\t\r\n\t\t\t\t\t\t\t<td  colspan=2 align=center nowrap style='padding:15px 0;'>PARAF DOSEN</td>\r\n\t\t\t\t\t\t\t<td  align=left nowrap>&nbsp; </td>\r\n  \t\t\t\t\t\t\t";
        $ii = 1;
        while ( $ii <= $datakuliah )
        {
            $bodycetak .= "<td align=center >&nbsp; </td>";
            ++$ii;
        }
        $bodycetak .= "\r\n \t\t\t\t\t\t\t<td  align=left nowrap>&nbsp;</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
    }
    $bodycetak .= "</tbody></table> \r\n\t\t\t\t<br><br>\r\n        \r\n        ";
    if ( $aksi == "cetak" )
    {
        $bodycetak .= "\r\n          <table width=100% border=0>\r\n            <tr valign=top align=left>\r\n                <td width=60% align=left style=border:none;>    \r\n                  </td>\r\n \r\n                 <td style=border:none;>{$lokasikantor}, <br>\r\n                {$labelpengawas}\r\n                <br><br><br><br> <br>\r\n                ....................................\r\n                 </td>\r\n              </tr>\r\n          </table>\r\n          ";
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
