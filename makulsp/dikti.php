<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$idprodi = getfield( "IDPRODI", "makul", " WHERE ID='{$idupdate}'" );
$namamakul = getfield( "NAMA", "makul", " WHERE ID='{$idupdate}'" );
/*echo " <div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\"> <tr class=judulform>\r\n\t\t\t<td width=150>Jurusan/Program Studi</td>\r\n\t\t\t<td>".$arrayprodidepmakul[$idprodi]."\r\n      </td>\r\n\t\t</tr> \r\n    <tr>\r\n      <td width=150>Kode Mata Kuliah</td>\r\n      <td><b>{$idupdate}</td>\r\n    </tr>\r\n    <tr>\r\n      <td>Nama Mata Kuliah Asli</td>\r\n      <td><b>".$namamakul."</td>\r\n    </tr>\r\n  </table></div></div>\r\n";
*/
echo "		<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=\"form\" action=\"index.php\" method=\"post\">
					<div class=\"m-portlet__body\">	";
echo "					<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$arrayprodidepmakul[$idprodi]."</label>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Kode Mata Kuliah</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>{$idupdate}</b></label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Nama Mata Kuliah Asli</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>".$namamakul."</b></label>
						</div>";
if ( $aksi2 == "hapus" )
{
    if ( $_GET['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Dikti", HAPUS_DATA );
        $aksi2 = "";
    }
    else
    {
        unset( $_SESSION['token'] );
        $total = 0;
        $q = "SELECT COUNT(*) AS JML FROM trnlmsp WHERE KDKMKTRNLM='{$idupdate}' AND THSMSTRNLM='{$tahunsemester}'\r\n     AND KDPSTTRNLM='{$prodiupdate}' \r\n     AND KDJENTRNLM='{$jenjangupdate}'\r\n    ";
        $h = mysqli_query($koneksi,$q);
        $d = sqlfetcharray( $h );
        $total += $d[JML];
        if ( $total <= 0 )
        {
            $q = "\r\n     \r\n     DELETE FROM tbkmksp\r\n              \r\n     WHERE\r\n     KDKMKTBKMK='{$idupdate}'\r\n     AND THSMSTBKMK='{$tahunsemester}'\r\n     \r\n     AND KDPSTTBKMK='{$prodiupdate}' \r\n     AND KDJENTBKMK='{$jenjangupdate}'\r\n     ";
            mysqli_query($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Data Mata Kuliah berhasil dihapus";
            }
            else
            {
                $errmesg = "Data Mata Kuliah tidak dihapus";
            }
        }
        else
        {
            $errmesg = "Data Kurikulum tidak dapat dihapus. Ada data KRS yg masih berkaitan.";
        }
    }
    $aksi2 = "";
}
if ( $aksi2 == "Tambah" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Data Dikti", TAMBAH_DATA );
        $aksi2 = "formtambah";
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditasnama( "Nama Mata Kuliah", $namamakul2, 100, false );
        $vld[] = cekvaliditasthnajaran( "Tahun/Semester Pelaporan Data", $tahun2, $semester2 );
        $vld[] = cekvaliditaskode( "Jenjang Program Studi", $jenjang1, 2 );
        $vld[] = cekvaliditaskodeprodi( "Program Studi", $prodi1 );
        $vld[] = cekvaliditasinteger( "SKS Kurikulum", $sks, 1, false );
        $vld[] = cekvaliditasinteger( "SKS Tatap Muka", $sks2, 1 );
        $vld[] = cekvaliditasinteger( "SKS Praktikum", $sks3, 1 );
        $vld[] = cekvaliditasinteger( "SKS Praktek Lapangan", $sks4, 1 );
        $vld[] = cekvaliditasinteger( "Penempatan Semester", $sem, 2 );
        $vld[] = cekvaliditaskode( "Kelompok Mata Kuliah", $kelompok, 2 );
        $vld[] = cekvaliditaskode( "Kurikulum Inti/Institusi", $kurikulum, 2 );
        $vld[] = cekvaliditaskode( "Mata Kuliah Wajib/Pilihan", $wajib, 2 );
        $vld[] = cekvaliditasnidn( "No Dosen pengampu", $dosen );
        $vld[] = cekvaliditaskode( "Jenjang Program Studi Pengampu", $jenjang, 2 );
        $vld[] = cekvaliditaskodeprodi( "Program Studi Pengampu", $prodi );
        $vld[] = cekvaliditaskode( "Status Mata Kuliah", $status, 2 );
        $vld[] = cekvaliditaskode( "Silabus", $silabus, 2 );
        $vld[] = cekvaliditaskode( "Satuan Acara Perkuliahan", $satuan, 2 );
        $vld[] = cekvaliditaskode( "Bahan Ajar", $bahan, 2 );
        $vld[] = cekvaliditaskode( "Diktat", $diktat, 2 );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
            unset( $vld );
            $aksi2 = "formtambah";
        }
        else
        {
            $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$idprodi}'";
            $h = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                $d = sqlfetcharray( $h );
                $kodept = $d[KDPTIMSPST];
                $kodejenjang = $d[KDJENMSPST];
                $kodeps = $d[KDPSTMSPST];
            }
            if ( $sem + 0 < 10 )
            {
                $sem = "0".( $sem + 0 );
            }
            $q = "\r\n        INSERT INTO tbkmksp\r\n        (THSMSTBKMK ,KDPTITBKMK ,KDPSTTBKMK ,KDJENTBKMK,KDKMKTBKMK ,NAKMKTBKMK ,\r\n        SKSMKTBKMK ,SKSTMTBKMK ,SKSPRTBKMK ,SKSLPTBKMK ,SEMESTBKMK ,\r\n        KDKELTBKMK ,KDKURTBKMK ,KDWPLTBKMK ,NODOSTBKMK ,JENJATBKMK ,\r\n        PRODITBKMK ,STKMKTBKMK ,SLBUSTBKMK ,SAPPPTBKMK ,BHNAJTBKMK ,\r\n        DIKTTTBKMK,KELOMPOKKURIKULUM,NAMA2)\r\n        VALUES\r\n        ('{$tahun2}{$semester2}','{$kodept}','{$prodi1}','{$jenjang1}','{$idupdate}','{$namamakul2}',\r\n        '{$sks}','{$sks2}','{$sks3}','{$sks4}','{$sem}','{$kelompok}','{$kurikulum}',\r\n        '{$wajib}','{$dosen}','{$jenjang}','{$prodi}','{$status}','{$silabus}',\r\n        '{$satuan}','{$bahan}','{$diktat}','{$kelompokkurikulum}','{$nama2}')\r\n      ";
            mysqli_query($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Data Mata Kuliah berhasil disimpan";
            }
            else
            {
                $errmesg = "Data Mata Kuliah tidak disimpan";
            }
        }
    }
    $aksi2 = "formtambah";
}
if ( $aksi2 == "Simpan" )
{
	#echo "ll";exit();
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Data Dikti", SIMPAN_DATA );
        $aksi2 = "formupdate";
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditasnama( "Nama Mata Kuliah", $namamakul2, 100, false );
        $vld[] = cekvaliditasthnajaran( "Tahun/Semester Pelaporan Data", $tahun2, $semester2 );
        $vld[] = cekvaliditaskode( "Jenjang Program Studi", $jenjang1, 2 );
        $vld[] = cekvaliditaskodeprodi( "Program Studi", $prodi1 );
        $vld[] = cekvaliditasinteger( "SKS Kurikulum", $sks, 1, false );
        $vld[] = cekvaliditasinteger( "SKS Tatap Muka", $sks2, 1 );
        $vld[] = cekvaliditasinteger( "SKS Praktikum", $sks3, 1 );
        $vld[] = cekvaliditasinteger( "SKS Praktek Lapangan", $sks4, 1 );
        $vld[] = cekvaliditasinteger( "Penempatan Semester", $sem, 2 );
        $vld[] = cekvaliditaskode( "Kelompok Mata Kuliah", $kelompok, 2 );
        $vld[] = cekvaliditaskode( "Kurikulum Inti/Institusi", $kurikulum, 2 );
        $vld[] = cekvaliditaskode( "Mata Kuliah Wajib/Pilihan", $wajib, 2 );
        $vld[] = cekvaliditasnidn( "No Dosen pengampu", $dosen );
        $vld[] = cekvaliditaskode( "Jenjang Program Studi Pengampu", $jenjang, 2 );
        $vld[] = cekvaliditaskodeprodi( "Program Studi Pengampu", $prodi );
        $vld[] = cekvaliditaskode( "Status Mata Kuliah", $status, 2 );
        $vld[] = cekvaliditaskode( "Silabus", $silabus, 2 );
        $vld[] = cekvaliditaskode( "Satuan Acara Perkuliahan", $satuan, 2 );
        $vld[] = cekvaliditaskode( "Bahan Ajar", $bahan, 2 );
        $vld[] = cekvaliditaskode( "Diktat", $diktat, 2 );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2 );
            unset( $vld );
            $aksi2 = "formupdate";
        }
        else
        {
            $q = "SELECT IDX FROM mspst WHERE \r\n    KDPSTMSPST='{$prodi1}' AND\r\n         KDJENMSPST='{$jenjang1}' LIMIT 0,1";
            $h = mysqli_query($koneksi,$q);
            if ( sqlnumrows( $h ) <= 0 )
            {
                $errmesg = "Data Program Studi dan Jenjang tidak valid.";
            }
            else
            {
                $d = sqlfetcharray( $h );
                $idxprodi = $d[IDX];
                $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$idprodi}'";
                $h = mysqli_query($koneksi,$q);
                if ( 0 < sqlnumrows( $h ) )
                {
                    $d = sqlfetcharray( $h );
                    $kodept = $d[KDPTIMSPST];
                    $kodejenjang = $d[KDJENMSPST];
                    $kodeps = $d[KDPSTMSPST];
                }
                if ( $sem + 0 < 10 )
                {
                    $sem = "0".( $sem + 0 );
                }
                $q = "\r\n     \r\n     UPDATE tbkmksp\r\n     SET\r\n      NAKMKTBKMK='{$namamakul2}',\r\n        SKSMKTBKMK='{$sks}',SKSTMTBKMK='{$sks2}',SKSPRTBKMK='{$sks3}',\r\n        SKSLPTBKMK='{$sks4}',SEMESTBKMK='{$sem}',KDKELTBKMK='{$kelompok}',\r\n        KDKURTBKMK='{$kurikulum}',\r\n       KDWPLTBKMK= '{$wajib}',NODOSTBKMK='{$dosen}',JENJATBKMK='{$jenjang}',\r\n       PRODITBKMK='{$prodi}',STKMKTBKMK='{$status}',SLBUSTBKMK='{$silabus}',\r\n        SAPPPTBKMK='{$satuan}',BHNAJTBKMK='{$bahan}',DIKTTTBKMK='{$diktat}' ,\r\n        KELOMPOKKURIKULUM='{$kelompokkurikulum}',\r\n        NAMA2='{$nama2}'\r\n        \r\n     WHERE\r\n     KDKMKTBKMK='{$idupdate}'\r\n     AND THSMSTBKMK='{$tahunsemester}'\r\n     AND KDPSTTBKMK='{$prodiupdate}' \r\n     AND KDJENTBKMK='{$jenjangupdate}'\r\n     ";
                mysqli_query($koneksi,$q);
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    $q2 = "";
                    if ( $ifsks == 1 )
                    {
                        $q2 .= "SKSMAKUL='{$sks}' ";
                    }
                    if ( $ifnama == 1 )
                    {
                        if ( $ifsks == 1 )
                        {
                            $q2 .= ", NAMA='{$namamakul2}' ";
                        }
                        else
                        {
                            $q2 .= "NAMA='{$namamakul2}' ";
                        }
                    }
                    if ( $ifnama == 1 || $ifsks == 1 )
                    {
                        $q = "SELECT IDX FROM mspst WHERE \r\n                KDPSTMSPST='{$prodiupdate}'  AND \r\n                KDJENMSPST='{$jenjangupdate}'\r\n                \r\n                ";
                        $h = mysqli_query($koneksi,$q);
                        if ( 0 < sqlnumrows( $h ) )
                        {
                            $d = sqlfetcharray( $h );
                            $q = "SELECT pengambilanmksp.*\r\n                  FROM pengambilanmksp ,mahasiswa \r\n                  WHERE \r\n                  pengambilanmksp.IDMAHASISWA=mahasiswa.ID AND\r\n                  mahasiswa.IDPRODI='{$d['IDX']}' AND\r\n                  TAHUN='".( $tahun2 + 1 )."' AND \r\n                  SEMESTER='{$semester2}' AND \r\n                  IDMAKUL='{$idupdate}' \r\n                  \r\n                  ";
                            $h = mysqli_query($koneksi,$q);
                            #do
                            #{
							if(0 < sqlnumrows( $h )){
                                while($d = sqlfetcharray( $h ))
                                {
                                    $q = "UPDATE pengambilanmksp SET {$q2} \r\n                          WHERE TAHUN='".( $tahun2 + 1 )."' AND SEMESTER='{$semester2}'\r\n                          AND IDMAKUL='{$idupdate}' AND\r\n                          IDMAHASISWA='{$d['IDMAHASISWA']}' ";
                                    mysqli_query($koneksi,$q);
                                }
							}
                            #} while ( 1 );
                        }
                    }
                    $tahunsemester = "{$tahun2}{$semester2}";
                    $prodiupdate = $prodi1;
                    $jenjangupdate = $jenjang1;
                    $errmesg = "Data Mata Kuliah berhasil disimpan";
                }
                else
                {
                    $errmesg = "Data Mata Kuliah tidak disimpan";
                }
            }
        }
    }
    $aksi2 = "formupdate";
}
/*echo " <div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">\r\n  <tr >\r\n  <td width=25% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=formtambah&idupdate={$idupdate}'> ".IKONTAMBAH." Tambah Data Kurikulum Baru </td>\r\n  <td width=25% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=tampilkan&idupdate={$idupdate}'> ".IKONUPDATE." Edit Data Kurikulum  </td>";
*/
echo "\r\n<br>\r\n <div class=\"portlet-body\">
						<div class=\"table-scrollable\">";
#echo "<table class=\"table table-striped table-bordered table-hover\">\r\n  <tr >\r\n  <td width=25% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=formtambah&idupdate={$idupdate}'>".IKONTAMBAH." Tambah Kurikulum Baru \r\n  ";
echo "	<table class=\"table table-striped table-bordered table-hover\">
			<tr >\r\n  <td width=25% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=formtambah&idupdate={$idupdate}'>Tambah Data Kurikulum Baru </td>\r\n  <td width=25% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=tampilkan&idupdate={$idupdate}'> Edit Data Kurikulum  </td>";
if ( $tahunsemester != "" )
{
    #echo "\r\n  <td width=25% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=syarat&idupdate={$idupdate}&tahunsemester={$tahunsemester}&prodiupdate={$prodiupdate}&jenjangupdate={$jenjangupdate}'> Syarat Pengambilan</td>\r\n  \r\n  <td width=25% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=jadwal&idupdate={$idupdate}&tahunsemester={$tahunsemester}&prodiupdate={$prodiupdate}&jenjangupdate={$jenjangupdate}'> Jadwal Kuliah</td>\r\n  \r\n  ";
	echo "\r\n  <td width=25% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=syarat&idupdate={$idupdate}&tahunsemester={$tahunsemester}&prodiupdate={$prodiupdate}&jenjangupdate={$jenjangupdate}'> Syarat Pengambilan</td>";
}
echo "\r\n  </tr>\r\n</table>\r\n</div></div>";
printmesg( $errmesg );
if ( $aksi2 == "syarat" )
{
    include( "syaratpengambilan.php" );
}
if ( $aksi2 == "jadwal" && $STEIINDONESIA == 1 )
{
    include( "jadwal.php" );
}
if ( $aksi2 == "formupdate" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    /*echo "<form name=form action=index.php method=post> <div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "sessid", "{$token}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tahunsemester", "{$tahunsemester}", "" ).createinputhidden( "jenjangupdate", "{$jenjangupdate}", "" ).createinputhidden( "prodiupdate", "{$prodiupdate}", "" )."\r\n   ";
    */
	echo "	<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post> 
				<div class=\"portlet-body\">
				".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "sessid", "{$token}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tahunsemester", "{$tahunsemester}", "" ).createinputhidden( "jenjangupdate", "{$jenjangupdate}", "" ).createinputhidden( "prodiupdate", "{$prodiupdate}", "" )."\r\n   ";
    
	include( "makul2.php" );
    #echo "\r\n \t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t".IKONUPDATE48."\r\n\t\t\t\t\t<input type=submit name=aksi2 value='Simpan' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  </table>\r\n  </form></div></div>\r\n  ";
	echo "	<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
								<div class=\"col-lg-6\">
										<input type=\"submit\" name=aksi2 class=\"btn btn-brand\" value=Simpan></input>
										<input type=\"reset\" class=\"btn btn-secondary\" value=Reset></input>  
									</div>
						</div>
		</div>
				</form>
				<!--end::Form-->	
			</div>
			<!--end::Portlet-->	";
}
if ( $aksi2 == "formtambah" )
{
	
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    echo "	<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>".
			createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "sessid", "{$token}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" )."";
	include( "makul2.php" );
    #echo "\r\n \t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t".IKONUPDATE48."\r\n \t\t\t\t\t<input type=submit name=aksi2 value='Tambah' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  </table>\r\n </div></div> </form>\r\n  ";
	echo "	<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
								<div class=\"col-lg-6\">
										<input type=\"submit\" name=aksi2 class=\"btn btn-brand\" value=Tambah></input>
										<input type=\"reset\" class=\"btn btn-secondary\" value=Reset></input>  
									</div>
						</div>
		</div>
				</form>
				<!--end::Form-->	
			</div>
			<!--end::Portlet-->	";
}
if ( $aksi2 == "" || $aksi2 == "tampilkan" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    $q = "SELECT tbkmksp.*,mspst.NMPSTMSPST \r\n  FROM tbkmksp,mspst WHERE \r\n  mspst.KDPSTMSPST=tbkmksp.KDPSTTBKMK AND\r\n  mspst.KDJENMSPST=tbkmksp.KDJENTBKMK AND\r\n  KDKMKTBKMK='{$idupdate}' \r\n   \r\n   {$qprodideptbkmk}\r\n  ORDER BY THSMSTBKMK DESC";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        #echo "\r\n    <br>\r\n      <table class=data{$cetak}>\r\n        <tr class=juduldata{$cetak} align=center>\r\n          <td>No.</td>\r\n          <td>Kelompok</td>\r\n          <td>Tahun / Semester Lapor</td>\r\n          <td>Prodi Penyelenggara</td>\r\n          <td>Jen jang</td>\r\n          <td>Nama Makul</td>\r\n          <td>SKS</td>\r\n          <td>SKS Tatap Muka</td>\r\n          <td>SKS Prak tikum</td>\r\n          <td>SKS Prak. Lap.</td>\r\n          <td>Se mes ter</td>\r\n          <td>Ke lom pok</td>\r\n          <td>Kuri ku lum</td>\r\n          <td>Wajib / Pilihan</td>\r\n          <td>NIDN Dosen Pengampu</td>\r\n \r\n          <td>Sta tus</td>\r\n          <td>Si la bus</td>\r\n          <td>Sa tuan Acara Per kuliah an</td>\r\n          <td>Ba han Ajar</td>\r\n          <td>Dik tat</td>\r\n            <td colspan=2>Aksi</td>\r\n        </tr>";
        echo "<div class=\"m-portlet\">			
				<div class=\"m-section__content\">
					<div class=\"table-responsive\">
						<table class=\"table table-bordered table-hover\">
							<thead>
								<tr class=juduldata{$cetak} align=center>\r\n          <td>No.</td>\r\n          <td>Kelompok</td>\r\n          <td>Tahun / Semester Lapor</td>\r\n          <td>Prodi Penyelenggara</td>\r\n          <td>Jen jang</td>\r\n          <td>Nama Makul</td>\r\n          <td>SKS</td>\r\n          <td>SKS Tatap Muka</td>\r\n          <td>SKS Prak tikum</td>\r\n          <td>SKS Prak. Lap.</td>\r\n          <td>Se mes ter</td>\r\n          <td>Ke lom pok</td>\r\n          <td>Kuri ku lum</td>\r\n          <td>Wajib / Pilihan</td>\r\n          <td>NIDN Dosen Pengampu</td>\r\n \r\n          <td>Sta tus</td>\r\n          <td>Si la bus</td>\r\n          <td>Sa tuan Acara Per kuliah an</td>\r\n          <td>Ba han Ajar</td>\r\n          <td>Dik tat</td>\r\n            <td colspan=2>Aksi</td>\r\n        </tr>";
		echo "				</thead>
							<tbody>";	
		$i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            $tmp = $d[THSMSTBKMK];
            $tahun2 = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
            $semester2 = $tmp[4];
            $nama2 = "";
            if ( $d[NAMA2] != "" )
            {
                $nama2 = "<br><i>({$d['NAMA2']})</i>";
            }
            /*echo "\r\n            <tr valign=top align=center {$kelas}{$cetak}>\r\n          <td>{$i}</td>\r\n          <td>".$arraykelompokkurikulum[$d[KELOMPOKKURIKULUM]]."</td>\r\n          <td nowrap align=left>{$tahun2}/".( $tahun2 + 1 )." ".$arraysemester[$semester2]." </td>\r\n          <td nowrap align=left>{$d['KDPSTTBKMK']}/{$d['NMPSTMSPST']}</td>\r\n          <td>".$arrayjenjang[$d[KDJENTBKMK]]."</td>\r\n          <td align=left nowrap>{$d['NAKMKTBKMK']} {$nama2}</td>\r\n          <td>{$d['SKSMKTBKMK']}</td>\r\n          <td>{$d['SKSTMTBKMK']}</td>\r\n          <td>{$d['SKSPRTBKMK']}</td>\r\n          <td>{$d['SKSLPTBKMK']}</td>\r\n          <td>{$d['SEMESTBKMK']}</td>\r\n          <td>".$arraykelompokmk[$d[KDKELTBKMK]]."</td>\r\n          <td>".$arrayjeniskurikulum[$d[KDKURTBKMK]]."</td>\r\n          <td>".$arrayjenismk[$d[KDWPLTBKMK]]."</td>\r\n          <td>{$d['NODOSTBKMK']}</td>\r\n \r\n          <td>".$arraystatuspt[$d[STKMKTBKMK]]."</td>\r\n          <td>{$d['SLBUSTBKMK']}</td>\r\n          <td>{$d['SAPPPTBKMK']}</td>\r\n          <td>{$d['BHNAJTBKMK']}</td>\r\n          <td>{$d['DIKTTTBKMK']}</td>              \r\n          <td><a href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&idupdate={$idupdate}&tahunsemester={$d['THSMSTBKMK']}&jenjangupdate={$d['KDJENTBKMK']}&prodiupdate={$d['KDPSTTBKMK']}&aksi2=formupdate'>".IKONUPDATE."</td>              \r\n          <td><a onClick='return confirm(\"Hapus Data pelaporan Mata Kuliah?\")' href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&idupdate={$idupdate}&tahunsemester={$d['THSMSTBKMK']}&jenjangupdate={$d['KDJENTBKMK']}&prodiupdate={$d['KDPSTTBKMK']}&aksi2=hapus&sessid={$token}'>".IKONHAPUS."</td>              \r\n          </tr>\r\n          ";
            */
			echo "\r\n            <tr valign=top align=center {$kelas}{$cetak}>\r\n          <td>{$i}</td>\r\n          <td>".$arraykelompokkurikulum[$d[KELOMPOKKURIKULUM]]."</td>\r\n          <td nowrap align=left>{$tahun2}/".( $tahun2 + 1 )." ".$arraysemester[$semester2]." </td>\r\n          <td nowrap align=left>{$d['KDPSTTBKMK']}/{$d['NMPSTMSPST']}</td>\r\n          <td>".$arrayjenjang[$d[KDJENTBKMK]]."</td>\r\n          <td align=left nowrap>{$d['NAKMKTBKMK']} {$nama2}</td>\r\n          <td>{$d['SKSMKTBKMK']}</td>\r\n          <td>{$d['SKSTMTBKMK']}</td>\r\n          <td>{$d['SKSPRTBKMK']}</td>\r\n          <td>{$d['SKSLPTBKMK']}</td>\r\n          <td>{$d['SEMESTBKMK']}</td>\r\n          <td>".$arraykelompokmk[$d[KDKELTBKMK]]."</td>\r\n          <td>".$arrayjeniskurikulum[$d[KDKURTBKMK]]."</td>\r\n          <td>".$arrayjenismk[$d[KDWPLTBKMK]]."</td>\r\n          <td>{$d['NODOSTBKMK']}</td>\r\n \r\n          <td>".$arraystatuspt[$d[STKMKTBKMK]]."</td>\r\n          <td>{$d['SLBUSTBKMK']}</td>\r\n          <td>{$d['SAPPPTBKMK']}</td>\r\n          <td>{$d['BHNAJTBKMK']}</td>\r\n          <td>{$d['DIKTTTBKMK']}</td>              \r\n          <td><a href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&idupdate={$idupdate}&tahunsemester={$d['THSMSTBKMK']}&jenjangupdate={$d['KDJENTBKMK']}&prodiupdate={$d['KDPSTTBKMK']}&aksi2=formupdate'><i class=\"fa fa-edit\"></i></td>              \r\n          <td><a onClick='return confirm(\"Hapus Data pelaporan Mata Kuliah?\")' href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&idupdate={$idupdate}&tahunsemester={$d['THSMSTBKMK']}&jenjangupdate={$d['KDJENTBKMK']}&prodiupdate={$d['KDPSTTBKMK']}&aksi2=hapus&sessid={$token}'><i class=\"fa fa-trash\"></i></td>              \r\n          </tr>\r\n          ";
            
			++$i;
        }
        #echo "\r\n      </table>\r\n    ";
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
        printmesg( "Kurikulum Mata Kuliah Semester Pendek tidak ada" );
    }
    #echo "\r\n   \r\n  ";
}
?>
