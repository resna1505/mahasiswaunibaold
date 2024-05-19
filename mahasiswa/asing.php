<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi == "update" && $REQUEST_METHOD == POST )
{
    cekhaktulis( $kodemenu );
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Mahasiswa Asing", HAPUS_DATA );
        unset( $_SESSION['token'] );
    }
    else if ( $aksi2 == "Hapus" )
    {
        $q = "delete from trmln WHERE NIMHSTRMLN='{$idupdate}'";
        doquery($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Data Status Mahasiswa berhasil dihapus";
        }
        else
        {
            $errmesg = "Data Mahasiswa tidak dihapus";
        }
    }
    else
    {
        $vld[] = cekvaliditasnama( "Kode Negara Asal", $ptasal );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
            unset( $vld );
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
            $q = "SELECT * FROM trmln WHERE NIMHSTRMLN='{$idupdate}'";
            $h2 = doquery($koneksi,$q);
            if ( sqlnumrows( $h2 ) <= 0 )
            {
                $q = "INSERT INTO trmln (KDPTITRMLN,KDJENTRMLN,KDPSTTRMLN,NIMHSTRMLN) \r\n      VALUES ('{$kodept}','{$kodejenjang}','{$kodeps}','{$idupdate}') ";
                doquery($koneksi,$q);
            }
            if ( $bulanawal < 10 )
            {
                $bulanawal = "0{$bulanawal}";
            }
            if ( $bulanakhir < 10 )
            {
                $bulanakhir = "0{$bulanakhir}";
            }
            if ( $status != "L" )
            {
                $individu = $skripsi = $bulanawal = $bulanakhir = $tahunawal = $tahunakhir = $dosen1 = $dosen2 = $dosen3 = $dosen4 = $dosen5 = "";
                $data = "";
                $dtk = "";
                $tglsk = "";
            }
            $q = "\r\n      UPDATE trmln\r\n      SET\r\n       KDPTITRMLN ='{$kodept}',KDPSTTRMLN ='{$kodeps}',KDJENTRMLN='{$kodejenjang}',\r\n       KDNEGTRMLN='{$ptasal}' \r\n       WHERE NIMHSTRMLN = '{$idupdate}'\r\n     ";
            doquery($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $ketlog = "Update data Mahasiswa dengan ID={$idupdate} ({$data['nama']})";
                buatlog( 13 );
                $errmesg = "Data Mahasiswa berhasil diupdate";
            }
            else
            {
                $errmesg = "Data Mahasiswa tidak diupdate";
            }
        }
    }
}
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
if ( $aksi == "formupdate" )
{
    cekhaktulis( $kodemenu );
    $q = "SELECT \r\n\tmahasiswa.IDPRODI,mahasiswa.ID,mahasiswa.NAMA,\r\n  prodi.JENIS \r\n\tFROM mahasiswa,prodi WHERE \r\n\tmahasiswa.ID='{$idupdate}'\r\n\tAND prodi.ID=mahasiswa.IDPRODI\r\n\t";
    $h = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        printmesg( $errmesg );
        $d = sqlfetcharray( $h );
        $q = "SELECT * FROM trmln WHERE NIMHSTRMLN='{$idupdate}'";
        $h2 = doquery($koneksi,$q);
        $d2 = sqlfetcharray( $h2 );
        echo "<br>";
        printmesg( "Data Status Mahasiswa Asing belum ada." );
        $tmp = explode( "-", $d2[TGLLSTRLSM] );
        $dtk[thn] = $tmp[0];
        $dtk[tgl] = $tmp[2];
        $dtk[bln] = $tmp[1];
        $tmp = explode( "-", $d2[TGLRETRLSM] );
        $tglsk[thn] = $tmp[0];
        $tglsk[tgl] = $tmp[2];
        $tglsk[bln] = $tmp[1];
        $tmp = $d2[THSMSTRLSM];
        $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
        $semester = $tmp[4];
        $tmp = $d2[BLAWLTRLSM];
        $bulanawal = $tmp[0].$tmp[1];
        $tahunawal = $tmp[2].$tmp[3].$tmp[4].$tmp[5];
        if ( file_exists( "foto/{$d['ID']}" ) )
        {
            $fotosaatini = "\r\n\t\t\t\r\n\t\t\t<img src='foto/{$d['ID']}' border=0 width=100><br>\r\n\t\t\t";
        }
        /*echo "\r\n\t\t<br>\r\n\t\t<form name=form action=index.php method=post  ENCTYPE='MULTIPART/FORM-DATA'>\r\n\t\t<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "idprodi", $d[IDPRODI], "" ).createinputhidden( "tab", "{$tab}", "" )."<tr class=judulform>\r\n\t\t\t<td>Jurusan/Program Studi</td>\r\n\t\t\t<td>".$arrayprodidep[$d[IDPRODI]]."\r\n      </td>\r\n\t\t</tr> \r\n    <tr class=judulform>\r\n\t\t\t<td>NIM </td>\r\n\t\t\t<td>{$d['ID']}</td>\r\n\t\t</tr> \t\t \r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Nama  </td>\r\n\t\t\t<td>{$d['NAMA']}</td>\r\n\t\t</tr> \r\n \r\n    <tr class=judulform>\r\n\t\t\t<td>Kode Negara Asal</td>\r\n\t\t\t<td>".createinputtext( "ptasal", $d2[KDNEGTRMLN], " class=masukan  size=10" )."\r\n  \t\t\t<a \r\n\t\t\thref=\"javascript:daftarnegara('form,wewenang,ptasal',\r\n\t\t\tdocument.form.ptasal.value)\" >\r\n\t\t\tdaftar Negara\r\n\t\t\t</a>     <br>\r\n\t\t\t<b>".getnegara( $d2[KDNEGTRMLN] )."</b>\r\n      \r\n      </td>\r\n\t\t</tr>\r\n  \r\n \r\n    \t\r\n \t\t<tr class=judulform>\r\n\t\t\t<td colspan=2><hr></td>\r\n\t\t</tr>\r\n  \t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t".IKONUPDATE48."\r\n\t\t\t\t\t<input type=submit value='Update' class=\"btn blue\">\r\n\t\t\t\t".IKONHAPUS."\r\n\t\t\t\t\t<input type=submit name=aksi2 value='Hapus' class=\"btn red\">\r\n\t\t\t\t\t<input type=reset value='Reset' class=\"btn yellow\">\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</div></div></div></div></div></form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t\t";
		*/
		echo "	<div class=\"m-portlet\">
					<!--begin::Form-->
					<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=\"form\" action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'>
						".createinputhidden( "pilihan", $pilihan, "" ).
						createinputhidden( "aksi", "update", "" ).
						createinputhidden( "idupdate", "{$idupdate}", "" ).
						createinputhidden( "sessid", $_SESSION['token'], "" ).
						createinputhidden( "idprodi", $d[IDPRODI], "" ).
						createinputhidden( "tab", "{$tab}", "" )."
						<div class=\"m-portlet__body\">	";
		echo "			<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
							<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$arrayprodidep[$d[IDPRODI]]."</label>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">NIM Mahasiswa</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>{$d['ID']}</b></label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
							<label class=\"col-lg-2 col-form-label\">Nama Mahasiswa</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>{$d['NAMA']}</b></label>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Kode Negara Asal</label>\r\n    
							<div class=\"col-lg-6\">
								".createinputtext( "ptasal", $d2[KDNEGTRMLN], " class=form-control m-input  size=10 id='inputStringPropinsi' onkeyup=\"lookupPropinsi(this.value);\" placeholder=\"Ketik Kode / Nama Propinsi...\"" )."
								<!--<a href=\"javascript:daftarnegara('form,wewenang,ptasal',document.form.ptasal.value)\" >daftar Negara</a>-->
								<div class=\"suggestionsBoxDosen\" id=\"suggestionsPropinsi\" style=\"display: none;\">
								   <div class=\"suggestionListPropinsi\" id=\"autoSuggestionsListPropinsi\"></div>
								</div>	
								<br>
								<b>".getnegara( $d2[KDNEGTRMLN] )."</b>
							</div>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
							<div class=\"col-lg-6\">
								<input type=submit value='Update' class=\"btn btn-brand\">
								<input type=submit name=aksi2 value='Hapus' class=\"btn btn-secondary\">
								<input type=reset value='Reset' class=\"btn btn-secondary\">
							</div>
						</div>";
	}
    else
    {
        $errmesg = "Data Mahasiswa dengan ID = '{$idupdate}' tidak ada";
        $aksi = "";
    }
}
?>
