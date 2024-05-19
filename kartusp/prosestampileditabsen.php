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
$q = "SELECT makul.ID,makul.SKS,makul.SEMESTER,\r\n prodi.NAMA as NAMAP ,prodi.TINGKAT,prodi.ID AS IDPRODI,prodi.NIPPIMPINAN,prodi.NAMAPIMPINAN,\r\n  \r\n fakultas.NAMA as NAMAF, \r\n fakultas.NAMAPIMPINAN as DEKAN ,fakultas.NAMAPD1,fakultas.NIPPD1,\r\n departemen.NAMA AS NAMAJ\r\n FROM makul,prodi,departemen LEFT JOIN fakultas ON departemen.IDFAKULTAS=fakultas.ID\r\n\r\nWHERE 1=1 \r\nAND\r\nmakul.IDPRODI=prodi.ID\r\nAND\r\ndepartemen.ID=prodi.IDDEPARTEMEN\r\nAND makul.ID='{$idmakulupdate}'\r\n ";
$q = "SELECT tbkmksp.NAKMKTBKMK NAMA,makul.ID,\r\n      mspst.IDX AS IDPRODI,\r\n     tbkmksp.*,SKSMKTBKMK AS SKS ,     \r\n      SEMESTBKMK  +0 AS SEMESTER ,\r\n prodi.NAMA as NAMAP ,prodi.TINGKAT,prodi.ID AS IDPRODI,prodi.NIPPIMPINAN,prodi.NAMAPIMPINAN,\r\n  \r\n fakultas.NAMA as NAMAF, \r\n fakultas.NAMAPIMPINAN as DEKAN ,fakultas.NAMAPD1,fakultas.NIPPD1,\r\n departemen.NAMA AS NAMAJ\r\n      \r\n      FROM makul,mspst,tbkmksp, prodi,departemen LEFT JOIN fakultas ON departemen.IDFAKULTAS=fakultas.ID\r\n      \r\n\tWHERE \r\n  makul.ID=tbkmksp.KDKMKTBKMK AND\r\n \r\n  mspst.KDPSTMSPST=tbkmksp.KDPSTTBKMK AND\r\n  mspst.KDJENMSPST=tbkmksp.KDJENTBKMK AND\r\n  mspst.KDPTIMSPST=tbkmksp.KDPTITBKMK\r\n  AND makul.ID='{$idmakulupdate}'\r\nAND mspst.IDX=prodi.ID\r\nAND departemen.ID=prodi.IDDEPARTEMEN\r\nAND tbkmksp.THSMSTBKMK='".( $tahunupdate - 1 )."{$semesterupdate}'\r\nAND mspst.IDX='{$idprodiupdate}'\r\n  ";
$hx = mysqli_query($koneksi,$q);
$bodycetak .= mysqli_error($koneksi);
if ( 0 < sqlnumrows( $hx ) )
{
    $dx = sqlfetcharray( $hx );
    $namapimpinan = $dx[NAMAPIMPINAN];
    $nippimpinan = $dx[NIPPIMPINAN];
}
echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        ";
if ( $aksi != "cetak" )
{
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
    printmesg( "{$LABEL_ABSENSI} {$jenis2}" );
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
        $judulcetak .= "DAFTAR HADIR ABSENSI KULIAH";
    }
    $judulcetak .= "\r\n    <br><br>";
}
if ( $jenis == "Kuliah" )
{
    $rowspan = "rowspan=3";
}
if ( $UNIVERSITAS == "STIKES SAMARINDA" && $jenis == "Kuliah" && $aksi == "cetak" )
{
    $bodycetak .= "\r\n    <div align=center >\r\n    <table width=100%>\r\n    <tr>\r\n    <td  class=loseborder width=10%><img src='../kartu/logosamarinda.jpg'   height=100>\r\n    </td>\r\n    <td nowrap align=center  class=loseborder style='font-weight:bold;font-size:12pt;' width=80%> ABSENSI PERKULIAHAN<BR>\r\n    SEKOLAH TINGGI ILMU KESEHATAN MUHAMMADIYAH SAMARINDA<BR>\r\n    PROGRAM STUDI ".$arrayjenjang[$dx[TINGKAT]]." {$dx['NAMAP']}<BR>\r\n    TAHUN AKADEMIK ".( $tahunupdate - 1 )."/{$tahunupdate}\r\n    </td>\r\n\t<td class='loseborder' width=10%></tr></table>\r\n    </div>";
}
else
{
    $bodycetak .= "\r\n    <div align=center  style='font-weight:bold;font-size:20pt;'>{$judulcetak}</div>";
}
$bodycetak .= " \r\n\r\n    \r\n    <table width=100%>\r\n    <thead valign=bottom  style='display: table-header-group;'>";
if ( $UNIVERSITAS == "STIKES SAMARINDA" )
{
    include( "../kartu/headerabsenkuliahstikessamarinda.php" );
}
else if ( $UNIVERSITAS == "UNILAK" )
{
    include( "../kartu/headerabsenkuliahunilak.php" );
}
else
{
    /*echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
	
	echo "				<div class=\"m-portlet\">						
							<!--begin::Form-->
							<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=\"form\">
								<div class=\"m-portlet__body\">	";	
    /*$bodycetak .= "\r\n    <tr>\r\n    <td width=50% align=left valign=top class=loseborder>\r\n    <table  class=\"table table-striped table-bordered table-hover\" > \r\n    ";
    $bodycetak .= "\r\n     <tr  >\r\n\t\t\t<td class=judulform>{$LABEL_JURUSAN}</td>\r\n\t\t\t<td>: {$dx['NAMAP']}</td>\r\n\t\t</tr>\r\n     <tr  >\r\n\t\t\t<td class=judulform>Jenjang</td>\r\n\t\t\t<td>: ".$arrayjenjang[$dx[TINGKAT]]."</td>\r\n\t\t</tr>\r\n     <tr  >\r\n\t\t\t<td class=judulform>Kode Mata Kuliah</td>\r\n\t\t\t<td>: {$idmakulupdate}</td>\r\n\t\t</tr>\r\n     <tr  >\r\n\t\t\t<td class=judulform>Mata Kuliah</td>\r\n\t\t\t<td>: {$dx['NAMA']}</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>SMT/SKS/Kelas</td>\r\n\t\t\t<td>: {$dx['SEMESTER']}/{$dx['SKS']}/{$kelasupdate}</td>\r\n\t\t</tr>"."\r\n\t\t</table>\r\n\t\t</td><td width=50% align=left  class=loseborder>\r\n\t\t<table class=\"table table-striped table-bordered table-hover\" width=100%>\r\n\t\t      <tr class=judulform>\r\n\t\t\t<td  >Tahun Akademik</td>\r\n\t\t\t<td>: ".$arraysemester[$semesterupdate]."\t ".( $tahunupdate - 1 )."/{$tahunupdate}\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>";
    */
	$bodycetak .= "					<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">{$LABEL_JURUSAN}</label>\r\n    
										<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">: {$dx['NAMAP']} </label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Jenjang</label>\r\n    
										<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">: ".$arrayjenjang[$dx[TINGKAT]]."</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Kode Mata Kuliah</label>\r\n    
										<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">: {$idmakulupdate}</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Mata Kuliah</label>\r\n    
										<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">: {$dx['NAMA']}</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">SMT/SKS/Kelas</label>\r\n    
										<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">: {$dx['SEMESTER']}/{$dx['SKS']}/".$arraylabelkelas[$kelasupdate]."</label>
									</div>"."
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Tahun Akademik</label>\r\n    
										<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">: ".$arraysemester[$semesterupdate]."\t ".( $tahunupdate - 1 )."/{$tahunupdate}</label>
									</div>
								";
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
    #$bodycetak .= "<tr class=judulform>\r\n\t\t\t<td>Hari/Tanggal</td>\r\n\t\t\t<td>: \t\t{$hari}\t\r\n\t\t\t</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Jam</td>\r\n\t\t\t<td>: \t{$jam}\t\t\r\n\t\t\t</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Ruang</td>\r\n\t\t\t<td>: \t\t{$ruangan}\t\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t\r\n    <tr class=judulform>\r\n\t\t\t<td class=judulform nowrap>{$LABEL_DOSEN_PENGASUH}</td>\r\n\t\t\t<td>: <!-- {$iddosenupdate}, --> ".getnamafromtabel( $iddosenupdate, "dosen" )."</td>\r\n\t\t</tr>\r\n    <!--\r\n    <tr class=judulform>\r\n\t\t\t<td>Pengawas</td>\r\n\t\t\t<td>: \t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t-->\r\n\t\t</table>\r\n\t\t </td></tr>";
	$bodycetak .= "					<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Hari/Tanggal</label>\r\n    
										<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">:{$hari}</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Jam</label>\r\n    
										<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">:{$jam}</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Ruang</label>\r\n    
										<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">: \t\t{$ruangan}</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">{$LABEL_DOSEN_PENGASUH}</label>\r\n    
										<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">: <!-- {$iddosenupdate}, --> ".getnamafromtabel( $iddosenupdate, "dosen" )."</label>
									</div>
									<!--\r\n    <tr class=judulform>\r\n\t\t\t<td>Pengawas</td>\r\n\t\t\t<td>: \t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t-->
								</div>
							</form>
						</div>";
}
#$bodycetak .= "\r\n\t \r\n\t\t</thead>\r\n\t\t</table></div></div>\r\n\t\t<!-- <tr>\r\n\t\t<td colspan=2 style= border:none;>\r\n\t\t\r\n\t\t-->\r\n\t\t";
if ( $jeniskelas != "" )
{
    $qfield .= " AND mahasiswa.JENISKELAS='{$jeniskelas}'";
    $qjudul .= " Jenis Kelas '".$arraykelasstei["{$jeniskelas}"]."' <br>";
    $qinput .= " <input type=hidden name=jeniskelas value='{$jeniskelas}'>";
    $href .= "jeniskelas={$jeniskelas}&";
}
$q = "\r\n\t\t\t\tSELECT mahasiswa.NAMA,mahasiswa.ID \r\n\t\t\t\tFROM mahasiswa,pengambilanmksp\r\n\t\t\t\tWHERE \r\n\t\t\t\tmahasiswa.ID=pengambilanmksp.IDMAHASISWA\r\n\t\t\t\tAND pengambilanmksp.IDMAKUL='{$idmakulupdate}'\r\n\t\t\t\tAND pengambilanmksp.TAHUN='{$tahunupdate}'\r\n\t\t\t\tAND pengambilanmksp.SEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND pengambilanmksp.KELAS='{$kelasupdate}'\r\n\t\t\t\t\r\n\t\t\t\tand mahasiswa.IDPRODI='{$dx['IDPRODI']}'\r\n\t\t\t\t{$qfield}\r\n\t\t\t\tORDER BY mahasiswa.ID\r\n\t\t\t";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    if ( $aksi != "cetak" )
    {
        $colorbox = "jQuery('a.lihatjadwal.colorbox();";
        $bodycetak .= "\r\n\t\t\t\t\t\t<table class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t<form target=_blank action='cetakabsenujian.php' method=post>\r\n\t\t \t\t\t\t<input type=submit name=aksi class=\"btn btn-brand\" value='Cetak'><!--<input type=checkbox name=pdf value=1> PDF\r\n             <a class='settingpdf' href='../lib/settingpdf.php' >Setting</a> \r\n  \t\t\t\t\t\t\r\n  \t\t\t<script>\r\n            jQuery(document).ready(function () {\r\n                jQuery('a.settingpdf').colorbox();\r\n            });\r\n        </script>-->\r\n             \r\n             \r\n             ".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" ).createinputhidden( "idprodiupdate", "{$dx['IDPRODI']}", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" ).createinputhidden( "jenis", "{$jenis}", "" ).createinputhidden( "datakuliah", "{$datakuliah}", "" ).createinputhidden( "kopsurat", "{$kopsurat}", "" )."\r\n\t\t\t\t{$qinput}\r\n\t\t\t\t\t</form>\r\n\t\t\t\t\t\t</td></tr></table>";
    }
    /*$bodycetak .= "<br>\r\n        <table class=\"table table-striped table-bordered table-hover\">";
    $bodycetak .= "\r\n\t\t\t\t\t<thead  style='display: table-header-group;' >\r\n\t\t\t\t\t<tr class=juduldata{$cetak} align=center   >";
    */
	$bodycetak .="		<div class=\"m-portlet\">";			
	$bodycetakhead =	"	<div class=\"m-section__content\">
								<div class=\"table-responsive\">
									<table class=\"table table-bordered table-hover\">
									<thead>";
	if ( $UNIVERSITAS == "STIKES SAMARINDA" )
    {
        $bodycetakhead .= "\r\n\t\t\t\t\t\t<td {$rowspan}  align=center><b>NO</td>\r\n\t\t\t\t\t\t<td {$rowspan} align=center><b>NAMA MAHASISWA</td> \r\n\t\t\t\t\t\t<td {$rowspan} align=center><b>NIM</td>\r\n\t\t\t\t\t\t";
    }
    else
    {
        $bodycetakhead .= "\r\n\t\t\t\t\t\t<td {$rowspan}  align=center><b>NO</td>\r\n\t\t\t\t\t\t<td {$rowspan} align=center><b>NIM</td>\r\n\t\t\t\t\t\t<td {$rowspan} align=center><b>Nama</td> \r\n\t\t\t\t\t\t";
    }
    if ( $jenis == "UTS" )
    {
        $bodycetakhead .= "<td align=center><b>Nilai </td>\r\n              <td align=center><b>Tanda Tangan </td>";
    }
    else
    {
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
            $bodycetak .= " \r\n                  <td align=center colspan='{$datakuliah}'   align=center><b> KULIAH </td>\r\n                  ";
        }
    }
    $bodycetak .= "\r\n \r\n\t\t\t\t\t</tr>\r\n\t\t\t\t";
    if ( $jenis == "Kuliah" )
    {
        $bodycetak .= "\r\n            <tr  class=juduldata{$cetak}  >\r\n               ";
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
        $bodycetakhead .= "\r\n            </tr>\r\n          ";
        $bodycetakhead .= "\r\n            <tr class=juduldata{$cetak}  >\r\n             ";
        $ii = 1;
        while ( $ii <= $datakuliah )
        {
            $bodycetakhead .= "<td align=center width=30 align=center>Hr: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>Tgl:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
            ++$ii;
        }
        $bodycetakhead .= "\r\n            </tr>\r\n          ";
    }
    #$bodycetak .= "</thead><tbody>";
	$bodycetakhead .= "</thead>";
    $bodycetak .= " {$bodycetakhead} <tbody>";
    $i = 1;
    $totalbobot = 0;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        $bodycetak .= "\r\n\t\t\t\t\t\t<tr {$kelas}{$cetak} {$heightrow} align=center>";
        if ( $UNIVERSITAS == "STIKES SAMARINDA" )
        {
            $bodycetak .= "\r\n\t\t\t\t\t\t\t<td  align=center nowrap>{$i}</td>\r\n\t\t\t\t\t\t\t<td  align=left nowrap>{$d['NAMA']}</td>\r\n\t\t\t\t\t\t\t<td  align=left nowrap>{$d['ID']}</td> \r\n \t\t\t\t\t\t\t";
        }
        else
        {
            $bodycetak .= "\r\n\t\t\t\t\t\t\t<td  align=center nowrap>{$i}</td>\r\n\t\t\t\t\t\t\t<td  align=left nowrap>{$d['ID']}</td> \r\n\t\t\t\t\t\t\t<td  align=left nowrap>{$d['NAMA']}</td>\r\n \t\t\t\t\t\t\t";
        }
        if ( $jenis == "UTS" )
        {
            $bodycetak .= "\r\n              <td> </td>\r\n              <td> </td>";
        }
        else if ( $jenis == "UAS" )
        {
            if ( $UNIVERSITAS == "UNILAK" )
            {
                $bodycetak .= "\r\n              <td> </td>\r\n              <td> </td>\r\n              <td width=40> </td>\r\n              <td width=40> </td>\r\n              <td width=40> </td>\r\n              <td width=40> </td>\r\n              <td width=40> </td>\r\n              <td nowrap align=center>A B C D E</td>\r\n              ";
                break;
            }
            else
            {
                $bodycetak .= "\r\n              <td> </td>\r\n              <td width=40> </td>\r\n              <td width=40> </td>\r\n              <td width=40> </td>\r\n              <td width=40> </td>\r\n              <td width=40> </td>\r\n              <td nowrap align=center>A B C D E</td>\r\n              ";
            }
        }
        else
        {
            $ii = 1;
            while ( $ii <= $datakuliah )
            {
                $bodycetak .= "<td align=center> </td>";
                ++$ii;
            }
        }
        $bodycetak .= "\r\n \t\t\t\t\t\t\t\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
        $totalbobotsemua += $nilaiekakhir;
        $totalbobot += $d[BOBOT];
        ++$i;
    }
    if ( $jenis == "Kuliah" && $aksi == "cetak" )
    {
        $bodycetak .= "\r\n\t\t\t\t\t\t<tr {$kelas}{$cetak} {$heightrow} align=center>\r\n\t\t\t\t\t\t\t \r\n\t\r\n\t\t\t\t\t\t\t<td  colspan=2 align=center nowrap style='padding:15px 0;'>PARAF DOSEN</td>\r\n\t\t\t\t\t\t\t<td  align=left nowrap> </td>\r\n  \t\t\t\t\t\t\t";
        $ii = 1;
        while ( $ii <= $datakuliah )
        {
            $bodycetak .= "<td align=center >&nbsp; </td>";
            ++$ii;
        }
        $bodycetak .= "\r\n \t\t\t\t\t\t\t\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
    }
    #$bodycetak .= "</tbody></table></div>\r\n\t\t\t\t<br><br>\r\n        \r\n        ";
	$bodycetak .= "		</tbody>
								</table>
							</div>
						</div>
					</div>
					<!--end::Section-->
				</div>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->";
    if ( $aksi == "cetak" )
    {
        if ( $UNIVERSITAS == "STIKES SAMARINDA" && $jenis == "Kuliah" )
        {
            $bodycetak .= "\r\n          <table class=\"table table-striped table-bordered table-hover\" width=100%>\r\n          <tr>\r\n            <td class=loseborder valign=top>\r\n          PERHATIAN :\t\t<br>\r\n1. Mahasiswa Dilarang Menambah Nama Pada Lembar Absen Yang Telah Disediakan\t\t<br>\r\n2. Mahasiswa Yang Tidak Mengumpulkan Kartu Rencana Studi Tidak Berhak Mengikuti Perkuliahan \t\t<br>\r\n3. Mahasiswa Yang Namanya Tidak Tercantum Dalam Lembar Absen Kehadirannya Dianggap Alpa \t\t<br>\r\n4. Kehadiran Kurang Dari 75% Mahasiswa Tidak Dapat Mengikuti Ujian Semester \t\t\r\n            </td>\r\n            <td class=loseborder valign=top>\r\n            Samarinda,  <br>\r\n                Ketua program Studi\r\n                <br><br><br> <br> \r\n                <u>{$namapimpinan}</u><br>\r\n                {$nippimpinan}\r\n            </td>\r\n            </tr>\r\n            </table>\r\n          \r\n          ";
        }
        else if ( $UNIVERSITAS == "UNILAK" && $jenis == "Kuliah" )
        {
            $bodycetak .= "\r\n          <table class=\"table table-striped table-bordered table-hover\" width=100%>\r\n          <tr>\r\n            <td class=loseborder valign=top  >\r\n              Pembantu Dekan I<br>\r\n                 <br><br><br> <br> \r\n                 <u>{$dx['NAMAPD1']}</u><br>\r\n                NIP. {$dx['NIPPD1']}\r\n             </td>\r\n            <td class=loseborder valign=top>\r\n            Pekanbaru, {$w['mday']} ".$arraybulan[$w[mon] - 1]." {$w['year']} <br>\r\n                Dosen Pengampu\r\n                <br><br><br> <br> \r\n                <u>".getnamafromtabel( "{$dosenpengampu}", "dosen" )."</u><br>\r\n                NIP. {$dosenpengampu}\r\n            </td>\r\n            </tr>\r\n            </table></div>\r\n          \r\n          ";
        }
        else if ( $UNIVERSITAS == "UNILAK" && ( $jenis == "UTS" || $jenis == "UAS" ) )
        {
            $bodycetak .= "\r\n          <table class=\"table table-striped table-bordered table-hover\" width=100%>\r\n          <tr>\r\n            <td class=loseborder valign=top  width=50%>\r\n               Pengawas<br><br><br>\r\n               1. .............................<br><br><br> \r\n               2. .............................<br><br>\r\n                  \r\n             </td>\r\n            <td class=loseborder valign=top>\r\n            Pekanbaru, {$w['mday']} ".$arraybulan[$w[mon] - 1]." {$w['year']} <br>\r\n                Dosen Pengampu\r\n                <br><br><br> <br> \r\n                <u>".getnamafromtabel( "{$dosenpengampu}", "dosen" )."</u><br>\r\n                NIP. {$dosenpengampu}\r\n            </td>\r\n            </tr>\r\n            </table>\r\n          \r\n          ";
        }
        else
        {
            $bodycetak .= "\r\n          <table class=\"table table-striped table-bordered table-hover\">\r\n            <tr valign=top align=left>\r\n                <td width=60% align=left style=border:none;>  \r\n                 &nbsp;\r\n                  </td>\r\n \r\n                 <td style=border:none;>{$lokasikantor}, <br>\r\n                Pengawas\r\n                <br><br><br><br> <br>\r\n                ....................................\r\n                 </td>\r\n              </tr>\r\n          </table>\r\n     </div></div></div></div></div>     ";
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
