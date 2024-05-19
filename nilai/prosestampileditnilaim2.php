<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $jenisusers == 1 && $aturaneditnilaidosen == 1 )
{
    $tanggalselesai = waktueditnilai( $tahunupdate, $semesterupdate, $idprodiupdate );
    $trtanggal = "\r\n          <tr>\r\n            <td><b>Batas Akhir Entri Nilai</td>\r\n            <td><b>: {$tanggalselesai}</td>\r\n          </tr>\r\n        ";
}
$q = "\r\n\t\t\t\tSELECT IDKONVERSI,SIMBOL,NILAI,SYARAT FROM konversiumum\r\n\t\t\t\tORDER BY NILAI DESC\r\n\t\t\t";
$hb = mysqli_query($koneksi,$q);
unset( $arraybobotnilai );
if(sqlnumrows( $hb )>0){
	while ($db = sqlfetcharray($hb))
	{
		$arraybobotnilai["{$db['SIMBOL']}"] = "{$db['NILAI']}";
	}
}
$q = "\r\n\t\t\t\tSELECT NLAKHTBBNL AS SIMBOL,BOBOTTBBNL AS NILAI,SYARAT \r\n        FROM tbbnl,mspst\r\n\t\t\t\tWHERE\r\n\t\t\t\ttbbnl.KDPTITBBNL=mspst.KDPTIMSPST AND\r\n\t\t\t\ttbbnl.KDJENTBBNL=mspst.KDJENMSPST AND\r\n\t\t\t\ttbbnl.KDPSTTBBNL=mspst.KDPSTMSPST AND\r\n\t\t\t\t\r\n\t\t\t\tTHSMSTBBNL='".( $tahunupdate - 1 )."{$semesterupdate}' AND\r\n \t\t\t\tIDX='{$idprodiupdate}'\r\n         ORDER BY BOBOTTBBNL DESC\r\n\t\t\t";
$h = mysqli_query($koneksi,$q);
echo mysqli_error($koneksi);
unset( $arraybobotnilai );
#while ( !( 0 < sqlnumrows( $h ) ) || !( $d = sqlfetcharray( $h ) ) )
if(sqlnumrows( $h )>0)
{
	while( $d = sqlfetcharray( $h ) ){
		$arraybobotnilai["{$d['SIMBOL']}"] = "{$d['NILAI']}";
	}
}
$q = "\r\n\t\t\t\tSELECT SIMBOL,NILAI,SYARAT FROM konversi\r\n\t\t\t\tWHERE \r\n\t\t\t\tIDMAKUL='{$idmakulupdate}'\r\n\t\t\t\tAND TAHUN='{$tahunupdate}'\r\n\t\t\t\tAND SEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND KELAS='{$kelasupdate}'\r\n\t\t\t\tORDER BY NILAI DESC\r\n\t\t\t\t";
$h = mysqli_query($koneksi,$q);
unset( $arraybobotnilai );
if(0 < sqlnumrows( $h ))
#while ( !( 0 < sqlnumrows( $h ) ) || !( $d = sqlfetcharray( $h ) ) )
{
	while( $d = sqlfetcharray( $h ) ){
		$arraybobotnilai["{$d['SIMBOL']}"] = "{$d['NILAI']}";
	}
}
if ( is_array( $arraybobotnilai ) )
{
    echo "\r\n          <script>\r\n            function setbobot(nilai,bobot) { ";
    foreach ( $arraybobotnilai as $k => $v )
    {
        echo "\r\n                if (nilai.value=='{$k}') {\r\n                  bobot.value='{$v}';\r\n                } else\r\n                ";
    }
    echo "\r\n               {\r\n               }\r\n            }\r\n          </script>\r\n          \r\n          ";
}
if ( $aksi != "cetak" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
}
if ( $jenisusers == 1 )
{
    $iddosen = $users;
}
$konversisemua = 0;
@$konf = @file( "konfig" );
if ( is_array( $konf ) )
{
    if ( trim( $konf[0] ) == "0" )
    {
        $konversisemua = 0;
    }
    else
    {
        $konversisemua = 1;
    }
}
if ( $aksi != "cetak" )
{
    printmesg( "Edit Data Nilai (Manual)" );
    printmesg( $errmesg );
}
/*else
{
    printjudulmenucetak( "Data Nilai" );
    printmesgcetak( $errmesg );
}*/
#echo "<table  class=form>"."\r\n     {$trtanggal}\r\n     <tr>\r\n\t\t\t<td class=judulform>Prodi</td>\r\n\t\t\t<td>:  ".$arrayprodidep[$idprodiupdate]."</td>\r\n\t\t</tr>\r\n     <tr  >\r\n\t\t\t<td class=judulform>Mata Kuliah</td>\r\n\t\t\t<td>: {$idmakulupdate}, ".getnamamk( "{$idmakulupdate}", "".( $tahunupdate - 1 )."{$semesterupdate}", $idprodiupdate )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Tahun Akademik</td>\r\n\t\t\t<td>: ".( $tahunupdate - 1 )."/{$tahunupdate}\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Semester</td>\r\n\t\t\t<td>: ".$arraysemester[$semesterupdate]."\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td class=judulform>Dosen Pengajar</td>\r\n\t\t\t<td>: {$iddosenupdate}, ".getnamafromtabel( $iddosenupdate, "dosen" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Kode Kelas</td>\r\n\t\t\t<td>: ".$arraylabelkelas[$kelasupdate]."</td>\r\n\t\t</tr>"."\r\n\t\t</table>\r\n\t\t\r\n\t\t";
#printjudulmenukecil( "Rincian Data Nilai Mahasiswa" );
echo "	<div class='portlet-body form'>
			<div class=\"table-scrollable\">
				<table class=\"table table-striped table-bordered table-hover\">
					{$trtanggal}\r\n     <tr>\r\n\t\t\t<td class=judulform>Prodi</td>\r\n\t\t\t<td>:  ".$arrayprodidep[$idprodiupdate]."</td>\r\n\t\t</tr>\r\n     <tr  >\r\n\t\t\t<td class=judulform>Mata Kuliah</td>\r\n\t\t\t<td>: {$idmakulupdate}, ".getnamamk( "{$idmakulupdate}", "".( $tahunupdate - 1 )."{$semesterupdate}", $idprodiupdate )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Tahun Akademik</td>\r\n\t\t\t<td>: ".( $tahunupdate - 1 )."/{$tahunupdate}\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Semester</td>\r\n\t\t\t<td>: ".$arraysemester[$semesterupdate]."\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td class=judulform>Dosen Pengajar</td>\r\n\t\t\t<td>: {$iddosenupdate}, ".getnamafromtabel( $iddosenupdate, "dosen" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Kode Kelas</td>\r\n\t\t\t<td>: ".$arraylabelkelas[$kelasupdate]."</td>\r\n\t\t</tr>".
				"</table>
			</div>
			<div class=\"caption\">
				<div class=\"alert alert-success\"> Rincian Data Nilai Mahasiswa</div>
			</div>";
$q = "\r\n\t\t\t\tSELECT mahasiswa.NAMA,mahasiswa.ID ,pengambilanmk.NILAI,pengambilanmk.SIMBOL,pengambilanmk.BOBOT\r\n\t\t\t\tFROM mahasiswa,pengambilanmk \r\n\t\t\t\tWHERE \r\n\t\t\t\tmahasiswa.ID=pengambilanmk.IDMAHASISWA\r\n\t\t\t\tAND pengambilanmk.IDMAKUL='{$idmakulupdate}'\r\n\t\t\t\tAND pengambilanmk.TAHUN='{$tahunupdate}'\r\n\t\t\t\tAND pengambilanmk.SEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND pengambilanmk.KELAS='{$kelasupdate}'\r\n \t\t\t\t{$qprodidep5}\r\n \r\n\t\t\t\tORDER BY mahasiswa.ID\r\n\t\t\t";
#echo $q;
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    if ( $aksi != "cetak" )
    {
        echo "		<div class=\"tools\">
						<form target=_blank action='cetaktampilnilaim.php'>
							".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" ).createinputhidden( "idprodiupdate", "{$idprodiupdate}", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" )."
								<div class=\"table-scrollable\">
									<table class=\"table table-striped table-bordered table-hover\">
										<tr>
											<td>
												<input type=submit name=aksi class=\"btn btn-brand\" value='Cetak'>
												<!--<input type=checkbox name=pdf value=1> PDF\r\n             
													<a class='settingpdf' href='../lib/settingpdf.php' >Setting</a> \r\n  \t\t\t\t\t\t\r\n  \t\t\t<script>\r\n            jQuery(document).ready(function () {\r\n                jQuery('a.settingpdf').colorbox();\r\n            });\r\n        </script>\r\n    -->         
													
											</td>
										</tr>
									</table>
								</div>
						</form>
					</div>";
    }
    #echo "<table {$border} class=form{$cetak}>";
    echo "						<div class=\"m-portlet\">			
									<div class=\"m-section__content\">
										<div class=\"table-responsive\">
											<table class=\"table table-bordered table-hover\">
												<thead>";
	echo "											<tr class=juduldata{$cetak} align=center>
														<td>No</td>\r\n\t\t\t\t\t\t<td>NIM</td>\r\n\t\t\t\t\t\t<td>Nama</td><td>Nilai Akhir</td><td>Simbol</td><td>Bobot</td>
													</tr>";
    echo "										</thead>
												<tbody>";
	$i = 1;
    $totalbobot = 0;
    while ( $d = sqlfetcharray( $h ) )
    {
        if ( session_is_registered_sikad( "prodis" ) && $_SESSION[prodis] != "" )
        {
            $q = "SELECT COUNT(tbkmk.KDPSTTBKMK) AS JML \r\n             FROM tbkmk,msmhs WHERE\r\n \t\t\t\t       tbkmk.KDKMKTBKMK='{$idmakulupdate}'\r\n\t\t\t\t      AND tbkmk.THSMSTBKMK=concat('".( $tahunupdate - 1 )."','{$semesterupdate}')\r\n \t\t\t\t      AND msmhs.NIMHSMSMHS='{$d['ID']}'\r\n\t\t\t\t      AND msmhs.KDPSTMSMHS=tbkmk.KDPSTTBKMK\r\n\t\t\t\t      AND msmhs.KDJENMSMHS=tbkmk.KDJENTBKMK\t\t\t\t  \r\n              {$qprodideptbkmk}\r\n            ";
            $hxx = mysqli_query($koneksi,$q);
            $dxx = sqlfetcharray( $hxx );
            if ( $dxx[JML] <= 0 )
            {
                continue;
            }
        }
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t\t\t<tr {$kelas}{$cetak}  align=center>\r\n\t\t\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\r\n\t\t\t\t\t\t\t<td  align=left nowrap>{$d['ID']}</td>\r\n\t\t\t\t\t\t\t<td  align=left nowrap>{$d['NAMA']}</td>";
        $nilaiakhir = $d[NILAI];
        
	$totalnilaiakhir += $nilaiakhir;
	$simbolakhir = $d[SIMBOL];
        $nilaiekakhir = $d[BOBOT];
        echo "\r\n\t\t\t\t\t\t\t<td>   ".number_format_sikad( $nilaiakhir, 2, ".", "," )."</td><td>{$simbolakhir} </td><td>".number_format_sikad( $nilaiekakhir, 2, ".", "," )."</td></tr>";
        $totalbobotsemua += $nilaiekakhir;
        $totalbobot += $d[BOBOT];
        ++$i;
    }
    echo " \r\n\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t\t\t\t\t\t<td colspan=3 align=right>Total</td>";
    echo "\r\n\t\t\t\t\t\t\t\t<td>".number_format_sikad( $totalnilaiakhir, 2, ".", "," )."</td>\r\n\t\t\t\t\t\t\t\t<td>".number_format_sikad( $totalbobotsemua, 2, ".", "," )."</td>\r\n\t\t\t\t\t\t\t\t<td></td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t\t\t\t\t\t<td colspan=3 align=right>Rata-rata</td>";
    echo "\r\n\t\t\t\t\t\t\t\t<td>".number_format_sikad( $totalnilaiakhir / ( $i - 1 ), 2, ".", "," )."</td>\r\n\t\t\t\t\t\t\t\t<td>".number_format_sikad( $totalbobotsemua / ( $i - 1 ), 2, ".", "," )."</td>\r\n\t\t\t\t\t\t\t\t<td colspan=2> </td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t";
    #echo "</table>\r\n\t\t\t\t<br><br>";
	echo "		       			</tbody>
								</table>
							</div>
						</div>
					</div>
				</form>
			</div>";
}
else
{
    $errmesg = "Data mahasiswa yang mengambil mata kuliah ini belum ada";
    printmesg( $errmesg );
}
?>
