<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$stylecetak = "\r\n<style type=\"text/css\">\r\n\r\n.form td{\r\n\tborder:none;\r\n\tpadding:2px 5px;\r\n\t}\r\n@media print {\r\n   thead {display: table-header-group;}\r\n}\r\n</style>\r\n";
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
echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        ";
if ( $aksi != "cetak" )
{
    printmesg( "BERITA ACARA" );
    printmesg( $errmesg );
}
else
{
    $tmpkop = "";
    if ( $kopsurat == 1 )
    {
        include( "../nilai/proseskop.php" );
    }
    $bodycetak .= $tmpcetakawal = "<div style='page-break-after:always'>\r\n        ".$tmpkop;
}
if ( $jeniskelas != "" )
{
    $qfield .= " AND mahasiswa.JENISKELAS='{$jeniskelas}'";
    $qjudul .= " Jenis Kelas '".$arraykelasstei["{$jeniskelas}"]."' <br>";
    $qinput .= " <input type=hidden name=jeniskelas value='{$jeniskelas}'>";
    $href .= "jeniskelas={$jeniskelas}&";
}
$q = "\r\n\t\t\t\tSELECT COUNT(mahasiswa.ID) AS JML \r\n\t\t\t\tFROM mahasiswa,pengambilanmk\r\n\t\t\t\tWHERE \r\n\t\t\t\tmahasiswa.ID=pengambilanmk.IDMAHASISWA\r\n\t\t\t\tAND pengambilanmk.IDMAKUL='{$idmakulupdate}'\r\n\t\t\t\tAND pengambilanmk.TAHUN='{$tahunupdate}'\r\n\t\t\t\tAND pengambilanmk.SEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND pengambilanmk.KELAS='{$kelasupdate}'\r\n\t\t\t\t\r\n\t\t\t\tand mahasiswa.IDPRODI='{$dx['IDPRODI']}'\r\n\t\t\t\t{$qfield}\r\n\t\t\t\tORDER BY mahasiswa.ID\r\n\t\t\t";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
	echo "				<div class=\"m-portlet\">						
							<!--begin::Form-->";
    $d = sqlfetcharray( $h );
    if ( $aksi != "cetak" )
    {
        $colorbox = "jQuery('a.lihatjadwal.colorbox();";
        #$bodycetak .= "\r\n\t\t\t\t\t\t<table class=form>\r\n\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t<form target=_blank action='cetakberitaacara.php' method=post>\r\n\t\t \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n             <input type=checkbox name=pdf value=1> PDF\r\n             <a class='settingpdf' href='../lib/settingpdf.php' >Setting</a> \r\n  \t\t\t\t\t\t\r\n  \t\t\t<script>\r\n            jQuery(document).ready(function () {\r\n                jQuery('a.settingpdf').colorbox();\r\n            });\r\n        </script>\r\n\r\n             ".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" ).createinputhidden( "idprodiupdate", "{$dx['IDPRODI']}", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" ).createinputhidden( "jenis", "{$jenis}", "" ).createinputhidden( "datakuliah", "{$datakuliah}", "" ).createinputhidden( "kopsurat", "{$kopsurat}", "" )."\r\n\t\t\t\t{$qinput}\r\n\t\t\t\t\t</form>\r\n\t\t\t\t\t\t</td></tr></table>";
		$bodycetak .= "\r\n\t\t\t\t\t\t<table class=form>\r\n\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t<form target=_blank action='cetakberitaacara.php' method=post>\r\n\t\t \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'><script>\r\n            jQuery(document).ready(function () {\r\n                jQuery('a.settingpdf').colorbox();\r\n            });\r\n        </script>\r\n\r\n             ".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" ).createinputhidden( "idprodiupdate", "{$dx['IDPRODI']}", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" ).createinputhidden( "jenis", "{$jenis}", "" ).createinputhidden( "datakuliah", "{$datakuliah}", "" ).createinputhidden( "kopsurat", "{$kopsurat}", "" )."\r\n\t\t\t\t{$qinput}\r\n\t\t\t\t\t</form>\r\n\t\t\t\t\t\t</td></tr></table>";
    
	}
    $bodycetak .= "\r\n    <div align=center  style='font-weight:bold;font-size:20pt;'>BERITA ACARA</div>";
    $bodycetak .= "\r\n\t\t<br><br>\t\t\r\n    <table width=100%  style='border:none;'>\r\n      <tr>\r\n        <td class=loseborder>\r\n        <p>\r\n        Kami Pengawas {$jenis} pada Program Studi {$dx['NAMAP']} / ".$arrayjenjang[$dx[TINGKAT]].", {$dx['NAMAF']} \r\n        </p>\r\n        <br> \r\n        <p>\r\n        <table style='border:none;'>\r\n          <tr>\r\n            <td class=loseborder>1. </td>\r\n            <td class=loseborder>Mata ujian</td>\r\n            <td class=loseborder>:</td>\r\n            <td class=loseborder>{$dx['NAMA']}</td>\r\n          </tr>\r\n          <tr>\r\n            <td class=loseborder>2. </td>\r\n            <td class=loseborder>Diselenggarakan Di</td>\r\n            <td class=loseborder>:</td>\r\n            <td class=loseborder>KAMPUS {$dx['NAMAF']}</td>\r\n          </tr>        \r\n          <tr>\r\n            <td class=loseborder>3. </td>\r\n            <td class=loseborder>Pada Hari, Tanggal</td>\r\n            <td class=loseborder>:</td>\r\n            <td class=loseborder>".$arrayhari[$w[wday]].", {$w['mday']} ".$arraybulan[$w[mon] - 1]." {$w['year']}</td>\r\n          </tr>               \r\n          <tr>\r\n            <td class=loseborder>4. </td>\r\n            <td class=loseborder>Waktu</td>\r\n            <td class=loseborder>:</td>\r\n            <td class=loseborder>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp; / {$dx['SKS']} SKS</td>\r\n          </tr>                \r\n          <tr>\r\n            <td class=loseborder>5. </td>\r\n            <td class=loseborder>Tahun Akademik</td>\r\n            <td class=loseborder>:</td>\r\n            <td class=loseborder>\t ".( $tahunupdate - 1 )."/{$tahunupdate}\t</td>\r\n          </tr>               \r\n          <tr>\r\n            <td class=loseborder>6. </td>\r\n            <td class=loseborder>Semester</td>\r\n            <td class=loseborder>:</td>\r\n            <td class=loseborder>".$arraysemester[$semesterupdate]."</td>\r\n          </tr>              \r\n          <tr>\r\n            <td class=loseborder>7. </td>\r\n            <td class=loseborder>Peserta</td>\r\n            <td class=loseborder>:</td>\r\n            <td class=loseborder> </td>\r\n          </tr>               \r\n          <tr>\r\n            <td class=loseborder> </td>\r\n            <td class=loseborder>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jumlah</td>\r\n            <td class=loseborder>:</td>\r\n            <td class=loseborder>{$d['JML']}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;orang</td>\r\n          </tr>               \r\n          <tr>\r\n            <td class=loseborder> </td>\r\n            <td class=loseborder>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hadir</td>\r\n            <td class=loseborder>:</td>\r\n            <td class=loseborder>...............orang</td>\r\n          </tr>               \r\n          <tr>\r\n            <td class=loseborder> </td>\r\n            <td class=loseborder>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tidak Hadir</td>\r\n            <td class=loseborder>:</td>\r\n            <td class=loseborder>...............orang </td>\r\n          </tr>               \r\n            </table>\r\n        </p>\r\n        <br> \r\n        <p>\r\n        Hal-hal yang perlu dilaporkan selama {$jenis} berlangsung :\r\n         <br> \r\n          1. ............................................................<br>\r\n          2. ............................................................<br>\r\n          3. ............................................................<br>\r\n        </ol>\r\n        </p>\r\n        <br> \r\n        <p>\r\n        Demikian Berita Acara ini kami buat dengan sebenarnya untuk diketahui dan dipergunakan sepenuhnya.\r\n        </p>\r\n\r\n \r\n       </table>\r\n <br> \r\n        \r\n        ";
    if ( $aksi == "cetak" )
    {
        $bodycetak .= "\r\n          <table width=100% border=0>\r\n            <tr valign=top align=left>\r\n                <td width=40% align=left style=border:none;  class=loseborder>  \r\n                 &nbsp;\r\n                  </td>\r\n \r\n                 <td nowrap style=border:none;>{$lokasikantor},  {$w['mday']} ".$arraybulan[$w[mon] - 1]." {$w['year']}<br>\r\n                PENGAWAS\r\n                <br><br> <br>\r\n                1. .................................... (...........................)<br><br>\r\n                2. .................................... (...........................)\r\n                 </td>\r\n              </tr>\r\n          </table>\r\n          ";
    }
	echo "				</div>
					</div>
				</div>
			</div>
		";
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
