<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$idprodi = getfield( "IDPRODI", "mahasiswa", " WHERE ID='{$idupdate}'" );
$namamakul = getfield( "NAMA", "mahasiswa", " WHERE ID='{$idupdate}'" );
/*echo "\r\n<br>\r\n <div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">\r\n     <tr class=judulform>\r\n\t\t\t<td width=150>Jurusan/Program Studi</td>\r\n\t\t\t<td>".$arrayprodidep[$idprodi]."\r\n      </td>\r\n\t\t</tr> \r\n    <tr>\r\n      <td>NIM Mahasiswa</td>\r\n      <td><b>{$idupdate}</td>\r\n    </tr>\r\n    <tr>\r\n      <td>Nama Mahasiswa</td>\r\n      <td><b>".$namamakul."</td>\r\n    </tr>\r\n    </table></div></div></div></div>\r\n";
*/
echo "		<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=\"form\" action=\"index.php\" method=\"post\">
					<div class=\"m-portlet__body\">	";
		echo "			<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
							<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
								".$arrayprodidep[$idprodi]."</label>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">NIM Mahasiswa</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>{$idupdate}</b></label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
							<label class=\"col-lg-2 col-form-label\">Nama Mahasiswa</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>".$namamakul."</b></label>
						</div>";
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
printmesg( $errmesg );
if ( $aksi2 == "" || $aksi2 == "tampilkan" )
{
    $q = "SELECT * FROM trnlm WHERE NIMHSTRNLM='{$idupdate}' AND KDPTITRNLM!='' ORDER BY THSMSTRNLM DESC, KDKMKTRNLM";
    $h = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        /*echo "\r\n    <br>\r\n      <div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\"{$cetak}>\r\n        <tr class=juduldata{$cetak} align=center>\r\n          <td>No.</td>\r\n          <td>Tahun / Semester Lapor</td>\r\n          <td>Kode Makul</td>\r\n          <td>Nama Makul</td>\r\n          <td>Nilai</td>\r\n          <td>Bobot</td>\r\n          <td>Kelas</td>\r\n          <!--           \r\n            <td colspan=2>Aksi</td>\r\n            -->\r\n        </tr>";
        */
		echo "<div class=\"m-portlet\">			
				<div class=\"m-section__content\">
					<div class=\"table-responsive\">
						<table class=\"table table-bordered table-hover table-striped2\">
							<thead>
								<tr class=juduldata{$cetak} align=center>\r\n          <td>No.</td>\r\n          <td>Tahun / Semester Lapor</td>\r\n          <td>Kode Makul</td>\r\n          <td>Nama Makul</td>\r\n          <td>Nilai</td>\r\n          <td>Bobot</td>\r\n          <td>Kelas</td>\r\n          <!--           \r\n            <td colspan=2>Aksi</td>\r\n            -->\r\n        </tr>";
		echo "				</thead>
							<tbody>";
		$i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            $tmp = $d[THSMSTRNLM];
            $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
            $semester = $tmp[4];
            echo "\r\n            <tr valign=top align=center {$kelas}{$cetak}>\r\n          <td>{$i}</td>\r\n          <td nowrap align=left>{$tahun} ".$arraysemester[$semester]." </td>\r\n          <td>{$d['KDKMKTRNLM']}</td>\r\n\r\n          <td align=left>".@getnamamk( @$d[KDKMKTRNLM], @$d[THSMSTRNLM], @$idprodi )."</td>\r\n          <td >{$d['NLAKHTRNLM']} </td>\r\n          <td>{$d['BOBOTTRNLM']}</td>\r\n          <td>{$d['KELASTRNLM']}</td>\r\n\r\n          <!--           \r\n          <td><a href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&idupdate={$idupdate}&tahunsemester={$d['THSMSTRNLM']}&makulupdate={$d['KDKMKTRNLM']}&aksi2=formupdate'>".IKONUPDATE."</td>              \r\n          <td><a onClick='return confirm(\"Hapus Data Nilai Semester Mahasiswa?\")' href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&idupdate={$idupdate}&tahunsemester={$d['THSMSTRNLM']}&makulupdate={$d['KDKMKTRNLM']}&aksi2=hapus&sessid={$_SESSION['token']}'>".IKONHAPUS."</td>              \r\n          -->\r\n          </tr>\r\n          ";
            ++$i;
        }
        #echo "\r\n      </table>\r\n </div></div>   ";
		echo "								</tbody>
								</table>
							</div>
						</div>
					</div>
					<!--end::Section-->
				</div>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->";
    }
    else
    {
        printmesg( "Data  Nilai Semester Mahasiswa tidak ada" );
    }
    echo "\r\n   \r\n  ";
}
?>
