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
    $ketlog = "Update data ijazah/transkrip Mahasiswa dengan ID={$idupdate}  ";
    buatlog( 13 );
    $errmesg = "Data Mahasiswa berhasil diupdate";
    if ( $transkrip != "" )
    {
        move_uploaded_file( $transkrip, "transkrip/{$idupdate}" );
    }
    if ( $ijazah != "" )
    {
        move_uploaded_file( $ijazah, "ijazah/{$idupdate}" );
    }
}
if ( $aksi == "formupdate" )
{
    cekhaktulis( $kodemenu );
    $q = "SELECT \r\n\tmahasiswa.*,prodi.JENIS \r\n\tFROM mahasiswa,prodi WHERE \r\n\tmahasiswa.ID='{$idupdate}'\r\n\tAND prodi.ID=mahasiswa.IDPRODI\r\n\t";
    $h = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        printmesg( $errmesg );
        $d = sqlfetcharray( $h );
        $tmp = explode( "-", $d[TANGGAL] );
        $d[thn] = $tmp[0];
        $d[tgl] = $tmp[2];
        $d[bln] = $tmp[1];
        $tmp = explode( "-", $d[TANGGALMASUK] );
        $dtm[thn] = $tmp[0];
        $dtm[tgl] = $tmp[2];
        $dtm[bln] = $tmp[1];
        $tmp = explode( "-", $d[TANGGALKELUAR] );
        $dtk[thn] = $tmp[0];
        $dtk[tgl] = $tmp[2];
        $dtk[bln] = $tmp[1];
        $idprodi = getfield( "IDPRODI", "mahasiswa", " WHERE ID='{$idupdate}'" );
        $namamakul = getfield( "NAMA", "mahasiswa", " WHERE ID='{$idupdate}'" );
        /*echo "\r\n<br>\r\n  <div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">\r\n     <tr class=judulform>\r\n\t\t\t<td width=150>Jurusan/Program Studi</td>\r\n\t\t\t<td>".$arrayprodidep[$idprodi]."\r\n      </td>\r\n\t\t</tr> \r\n    <tr>\r\n      <td>NIM Mahasiswa</td>\r\n      <td><b>{$idupdate}</td>\r\n    </tr>\r\n    <tr>\r\n      <td>Nama Mahasiswa</td>\r\n      <td><b>".$namamakul."</td>\r\n    </tr>\r\n    </table></div></div>\r\n";
        */
		echo "		<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=\"form\" action=\"index.php\" method=\"post\" ENCTYPE='MULTIPART/FORM-DATA'>
					".createinputhidden( "pilihan", $pilihan, "" ).
					createinputhidden( "aksi", "update", "" ).
					createinputhidden( "idupdate", "{$idupdate}", "" ).
					createinputhidden( "tab", "{$tab}", "" )."	
					<div class=\"m-portlet__body\">	";
		echo "			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$arrayprodidep[$idprodi]."</label>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">NIM Mahasiswa</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>{$idupdate}</b></label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Nama Mahasiswa</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>".$namamakul."</b></label>
						</div>";
		if ( file_exists( "transkrip/{$idupdate}" ) )
        {
            $transkripsaatini = "\r\n        <img src='transkrip/{$idupdate}' width=600><br>\r\n      ";
        }
        if ( file_exists( "ijazah/84108008" ) )
        {
            $ijazahsaatini = "\r\n        <img src='ijazah/{$idupdate}' width=600><br>\r\n      ";
        }
        /*echo "\r\n\t\t<br>\r\n\t\t<form name=form action=index.php method=post  ENCTYPE='MULTIPART/FORM-DATA'>\r\n\t\t<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tab", "{$tab}", "" )." <tr class=judulform>\r\n\t\t\t<td>File Transkrip</td>\r\n\t\t\t<td>\r\n\t\t\t{$transkripsaatini}\r\n\t\t\t<input type=file name=transkrip class=masukan> \r\n\t\t\t</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>File Ijazah</td>\r\n\t\t\t<td>\r\n\t\t\t{$ijazahsaatini}\r\n\t\t\t<input type=file name=ijazah class=masukan> \r\n\t\t\t</td>\r\n\t\t</tr>    \r\n \r\n\t\r\n \t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t".IKONUPDATE48."\r\n\t\t\t\t\t<input type=submit value='Update' class=\"btn blue\">\r\n\t\t\t\t\t<input type=reset value='Reset' class=\"btn red\">\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table></div></div></div></div></div>\r\n\t\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t\t";
		*/
		
		echo "			<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">File Transkrip</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
								{$transkripsaatini}\r\n\t\t\t<input type=file name=transkrip class=masukan>
							</label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">File Ijazah</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
								{$ijazahsaatini}<input type=file name=ijazah class=masukan>
							</label>
						</div> 
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
							<div class=\"col-lg-6\">
								<input type=submit value='Update' class=\"btn btn-brand\">
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
