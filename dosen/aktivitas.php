<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$idprodi = getfield( "IDDEPARTEMEN", "dosen", " WHERE ID='{$idupdate}'" );
$namamakul = getfield( "NAMA", "dosen", " WHERE ID='{$idupdate}'" );
/*echo "<div class=\"portlet-body\">
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
    if ( $_SESSION['token'] != $_GET['sessid'] )
    {
        $errmesg = token_err_mesg( "Aktivitas Mengajar", HAPUS_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $q = "\r\n     \r\n     DELETE FROM trakd\r\n              \r\n     WHERE\r\n     NODOSTRAKD='{$idupdate}'\r\n     AND THSMSTRAKD='{$tahunsemester}'\r\n     AND  KDKMKTRAKD='{$makulupdate}' \r\n     AND KELASTRAKD='{$kelasupdate}'\r\n     ";
        doquery($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Data Aktivitas Mengajar Dosen berhasil dihapus";
        }
        else
        {
            $errmesg = "Data Aktivitas Mengajar Dosen tidak dihapus";
        }
    }
    $aksi2 = "";
}
if ( $aksi2 == "Tambah" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Aktivitas Mengajar", TAMBAH_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditasthnajaran( "Tahun/Semester Data", $tahun2, $semester2, false );
        $vld[] = cekvaliditaskodemakul( "Kode Makul", $kodemakul, 16, false );
        $vld[] = cekvaliditasinteger( "Kelas", $kelas, 2, false );
        $vld[] = cekvaliditasinteger( "Jumlah Tatap Muka", $jumlah1 );
        $vld[] = cekvaliditasinteger( "Jumlah Realisasi Tatap Muka", $jumlah2 );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, TAMBAH_DATA );
        }
        else
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
            $q = "\r\n        INSERT INTO trakd\r\n        (\r\n\t\tTHSMSTRAKD, KDPTITRAKD,KDPSTTRAKD,KDJENTRAKD,NODOSTRAKD,KDKMKTRAKD,KELASTRAKD,\r\n\t\tTMRENTRAKD,TMRELTRAKD )\r\n        VALUES\r\n        ('{$tahun2}{$semester2}','{$kodept}','{$kodeps}','{$kodejenjang}','{$idupdate}',\r\n        '{$kodemakul}','{$kelas}',        '{$jumlah1}','{$jumlah2}')\r\n      ";
            doquery($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Data Aktivitas Mengajar Dosen berhasil disimpan";
            }
            else
            {
                $errmesg = "Data Aktivitas Mengajar Dosen tidak disimpan";
            }
        }
    }
    $aksi2 = "formtambah";
}
if ( $aksi2 == "Simpan" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Aktivitas Mengajar", SIMPAN_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditasthnajaran( "Tahun/Semester Data", $tahun2, $semester2, false );
        $vld[] = cekvaliditaskodemakul( "Kode Makul", $kodemakul, 16, false );
        $vld[] = cekvaliditasinteger( "Kelas", $kelas, 2, false );
        $vld[] = cekvaliditasinteger( "Jumlah Tatap Muka", $jumlah1 );
        $vld[] = cekvaliditasinteger( "Jumlah Realisasi Tatap Muka", $jumlah2 );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
        }
        else
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
            $q = "\r\n      UPDATE trakd\r\n      SET\r\n       THSMSTRAKD='{$tahun2}{$semester2}',\r\n       KDKMKTRAKD='{$kodemakul}',\r\n      KELASTRAKD='{$kelas}',\r\n      TMRENTRAKD='{$jumlah1}',\r\n      TMRELTRAKD='{$jumlah2}'\r\n      WHERE \r\n      NODOSTRAKD = '{$idupdate}' AND \r\n      THSMSTRAKD='{$tahunsemester}' AND\r\n      KDKMKTRAKD='{$makulupdate}' AND \r\n      KELASTRAKD='{$kelasupdate}'\r\n     ";
            doquery($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $tahunsemester = "{$tahun2}{$semester2}";
                $makulupdate = $kodemakul;
                $kelasupdate = $kelas;
                $errmesg = "Data Aktivitas Mengajar Dosen berhasil disimpan";
            }
            else
            {
                $errmesg = "Data Aktivitas Mengajar Dosen tidak disimpan";
            }
        }
    }
    $aksi2 = "formupdate";
}
echo "<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">\r\n  <tr >\r\n  <td width=50% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=formtambah&idupdate={$idupdate}'> ".IKONTAMBAH." Tambah Data</td>\r\n  <td width=50% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=tampilkan&idupdate={$idupdate}'>".IKONUPDATE." Edit Data</td>\r\n  </tr>\r\n</table></div></div>\r\n";
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
printmesg( $errmesg );
if ( $aksi2 == "formupdate" )
{
    /*echo "<form name=form action=index.php method=post>\r\n\t\t<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "makulupdate", "{$makulupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" ).createinputhidden( "sessid", "{$_SESSION['token']}", "" ).createinputhidden( "tahunsemester", "{$tahunsemester}", "" )."\r\n \r\n  ";
    */
	echo createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "makulupdate", "{$makulupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" ).createinputhidden( "sessid", "{$_SESSION['token']}", "" ).createinputhidden( "tahunsemester", "{$tahunsemester}", "" )."\r\n \r\n  ";
	include( "formaktivitas.php" );
    #echo "\r\n \t<tr>\r\n\t\t\t\t<td colspan=2><input type=submit name=aksi2 value='Simpan' class=\"btn btn-brand\">\r\n\t\t\t\t\t<input type=reset value='Reset' class=\"btn btn-secondary\" class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  </table></div></div>\r\n  </form>\r\n  ";
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
                            <table class=\"table table-striped table-bordered table-hover\">".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "sessid", "{$_SESSION['token']}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" )."\r\n \r\n  ";
    */
	
	echo createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "sessid", "{$_SESSION['token']}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" )."\r\n \r\n  ";
	include( "formaktivitas.php" );
    #echo "\r\n \t<tr>\r\n\t\t\t\t<td colspan=2><input type=submit name=aksi2 value='Tambah' class=\"btn btn-brand\">\r\n\t\t\t\t\t<input type=reset value='Reset' class=\"btn btn-secondary\">\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  </table>\r\n</div></div>  </form>\r\n  ";
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
    $q = "SELECT trakd.*,tbkmk.NAKMKTBKMK AS NAMAMAKUL \r\n  FROM trakd LEFT JOIN tbkmk ON\r\n  trakd.THSMSTRAKD=tbkmk.THSMSTBKMK AND\r\n  trakd.KDJENTRAKD=tbkmk.KDJENTBKMK AND\r\n  trakd.KDPSTTRAKD=tbkmk.KDPSTTBKMK AND\r\n  trakd.KDPTITRAKD=tbkmk.KDPTITBKMK  AND\r\n  trakd.KDKMKTRAKD=tbkmk.KDKMKTBKMK  \r\n  WHERE NODOSTRAKD='{$idupdate}' ORDER BY THSMSTRAKD DESC, KDKMKTRAKD";
    $h = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        /*echo "\r\n    <br>\r\n      <div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\"{$cetak}>\r\n        <tr class=juduldata{$cetak} align=center>\r\n          <td>No.</td>\r\n          <td>Tahun / Semester Lapor</td>\r\n          <td>Kode Makul</td>\r\n          <td>Nama Makul</td>\r\n          <td>Kelas</td>\r\n          <td>Jml Tatap Muka</td>\r\n          <td>Jml Realisasi Tatap Muka</td>\r\n            <td colspan=2>Aksi</td>\r\n        </tr>";
        */
		echo "<div class=\"m-portlet\">			
				<div class=\"m-section__content\">
					<div class=\"table-responsive\">
						<table class=\"table table-bordered table-hover\">
							<thead>
								<tr class=juduldata{$cetak} align=center>\r\n          <td>No.</td>\r\n          <td>Tahun / Semester Lapor</td>\r\n          <td>Kode Makul</td>\r\n          <td>Nama Makul</td>\r\n          <td>Kelas</td>\r\n          <td>Jml Tatap Muka</td>\r\n          <td>Jml Realisasi Tatap Muka</td>\r\n            <td colspan=2>Aksi</td>\r\n        </tr>";
		echo "				</thead>
							<tbody>";
		$i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            $tmp = $d[THSMSTRAKD];
            $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
            $semester = $tmp[4];
            echo "\r\n            <tr valign=top align=center {$kelas}{$cetak}>\r\n          <td>{$i}</td>\r\n          <td nowrap align=left>{$tahun} ".$arraysemester[$semester]." </td>\r\n          <td>{$d['KDKMKTRAKD']}</td>\r\n          <td align=left>{$d['NAMAMAKUL']}  </td>\r\n          <td >{$d['KELASTRAKD']}</td>\r\n          <td>{$d['TMRENTRAKD']}</td>\r\n          <td>{$d['TMRELTRAKD']}</td>\r\n\r\n             \r\n          <td><a href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&idupdate={$idupdate}&tahunsemester={$d['THSMSTRAKD']}&makulupdate={$d['KDKMKTRAKD']}&kelasupdate={$d['KELASTRAKD']}&aksi2=formupdate'>".IKONUPDATE."</td>              \r\n          <td><a onClick='return confirm(\"Hapus Data Aktivitas Mengajar Dosen?\")' href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&idupdate={$idupdate}&tahunsemester={$d['THSMSTRAKD']}&makulupdate={$d['KDKMKTRAKD']}&kelasupdate={$d['KELASTRAKD']}&aksi2=hapus&sessid={$_SESSION['token']}'>".IKONHAPUS."</td>              \r\n          </tr>\r\n          ";
            ++$i;
        }
        #echo "\r\n      </table>\r\n   </div></div></div></div></div> ";
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
        printmesg( "Data  Aktivitas Mengajar Dosen tidak ada" );
		echo "</p>";
    }
    echo "\r\n   \r\n  ";
}
?>
