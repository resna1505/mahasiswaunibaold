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
                            <table class=\"table table-striped table-bordered table-hover\">\r\n     <tr class=judulform>\r\n\t\t\t<td width=150>Jurusan/Program Studi</td>\r\n\t\t\t<td>".$arrayprodidep[$idprodi]."\r\n      </td>\r\n\t\t</tr> \r\n    <tr>\r\n      <td>NIM Mahasiswa</td>\r\n      <td><b>{$idupdate}</td>\r\n    </tr>\r\n    <tr>\r\n      <td>Nama Mahasiswa</td>\r\n      <td><b>".$namamakul."</td>\r\n    </tr>\r\n    </table></div></div></div></div></div>\r\n";
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
if ( $aksi2 == "hapus" )
{
    if ( $_GET['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Kelulusan/Cuti/Non-Aktif/DO Mahasiswa", HAPUS_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $q = "\r\n     \r\n     DELETE FROM trlsm\r\n              \r\n     WHERE\r\n     NIMHSTRLSM='{$idupdate}'\r\n     AND THSMSTRLSM='{$tahunsemester}'\r\n     ";
        doquery($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Data Kelulusan Mahasiswa berhasil dihapus";
        }
        else
        {
            $errmesg = "Data Kelulusan Mahasiswa tidak dihapus";
        }
        $aksi2 = "";
    }
}
if ( $aksi2 == "Tambah" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Kelulusan/Cuti/Non-Aktif/DO Mahasiswa", TAMBAH_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditasthnajaran( "Tahun/Semester Data", $tahun2, $semester2 );
        $vld[] = cekvaliditaskode( "Status Mahasiswa", $status, 1 );
        $vld[] = cekvaliditastanggal( "Tanggal keluar/lulus", $dtk['tgl'], $dtk['bln'], $dtk['thn'] );
        $vld[] = cekvaliditasinteger( "SKS Lulus", $data['sks'], 3 );
        $vld[] = cekvaliditasnumerik( "IPK Akhir", $data['ipk'], 5 );
        $vld[] = cekvaliditastanggal( "Tanggal SK", $tglsk['tgl'], $tglsk['bln'], $tglsk['thn'] );
        $vld[] = cekvaliditaskode( "Jalur Skripsi/Non Skripsi", $jalur, 1 );
        $vld[] = cekvaliditaskode( "Skripsi Individu/Kelompok", $individu, 1 );
        $vld[] = cekvaliditasthnbulan( "Bulan/Tahun Awal bimbingan", $tahunawal, $bulanawal );
        $vld[] = cekvaliditasthnbulan( "Bulan/Tahun Akhir bimbingan", $tahunakhir, $bulanakhir );
        $vld[] = cekvaliditaskode( "NIDN Pembimbing 1", $dosen1, 10 );
        $vld[] = cekvaliditaskode( "NIDN Pembimbing 2", $dosen2, 10 );
        $vld[] = cekvaliditaskode( "NIDN Pembimbing 3", $dosen3, 10 );
        $vld[] = cekvaliditaskode( "NIDN Pembimbing 4", $dosen4, 10 );
        $vld[] = cekvaliditaskode( "NIDN Pembimbing 5", $dosen5, 10 );
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
            if ( $bulanawal < 10 )
            {
                $bulanawal = "0{$bulanawal}";
            }
            if ( $bulanakhir < 10 )
            {
                $bulanakhir = "0{$bulanakhir}";
            }
            $tanggaldtk = "'{$dtk['thn']}-{$dtk['bln']}-{$dtk['tgl']}'";
            $tanggalsk = "'{$tglsk['thn']}-{$tglsk['bln']}-{$tglsk['tgl']}'";
            $skslulus = "'{$data['sks']}'";
            $ipkakhir = "'{$data['ipk']}'";
            if ( $status != "L" && $status != "K" && $status != "C" )
            {
                $jalur = $individu = $skripsi = $bulanawal = $bulanakhir = $tahunawal = $tahunakhir = $dosen1 = $dosen2 = $dosen3 = $dosen4 = $dosen5 = "";
                $data = "";
                $dtk = "";
                $tglsk = "";
                $tanggaldtk = "NULL";
                $skslulus = "NULL";
                $ipkakhir = "NULL";
                $tanggalsk = "NULL";
            }
            if ( $status == "L" )
            {
                $q = "SELECT  NOBLANKO  FROM trlsm WHERE STMHSTRLSM='L' AND NOBLANKO='{$data['noblanko']}' AND NIMHSTRLSM != '{$idupdate}'";
                $hl = doquery($koneksi,$q);
                if ( 0 < sqlnumrows( $hl ) )
                {
                    $data[noblanko] = "";
                    $errmesgblanko = "<br>No Blanko tidak disimpan karena sudah ada.";
                }
            }
            $q = "\r\n        INSERT INTO trlsm\r\n        (\r\n      THSMSTRLSM, KDPTITRLSM,KDPSTTRLSM,KDJENTRLSM,NIMHSTRLSM,STMHSTRLSM,TGLLSTRLSM,SKSTTTRLSM,\r\n      NLIPKTRLSM,NOSKRTRLSM,TGLRETRLSM,NOIJATRLSM,STLLSTRLSM,JNLLSTRLSM,BLAWLTRLSM,BLAKHTRLSM,\r\n      NODS1TRLSM,NODS2TRLSM,NODS3TRLSM,NODS4TRLSM, NODS5TRLSM,SIMBOL,NOBLANKO,NOTRANSKRIP,\r\n      NILAIUAPTULIS,NILAIUAPPRAKTEK,SIMBOLUAPTULIS,SIMBOLUAPPRAKTEK,PEMINATAN\r\n         )\r\n        VALUES\r\n        ('{$tahun2}{$semester2}','{$kodept}','{$kodeps}','{$kodejenjang}','{$idupdate}',\r\n        '{$status}',\r\n        {$tanggaldtk},{$skslulus},\r\n        '{$data['ipk']}','{$data['sk']}',\r\n        {$tanggalsk},'{$data['ijazah']}','{$jalur}',\r\n        '{$individu}','{$bulanawal}{$tahunawal}','{$bulanakhir}{$tahunakhir}',\r\n        '{$dosen1}','{$dosen2}','{$dosen3}','{$dosen4}','{$dosen5}' ,'{$data['simbol']}' ,'{$data['noblanko']}','{$data['notranskrip']}',\r\n        '{$d['nilaiuaptulis']}','{$d['nilaiuappraktek']}','{$d['simboluaptulis']}','{$d['simboluappraktek']}','{$d['peminatan']}' )\r\n      ";
        
	    #echo 'Transaksi='.$q.'<br>';
		    
	    doquery($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $q = "UPDATE mahasiswa\r\n             SET STATUS ='{$status}',\r\n            TANGGALKELUAR='{$dtk['thn']}-{$dtk['bln']}-{$dtk['tgl']}',\r\n            TAHUNLULUS='{$dtk['thn']}'\r\n            WHERE ID='{$idupdate}' \r\n            ";
               # echo 'Mahasiswa='.$q.'<br>';
		doquery($koneksi,$q);
                $q = "UPDATE msmhs SET STMHSMSMHS ='{$status}',TGLLSMSMHS='{$dtk['thn']}-{$dtk['bln']}-{$dtk['tgl']}'\r\n            WHERE NIMHSMSMHS='{$idupdate}' \r\n            ";
               # echo 'MASTER='.$q.'<br>';
		doquery($koneksi,$q);
                $errmesg = "Data Kelulusan Mahasiswa berhasil disimpan {$errmesgblanko}";
            }
            else
            {
                $errmesg = "Data Kelulusan Mahasiswa tidak disimpan {$errmesgblanko}";
            }
        }
    }
    $aksi2 = "formtambah";
}
if ( $aksi2 == "Simpan" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Kelulusan/Cuti/Non-Aktif/DO Mahasiswa", SIMPAN_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditasthnajaran( "Tahun/Semester Data", $tahun2, $semester2 );
        $vld[] = cekvaliditaskode( "Status Mahasiswa", $status, 1 );
        $vld[] = cekvaliditastanggal( "Tanggal keluar/lulus", $dtk['tgl'], $dtk['bln'], $dtk['thn'] );
        $vld[] = cekvaliditasinteger( "SKS Lulus", $data['sks'], 3 );
        $vld[] = cekvaliditasnumerik( "IPK Akhir", $data['ipk'], 5 );
        $vld[] = cekvaliditastanggal( "Tanggal SK", $tglsk['tgl'], $tglsk['bln'], $tglsk['thn'] );
        $vld[] = cekvaliditaskode( "Jalur Skripsi/Non Skripsi", $jalur, 1 );
        $vld[] = cekvaliditaskode( "Skripsi Individu/Kelompok", $individu, 1 );
        $vld[] = cekvaliditasthnbulan( "Bulan/Tahun Awal bimbingan", $tahunawal, $bulanawal );
        $vld[] = cekvaliditasthnbulan( "Bulan/Tahun Akhir bimbingan", $tahunakhir, $bulanakhir );
        $vld[] = cekvaliditaskode( "NIDN Pembimbing 1", $dosen1, 10 );
        $vld[] = cekvaliditaskode( "NIDN Pembimbing 2", $dosen2, 10 );
        $vld[] = cekvaliditaskode( "NIDN Pembimbing 3", $dosen3, 10 );
        $vld[] = cekvaliditaskode( "NIDN Pembimbing 4", $dosen4, 10 );
        $vld[] = cekvaliditaskode( "NIDN Pembimbing 5", $dosen5, 10 );
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
            if ( $bulanawal < 10 )
            {
                $bulanawal = "0{$bulanawal}";
            }
            if ( $bulanakhir < 10 )
            {
                $bulanakhir = "0{$bulanakhir}";
            }
            $tanggaldtk = "'{$dtk['thn']}-{$dtk['bln']}-{$dtk['tgl']}'";
            $tanggalsk = "'{$tglsk['thn']}-{$tglsk['bln']}-{$tglsk['tgl']}'";
            $skslulus = "'{$data['sks']}'";
            $ipkakhir = "'{$data['ipk']}'";
            if ( $status != "L" && $status != "K" && $status != "C" )
            {
                $jalur = $individu = $skripsi = $bulanawal = $bulanakhir = $tahunawal = $tahunakhir = $dosen1 = $dosen2 = $dosen3 = $dosen4 = $dosen5 = "";
                $data = "";
                $dtk = "";
                $tglsk = "";
                $tanggaldtk = "NULL";
                $skslulus = "NULL";
                $ipkakhir = "NULL";
                $tanggalsk = "NULL";
            }
            $errmesgblanko = "";
            $qblanko = "";
            if ( $status == "L" )
            {
                $q = "SELECT  NOBLANKO  FROM trlsm WHERE STMHSTRLSM='L' AND NOBLANKO='{$data['noblanko']}' AND NIMHSTRLSM != '{$idupdate}'";
                $hl = doquery($koneksi,$q);
                if ( 0 < sqlnumrows( $hl ) )
                {
                    $data[noblanko] = "";
                    $errmesgblanko = "<br>No Blanko tidak disimpan karena sudah ada.";
                }
                else
                {
                    $qblanko = ",\r\n      NOBLANKO='{$data['noblanko']}'";
                }
            }
            $q = "\r\n      UPDATE trlsm\r\n      SET\r\n      SIMBOL='{$data['simbol']}',\r\n      THSMSTRLSM='{$tahun2}{$semester2}',\r\n      KDPTITRLSM ='{$kodept}',KDPSTTRLSM ='{$kodeps}',KDJENTRLSM='{$kodejenjang}',\r\n       STMHSTRLSM='{$status}',\r\n      TGLLSTRLSM={$tanggaldtk},SKSTTTRLSM={$skslulus},\r\n      NLIPKTRLSM={$ipkakhir},NOSKRTRLSM='{$data['sk']}',TGLRETRLSM={$tanggalsk},\r\n      NOIJATRLSM='{$data['ijazah']}',STLLSTRLSM='{$jalur}',\r\n       \r\n      JNLLSTRLSM='{$individu}',BLAWLTRLSM='{$bulanawal}{$tahunawal}',BLAKHTRLSM='{$bulanakhir}{$tahunakhir}',\r\n      NODS1TRLSM='{$dosen1}',NODS2TRLSM='{$dosen2}',NODS3TRLSM='{$dosen3}',NODS4TRLSM='{$dosen4}',\r\n      NODS5TRLSM='{$dosen5}' ,\r\n      NOTRANSKRIP='{$data['notranskrip']}',\r\n      NILAIUAPTULIS='{$data['nilaiuaptulis']}',\r\n      NILAIUAPPRAKTEK='{$data['nilaiuappraktek']}',\r\n      SIMBOLUAPTULIS='{$data['simboluaptulis']}',\r\n      SIMBOLUAPPRAKTEK='{$data['simboluappraktek']}',\r\n      PEMINATAN='{$data['peminatan']}'\r\n      {$qblanko}\r\n      WHERE NIMHSTRLSM = '{$idupdate}' AND \r\n      THSMSTRLSM='{$tahunsemester}'\r\n     ";
            doquery($koneksi,$q);
            echo mysqli_error($koneksi);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $tahunsemester = "{$tahun2}{$semester2}";
                $errmesg = "Data Kelulusan Mahasiswa berhasil disimpan {$errmesgblanko}";
            }
            else
            {
                $errmesg = "Data Kelulusan Mahasiswa tidak disimpan {$errmesgblanko}";
            }
        }
    }
    $aksi2 = "formupdate";
}
echo "\r\n<br>\r\n<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">\r\n  <tr >\r\n  <td width=50% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=formtambah&idupdate={$idupdate}'> ".IKONTAMBAH." Tambah Data Baru </td>\r\n  <td width=50% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=tampilkan&idupdate={$idupdate}'> ".IKONUPDATE." Edit Data Lama</td>\r\n  </tr>\r\n</table></div></div>\r\n";
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
printmesg( $errmesg );
if ( $aksi2 == "formupdate" )
{
    /*echo "\r\n  <br>\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tahunsemester", "{$tahunsemester}", "" )."\r\n \r\n  ";
    */
	echo createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tahunsemester", "{$tahunsemester}", "" )."\r\n \r\n  ";
	include( "formlulus.php" );
    #echo "\r\n \t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t".IKONUPDATE48."\r\n\t\t\t\t\t<input type=submit name=aksi2 value='Simpan' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  </table>\r\n  </form>\r\n </div></div> ";
	echo "					<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
								<div class=\"col-lg-6\">
									<input type=submit name=aksi2 value='Simpan' class=\"btn btn-brand\">
									<input type=reset value='Reset' class=\"btn btn-secondary\">
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
                            <table class=\"table table-striped table-bordered table-hover\">".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" )."\r\n \r\n  ";
    */
	echo createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" )."\r\n \r\n  ";
	include( "formlulus.php" );
    #echo "\r\n \t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t".IKONUPDATE48."\r\n\t\t\t\t\t<input type=submit name=aksi2 value='Tambah' class=\"btn blue\">\r\n\t\t\t\t\t<input type=reset value='Reset' class=\"btn red \">\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  </table>\r\n </div></div></div></div> </form>\r\n  ";
	echo "					<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
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
    $q = "SELECT * FROM trlsm WHERE NIMHSTRLSM='{$idupdate}' ORDER BY THSMSTRLSM DESC";
    $h = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        #echo "\r\n    <br>\r\n      <table class=data{$cetak}>\r\n        <tr class=juduldata{$cetak} align=center>\r\n          <td>No.</td>\r\n          <td>Tahun / Semester Lapor</td>\r\n          <td>Status Aktivitas</td>\r\n          <td>Tanggal Keluar/Lulus</td>\r\n          <td>Total SK Lulus</td>\r\n          <td>IPK Akhir</td>\r\n          <td>Nomor S.K. Yudisium</td>\r\n          <td>Tanggal S.K. Yudisium</td>\r\n          <td>Nomor Seri Ijazah</td>\r\n          <td>Jalur</td>\r\n          <td>Skripsi Individu atau Kelompok</td>\r\n          <td>Bulan-Tahun Awal Bimbingan</td>\r\n          <td>Bulan-Tahun Akhir Bimbingan</td>\r\n          <td>NIDN Dosen Pembimbing #1</td>\r\n          <td>NIDN Dosen Pembimbing #2</td>\r\n \r\n            <td colspan=2>Aksi</td>\r\n        </tr>";
        /*  echo "\r\n    <br>\r\n    <div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped2 table-bordered table-hover\"{$cetak}>\r\n        <tr class=juduldata{$cetak} align=center>\r\n          <td>No.</td>\r\n          <td>Tahun / Semester Lapor</td>\r\n          <td>Status Aktivitas</td>\r\n          <td>Tanggal Keluar / Lulus</td>\r\n          <td>Total SKS Lulus</td>\r\n          <td>IPK Akhir</td>\r\n          <td>Nomor S.K. Yudisium</td><td>Tanggal S.K. Yudisium</td><td>Nomor Seri Ijazah</td><td>Jalur</td><td>Skripsi Individu / Kelompok</td>  <td>Bulan-Tahun Awal Bimbingan</td>\r\n          <td>Bulan-Tahun Akhir Bimbingan</td>\r\n          <td>NIDN Dosen Pembimbing #1</td>\r\n          <td>NIDN Dosen Pembimbing #2</td>\r\n \r\n          <td colspan=2>Aksi</td>\r\n        </tr>";
      
		*/
		echo "<div class=\"m-portlet\">			
				<div class=\"m-section__content\">
					<div class=\"table-responsive\">
						<table class=\"table table-bordered table-hover\">
							<thead>
								<tr class=juduldata{$cetak} align=center>\r\n          <td>No.</td>\r\n          <td>Tahun / Semester Lapor</td>\r\n          <td>Status Aktivitas</td>\r\n          <td>Tanggal Keluar / Lulus</td>\r\n          <td>Total SKS Lulus</td>\r\n          <td>IPK Akhir</td>\r\n          <td>Nomor S.K. Yudisium</td><td>Tanggal S.K. Yudisium</td><td>Nomor Seri Ijazah</td><td>Jalur</td><td>Skripsi Individu / Kelompok</td>  <td>Bulan-Tahun Awal Bimbingan</td>\r\n          <td>Bulan-Tahun Akhir Bimbingan</td>\r\n          <td>NIDN Dosen Pembimbing #1</td>\r\n          <td>NIDN Dosen Pembimbing #2</td>\r\n \r\n          <td colspan=2>Aksi</td>\r\n        </tr>";
		echo "				</thead>
							<tbody>";
		$i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            $tmp = explode( "-", $d2[TGLLSTRLSM] );
            $dtk[thn] = $tmp[0];
            $dtk[tgl] = $tmp[2];
            $dtk[bln] = $tmp[1];
            $tmp = explode( "-", $d[TGLRETRLSM] );
            $tglsk[thn] = $tmp[0];
            $tglsk[tgl] = $tmp[2];
            $tglsk[bln] = $tmp[1];
            $tmp = $d[THSMSTRLSM];
            $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
            $semester = $tmp[4];
            $tmp = $d[BLAWLTRLSM];
            $bulanawal = $tmp[0].$tmp[1];
            $tahunawal = $tmp[2].$tmp[3].$tmp[4].$tmp[5];
            $tmp = $d[BLAKHTRLSM];
            $bulanakhir = $tmp[0].$tmp[1];
            $tahunakhir = $tmp[2].$tmp[3].$tmp[4].$tmp[5];
            echo "\r\n            <tr valign=top align=center {$kelas}{$cetak}>\r\n          <td>{$i}</td>\r\n          <td nowrap align=left>{$tahun} ".$arraysemester[$semester]." </td>\r\n          <td>".$arraystatusmahasiswa[$d[STMHSTRLSM]]."</td>\r\n          <td nowrap>{$d['TGLLSTRLSM']}</td>\r\n          <td>{$d['SKSTTTRLSM']}</td>\r\n          <td>{$d['NLIPKTRLSM']}</td>\r\n          <td>{$d['NOSKRTRLSM']}</td>\r\n          <td nowrap>{$d['TGLRETRLSM']}</td>\r\n          <td>{$d['NOIJATRLSM']}</td>\r\n          <td>".$arrayjalurskripsi[$d[STLLSTRLSM]]."</td>\r\n          <td>".$arrayskripsiindividu[$d[JNLLSTRLSM]]."</td>\r\n          <td>{$bulanawal}-{$tahunawal}</td>\r\n          <td>{$bulanakhir}-{$tahunakhir}</td>\r\n          <td>{$d['NODS1TRLSM']}</td>\r\n          <td>{$d['NODS2TRLSM']}</td>\r\n           \r\n          <td><a href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&idupdate={$idupdate}&tahunsemester={$d['THSMSTRLSM']}&aksi2=formupdate'><i class=\"fa fa-edit\"></i></td>              \r\n          <td><a onClick='return confirm(\"Hapus Data pelaporan Kelulusan Mahasiswa?\")' href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&idupdate={$idupdate}&tahunsemester={$d['THSMSTRLSM']}&aksi2=hapus&sessid={$_SESSION['token']}'><i class=\"fa fa-trash\"></i></td>              \r\n          </tr>\r\n          ";
            ++$i;
        }
        #echo "\r\n      </table>\r\n    ";
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
        printmesg( "Data  Kelulusan Mahasiswa tidak ada" );
		echo "</p>";
    }
    echo "\r\n   \r\n  ";
}
?>
