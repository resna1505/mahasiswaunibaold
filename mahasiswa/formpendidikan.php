<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $aksi2 == "formupdate" )
{
    $q = "SELECT * FROM msphs WHERE NIMHSMSPHS='{$idupdate}' AND NORUTMSPHS='{$urutan}'";
    $h2 = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $h2 ) )
    {
        $d2 = sqlfetcharray( $h2 );
    }
    $tmp = explode( "-", $d2[TGIJAMSPHS] );
    $dtk[thn] = $tmp[0];
    $dtk[tgl] = $tmp[2];
    $dtk[bln] = $tmp[1];
}
echo "	<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Jenjang Studi</label>\r\n    
			<label class=\"col-form-label\">
				".createinputselect( "strata", $arraypendidikantertinggi, "{$d2['JENJAMSPHS']}", " class=form-control m-input  ", "" )."
			</label>
		</div>
		<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">Gelar Akademik</label>\r\n    
			<label class=\"col-form-label\">
				".createinputtext( "gelar", $d2[GELARMSPHS], " class=form-control m-input  size=10" )."
			</label>
		</div> 
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Kode PT</label>\r\n    
			<div class=\"col-lg-6\">
				".createinputtext( "kodept", $d2[ASPTIMSPHS], " class=form-control m-input  size=10 id='inputStringListPT' onkeyup=\"lookupListPT(this.value);\" placeholder=\"Ketik Instansi Perguruan Tinggi...\"" )."
				<!--<a href=\"javascript:daftarpt('form,wewenang,kodept',document.form.kodept.value)\" >daftar PT</a>-->
				<div class=\"suggestionsBox\" id=\"suggestionsListPT\" style=\"display: none;\">
					<div class=\"suggestionsListPT\" id=\"autoSuggestionsListPT\"></div>
				</div>	
			</div>
		</div>
		<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">Nama PT</label>\r\n    
			<label class=\"col-form-label\">
				".createinputtext( "namapt", $d2[NMPTIMSPHS], " class=form-control m-input  size=50" )."
			</label>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Bidang Ilmu</label>\r\n    
			<label class=\"col-form-label\">
				".createinputtext( "bidangilmu", $d2[BIDILMSPHS], " class=form-control m-input  size=40" )."
			</label>
		</div>
		<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">Kota Asal</label>\r\n    
			<label class=\"col-form-label\">
				".createinputtext( "kotaasal", $d2[KOTAAMSPHS], " class=form-control m-input  size=20" )."
			</label>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Kode Negara</label>\r\n    
			<div class=\"col-lg-6\">
				".createinputtext( "kodenegara", $d2[KDNEGMSPHS], " class=form-control m-input  size=4 id='inputStringPropinsi' onkeyup=\"lookupPropinsi(this.value);\" placeholder=\"Ketik Kode / Nama Propinsi...\"" )."
				<!--<a href=\"javascript:daftarprop('form,wewenang,kodenegara',document.form.kodenegara.value)\" >daftar Propinsi/Negara</a>-->
				<div class=\"suggestionsBoxDosen\" id=\"suggestionsPropinsi\" style=\"display: none;\">
				   <div class=\"suggestionListPropinsi\" id=\"autoSuggestionsListPropinsi\"></div>
				</div>
			</div>
		</div>
		<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">Tanggal Ijazah</label>\r\n    
			<label class=\"col-form-label\">
				".createinputtanggal( "data", $dtk, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."
			</label>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Total SKS Lulus</label>\r\n    
			<label class=\"col-form-label\">
				".createinputtext( "sks", $d2[SKSTTMSPHS], " class=form-control m-input  size=3" )."
			</label>
		</div>
		<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">IPK Lulus</label>\r\n    
			<label class=\"col-form-label\">
				".createinputtext( "ipk", $d2[NLIPKMSPHS], " class=form-control m-input  size=3" )."
			</label>
		</div>
		<!--<tr class=judulform>\r\n\t\t\t<td colspan=2><hr></td>\r\n\t\t</tr>\r\n \r\n \r\n\t\t-->";
?>
