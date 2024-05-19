<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $aksitambah == "Hapus" )
{
    if ( $_SESSION['token'] == $_POST['sessid'] )
    {
        unset( $_SESSION['token'] );
        cekhaktulis( $kodemenu );
        if ( is_array( $data ) )
        {
            $jmlaf = 0;
            foreach ( $data as $k => $v )
            {
                if ( $v[hapus] == 1 )
                {
                    $q = "SELECT FILE FROM hasiltugaskuliah\r\n\t\t\t\t\tWHERE\r\n\t\t\t\t\tIDMAKUL='{$idmakulupdate}' AND\r\n\t\t\t\t\tTAHUN='{$tahunupdate}' AND\r\n\t\t\t\t\tSEMESTER='{$semesterupdate}'\tAND\r\n\t\t\t\t\tKELAS='{$kelasupdate}'\tAND\r\n\t\t\t\t\tIDBAHAN='{$idupdate}'\tAND\r\n\t\t\t\t\tIDMAHASISWA='{$k}'\r\n\t\t\t\t";
                    $hd = mysqli_query($koneksi,$q);
                    $dh = sqlfetcharray( $hd );
                    $q = "\r\n\t\t\t\t\tDELETE FROM hasiltugaskuliah \r\n\t\t\t\t\tWHERE\r\n\t\t\t\t\tIDMAKUL='{$idmakulupdate}' AND\r\n\t\t\t\t\tTAHUN='{$tahunupdate}'\tAND\r\n\t\t\t\t\tSEMESTER='{$semesterupdate}'\tAND\r\n\t\t\t\t\tKELAS='{$kelasupdate}'\tAND\r\n\t\t\t\t\tIDBAHAN='{$idupdate}'\tAND\r\n\t\t\t\t\tIDMAHASISWA='{$k}'\t\t\t\t\t\r\n\t\t\t\t";
                    mysqli_query($koneksi,$q);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        @unlink( @"{$FOLDERFILEHASIL}/".@md5( @$dh[FILE] ) );
                        ++$jmlaf;
                    }
                }
            }
            if ( 0 < $jmlaf )
            {
                $errmesg = "Data Hasil Tugas Kuliah nilai berhasil dihapus";
            }
            else
            {
                $errmesg = "Data Hasil Tugas Kuliah nilai tidak dihapus";
            }
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Tugas Kuliah", HAPUS_DATA );
    }
}
if ( $aksitambah == "Update" )
{
    if ( $_SESSION['token'] == $_POST['sessid'] )
    {
        unset( $_SESSION['token'] );
        cekhaktulis( $kodemenu );
        if ( is_array( $data ) )
        {
            $jmlaf = 0;
            foreach ( $data as $k => $v )
            {
                $q = "\r\n\t\t\t\t\tUPDATE hasiltugaskuliah \r\n\t\t\t\t\tSET NILAI='{$v['nilai']}'\r\n\t\t\t\t\tWHERE\r\n\t\t\t\t\tIDMAKUL='{$idmakulupdate}' AND\r\n\t\t\t\t\tTAHUN='{$tahunupdate}'\tAND\r\n\t\t\t\t\tSEMESTER='{$semesterupdate}'\tAND\r\n\t\t\t\t\tKELAS='{$kelasupdate}'\tAND\r\n\t\t\t\t\tIDBAHAN='{$idupdate}'\tAND\r\n\t\t\t\t\tIDMAHASISWA='{$k}'\t\t\t\t\t\r\n\t\t\t\t";
                mysqli_query($koneksi,$q);
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    ++$jmlaf;
                }
            }
            if ( 0 < $jmlaf )
            {
                $errmesg = "Data Hasil Tugas Kuliah nilai berhasil disimpan";
            }
            else
            {
                $errmesg = "Data Hasil Tugas Kuliah nilai tidak disimpan";
            }
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Tugas Kuliah", SIMPAN_DATA );
    }
}
if ( $aksi == "" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    cekhaktulis( $kodemenu );
    #printjudulmenu( "Hasil Tugas Kuliah" );
    #printmesg( $errmesg );
    $q = "SELECT tugaskuliah.* FROM tugaskuliah WHERE \r\n    IDBAHAN='{$idupdate}' AND\r\n    IDMAKUL='{$idmakulupdate}' AND\r\n    TAHUN='{$tahunupdate}' AND\r\n    SEMESTER='{$semesterupdate}' AND\r\n    KELAS='{$kelasupdate}'\r\n    ";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    #echo "\r\n\t\t \r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" )."<tr class=judulform>\r\n\t\t\t<td width=200>Mata Kuliah</td>\r\n\t\t\t<td>{$idmakulupdate}, ".getnamafromtabel( $idmakulupdate, "makul" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Tahun Ajaran</td>\r\n\t\t\t<td>".( $tahunupdate - 1 )."/{$tahunupdate}\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr> \r\n\t\t<tr>\r\n\t\t\t<td class=judulform>Semester</td>\r\n\t\t\t<td >  ".$arraysemester[$semesterupdate]."  </td>\r\n\t\t</tr>\r\n  \t\t<tr class=judulform>\r\n\t\t\t<td class=judulform>Dosen Pengajar </td>\r\n\t\t\t<td>{$iddosenupdate}, ".getnamafromtabel( $iddosenupdate, "dosen" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Kode Kelas</td>\r\n\t\t\t<td>".$arraylabelkelas[$kelasupdate]."</td>\r\n\t\t</tr>"."\r\n\t\t</table>\r\n\t\t<br>\r\n\t\t";
    #printjudulmenukecil( "Tugas Kuliah " );
    echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
                        echo "			<div class='portlet-title'>";
												printmesg("Hasil Tugas Kuliah");
								echo "	</div>";
	echo "  	<div class=\"m-portlet\">				
					<!--begin::Form-->";
	echo "			<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'>"
						.createinputhidden( "pilihan", $pilihan, "" )
						.createinputhidden( "aksi", "", "" )
						.createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" )
						.createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" )
						.createinputhidden( "tahunupdate", "{$tahunupdate}", "" )
						.createinputhidden( "semesterupdate", "{$semesterupdate}", "" )
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
								printmesg("Tugas Kuliah Baru");
	echo "				</div>
						<div class=\"form-group m-form__group row\">
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
        
        if ( $d[FLAGFILE] == 0 )
        {
            echo "\r\n            <a target=_blank href='file/{$d['FILE']}'>{$d['FILE']}</a>";
        }
        else if ( $d[FLAGFILE] == 1 )
        {
            echo "\r\n            <a target=_blank href='dl.php?idmakulupdate={$d['IDMAKUL']}&iddosenupdate={$d['IDDOSEN']}&tahunupdate={$d['TAHUN']}&semesterupdate={$d['SEMESTER']}&kelasupdate={$d['KELAS']}&idbahan={$d['IDBAHAN']}\r\n' >download</a>";
        }
        
    }
	echo "					</div>
						</div> ";
    $tmp = explode( " ", "{$d['MULAI']}" );
    $tglmulai = explode( "-", $tmp[0] );
    $jammulai = $tmp[1];
    $tmp = explode( " ", "{$d['SELESAI']}" );
    $tglselesai = explode( "-", $tmp[0] );
    $jamselesai = $tmp[1];
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
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Ukuran File max</label>\r\n    
							<div class=\"col-lg-6\">
								{$d['UKURAN']} MB
							</div>
						</div>
					</div>";
    #printjudulmenukecil( "Daftar Pengumpul Tugas Kuliah" );
    echo "			<div class='portlet-title'>";
						printmesg("Daftar Pengumpul Tugas Kuliah");
	echo "			</div>";
	$q = "\r\n\t\t\tSELECT hasiltugaskuliah.*,mahasiswa.NAMA \r\n      FROM hasiltugaskuliah,mahasiswa\r\n\t\t\tWHERE IDMAKUL='{$idmakulupdate}'\r\n\t\t\tAND TAHUN='{$tahunupdate}'\r\n\t\t\tAND SEMESTER='{$semesterupdate}'\r\n\t\t\tAND hasiltugaskuliah.KELAS='{$kelasupdate}'\r\n\t\t\tAND IDBAHAN='{$idupdate}'\r\n\t\t\tAND mahasiswa.ID=hasiltugaskuliah.IDMAHASISWA\r\n\t\t\tORDER BY IDMAHASISWA\r\n\t\t";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        echo "		<form name=form action=index.php method=post>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" )."";
		echo "					<div class=\"m-section__content\">		
									<div class=\"table-responsive\">		
										<table class=\"table table-bordered table-hover\">
											<thead>
												<tr class=juduldata align=center>\r\n\t\t\t\t\t<td colspan=8 align=right>  \r\n           <input type=submit name=aksitambah value='Update' class=masukan\r\n\t\t\t\t\tonClick=\"return confirm('Simpan Nilai Hasil Tugas Kuliah?')\"\r\n\t\t\t\t\t>\r\n           <input type=submit name=aksitambah value='Hapus' class=masukan\r\n\t\t\t\t\tonClick=\"return confirm('Hapus Data Hasil Tugas Kuliah?')\"\r\n\t\t\t\t\t></td>\r\n\t\t\t\t</tr>\r\n\t\t\t\t<tr class=juduldata align=center>\r\n\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t<td>NIM Mahasiswa</td>\r\n\t\t\t\t\t<td>Nama</td>\r\n\t\t\t\t\t<td>File</td>\r\n\t\t\t\t\t<td>Catatan</td>\r\n\t\t\t\t\t<td>Tanggal Kirim</td><!--\r\n\t\t\t\t\t<td>Nilai</td>\r\n\t\t\t\t\t--><td >Pilih Hapus </td>\r\n\t\t\t\t</tr>\r\n\t\t\t";
        echo "								</thead>
											<tbody>";
		$i = 1;
        $totalbobot = 0;
        $rata2 = 0;
        $total = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            $total += $d[NILAI];
            echo "\r\n\t\t\t\t\t<tr {$kelas} valign=top align=center>\r\n\t\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\t\t\t\t\t<td align=left >{$d['IDMAHASISWA']}</td>\r\n\t\t\t\t\t\t<td align=left >{$d['NAMA']}</td>\r\n \t\t\t\t\t\t<td align=center >";
            if ( $d[FLAGFILE] == 0 )
            {
                echo "\r\n            <a target=_blank href='hasil/{$d['FILE']}'>{$d['FILE']}</a>";
            }
            else if ( $d[FLAGFILE] == 1 )
            {
                echo "\r\n            <a target=_blank href='dl.php?jenis=1&idmakulupdate={$d['IDMAKUL']}&iddosenupdate={$d['IDDOSEN']}&tahunupdate={$d['TAHUN']}&semesterupdate={$d['SEMESTER']}&kelasupdate={$d['KELAS']}&idbahan={$d['IDBAHAN']}\r\n' >download</a>";
            }
            echo "\r\n              </td>\r\n\t\t\t\t\t\t<td align=left >".htmlspecialchars_decode( $d[KET] )."</td>\r\n  \t\t\t\t\t<td nowrap>{$d['TANGGAL']}</td><!--\r\n \t\t\t\t\t\t<td align=center>".createinputtext( "data[{$d['IDMAHASISWA']}][nilai]", "{$d['NILAI']}", " class=masukan size=2" )."</td>-->\r\n \t\t\t\t\t\t<td align=center>".createinputcek( "data[{$d['IDMAHASISWA']}][hapus]", "1", "", "", " class=masukan size=4" )."</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t";
            ++$i;
        }
        $rata2 = number_format_sikad( $total / ( $i - 1 ), 2 );
        echo "\r\n         <!-- <tr>\r\n            <td align=right colspan=6><b>Rata-rata nilai</td>\r\n            <td><b>{$rata2}</td>\r\n          </tr>\r\n   -->    </table>\r\n\t\t\t</form>\r\n      <form target=_blank action=cetakhasiltugaskuliah.php method=post>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" )."   \r\n     <input type=submit value=Cetak>\r\n      </form>\r\n      \r\n      ";
		echo "							</tbody>
									</table>
								</div>
							</div>
						";
	}
    else
    {
        $errmesg = "Data Hasil Tugas Kuliah belum ada";
        printmesg( $errmesg );
    }
}
?>
