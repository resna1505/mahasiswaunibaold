<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $aksi == "" )
{
	#include( "../libchart/libchart.php" );
    $q = "SELECT trakm.THSMSTRAKM,mahasiswa.ID,mahasiswa.NAMA,mahasiswa.IDDOSEN,mahasiswa.DOSENTA,mahasiswa.STATUS,mahasiswa.ANGKATAN,".
	"mahasiswa.IDPRODI,prodi.JENIS,trakm.NLIPKTRAKM,trakm.SKSTTTRAKM FROM mahasiswa JOIN prodi ON prodi.ID=mahasiswa.IDPRODI LEFT JOIN ".
	"trakm ON trakm.NIMHSTRAKM=mahasiswa.ID WHERE ".
	"mahasiswa.ID='$idupdate' ORDER BY trakm.THSMSTRAKM DESC LIMIT 1";
	#echo $q;
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        printmesg( $errmesg );
        $d = sqlfetcharray( $h );
        $tmp = explode( "-", $d['TANGGAL'] );
        $d['thn'] = $tmp[0];
        $d['tgl'] = $tmp[2];
        $d['bln'] = $tmp[1];
        $tmp = explode( "-", $d['TANGGALMASUK'] );
        $dtm['thn'] = $tmp[0];
        $dtm['tgl'] = $tmp[2];
        $dtm['bln'] = $tmp[1];
        $tmp = explode( "-", $d['TANGGALKELUAR'] );
        $dtk['thn'] = $tmp[0];
        $dtk['tgl'] = $tmp[2];
        $dtk['bln'] = $tmp[1];
        if ( file_exists( "../mahasiswa/foto/{$d['ID']}" ) )
        {
            $fotosaatini = "\r\n\t\t\t\r\n\t\t\t<img src='../mahasiswa/foto/{$d['ID']}' border=0 width=100><br>\r\n\t\t\t";
        }
        /*echo "<br>
			<form name=form><table class=form border='0'>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tab", "{$tab}", "" )."
			<tr class=judulform><td rowspan='8' width='15px'>{$fotosaatini}</td><td width=250>Nama Mahasiswa </td><td>{$d['NAMA']}</td></tr>
			<tr><td>NIM Mahasiswa</td><td>{$d['ID']}</td>\r\n\t\t</tr>
			<tr class=judulform>\r\n\t\t\t<td>Dosen Pembimbing </td>\r\n\t\t\t<td>".$arraydosendep[$d[DOSENTA]]."</td></tr>
			<tr class=judulform>\r\n\t\t\t<td>IPK </td>\r\n\t\t\t<td>".$d['NLIPKTRAKM']." <a onclick=\"window.open('../lib/listgrafik.php?diagram=1&idmahasiswa='+{$idupdate}, '_blank', 'width=700,height=500,scrollbars=yes')\" > [lihat grafik]</a></td></tr>
			<tr class=judulform>\r\n\t\t\t<td>Total SKS</td>\r\n\t\t\t<td>".$d['SKSTTTRAKM']."</td></tr>
			
			<tr class=judulform>\r\n\t\t\t<td>Status Kuliah</td>\r\n\t\t\t<td>".$arraystatusmahasiswa[$d[STATUS]]."</td></tr>
			<tr class=judulform>\r\n\t\t\t<td>Angkatan</td><td>".$d['ANGKATAN']."</td>\r\n\t\t</tr>
			<tr class=judulform>\r\n\t\t\t<td>Jurusan/Program Studi</td>\r\n\t\t\t<td>".$arrayprodidep[$d[IDPRODI]]."</td></tr>";*/
		
		echo "<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=\"form\" action=\"index.php\" method=\"post\">
					".createinputhidden( "pilihan", $pilihan, "" )
					.createinputhidden( "aksi", "update", "" )
					.createinputhidden( "idupdate", "{$idupdate}", "" )
					.createinputhidden( "tab", "{$tab}", "" )."
					<div class=\"m-portlet__body\">
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Foto</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">{$fotosaatini}</label>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Nama Mahasiswa </label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">{$d['NAMA']}</label>
						</div>";
			//ambil data buat grafik
			/*$q = "SELECT NLIPSTRAKM,THSMSTRAKM FROM trakm WHERE NIMHSTRAKM='{$idupdate}' ORDER BY THSMSTRAKM  ";
			echo $q.'<br>';
			$hg = doquery( $q, $koneksi );
			if ( 0 < sqlnumrows( $h ) )
			{
				delgambartemp();
				$xx1 = mt_rand();
				$q = "INSERT INTO gambartemp VALUES('gambardiagram/"."{$xx1}.png',NOW())";
				doquery( $q, $koneksi );
				$chart = new VerticalChart( );
				while ( $dg = sqlfetcharray( $hg ) )
				{
					$thnd = substr( $dg[THSMSTRAKM], 0, 4 );
					$semd = substr( $dg[THSMSTRAKM], 4, 1 );
					$semd = $arraysemester[$semd];
					$chart->addPoint( new Point( "{$semd} {$thnd}/".( $thnd + 1 )."", $dg[NLIPSTRAKM] ) );
				}
				$chart->setTitle( "Grafik IP Mahasiswa ({$idupdate}) per Semester" );
				$chart->render( "../nilai/gambardiagram/{$xx1}.png" );
				echo "<img  src='../nilai/gambardiagram/{$xx1}.png' style='border: 1px solid gray;'/>";
			}*/
			echo "	<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
						<label class=\"col-lg-2 col-form-label\">NIM Mahasiswa</label>\r\n    
						<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">{$d['ID']}</label>
					</div>
					<div class=\"form-group m-form__group row\">
						<label class=\"col-lg-2 col-form-label\">Dosen Pembimbing</label>\r\n    
						<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$arraydosendep[$d['DOSENTA']]."</label>
					</div>
					<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
						<label class=\"col-lg-2 col-form-label\">IPK</label>\r\n    
						<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$d['NLIPKTRAKM']."</label>
					</div>
					<div class=\"form-group m-form__group row\">
						<label class=\"col-lg-2 col-form-label\">Total SKS</label>\r\n    
						<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$d['SKSTTTRAKM']."</label>
					</div>
					<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
						<label class=\"col-lg-2 col-form-label\">Status Kuliah</label>\r\n    
						<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$arraystatusmahasiswa[$d['STATUS']]."</label>
					</div>
					<div class=\"form-group m-form__group row\">
						<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
						<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$d['ANGKATAN']."</label>
					</div>
					<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
						<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
						<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$arrayprodidep[$d['IDPRODI']]."</label>
					</div>";	
		include( "aktivitasakademik.php" );
        #echo "\r\n \r\n\t\t\t</table></form>\r\n \r\n \r\n\t\t";
		#include( "chartakademik.php" );
		echo "	</div>
				</form>
			</div>";
    }
}
?>
<!--begin::Page Resources -->
		<script src="../../assets/demo/default/custom/components/charts/morris-charts.js" type="text/javascript"></script>
		<!--end::Page Resources -->
