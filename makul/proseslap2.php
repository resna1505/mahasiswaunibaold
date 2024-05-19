<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
unset( $arraysort );
$arraysort[0] = "mahasiswa.IDPRODI";
$arraysort[1] = "mahasiswa.ANGKATAN";
$arraysort[2] = "mahasiswa.ID";
$arraysort[3] = "mahasiswa.NAMA";
$arraysort[4] = "mahasiswa.STATUS";
$arraysort[5] = "mahasiswa.IDDOSEN";
$vld[] = cekvaliditasthnajaran( "Tahun Semester", $tahun, $semester );
$vld[] = cekvaliditaskodeprodi( "Program Studi", $idprodi );
$vld[] = cekvaliditastahun( "Angkatan", $angkatan );
$vld[] = cekvaliditasnim( "NIM", $id );
$vld[] = cekvaliditaskode( "Nama", $nama );
$vld[] = cekvaliditaskode( "Status", $status );
$vld = array_filter( $vld, "filter_not_empty" );
if ( isset( $vld ) && 0 < count( $vld ) )
{
    $errmesg = val_err_mesg( $vld, 2, CARI_DATA );
    $aksi = "";
}
else
{
    $href = "index.php?pilihan={$pilihan}&aksi=tampilkan&tahun={$tahun}&semester={$semester}&";
    if ( $idprodi != "" )
    {
        $qfield .= " AND IDPRODI='{$idprodi}'";
        $qjudul .= " Jurusan/Program Studi '".$arrayprodi[$idprodi]."' <br>";
        $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
        $href .= "idprodi={$idprodi}&";
    }
    if ( $iddosen != "" )
    {
        $qfield .= " AND IDDOSEN='{$iddosen}'";
        $qjudul .= " Dosen Wali '".$arraydosen[$iddosen]."' <br>";
        $qinput .= " <input type=hidden name=iddosen value='{$iddosen}'>";
        $href .= "iddosen={$iddosen}&";
    }
    if ( $angkatan != "" )
    {
        $qfield .= " AND ANGKATAN='{$angkatan}'";
        $qjudul .= " Angkatan '{$angkatan}' <br>";
        $qinput .= " <input type=hidden name=angkatan value='{$angkatan}'>";
        $href .= "angkatan={$angkatan}&";
    }
    if ( $id != "" )
    {
        $qfield .= " AND ID LIKE '%{$id}%'";
        $qjudul .= " NIM mengandung kata '{$id}' <br>";
        $qinput .= " <input type=hidden name=id value='{$id}'>";
        $href .= "id={$id}&";
    }
    if ( $jeniskelas != "" )
    {
        $qfield .= " AND mahasiswa.JENISKELAS='{$jeniskelas}'";
        $qjudul .= " Jenis Kelas '".$arraykelasstei["{$jeniskelas}"]."' <br>";
        $qinput .= " <input type=hidden name=jeniskelas value='{$jeniskelas}'>";
        $href .= "jeniskelas={$jeniskelas}&";
    }
    if ( $nama != "" )
    {
        $qfield .= " AND mahasiswa.NAMA LIKE '%{$nama}%'";
        $qjudul .= " Nama mengandung kata '{$nama}' <br>";
        $qinput .= " <input type=hidden name=nama value='{$nama}'>";
        $href .= "nama={$nama}&";
    }
    if ( $status != "" )
    {
        $qfield .= " AND STATUS='{$status}'";
        $qjudul .= " Status Mahasiswa '".$arraystatusmahasiswa["{$status}"]."' <br>";
        $qinput .= " <input type=hidden name=status value='{$status}'>";
        $href .= "status={$status}&";
    }
    $qinput .="<input type=hidden name=semester value='{$semester}'>";
	$qinput .="<input type=hidden name=tahun value='{$tahun}'>";
    if ( $arraysort[$sort] == "" )
    {
        $sort = 2;
    }
    $qinput .= " <input type=hidden name=sort value='{$sort}'>";
    $q = "SELECT  COUNT(DISTINCT mahasiswa.ID) AS JML\r\n   FROM mahasiswa  LEFT JOIN pengambilanmk ON mahasiswa.ID=pengambilanmk.IDMAHASISWA\r\n  AND pengambilanmk.TAHUN='{$tahun}' AND pengambilanmk.SEMESTER='{$semester}'\r\n  WHERE 1=1\r\n  {$qprodidep2}\r\n\t{$qfield}\r\n\t AND SKSMAKUL IS NULL\r\n   ";
    $h = doquery( $q, $koneksi );
    $d = sqlfetcharray( $h );
    $total = $d[JML];
    include( "../paginating.php" );
    $q = "SELECT  \r\n  mahasiswa.ID,mahasiswa.NAMA,IDPRODI,ANGKATAN,STATUS,IDDOSEN ,SUM(SKSMAKUL) AS JMLSKS\r\n  FROM mahasiswa  LEFT JOIN pengambilanmk ON mahasiswa.ID=pengambilanmk.IDMAHASISWA\r\n  AND pengambilanmk.TAHUN='{$tahun}' AND pengambilanmk.SEMESTER='{$semester}'\r\n  WHERE 1=1\r\n  {$qprodidep2}\r\n\t{$qfield}\r\n\t GROUP BY mahasiswa.ID HAVING (SUM(SKSMAKUL) IS NULL OR SUM(SKSMAKUL)<=0)\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
    $h = doquery( $q, $koneksi );
    if ( 0 < sqlnumrows( $h ) )
    {
		echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">";
								printmesg( "Semester/Tahun Akademik: ".$arraysemester[$semester]." ".( $tahun - 1 )."/{$tahun} <br>".$qjudul );
        if ( $aksi != "cetak" )
        {
            #printjudulmenu( "Data Mahasiswa yang Belum Mengambil KRS" );
            #printmesg( "Semester/Tahun Akademik: ".$arraysemester[$semester]." ".( $tahun - 1 )."/{$tahun} <br>".$qjudul );
			echo "						<div class=\"tools\">
										<form target=_blank action='cetaklap2.php' method=post>
											<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td>
														<input type=submit name=aksi2 class=\"btn btn-brand\" value='Cetak'>\r\n \t\t\t\t{$qinput}\r\n \t\t\t\t{$input}\r\n\t\t\t
													</td>
												</tr>
											</table>
										</form>
									</div>{$tpage} {$tpage2}";
        }
        #else
        #{
            #printjudulmenucetak( "Data Mahasiswa yang Belum Mengambil KRS" );
        #    printmesgcetak( "Semester/Tahun Akademik: ".$arraysemester[$semester]." ".( $tahun - 1 )."/{$tahun} <br>".$qjudul );
        #}
		if($status=='A'){
			#$tombolnonaktif="<input type=submit id=tom_non_aktif class=tombol value='Non Aktif'>";
		}
        #if ( $aksi != "cetak" )
        #{
            /*echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Data Mahasiswa yang Belum Mengambil KRS </span>
                            </div>
                            <div class=\"actions\">
                                <form target=_blank action='cetaklap2.php'>\r\n \t\t\t\t<input type=submit name=aksi2 class=\"btn green\" value='Cetak'>\r\n   {$tombolnonaktif}     <input type=hidden name=tahun value='{$tahun}'>\r\n        <input type=hidden name=semester value='{$semester}'>\r\n \t\t\t\t{$qinput} \t\t\t\t{$input}\r\n\t\t\t</form>
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
		echo "						<div class=\"caption\">";
												printmesg("Data Mahasiswa yang Belum Mengambil KRS");
		echo "						</div>
						<form target=_blank action='cetaklap3.php' method=post>
									<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>";

            #echo " \t{$tpage} {$tpage2}\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetaklap2.php'>\r\n \t\t\t\t<input type=submit name=aksi2 class=tombol value='Cetak'>\r\n   {$tombolnonaktif}     <input type=hidden name=tahun value='{$tahun}'>\r\n        <input type=hidden name=semester value='{$semester}'>\r\n \t\t\t\t{$qinput} \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
        #}
        #echo "\r\n \t\t\t<table class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t";
		echo "<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t";
		if ( $aksi != "cetak" )
        {
		#if($status=='A'){
			#echo '<td><input type=checkbox id=cekall></td>';
			echo "<td><input type='checkbox' name='chkall' id='chkall'></td>";
		#}
		}		echo "<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>Jurusan/Program Studi</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Angkatan</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>NIM</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Nama</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>Status</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Dosen Wali</td>\r\n\t\t\t\t \r\n        \r\n \t\t\t</tr>\r\n\t\t";
         echo "	
				</thead>
					<tbody>";
		$i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t";
			if ( $aksi != "cetak" )
			{
			#if($status=='A'){
				#echo "<td><input type=checkbox id=cek value={$d[ID]}></td>";
				echo "<td><input type='checkbox' class='chkbox' name='idmhs[]' value='".$d["ID"]."'></td>";
			#}
			}			echo "
			<td>{$i}&nbsp;</td>\r\n\t\t\t\t\t<td align=left nowrap>".$arrayprodidep[$d[IDPRODI]]."&nbsp;</td>\r\n \t\t\t\t\t<td align=center>{$d['ANGKATAN']}&nbsp;</td>\r\n \t\t\t\t\t<td align=left nowrap> {$d['ID']}&nbsp;</td>\r\n \t\t\t\t\t<td align=left nowrap>{$d['NAMA']}&nbsp;</td>\r\n \t\t\t\t\t<td align=left nowrap><div id=status_".$d['ID'].">".$arraystatusmahasiswa[$d[STATUS]]."&nbsp;</div></td>\r\n \t\t\t\t\t<td align=left nowrap>".$arraydosen[$d[IDDOSEN]]."&nbsp;</td>\r\n          \r\n  \t\t\t\t</tr>\r\n\t\t\t";
            ++$i;
        }
        #echo "</table></div></div>{$tpage} {$tpage2}</div></div></div>";
		echo "								</tbody>
								</table>
							</div>
						</div>
					</div>
					
				<!--end::Section-->";
					if ( $aksi != "cetak" )
					{
		echo "		<div class=\"tools\">						
						<div class=\"table-scrollable\">
							<table class=\"table table-striped table-bordered table-hover\">
								<tr>
									<td>
										<input type='submit' name='printbtn' class=\"btn btn-brand\" value='Pilih Cetak'>\r\n \t\t\t\t{$qinput}\r\n \t\t\t\t{$input}\r\n\t\t\t
									</td>
								</tr>
							</table>
						</div>
					</div>";
					}
		echo "	</form>
				</div>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->
			</div>
			</div>
			</div>
			</div>
			</div>";
        $aksi = "tampilkan";
		if($status=='A'){
			?>
			<script>
			$(document).ready(function(){
				
				$('#cekall').click(function(e){
					if($('#cekall').attr('checked')){
						$('input:checkbox').attr('checked',true);
					}else{
						$('input:checkbox').attr('checked',false);
					}
				});
				
				
				$('#tom_non_aktif').click(function(e){
							e.preventDefault();
							 if($('#cek:checked').length==0){
								 alert('pilih salah satu');
								 return false;
							 }else{
								 var ids;
								 var sel = $('#cek:checked').map(function(_, el) {
									 return $(el).val()
								 }).get();
								$.each(sel,function(key,value){
									 $.ajax({
										 type:"POST",
										 url:"nonaktifajax.php",
										 data:"id="+value,
										 success:function(data){
											if(data=='berhasil'){
												$('#status_'+value).html('Non Aktif');
											}else{
												//$('#status_'+value).html('Non Aktif');
											}
										 }
									});
								});
								/// console.log(sel);
							}
						});
				});
			</script>					
			<?php
		}
    }
    else
    {
        $errmesg = "Data Mahasiswa Tidak Ada";
        $aksi = "";
    }
}
?>
<script>
</script>