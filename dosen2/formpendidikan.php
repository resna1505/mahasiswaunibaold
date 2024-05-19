<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi2 == "formupdate" )
{
    $q = "SELECT * FROM mspds WHERE NODOSMSPDS='{$idupdate}' AND NORUTMSPDS='{$urutan}'";
	#echo $q;
    $h2 = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h2 ) )
    {
        $d2 = sqlfetcharray( $h2 );
    }
    $tmp = explode( "-", $d2[TGIJAMSPDS] );
    $dtk[thn] = $tmp[0];
    $dtk[tgl] = $tmp[2];
    $dtk[bln] = $tmp[1];
	
	//get ID from table riwayatpendidikandosen
	#echo $idupdate$urutan;
	if ( file_exists( "../dosen/ijazah/{$idupdate}{$urutan}" ) )
        {
            $ijazahsaatini = "\r\n\t\t\t\r\n\t\t\t<img src='../dosen/ijazah/{$idupdate}{$urutan}' border=0 width=100><br>\r\n\t\t\t";
        }
}
#echo "\r\n  \r\n\t\t\t<tr class=judulform>\r\n\t\t\t\t<td width=100>Jenjang Studi</td>\r\n\t\t\t\t<td>".createinputselect( "strata", $arraypendidikantertinggi, "{$d2['JENJAMSPDS']}", "", " class=form-control m-input  " )."</td>\r\n\t\t\t</tr>  \t\t\r\n\t\t\t<tr class=judulform>\r\n\t\t\t\t<td  >Gelar Akademik</td>\r\n\t\t\t\t<td>".createinputtext( "gelar", $d2[GELARMSPDS], " class=masukan  size=10" )."</td>\r\n\t\t\t</tr>  \t\t\r\n\t\t\t<tr class=judulform>\r\n\t\t\t\t<td  >Kode PT</td>\r\n\t\t\t\t<td>".createinputtext( "kodept", $d2[ASPTIMSPDS], " class=masukan  size=10" )."\r\n\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftarpt('form,wewenang,kodept',\r\n\t\t\tdocument.form.kodept.value)\" >\r\n\t\t\tdaftar PT\r\n\t\t\t</a>\r\n \t\t\t\t</td>\r\n\t\t\t</tr>  \t\t\r\n\r\n\t\t\t<tr class=judulform>\r\n\t\t\t\t<td  >Nama PT</td>\r\n\t\t\t\t<td>".createinputtext( "namapt", $d2[NMPTIMSPDS], " class=masukan  size=50" )."\r\n        Hanya diisi jika Kode PT tidak ada di daftar PT</td>\r\n\t\t\t</tr>  \t\t\r\n\t\t\t\r\n\t\t\t<tr class=judulform>\r\n\t\t\t\t<td  >Bidang Ilmu</td>\r\n\t\t\t\t<td>".createinputtext( "bidangilmu", $d2[BIDILMSPDS], " class=masukan  size=40" )."</td>\r\n\t\t\t</tr>  \t\t\r\n\t\t\t<tr class=judulform>\r\n\t\t\t\t<td  >Kota Asal</td>\r\n\t\t\t\t<td>".createinputtext( "kotaasal", $d2[KOTAAMSPDS], " class=masukan  size=20" )."</td>\r\n\t\t\t</tr>  \t\t\r\n\t\t\t<tr class=judulform>\r\n\t\t\t\t<td  >Kode Negara</td>\r\n\t\t\t\t<td>".createinputtext( "kodenegara", $d2[KDNEGMSPDS], " class=masukan  size=4" )."\r\n \t\t\t<a \r\n\t\t\thref=\"javascript:daftarprop('form,wewenang,kodenegara',\r\n\t\t\tdocument.form.kodenegara.value)\" >\r\n\t\t\tdaftar Propinsi/Negara\r\n\t\t\t</a>        \r\n        </td>\r\n\t\t\t</tr>  \t\t\r\n\r\n\t\t\t<tr class=judulform>\r\n\t\t\t\t<td  >Tanggal Ijazah</td>\r\n\t\t\t\t<td>".createinputtanggal( "data", $dtk, " class=masukan" )."</td>\r\n\t\t\t</tr><tr class=judulform>\r\n\t\t\t<td>File Ijazah</td>\r\n\t\t\t<td>\r\n\t\t\t{$ijazahsaatini}\r\n\t\t\t<input type=file name=ijazah class=masukan> \r\n\t\t\t</td>\r\n\t\t</tr><tr class=judulform>\r\n\t\t\t<td colspan=2><hr></td>\r\n\t\t</tr>\r\n \r\n \r\n\t\t";
echo "	<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Jenjang Studi</label>\r\n    
			<div class=\"col-lg-6\">".createinputselect( "strata", $arraypendidikantertinggi, "{$d2['JENJAMSPDS']}", "", " class=masukan  " )."</div>
		</div>
		<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
			<label class=\"col-lg-2 col-form-label\">Gelar Akademik</label>\r\n    
			<div class=\"col-lg-6\">".createinputtext( "gelar", $d2[GELARMSPDS], " class=form-control m-input  size=10" )."</div>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Kode PT</label>\r\n    
			<div class=\"col-lg-6\">".createinputtext( "kodept", $d2[ASPTIMSPDS], " class=form-control m-input  size=10 id='inputStringListPT' onkeyup=\"lookupListPT(this.value);\" placeholder=\"Ketik Instansi Perguruan Tinggi...\"" )."
				<!--<a href=\"javascript:daftarpt('form,wewenang,kodept',\r\n\t\t\tdocument.form.kodept.value)\" >daftar PT </a>-->
				<div class=\"suggestionsBox\" id=\"suggestionsListPT\" style=\"display: none;\">
					<div class=\"suggestionsListPT\" id=\"autoSuggestionsListPT\"></div>
				</div>	
			</div>
		</div>
		<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
			<label class=\"col-lg-2 col-form-label\">Nama PT</label>\r\n    
			<div class=\"col-lg-6\">".createinputtext( "namapt", $d2[NMPTIMSPDS], " class=form-control m-input  size=50" )."Hanya diisi jika Kode PT tidak ada di daftar PT</div>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Bidang Ilmu</label>\r\n    
			<div class=\"col-lg-6\">".createinputtext( "bidangilmu", $d2[BIDILMSPDS], " class=form-control m-input  size=40" )."</div>
		</div>
		<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
			<label class=\"col-lg-2 col-form-label\">Kota Asal</label>\r\n    
			<div class=\"col-lg-6\">".createinputtext( "kotaasal", $d2[KOTAAMSPDS], " class=form-control m-input  size=20" )."</div>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Kode Negara</label>\r\n    
			<div class=\"col-lg-6\">".createinputtext( "kodenegara", $d2[KDNEGMSPDS], " class=form-control m-input  size=4 id='inputStringPropinsi' onkeyup=\"lookupPropinsi(this.value);\" placeholder=\"Ketik Kode / Nama Propinsi...\"" )."
				<!--<a href=\"javascript:daftarprop('form,wewenang,kodenegara',document.form.kodenegara.value)\" >daftar Propinsi/Negara</a>-->
				<div class=\"suggestionsBoxDosen\" id=\"suggestionsPropinsi\" style=\"display: none;\">
				   <div class=\"suggestionListPropinsi\" id=\"autoSuggestionsListPropinsi\"></div>
				</div>	
			</div>
		</div>
		<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
			<label class=\"col-lg-2 col-form-label\">Tanggal Ijazah</label>\r\n    
			<div class=\"col-lg-6\">".createinputtanggal( "data", $dtk, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."</div>
		</div>
		";
?>
