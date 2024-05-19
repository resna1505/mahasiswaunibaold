<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $users == "" )
{
    $users = $users_mobile;
}
if ( $aksi == "tambah" && $REQUEST_METHOD == POST )
{
    if ( $_SESSION['token'] == $_POST['sessid'] )
    {
        unset( $_SESSION['token'] );
        $q = "SELECT tugaskuliah.* FROM tugaskuliah WHERE \r\n    IDBAHAN='{$idupdate}' AND\r\n    IDMAKUL='{$idmakulupdate}' AND\r\n    TAHUN='{$tahunupdate}' AND\r\n    SEMESTER='{$semesterupdate}' AND\r\n    KELAS='{$kelasupdate}'\r\n    ";
        $h = mysqli_query($koneksi,$q);
        $d = sqlfetcharray( $h );
        if ( $filebahan == "" )
        {
            $errmesg = "File hasil tugas kuliah harus diisi";
        }
        else
        {
            if ( $d[UKURAN] * 1024 * 1024 < $filebahan_size )
            {
                $errmesg = "Ukuran file > {$d['UKURAN']} MB";
            }
            else
            {
                $q = "SELECT *\r\n    FROM hasiltugaskuliah WHERE \r\n    IDBAHAN='{$idupdate}' AND\r\n    IDMAKUL='{$idmakulupdate}' AND\r\n    TAHUN='{$tahunupdate}' AND\r\n    SEMESTER='{$semesterupdate}' AND\r\n    IDMAHASISWA='{$users}' AND\r\n    KELAS='{$kelasupdate}'\r\n    ";
                $hm = mysqli_query($koneksi,$q);
                $sudahkirim = 0;
                if ( sqlnumrows( $hm ) )
                {
                    $dm = sqlfetcharray( $hm );
                    $filelama = $dm[FILE];
                    $sudahkirim = 1;
                }
                $ket = html_entity_decode( $ket );
                $ket = preg_replace( "/<script[^>]*>.*?< *script[^>]*>/i", "", $ket );
                $namafilebaru = $filebahan_name;
                if ( file_exists( "{$FOLDERFILEHASIL}/".md5( $filebahan_name )."" ) )
                {
                    $namafilebaru = "{$idmakulupdate}{$tahunupdate}{$semesterupdate}{$kelasupdate}{$idbaru}".$filebahan_name;
                }
                if ( $sudahkirim == 0 )
                {
                    $q = "\r\n    \t\t\tINSERT INTO hasiltugaskuliah (IDBAHAN,IDMAKUL,TAHUN,KELAS,IDMAHASISWA,KET,SEMESTER,FILE,TANGGAL,FLAGFILE\r\n          ) \r\n    \t\t\tVALUES ('{$idupdate}','{$idmakulupdate}','{$tahunupdate}',\r\n    \t\t\t'{$kelasupdate}','{$users}','{$ket}','{$semesterupdate}','{$namafilebaru}',NOW(),1)\r\n    \t\t";
                }
                else if ( $sudahkirim == 1 && $d[KIRIMULANG] == 1 )
                {
                    $q = "\r\n    \t\t\tUPDATE hasiltugaskuliah SET \r\n          KET='{$ket}',\r\n          FILE='{$namafilebaru}',\r\n          TANGGAL=NOW()\r\n          WHERE\r\n            IDBAHAN='{$idupdate}' AND\r\n            IDMAKUL='{$idmakulupdate}' AND\r\n            TAHUN='{$tahunupdate}' AND\r\n            SEMESTER='{$semesterupdate}' AND\r\n            IDMAHASISWA='{$users}' AND\r\n            KELAS='{$kelasupdate}'";
                }
                mysqli_query($koneksi,$q);
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    $errmesg = "File Hasil Tugas Kuliah berhasil diupload";
                    if ( $filebahan != "" )
                    {
                        @move_uploaded_file( @$filebahan, @"{$FOLDERFILEHASIL}/".@md5( @$namafilebaru ) );
                        if ( $filelama != "" && $filelama != $namafilebaru )
                        {
                            @unlink( @"{$FOLDERFILEHASIL}/".@md5( @$filelama ) );
                        }
                    }
                    $ket = "";
                    $nama = "";
                }
                else
                {
                    $errmesg = "File Hasil Tugas Kuliah tidak berhasil diupload";
                }
            }
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Tugas Kuliah", SIMPAN_DATA );
    }
    $aksi = "";
}
if ( $aksi == "" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    $q = "SELECT tugaskuliah.*,IF(SELESAI<NOW(),1,0) AS TELAT \r\n    FROM tugaskuliah WHERE \r\n    IDBAHAN='{$idupdate}' AND\r\n    IDMAKUL='{$idmakulupdate}' AND\r\n    TAHUN='{$tahunupdate}' AND\r\n    SEMESTER='{$semesterupdate}' AND\r\n    KELAS='{$kelasupdate}'\r\n    ";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    #printjudulmenu( "Kirim/Upload Tugas Kuliah  " );
    #printmesg( $errmesg );
    #echo "\r\n\t\t<form name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'>\r\n\t\t<table class=form>".createinputhidden( "aksi2", $aksi2, "" ).createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" )."<tr class=judulform>\r\n\t\t\t<td width=200>Mata Kuliah</td>\r\n\t\t\t<td>{$idmakulupdate}, ".getnamafromtabel( $idmakulupdate, "makul" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Tahun Ajaran</td>\r\n\t\t\t<td>".( $tahunupdate - 1 )."/{$tahunupdate}\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr> \r\n\t\t<tr>\r\n\t\t\t<td class=judulform>Semester</td>\r\n\t\t\t<td >  ".$arraysemester[$semesterupdate]."  </td>\r\n\t\t</tr>\r\n  \t\t<tr class=judulform>\r\n\t\t\t<td class=judulform>Dosen Pengajar </td>\r\n\t\t\t<td>{$iddosenupdate}, ".getnamafromtabel( $iddosenupdate, "dosen" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Kode Kelas</td>\r\n\t\t\t<td>".$arraylabelkelas[$kelasupdate]."</td>\r\n\t\t</tr>"."\r\n\t\t</table>\r\n\t\t<br>\r\n\t\t";
    #printjudulmenukecil( "Kirim File Tugas Kuliah" );
    echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
                        echo "			<div class='portlet-title'>";
												printmesg("Kirim / Upload Tugas Kuliah");
								echo "	</div>";
	echo "  	<div class=\"m-portlet\">				
					<!--begin::Form-->";
	echo "			<form name=form action=index.php class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" method=post ENCTYPE='MULTIPART/FORM-DATA'>"
						.createinputhidden( "aksi2", $aksi2, "" )
						.createinputhidden( "pilihan", $pilihan, "" )
						.createinputhidden( "aksi", "tambah", "" )
						.createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" )
						.createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" )
						.createinputhidden( "tahunupdate", "{$tahunupdate}", "" )
						.createinputhidden( "semesterupdate", "{$semesterupdate}", "" )
						.createinputhidden( "idupdate", "{$idupdate}", "" )
						.createinputhidden( "kelasupdate", "{$kelasupdate}", "" )
						.createinputhidden( "sessid", $_SESSION['token'], "" )."";
	echo "				<div class=\"m-portlet__body\">		
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Mata Kuliah</label>\r\n    
								<div class=\"col-lg-6\">
									{$idmakulupdate}, ".getnamafromtabel( $idmakulupdate, "makul" )."
								</div>
							</div>
							<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Tahun Ajaran</label>\r\n    
							<div class=\"col-lg-6\">
								".( $tahunupdate - 1 )."/{$tahunupdate}
							</div>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Semester</label>\r\n    
							<div class=\"col-lg-6\">
								".$arraysemester[$semesterupdate]."
							</div>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Dosen Pengajar</label>\r\n    
							<div class=\"col-lg-6\">
								{$iddosenupdate}, ".getnamafromtabel( $iddosenupdate, "dosen" )."
							</div>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Kode Kelas</label>\r\n    
							<div class=\"col-lg-6\">
								".$arraylabelkelas[$kelasupdate]."
							</div>
						</div>";
	echo "				<div class='portlet-title'>";
								printmesg("Kirim File Tugas Kuliah");
	echo "				</div>";
	echo "				<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Nama Tugas</label>\r\n    
							<div class=\"col-lg-6\">
								{$d['NAMA']}
							</div>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Keterangan</label>\r\n    
							<div class=\"col-lg-6\">
								".htmlspecialchars_decode( $d[KET] )."
							</div>
						</div>";
	echo "				<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">File Tugas</label>\r\n    
							<div class=\"col-lg-6\">";
    if ( $d[FILE] != "" )
    {
        #echo "\r\n    <tr valign=top  class=judulform>\r\n\t\t\t<td><b>File Tugas</td>\r\n\t\t\t<td>";
        if ( $d[FLAGFILE] == 0 )
        {
            echo "\r\n            <a target=_blank href='..tugas/file/{$d['FILE']}'>{$d['FILE']}</a>";
        }
        else if ( $d[FLAGFILE] == 1 )
        {
            if ( $users_mobile == $users )
            {
                $filedl = "dltugas.php";
            }
            else
            {
                $filedl = "dl.php";
            }
            echo "\r\n            <a href='{$filedl}?idmakulupdate={$d['IDMAKUL']}&iddosenupdate={$d['IDDOSEN']}&tahunupdate={$d['TAHUN']}&semesterupdate={$d['SEMESTER']}&kelasupdate={$d['KELAS']}&idbahan={$d['IDBAHAN']}\r\n' >download</a>";
        }
        #echo "</td>\r\n\t\t</tr> ";
    }
	echo "					</div>
						</div> ";
    $tmp = explode( " ", "{$d['MULAI']}" );
    $tglmulai = explode( "-", $tmp[0] );
    $jammulai = $tmp[1];
    $tmp = explode( " ", "{$d['SELESAI']}" );
    $tglselesai = explode( "-", $tmp[0] );
    $jamselesai = $tmp[1];
    #echo "\r\n\r\n\r\n    <tr valign=top  class=judulform>\r\n\t\t\t<td><b>Tersedia Sejak </td>\r\n\t\t\t<td>{$tglmulai['2']} ".$arraybulan[$tglmulai[1] - 1]."  {$tglmulai['0']} {$jammulai}</td>\r\n\t\t\t</td>\r\n\t\t</tr> \r\n    <tr valign=top  class=judulform>\r\n\t\t\t<td nowrap><b>Tanggal Penyelesaian </td>\r\n\t\t\t<td>{$tglselesai['2']} ".$arraybulan[$tglselesai[1] - 1]."  {$tglselesai['0']} {$jamselesai}</td>\r\n\t\t\t</td>\r\n\t\t</tr> \r\n\r\n \r\n    <tr valign=top  class=judulform>\r\n\t\t\t<td><b>Bolehkah pengiriman ulang?</td>\r\n\t\t\t<td> \r\n      ".$arrayya[$d[KIRIMULANG]]."\r\n      </td>\r\n\t\t\t</td>\r\n\t\t</tr> \r\n\t\t<tr>\r\n      <td colspan=2><hr>  </td>\r\n    </tr>\r\n \r\n    \r\n    ";
    echo "				<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Tersedia Sejak</label>\r\n    
							<div class=\"col-lg-6\">
								{$tglmulai['2']} ".$arraybulan[$tglmulai[1] - 1]."  {$tglmulai['0']} {$jammulai}
							</div>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Tanggal Penyelesaian</label>\r\n    
							<div class=\"col-lg-6\">
								{$tglselesai['2']} ".$arraybulan[$tglselesai[1] - 1]."  {$tglselesai['0']} {$jamselesai}
							</div>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Bolehkah pengiriman ulang?</label>\r\n    
							<div class=\"col-lg-6\">
								".$arrayya[$d[KIRIMULANG]]."
							</div>
						</div>";
	$statuskirim = 0;
    $q = "SELECT  IDMAHASISWA,NILAI\r\n    FROM hasiltugaskuliah WHERE \r\n    IDBAHAN='{$idupdate}' AND\r\n    IDMAKUL='{$idmakulupdate}' AND\r\n    TAHUN='{$tahunupdate}' AND\r\n    SEMESTER='{$semesterupdate}' AND\r\n    KELAS='{$kelasupdate}' AND\r\n    IDMAHASISWA='{$users}'\r\n    ";
    $hx = mysqli_query($koneksi,$q);
    $pesanstatus = "<b style='color:red;'>Anda belum mengumpulkan tugas kuliah.";
    if ( 0 < sqlnumrows( $hx ) )
    {
        $dx = sqlfetcharray( $hx );
        $nilai = $dx[NILAI];
        $statuskirim = 1;
        $pesanstatus = "<b style='color:blue;'>Anda sudah mengumpulkan tugas kuliah.";
    }
    echo "				<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Status</label>\r\n    
							<div class=\"col-lg-6\">
								{$pesanstatus} 
							</div>
						</div>";
    if ( $d[JENIS] == 0 && $statuskirim == 1 )
    {
        echo "			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Nilai</label>\r\n    
							<div class=\"col-lg-6\">
								<b  style='font-size:24pt;'>{$nilai} </b> (Catatan: Nilai 0 bisa berarti dosen ybs belum mengupdate data nilai.)
							</div>
						</div>";
    }
    if ( $d[JENIS] == 0 && $d[TELAT] == 0 && ( $statuskirim == 0 && $d[KIRIMULANG] == 0 || $d[KIRIMULANG] == 1 ) )
    {
        echo "			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">File Tugas Kuliah (Max {$d['UKURAN']}  MB)</label>\r\n    
							<div class=\"col-lg-6\">
								<input type=file name=filebahan class=form-control m-input size=40>
							</div>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Catatan u/ Dosen</label>\r\n    
							<div class=\"col-lg-6\">
								".createinputtextarea( "ket", "{$ket}", "cols=50 rows=5 class=form-control m-input" )."
							</div>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
							<div class=\"col-lg-6\">
								<input type=submit value='Upload File Ini' class=\"btn btn-brand\">
								<input type=reset value='Reset' class=\"btn btn-secondary\">
							</div>
						</div>";
    }
	
    elseif ( $d[TELAT] == 1 )
    {
        printmesg( "Batas waktu penyerahan tugas kuliah sudah habis." );
    }
    else if ( $d[KIRIMULANG] == 0 && $statuskirim == 1 )
    {
        printmesg( "Tugas tidak dapat dikirim ulang." );
    }
	echo "			</div>
				</form>
			</div>
		</div>
		</div>
		</div>
		</div>";
    #echo "\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n \r\n<br><br>\r\n \t\t";
}
?>
