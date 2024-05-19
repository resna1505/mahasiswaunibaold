<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
/*$q = "SELECT komponenpembayaran.* FROM komponenpembayaran,biayakomponen WHERE komponenpembayaran.ID=biayakomponen.IDKOMPONEN 
	AND biayakomponen.IDPRODI='{$idprodi}' AND biayakomponen.GELOMBANG='{$gelombang}' AND 
	biayakomponen.ANGKATAN='{$angkatan}'  ORDER BY komponenpembayaran.JENIS,komponenpembayaran.ID\r\n        ";
            echo $q.'<br>';*/

		#exit();	
cekhaktulis( $kodemenu );
#echo "aksi3=".$aksi3;
if($aksi3!="Lanjut"){
	
echo "		<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Tahun/Semester Mulai</label>\r\n    
								<label class=\"col-form-label\">";
$waktu = getdate( );
if ( $tahun2 == "" )
{
    $tahun2 = $waktu[year];
}
echo "\r\n\t\t\t\t\t\t<select name=tahun2 class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n\t\t\t\t\t\t ";
$selected = "";
$i = 1901;
while ( $i <= $waktu[year] + 5 )
{
    if ( $i == $tahun2 )
    {
        $selected = "selected";
    }
    echo "\r\n\t\t\t\t\t\t\t<option value='{$i}'  {$selected}>".$i."/".( $i + 1 )."</option>\r\n\t\t\t\t\t\t\t";
    $selected = "";
    ++$i;
}
echo "\r\n\t\t\t\t\t\t</select>/\r\n\t\t\t\t\t\t<select name=semester2 class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n\t\t\t\t\t\t ";
unset( $arraysemester[3] );
foreach ( $arraysemester as $k => $v )
{
    if ( $k == $semester2 )
    {
        $selected = "selected";
    }
    echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$selected}>{$v}</option>\r\n\t\t\t\t\t\t\t";
    $selected = "";
}
echo "\r\n\t\t\t\t\t\t</select>
			</label>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Tanggal Awal Tagihan</label>\r\n    
			<label class=\"col-form-label\">
				".createinputtanggal("tglawal","","class=form-control m-input style=\"width:auto;display:inline-block;\"")."</label>
		</div>
		<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">Tanggal Akhir Tagihan</label>\r\n    
			<label class=\"col-form-label\">
				".createinputtanggal("tglakhir","","class=form-control m-input style=\"width:auto;display:inline-block;\"")."</label>
		</div>
		<!--<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Komponen Pembayaran</label>\r\n  
			<div class=\"col-lg-6\">
				".createinputtext( "namakomponen", $namakomponen, " class=form-control  size=20      id='inputString' onkeyup=\"lookupkomponenbayar(this.value,form.idprodi.value,form.angkatan.value,form.gelombang.value,form.idupdate.value);\" placeholder=\"Ketik Komponen Pembayaran Baru...\"" )."
				<div class=\"suggestionsBox\" id=\"suggestionsKomponenBayar\" style=\"display: none;\">
					<div class=\"suggestionListKomponenBayar\" id=\"autoSuggestionsListKomponenBayar\"></div>
				</div>
			</div>
			".createinputhidden( "idkomponen", $idkomponen, " class=form-control  size=3  id='inputString2'")."
				
		</div>-->
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Komponen</label>\r\n    
			<label class=\"col-form-label\">          
				<select name=idkomponen  onChange='gantilabel(this.value);' class=form-control m-input> 
					<option value='' >Pilih Komponen Pembayaran</option>\r\n           ";
						foreach ( $arraykomponenpembayaran_tagihan as $k => $v )
						{
							echo "<option value='$k'>$v</option>";
						}
echo "			</select>
			</label>&nbsp;
		</div>
		<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
				<div class=\"col-lg-6\">
					<input id=aksi3 type=submit name=aksi3 value='Lanjut' class=\"btn btn-brand\"  style='display:none;'>
				</div>
			</div>";
}
if ( $aksi3 == "Lanjut" )
{
echo "	<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">Tahun Ajaran/Semester</label>
			<!--<label class=\"col-form-label\">
				".( $tahun2 - 1 )."/{$tahun2} / ".$arraysemester[$semester2]."\r\n           <input type=hidden name=tahun2 value='{$tahun2}'>\r\n           <input type=hidden name=semester2 value='{$semester2}'>
			</label>-->
			<label class=\"col-form-label\">
				".( $tahun2)."/".($tahun2+1)." / ".$arraysemester[$semester2]."\r\n           <input type=hidden name=tahun2 value='{$tahun2}'>\r\n           <input type=hidden name=semester2 value='{$semester2}'>
			</label>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Tanggal Awal Tagihan</label>\r\n    
			<label class=\"col-form-label\">
				{$tglawal['tgl']}-{$tglawal['bln']}-{$tglawal['thn']}
				<input type=hidden name='tglawal[tgl]' value='{$tglawal['tgl']}'>
				<input type=hidden name='tglawal[bln]' value='{$tglawal['bln']}'>
				<input type=hidden name='tglawal[thn]' value='{$tglawal['thn']}'>
			</label>
		</div>
		<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">Tanggal Akhir Tagihan</label>\r\n    
			<label class=\"col-form-label\">
				{$tglakhir['tgl']}-{$tglakhir['bln']}-{$tglakhir['thn']}
				<input type=hidden name='tglakhir[tgl]' value='{$tglakhir['tgl']}'>
				<input type=hidden name='tglakhir[bln]' value='{$tglakhir['bln']}'>
				<input type=hidden name='tglakhir[thn]' value='{$tglakhir['thn']}'>
			</label>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Komponen</label>\r\n    
			<label class=\"col-form-label\">
				".$arraykomponenpembayaran[$idkomponen]."
				<input type=hidden name=idkomponen value='{$idkomponen}'>
			</label>
		</div>";
			$tahunangkatan=$angkatan+1;
			$tahun2=$tahun2+1;
			$hutangmhs=getjumlahhutangmahasiswa($idupdate,$tahun2,$tahunangkatan,$semester2,$idkomponen);
			$totaltagihan=intval($hutangmhs['totalhutangmhs']);
			/*$q = "SELECT biayakomponen.* FROM biayakomponen ,komponenpembayaran\r\n             WHERE\r\n             biayakomponen.IDKOMPONEN=komponenpembayaran.ID AND\r\n             biayakomponen.IDKOMPONEN='{$idkomponen}' AND \r\n             biayakomponen.ANGKATAN='{$angkatan}' AND\r\n             biayakomponen.IDPRODI='{$idprodi}'  AND\r\n                   biayakomponen.GELOMBANG='{$gelombang}'\r\n                   {$qfieldjeniskelas}\r\n             \r\n             ";
            $h2 = doquery( $q, $koneksi );
            if ( 0 < sqlnumrows( $h2 ) )
            {
                $d2 = sqlfetcharray( $h2 );
                $databiayakomponen = $d2;
                $biaya = $d2[BIAYA];
            }*/
echo "	<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">Total Tagihan</label>\r\n    
			<label class=\"col-form-label\">
				".createinputtext( "totaltagihan","{$totaltagihan}", "id=totaltagihan class=form-control m-input" )."
			</label>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Cicilan Per Bulan</label>\r\n    
			<label class=\"col-form-label\">
				".createinputtext( "cicilan", $d2['CCLTRAKK'], " class=form-control m-input" )."
			</label>
		</div>
		<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">Syarat Minimum KRS</label>\r\n    
			<label class=\"col-form-label\">
				".createinputtext( "minimalkrs", $d2['KRS'], " class=form-control m-input" )."
			</label>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Syarat Minimum UTS</label>\r\n    
			<label class=\"col-form-label\">
				".createinputtext( "minimaluts", $d2['UTS'], " class=form-control m-input" )."
			</label>
		</div>
		<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">Syarat Minimum UAS</label>\r\n    
			<label class=\"col-form-label\">
				".createinputtext( "minimaluas", $d2['UAS'], " class=form-control m-input" )."
			</label>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Tanggal Batas Tagihan</label>\r\n    
			<label class=\"col-form-label\">
				".createinputtext( "tglbatas", $d2['TGLBATAS'], " class=form-control m-input" )."
			</label>
		</div>
		<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">Denda (%)</label>\r\n    
			<label class=\"col-form-label\">
				".createinputtext( "denda", $d2['DENDA'], " class=form-control m-input" )."
			</label>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
			<div class=\"col-lg-6\">
					<input type=\"submit\" class=\"btn btn-brand\" name=aksi2 value=Tambah></input>
					<input type=\"reset\" class=\"btn btn-secondary\" value=Reset></input>  
			</div>
		</div>";
}
echo "<script>
function gantilabel(v) {
    document.getElementById('aksi3').style.display='inline';
  if (  v=='') { // Tidak memilih
    document.getElementById('aksi3').style.display='none';
  }
 
}
</script>	    		
   	";  
?>
