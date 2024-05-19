<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$idprodi = getfield( "IDDEPARTEMEN", "dosen", " WHERE ID='{$idupdate}'" );
$namamakul = getfield( "NAMA", "dosen", " WHERE ID='{$idupdate}'" );
/*echo "\r\n<br>\r\n  <div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">\r\n     <tr class=judulform>\r\n\t\t\t<td width=150>Jurusan/Program Studi</td>\r\n\t\t\t<td>".$arrayprodidep[$idprodi]."\r\n      </td>\r\n\t\t</tr> \r\n    <tr>\r\n      <td>NIDN Dosen</td>\r\n      <td><b>{$idupdate}</td>\r\n    </tr>\r\n    <tr>\r\n      <td>Nama Dosen</td>\r\n      <td><b>".$namamakul."</td>\r\n    </tr>\r\n    </table></div></div>\r\n";
*/
echo "		<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=\"form\" action=\"index.php\" method=\"post\">
					<div class=\"m-portlet__body\">	";
		echo "			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$arrayprodidep[$idprodi]."</label>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">NIDN Dosen</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">{$idupdate}</label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Nama Dosen</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$namamakul."</label>
						</div>";
if ( $aksi2 == "hapus" )
{
    $q = "\r\n     \r\n     DELETE FROM trlsd2\r\n              \r\n     WHERE\r\n     NODOSTRLSD='{$idupdate}'\r\n     AND THSMSTRLSD='{$tahunsemester}'\r\n     ";
    doquery($koneksi,$q);
    if ( 0 < sqlaffectedrows( $koneksi ) )
    {
        $errmesg = "Data Dosen Keluar berhasil dihapus";
    }
    else
    {
        $errmesg = "Data Dosen Keluar tidak dihapus";
    }
    $aksi2 = "";
}
if ( $aksi2 == "Tambah" )
{
    $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$idprodi}'";
    $h = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $kodept = $d[KDPTIMSPST];
        $kodejenjang = $d[KDJENMSPST];
        $kodeps = $d[KDPSTMSPST];
    }
    $q = "\r\n        INSERT INTO trlsd2\r\n        (\r\n      THSMSTRLSD, KDPTITRLSD,KDPSTTRLSD,KDJENTRLSD,NODOSTRLSD,STDOSTRLSD\r\n         )\r\n        VALUES\r\n        ('{$tahun2}{$semester2}','{$kodept}','{$kodeps}','{$kodejenjang}','{$idupdate}',\r\n        '{$status}' )\r\n      ";
    doquery($koneksi,$q);
    if ( 0 < sqlaffectedrows( $koneksi ) )
    {
        $q = "UPDATE dosen\r\n             SET STATUSKERJA ='{$status}' \r\n            WHERE ID='{$idupdate}' \r\n            ";
        doquery($koneksi,$q);
        $q = "UPDATE msdos SET STDOSMSDOS ='{$status}'\r\n            WHERE NODOSMSDOS='{$idupdate}' \r\n            ";
        doquery($koneksi,$q);
        $errmesg = "Data Dosen Keluar berhasil disimpan";
    }
    else
    {
        $errmesg = "Data Dosen Keluar tidak disimpan";
    }
    $aksi2 = "formtambah";
}
if ( $aksi2 == "Simpan" )
{
    $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$idprodi}'";
    $h = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $kodept = $d[KDPTIMSPST];
        $kodejenjang = $d[KDJENMSPST];
        $kodeps = $d[KDPSTMSPST];
    }
    $q = "\r\n      UPDATE trlsd2\r\n      SET\r\n      THSMSTRLSD='{$tahun2}{$semester2}',\r\n      KDPTITRLSD ='{$kodept}',KDPSTTRLSD ='{$kodeps}',KDJENTRLSD='{$kodejenjang}',\r\n       STDOSTRLSD='{$status}' \r\n      WHERE NODOSTRLSD = '{$idupdate}' AND \r\n      THSMSTRLSD='{$tahunsemester}'\r\n     ";
    doquery($koneksi,$q);
    if ( 0 < sqlaffectedrows( $koneksi ) )
    {
        $tahunsemester = "{$tahun2}{$semester2}";
        $errmesg = "Data Dosen Keluar berhasil disimpan";
    }
    else
    {
        $errmesg = "Data Dosen Keluar tidak disimpan";
    }
    $aksi2 = "formupdate";
}
echo "\r\n<br>\r\n<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">\r\n  <tr >\r\n  <td width=50% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=formtambah&idupdate={$idupdate}'> Tambah Data</td>\r\n  <td width=50% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=tampilkan&idupdate={$idupdate}'> Edit Data</td>\r\n  </tr>\r\n</table></div></div>\r\n";
printmesg( $errmesg );
if ( $aksi2 == "formupdate" )
{
    /*echo "\r\n  <br>\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tahunsemester", "{$tahunsemester}", "" )."\r\n \r\n  ";
    */
	echo createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tahunsemester", "{$tahunsemester}", "" )."\r\n \r\n  ";
	include( "formlulus2.php" );
    #echo "\r\n \t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit name=aksi2 value='Simpan' class=\"btn btn-brand\">\r\n\t\t\t\t\t<input type=reset value='Reset' class=\"btn btn-secondary\">\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  </table>\r\n</div></div>  </form>\r\n  ";
	echo "					<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
								<div class=\"col-lg-6\">
										<input type=\"submit\" class=\"btn btn-brand\" name=aksi2 value=Simpan></input>
										<input type=\"reset\" class=\"btn btn-secondary\" value=Reset></input>  
								</div>
							</div>
					</div>						
				</form>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->			
		";
}
if ( $aksi2 == "formtambah" )
{
    /*echo "\r\n  <br>\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" )."\r\n     \r\n  ";
    */
	echo createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" )."\r\n     \r\n  ";
	include( "formlulus2.php" );
    #echo "\r\n \t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit name=aksi2 value='Tambah' class=\"btn btn-brand\">\r\n\t\t\t\t\t<input type=reset value='Reset' class=\"btn btn-secondary\">\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  </table>\r\n </div></div> </form>\r\n  ";
	echo "					<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
								<div class=\"col-lg-6\">
										<input type=\"submit\" class=\"btn btn-brand\" name=aksi2 value=Tambah></input>
										<input type=\"reset\" class=\"btn btn-secondary\" value=Reset></input>  
								</div>
							</div>
					</div>						
				</form>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->			
		";
	
}
if ( $aksi2 == "" || $aksi2 == "tampilkan" )
{
    $q = "SELECT * FROM trlsd2 WHERE NODOSTRLSD='{$idupdate}' ORDER BY THSMSTRLSD DESC";
    $h = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
       /* echo "\r\n    <br>\r\n      <div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">{$cetak}>\r\n        <tr class=juduldata{$cetak} align=center>\r\n          <td>No.</td>\r\n          <td>Tahun / Semester Lapor</td>\r\n          <td>Status Aktivitas</td>\r\n  \r\n            <td colspan=2>Aksi</td>\r\n        </tr>";
        */
		echo "<div class=\"m-portlet\">			
				<div class=\"m-section__content\">
					<div class=\"table-responsive\">
						<table class=\"table table-bordered table-hover\">
							<thead>
								 <tr class=juduldata{$cetak} align=center>\r\n          <td>No.</td>\r\n          <td>Tahun / Semester Lapor</td>\r\n          <td>Status Aktivitas</td>\r\n  \r\n            <td colspan=2>Aksi</td>\r\n        </tr>";
		echo "				</thead>
							<tbody>";
		
		$i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            $tmp = $d[THSMSTRLSD];
            $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
            $semester = $tmp[4];
            echo "\r\n            <tr valign=top align=center {$kelas}{$cetak}>\r\n          <td>{$i}</td>\r\n          <td nowrap align=left>{$tahun} ".$arraysemester[$semester]." </td>\r\n          <td>".$arraystatuskerjadosen[$d[STDOSTRLSD]]."</td>\r\n             \r\n          <td><a href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&idupdate={$idupdate}&tahunsemester={$d['THSMSTRLSD']}&aksi2=formupdate'>Update</td>              \r\n          <td><a onClick='return confirm(\"Hapus Data pelaporan Dosen Keluar?\")' href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&idupdate={$idupdate}&tahunsemester={$d['THSMSTRLSD']}&aksi2=hapus'>Hapus</td>              \r\n          </tr>\r\n          ";
            ++$i;
        }
        #echo "\r\n      </table>\r\n  </div></div>  ";
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
    }else{
		echo "<p>";	
		printmesg( "Data  Dosen Keluar tidak ada" );
		echo "</p>";	
    }
	echo "\r\n   \r\n  ";
}
?>
