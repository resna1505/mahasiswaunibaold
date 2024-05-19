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
/*echo "\r\n<br>\r\n  <div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">\r\n     <tr class=judulform>\r\n\t\t\t<td width=150>Jurusan/Program Studi</td>\r\n\t\t\t<td>".$arrayprodidep[$idprodi]."\r\n      </td>\r\n\t\t</tr> \r\n    <tr>\r\n      <td>NIM Mahasiswa</td>\r\n      <td><b>{$idupdate}</td>\r\n    </tr>\r\n    <tr>\r\n      <td>Nama Mahasiswa</td>\r\n      <td><b>".$namamakul."</td>\r\n    </tr>";
*/
echo "		<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=\"form\" action=\"index.php\" method=\"post\">
					<div class=\"m-portlet__body\">	";
		echo "			<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
							<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$arrayprodidep[$idprodi]."</label>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">NIM Mahasiswa</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>{$idupdate}</b></label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
							<label class=\"col-lg-2 col-form-label\">Nama Mahasiswa</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>".$namamakul."</b></label>
						</div>";
if ( $UNIVERSITAS == "STIKES SAMARINDA" )
{
    $ipkuap = getfield( "IPKUAP", "mahasiswa", " WHERE ID='{$idupdate}'" );
    echo "\r\n    <tr>\r\n      <td>Nilai Ujian Akhir Program</td>\r\n      <td><b>{$ipkuap} </td>\r\n    </tr>";
}
#echo "\r\n    </table>\r\n</div></div></div></div> </div>";
if ( $aksi2 == "hapus" )
{
    if ( $_GET['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Aktivitas Kuliah", HAPUS_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $q = "SELECT COUNT(trnlm.THSMSTRNLM) AS JML FROM  trnlm \r\n  WHERE NIMHSTRNLM='{$idupdate}' AND THSMSTRNLM='{$tahunsemester}'";
        $h = doquery($koneksi,$q);
        $d = sqlfetcharray( $h );
        if ( 1 )
        {
            $q = "\r\n     DELETE FROM trakm\r\n     WHERE\r\n     NIMHSTRAKM='{$idupdate}'\r\n     AND THSMSTRAKM='{$tahunsemester}'\r\n     ";
            doquery($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Data Aktifitas Kuliah Mahasiswa berhasil dihapus";
            }
            else
            {
                $errmesg = "Data Aktifitas Kuliah Mahasiswa tidak dihapus";
            }
        }
        else
        {
            $errmesg = "Data Aktifitas Kuliah Mahasiswa tidak dihapus. Data KRS masih ada...";
        }
    }
    $aksi2 = "";
}
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
printmesg( $errmesg );
if ( $aksi2 == "" || $aksi2 == "tampilkan" )
{
    $q = "SELECT trakm.*, COUNT(trnlm.THSMSTRNLM) AS JML\r\n   \r\n  \r\n  FROM trakm \r\n  LEFT JOIN trnlm \r\n  ON \r\n  trnlm.THSMSTRNLM=trakm.THSMSTRAKM AND\r\n  trnlm.NIMHSTRNLM=trakm.NIMHSTRAKM AND\r\n  trnlm.KDPTITRNLM=trakm.KDPTITRAKM AND\r\n  trnlm.KDJENTRNLM=trakm.KDJENTRAKM AND\r\n  trnlm.KDPSTTRNLM=trakm.KDPSTTRAKM  \r\n   \r\n  WHERE NIMHSTRAKM='{$idupdate}'\r\n  GROUP BY  trakm.THSMSTRAKM\r\n  ORDER BY THSMSTRAKM DESC\r\n  \r\n  ";
    $h = doquery($koneksi,$q);
    echo mysqli_error($koneksi);
    if ( 0 < sqlnumrows( $h ) )
    {
        /*echo "\r\n    <br>\r\n     <div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">\r\n        <tr class=juduldata{$cetak} align=center>\r\n          <td>No.</td>\r\n          <td>Tahun / Semester Lapor</td>\r\n          <td>IP Semester</td>\r\n          <td>SKS Semester</td>\r\n          <td>IP Kumulatif</td>\r\n          <td>SKS Total</td>\r\n          <td>Jumlah MK KRS</td>\r\n            <td colspan=2>Aksi</td>  \r\n        </tr>";
        */
/*echo "	<div class=\"m-portlet m-portlet--mobile\">
			<div class=\"m-portlet__head\">
				<div class=\"m-portlet__head-caption\">
					<div class=\"m-portlet__head-title\">
						<h3 class=\"m-portlet__head-text\">
							Data Aktivitas Kuliah Mahasiswa
						</h3>
					</div>					
				</div>
			</div>";
echo "		<div class=\"m-portlet__body\">
				<!--begin: Datatable -->
				<table class=\"table table-striped- table-bordered table-hover table-checkable\" id=\"m_table_3\">
					<thead>";*/
echo "<div class=\"m-portlet\">			
				<div class=\"m-section__content\">
					<div class=\"table-responsive\">
						<table class=\"table table-bordered table-hover table-striped2\">
							<thead>
								<tr>
									<th>No.</th>\r\n          <th>Tahun / Semester Lapor</th>\r\n          <th>IP Semester</th>\r\n          <th>SKS Semester</th>\r\n          <th>IP Kumulatif</th>\r\n          <th>SKS Total</th>\r\n          <th>Jumlah MK KRS</th>\r\n ";
							if ( $tingkataksesusers[$kodemenu] == "T" && $jenisusers == 0 )
            {
							echo "<th>Aksi</th>  ";
			}
			echo "			</tr> 
				</thead>
					<tbody>";
		$i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            $tmp = $d[THSMSTRAKM];
            $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
            $semester = $tmp[4];
            $styletd = "";
            if ( $d[JML] <= 0 )
            {
                $styletd = " style='background-color:#FFFF00;' ";
            }
            echo "\r\n            <tr {$styletd} valign=top align=center {$kelas}{$cetak}>\r\n          <td>{$i}</td>\r\n          <td nowrap align=left>{$tahun} ".$arraysemester[$semester]." </td>\r\n          <td>{$d['NLIPSTRAKM']}</td>\r\n          <td >{$d['SKSEMTRAKM']}</td>\r\n          <td>{$d['NLIPKTRAKM']}</td>\r\n          <td>{$d['SKSTTTRAKM']}</td>\r\n          <td>{$d['JML']}</td>\r\n             <!--\r\n          <td><a href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&idupdate={$idupdate}&tahunsemester={$d['THSMSTRAKM']}&aksi2=formupdate'>".IKONUPDATE."</td>              \r\n          -->";
            #if ( $d[JML] <= 0 )
			if ( $tingkataksesusers[$kodemenu] == "T" && $jenisusers == 0 )
            {
                echo "\r\n          <td><a onClick='return confirm(\"Hapus Data Aktifitas Kuliah Mahasiswa?\")' href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&idupdate={$idupdate}&tahunsemester={$d['THSMSTRAKM']}&aksi2=hapus&sessid={$_SESSION['token']}'><i class=\"fa fa-trash\"></td>\r\n          ";
            }
            echo "             \r\n          </tr>\r\n          ";
            ++$i;
        }
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
		echo "<p>";	
        printmesg( "Data  Aktifitas Kuliah Mahasiswa tidak ada" );
		echo "</p>";
    }
    echo "\r\n   \r\n  ";
}
?>
