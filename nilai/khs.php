<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$seed = mt_srand( make_seed( ) );
$konversisemua = 0;
@$konf = @file( "konfig" );
if ( is_array( $konf ) )
{
    if ( trim( $konf[0] ) == "0" )
    {
        $konversisemua = 0;
    }
    else
    {
        $konversisemua = 1;
    }
}
if ( $aksi == "tampilkan" )
{
	#echo "kkk";exit();
    include( "proseslihatkhs.php" );
}
if ( $aksi == "tampilsemua" )
{
    include( "proseslihatkhs2.php" );
}
if ( $aksi == "" )
{
    #printjudulmenu( "Kartu Hasil Studi" );
    #printmesg( $errmesg );
    /*echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Kartu Hasil Studi </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
	echo "	<div class=\"page-content\">
					<div class=\"container-fluid\">
						<div class=\"row\">
							<div class=\"col-md-12\">
								<!-- BEGIN SAMPLE FORM PORTLET-->";
	echo "						<div class='portlet-title'>";
									printmesg( $errmesg );
									printmesg("Kartu Hasil Studi");										
	echo "						</div>	
							<div class=\"m-portlet\">
								<!--begin::Form-->";
    echo "						<form name=form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" action=index.php method=post>
									<input type=hidden name=pilihan value='{$pilihan}'>
									<input type=hidden name=aksi value='tampilkan'>
									<div class=\"m-portlet__body\"> ";
                        
    #echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>\r\n\t\t\t".IKONLAPORAN48."\r\n\t\t<table  class=\"table table-striped table-bordered table-hover\">\r\n    ";
    if ( $jenisusers != 2 && $jenisusers != 3 )
    {
        echo "	<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
					<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
					<div class=\"col-lg-6\">
						<select class=form-control m-input name=idprodi>
							<option value=''>Semua</option>";
							foreach ( $arrayprodidep as $k => $v )
							{
								echo "<option value='{$k}'>{$v}</option>";
							}
        echo "			</select>
					</div>
				</div>";
    }
    if ( $jenisusers == 0 )
    {
        /*echo "	<div class=\"form-group m-form__group row\">
					<label class=\"col-lg-2 col-form-label\">Dosen Wali</label>\r\n    
					<div class=\"col-lg-6\">
						<select class=form-control m-input name=iddosen>
							<option value=''>Semua</option>";
							foreach ( $arraydosendep as $k => $v )
							{
								echo "<option value='{$k}'>{$v}</option>";
							}
        echo "			</select>
					</div>
				</div>";*/
		echo "		<div class=\"form-group m-form__group row\">
						<label class=\"col-lg-2 col-form-label\">Dosen Wali</label>\r\n    
						<div class=\"col-lg-6\">".createinputtext( "iddosen", "", " class=form-control m-input  size=20 id='inputStringDosen' onkeyup=\"lookupDosen(this.value,'');\" placeholder=\"Ketik NIDN / Nama Dosen...\"" )."
							<!--<a href=\"javascript:daftardosen('form,wewenang,iddosen',document.form.iddosen.value)\" >daftar dosen</a>-->
							<div class=\"suggestionsBoxDosen\" id=\"suggestionsDosen\" style=\"display: none;\">
								<div class=\"suggestionListDosen\" id=\"autoSuggestionsListDosen\"></div>
							</div>
						</div>
					</div>";
    }
    if ( $jenisusers != 2 && $jenisusers != 3 )
    {
        echo "	<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
					<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
					<div class=\"col-lg-6\">";
						$waktu = getdate( );
        echo "			<select name=angkatan class=form-control m-input> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
							$arrayangkatan = getarrayangkatan( );
							foreach ( $arrayangkatan as $k => $v )
							{
								echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t";
							}
        echo "			</select>
					</div>
				</div>
				<div class=\"form-group m-form__group row\">
					<label class=\"col-lg-2 col-form-label\">NIM</label>\r\n    
					<div class=\"col-lg-6\">
						".createinputtext( "id", $id, " class=form-control m-input  size=20 id='inputString' onkeyup=\"lookup(this.value,form.angkatan.value,form.idprodi.value);\" placeholder=\"Ketik NIM / Nama Mahasiswa atau Alumni...\"" )."
						<!--<a href=\"javascript:daftarmhs('form,wewenang,id',document.form.id.value)\" >[ mahasiswa ]</a>
						<a href=\"javascript:daftaralumni('form,wewenang,id',\r\n\t\t\tdocument.form.id.value)\" >[ alumni ]</a>-->
						<div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">
							<div class=\"suggestionList\" id=\"autoSuggestionsList\"></div>
						</div>
					</div>
				</div>"."
					<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
						<label class=\"col-lg-2 col-form-label\">Nama</label>\r\n    
						<div class=\"col-lg-6\">".createinputtext( "nama", $nama, " class=form-control m-input  size=50" )."</div>
					</div> 
					<div class=\"form-group m-form__group row\">
						<label class=\"col-lg-2 col-form-label\">Status</label>\r\n    
						<div class=\"col-lg-6\">
							<select class=form-control m-input name=status>
								<option value=''>Semua</option>";
								foreach ( $arraystatusmahasiswa as $k => $v )
								{
									echo "<option value='{$k}'>{$v}</option>";
								}
        echo "				</select>
						</div>
					</div>";
    }
    else if ( $jenisusers == 2 || $jenisusers == 3 )
    {
        echo "		<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
						<label class=\"col-lg-2 col-form-label\">NIM</label>\r\n    
						<div class=\"col-lg-6\">{$users}</div>
					</div> ";
    }
    
    if ( $STEIINDONESIA == 1 || $UMJ == 1 || $JENISKELAS == 1 )
    {
        echo "		<div class=\"form-group m-form__group row\">
						<label class=\"col-lg-2 col-form-label\">Jenis Kelas Default</label>\r\n    
						<div class=\"col-lg-6\">
							<select name='jeniskelas' >
								<option value=''>Semua</option>\r\n      ";
								foreach ( $arraykelasstei as $k => $v )
								{
									$selected = "";
									if ( $k == $d[JENISKELAS] )
									{
										$selected = "selected";
									}
									echo "<option value='{$k}' {$selected}>{$v}</option>";
								}
        echo "				</select>
						</div>
					</div>";
    }
    echo "			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
						<label class=\"col-lg-2 col-form-label\">Tahun Akademik / Semester</label>\r\n    
						<div class=\"col-lg-6\">".createinputtahunajaransemester( 0 )."</div>
					</div>
					<div class=\"form-group m-form__group row\">
						<label class=\"col-lg-2 col-form-label\">Nilai M-K yang diambil</label>\r\n    
						<div class=\"col-lg-6\">
							<select class=form-control m-input name=nilaidiambil>";
    if ( $UNIVERSITAS != "STEI INDONESIA" )
    {
        echo "					<option value='1'>Nilai Terakhir</option>";
    }
    echo "						<option value='0' selected>Nilai Terbaik</option>
							</select>
						</div>
					</div>
					<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
						<label class=\"col-lg-2 col-form-label\">Perlakuan terhadap Nilai Kosong/Tunda</label>\r\n    
						<div class=\"col-lg-6\">
							<select class=form-control m-input name=nilaikosong>";
								if ( $UNIVERSITAS != "STEI INDONESIA" )
								{
									echo "\r\n\t\t\t\t\t\t<option value='0'>Tidak dihitung</option>\r\n            ";
								}
    echo "						<option value='1'>Dihitung</option>
							</select>
						</div>
					</div>
					<div class=\"form-group m-form__group row\">
						<label class=\"col-lg-2 col-form-label\">Nilai SP</label>\r\n    
						<div class=\"col-lg-6\">
							<div class=\"m-checkbox-list\">
								<label class=\"m-checkbox\">";
									if ( $UNIVERSITAS == "STEI INDONESIA" )
									{	
										$ceksp = "checked";
									}
	echo "							<input type=checkbox name=sp value=1 {$ceksp}>Ambil langsung dari nilai SP  (proses akan sedikit lebih lambat)
									<span></span>
								</label>
							</div>
						</div>
					</div>";
	#if ( $jenisusers != 2 && $jenisusers != 3 )
	#{
	echo "			<div class=\"form-group m-form__group row\">
						<label class=\"col-lg-2 col-form-label\">Jenis</label>
						<div class=\"col-lg-6\">
							<div class=\"m-radio-list\">
								";
    if ( $FILEKHS != "" && $UNIVERSITAS != "")
    {
        #echo "\r\n       \t\t<input type=radio class=form-control m-input name=jenistampilan value=99 checked >KHS {$UNIVERSITAS} <br>\r\n        ";
	echo "						<label class=\"m-radio\"><input type=radio class=form-control m-input name=jenistampilan value=99 checked >KHS  <br>\r\n        ";
	echo "						<span></span>
								</label>";
        $checked = "";
    }
    #else if ( $UNIVERSITAS == "" )
	else if ( $UNIVERSITAS == "" )
    {
        $checked = "checked ";
    }
    if ( $UNIVERSITAS == "UNIVERSITAS 17 AGUSTUS 1945" )
    {
    echo "						<label class=\"m-radio\"><input type=radio class=form-control m-input name=jenistampilan value=untag {$checked}>KHS {$UNIVERSITAS} - BLANKO<br>\r\n        ";
	echo "						<span></span>
								</label>";
    }
	echo "					</div>
						</div>
					</div>";
    /*echo "						<label class=\"m-radio\">
									<input type=radio class=form-control m-input name=jenistampilan value=1 {$checked}>Standar";
	echo "						<span></span>
								</label>
							</div>
						</div>
					</div>";*/
	#}					
	echo "			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
						<label class=\"col-lg-2 col-form-label\">Tanggal Laporan</label>
						<div class=\"col-lg-6\">".createinputtanggal( "tgllap", $tgllap, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."</div>
					</div>";
    #echo "\r\n\t\t\t<input type=radio class=form-control m-input name=jenistampilan value=1 checked>Standar\r\n \r\n\t\t</td>\r\n\t</tr>\r\n\t\t\t\r\n \t\t <tr class=judulform>\r\n\t\t\t<td>Tanggal Laporan</td>\r\n\t\t\t<td>".createinputtanggal( "tgllap", $tgllap, " class=form-control m-input " )."</td>\r\n\t\t</tr> \t\t\t";
    
	if ( $jenisusers != 2 && $jenisusers != 3 )
    {
        echo "		<div class=\"form-group m-form__group row\">
						<label class=\"col-lg-2 col-form-label\">Data Per Halaman</label>
						<div class=\"col-lg-6\">
							<input type=text class=form-control m-input name=dataperhalaman value='{$maxdata}' size=2>Sebaiknya nilainya diperkecil karena pemrosesan KHS akan memakan waktu relatif lama
						</div>
					</div>";
        if ( $jenisusers == 0 )
        {
            echo "	<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
						<label class=\"col-lg-2 col-form-label\">Kop Surat</label>
						<div class=\"col-lg-6\">
							<div class=\"m-radio-list\">
								<label class=\"m-radio\">
									<input type=radio class=form-control m-input name=kopsurat value='' checked>Tanpa Kop";
			echo "				<span></span>
								</label>
								<label class=\"m-radio\">
									<input type=radio class=form-control m-input name=kopsurat value='1' >Cetak Kop Surat Umum";
			echo "				<span></span>
								</label>
								<label class=\"m-radio\">
									<input type=radio class=form-control m-input name=kopsurat value='2' >Cetak Kop Surat Fakultas";
			echo "				<span></span>
								</label>
								
							</div>
						</div>
					</div>";
        }
        echo "		<div class=\"form-group m-form__group row\">
						<label class=\"col-lg-2 col-form-label\">Catatan</label>
						<div class=\"col-lg-6\">
							<textarea name=catatan cols=40 class=form-control m-input rows=5>{$catatan}</textarea>
						</div>
					</div>";
    }
    echo "			<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
						<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
						<div class=\"col-lg-6\">
							<input type=submit value='Tampilkan' class=\"btn btn-brand\">
						</div>
					</div> 
				</div>
			</form>
		</div>
	</div>
	</div>
	</div>
	</div>";
}
?>
