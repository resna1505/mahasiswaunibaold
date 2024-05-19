<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$q = "show columns from trlsd where field='ASPTITRLSD'";
$h = doquery($koneksi,$q);
if ( sqlnumrows( $h ) <= 0 )
{
    $q = "DROP TABLE `trlsd`";
    doquery($koneksi,$q);
    $q = "CREATE TABLE `trlsd` (\r\n    NODOSTRLSD CHAR( 10 ) NOT NULL ,\r\n    ASPTITRLSD CHAR( 6 ) NOT NULL ,\r\n    JENJATRLSD CHAR( 1 ) NOT NULL ,\r\n    SMAWLTRLSD CHAR( 5 ) NOT NULL ,\r\n    BIDILTRLSD CHAR( 40 ) NOT NULL ,\r\n    BISTUTRLSD CHAR( 1 ) NOT NULL ,\r\n    PRIMARY KEY ( NODOSTRLSD, ASPTITRLSD, JENJATRLSD )\r\n    )";
    doquery($koneksi,$q);
}
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
    if ( $_GET['sessid'] == $_SESSION['token'] )
    {
        $q = "\r\n\t\tDELETE FROM trlsd      \r\n\t\tWHERE\r\n\t\tNODOSTRLSD='{$idupdate}'\r\n\t\tAND SMAWLTRLSD='{$tahunsemester}'\r\n\t\t";
        #echo $q;exit();
	doquery($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Data Dosen Keluar berhasil dihapus";
        }
        else
        {
            $errmesg = "Data Dosen Keluar tidak dihapus";
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Keluar/Cuti/Studi Lanjut Dosen", HAPUS_DATA );
    }
    $aksi2 = "";
}
if ( $aksi2 == "Tambah" )
{
    if ( $_POST['sessid'] == $_SESSION['token'] )
    {
        $valdata[] = cekvaliditasthnajaran( "Semester Awal", $tahun2, $semester2, false );
        $valdata[] = cekvaliditaskode( "Kode PT", $kode_pt, 6, false );
        $valdata = array_filter( $valdata, "filter_not_empty" );
        if ( isset( $valdata ) && 0 < count( $valdata ) )
        {
            $errmesg = val_err_mesg( $valdata, 2, TAMBAH_DATA );
            unset( $valdata );
        }
        else
        {
            $q = "\r\n        INSERT INTO trlsd\r\n        (\r\n      NODOSTRLSD,ASPTITRLSD,JENJATRLSD,SMAWLTRLSD,BIDILTRLSD,BISTUTRLSD\r\n         )\r\n        VALUES\r\n        ('{$idupdate}','{$kode_pt}','{$jenjang}','{$tahun2}{$semester2}','{$bidangilmu}',\r\n        '{$biayastudi}' )\r\n      ";
            doquery($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Data Dosen Studi Lanjut berhasil disimpan";
            }
            else
            {
                $errmesg = "Data Dosen Studi Lanjut tidak disimpan";
            }
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Dosen Studi Lanjut", TAMBAH_DATA );
    }
    $aksi2 = "formtambah";
}
if ( $aksi2 == "Simpan" )
{
    if ( $_POST['sessid'] == $_SESSION['token'] )
    {
        $valdata[] = cekvaliditasthnajaran( "Semester Awal", $tahun2, $semester2, false );
        $valdata[] = cekvaliditaskode( "Kode PT", $kode_pt, 6, false );
        $valdata = array_filter( $valdata, "filter_not_empty" );
        if ( isset( $valdata ) && 0 < count( $valdata ) )
        {
            $errmesg = val_err_mesg( $valdata, 2, SIMPAN_DATA );
            unset( $valdata );
        }
        else
        {
            $q = "\r\n      UPDATE trlsd\r\n      SET\r\n      SMAWLTRLSD='{$tahun2}{$semester2}',\r\n      BIDILTRLSD='{$bidangilmu}',\r\n      BISTUTRLSD='{$biayastudi}'\r\n      \r\n       WHERE NODOSTRLSD = '{$idupdate}' AND \r\n      ASPTITRLSD='{$kode_pt_lama}' AND\r\n      JENJATRLSD='{$jenjang_lama}' \r\n     ";
            doquery($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $tahunsemester = "{$tahun2}{$semester2}";
                $errmesg = "Data Dosen Studi Lanjut berhasil disimpan";
            }
            else
            {
                $errmesg = "Data Dosen Studi Lanjut tidak disimpan";
            }
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Dosen Studi Lanjut", SIMPAN_DATA );
    }
    $aksi2 = "formupdate";
}
echo "<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">\r\n  <tr >\r\n  <td width=50% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=formtambah&idupdate={$idupdate}'>".IKONTAMBAH." Tambah Data</td>\r\n  <td width=50% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=tampilkan&idupdate={$idupdate}'>".IKONUPDATE." Edit Data</td>\r\n  </tr>\r\n</table></div></div>\r\n";
printmesg( $errmesg );
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
if ( $aksi2 == "formupdate" )
{
    /*echo "<form name=form action=index.php method=post>\r\n\t\t<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "kode_pt_lama", "{$kode_pt_lama}", "" ).createinputhidden( "jenjang_lama", "{$jenjang_lama}", "" )."\r\n \r\n  ";
    */
	echo createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "kode_pt_lama", "{$kode_pt_lama}", "" ).createinputhidden( "jenjang_lama", "{$jenjang_lama}", "" )."\r\n \r\n  ";
	include( "formlulus.php" );
    #echo "\r\n \t<tr>\r\n\t\t\t\t<td colspan=2><input type=submit name=aksi2 value='Simpan' class=\"btn btn-brand\">\r\n\t\t\t\t\t<input type=reset value='Reset' class=\"btn btn-secondary\">\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  </table>\r\n  </div></div></form>\r\n  ";
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
    /*echo "<form name=form action=index.php method=post>\r\n\t\t<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" )."\r\n \r\n  ";
    */
	echo createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" )."\r\n \r\n  ";
	include( "formlulus.php" );
    #echo "\r\n \t<tr>\r\n\t\t\t\t<td colspan=2><input type=submit name=aksi2 value='Tambah' class=\"btn btn-brand\">\r\n\t\t\t\t\t<input type=reset value='Reset' class=\"btn btn-secondary\">\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  </table>\r\n </div></div> </form>\r\n  ";
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
    $q = "SELECT trlsd.*,NMPTITBPTI FROM trlsd LEFT JOIN tbpti ON KDPTITBPTI=ASPTITRLSD\r\n  \r\n  WHERE NODOSTRLSD='{$idupdate}' ORDER BY SMAWLTRLSD DESC";
    $h = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        /*echo "\r\n    <br>\r\n    <div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\"{$cetak}>\r\n        <tr class=juduldata{$cetak} align=center>\r\n          <td>No.</td>\r\n          <td>Kode PT</td>\r\n          <td>Nama PT</td>\r\n          <td>Jenjang</td>\r\n          <td>Semester Awal</td>\r\n          <td>Bidang Ilmu</td>\r\n          <td>Biaya Studi</td>\r\n  \r\n            <td colspan=2>Aksi</td>\r\n        </tr>";
        */
		echo "<div class=\"m-portlet\">			
				<div class=\"m-section__content\">
					<div class=\"table-responsive\">
						<table class=\"table table-bordered table-hover\">
							<thead>
								 <tr class=juduldata{$cetak} align=center>\r\n          <td>No.</td>\r\n          <td>Kode PT</td>\r\n          <td>Nama PT</td>\r\n          <td>Jenjang</td>\r\n          <td>Semester Awal</td>\r\n          <td>Bidang Ilmu</td>\r\n          <td>Biaya Studi</td>\r\n  \r\n            <td colspan=2>Aksi</td>\r\n        </tr>";
		echo "				</thead>
							<tbody>";
		$i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            $tmp = $d[SMAWLTRLSD];
            $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
            $semester = $tmp[4];
            echo "\r\n            <tr valign=top align=center {$kelas}{$cetak}>\r\n          <td>{$i}</td>\r\n          <td nowrap align=left>{$d['ASPTITRLSD']} </td>\r\n          <td   align=left>{$d['NMPTITBPTI']} </td>\r\n          <td nowrap align=center>".$arrayjenjang[$d[JENJATRLSD]]." </td>\r\n          <td nowrap align=left>{$tahun} ".$arraysemester[$semester]." </td>\r\n          <td>{$d['BIDILTRLSD']}</td>\r\n          <td nowrap>".$arraybiayastudilanjut[$d[BISTUTRLSD]]."</td>\r\n             \r\n          <td><a href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&idupdate={$idupdate}&kode_pt_lama={$d['ASPTITRLSD']}&jenjang_lama={$d['JENJATRLSD']}&aksi2=formupdate'><i class=\"fa fa-edit\"></i></td>              \r\n          <td><a onClick='return confirm(\"Hapus Data pelaporan Dosen Studi Lanjut?\")' href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&idupdate={$idupdate}&kode_pt_lama={$d['ASPTITRLSD']}&jenjang_lama={$d['JENJATRLSD']}&tahunsemester={$tahun}{$semester}&aksi2=hapus&sessid={$_SESSION['token']}'><i class=\"fa fa-trash\"></i></td>              \r\n          </tr>\r\n          ";
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
    }
    else
    {
		echo "<p>";	
        printmesg( "Data  Dosen Studi Lanjut tidak ada" );
		echo "</p>";	
    }
    echo "\r\n   \r\n  ";
}
?>
