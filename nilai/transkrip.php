<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
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
    if ( $diagram == 1 )
    {
        delgambartemp();
        $seed = mt_srand(make_seed());
        $folder = "gambardiagram/";
        $ombangambing = 1;
    }
	#echo "aaa";exit();
    include( "proseslihattranskrip.php" );
}

if ( $aksi == "" )
{
    #printjudulmenu( "Transkrip Nilai" );
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
                                <span class=\"caption-subject bold uppercase\"> Transkrip Nilai </span>
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
		echo "					<div class='portlet-title'>";
									printmesg( $errmesg );
									printmesg("Transkrip Nilai");										
		echo "					</div>	
							<div class=\"m-portlet\">
								<!--begin::Form-->";
    echo "						<form name=form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" action=index.php method=post>
									<input type=hidden name=pilihan value='{$pilihan}'>
									<input type=hidden name=aksi value='tampilkan'>
									<div class=\"m-portlet__body\"> ";
    if ( $jenisusers != 2 && $jenisusers != 3 )
    {
        echo "	<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
					<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
					<div class=\"col-lg-6\">
						<select class=form-control m-input name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
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
        /*echo "	<div class=\"form-group m-form__group row\" >
					<label class=\"col-lg-2 col-form-label\">Dosen Wali</label>\r\n    
					<div class=\"col-lg-6\">
						<select class=form-control m-input name=iddosen>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
							foreach ( $arraydosendep as $k => $v )
							{
								echo "<option value='{$k}'>{$v}</option>";
							}
        echo "			</select>
					</div>
				</div>";*/
		echo "							<div class=\"form-group m-form__group row\">
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
				<div class=\"form-group m-form__group row\" >
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
					<div class=\"form-group m-form__group row\" >
						<label class=\"col-lg-2 col-form-label\">Status</label>\r\n    
						<div class=\"col-lg-6\">
							<select class=form-control m-input name=status>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
								foreach ( $arraystatusmahasiswa as $k => $v )
								{
									echo "<option value='{$k}'>{$v}</option>";
								}
        echo "				</select>
						</div>
					</div>";
    }
    if ( ( $STEIINDONESIA == 1 || $UMJ == 1 || $JENISKELAS == 1 ) && $jenisusers != 2 && $jenisusers != 3 )
    {
        echo "	<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
					<label class=\"col-lg-2 col-form-label\">Jenis Kelas Default</label>   
					<div class=\"col-lg-6\">
						<select name='jeniskelas'>
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
        echo "			</select>
					</div>
				</div>";
    }
    echo "	<div class=\"form-group m-form__group row\" >
				<label class=\"col-lg-2 col-form-label\">Nilai M-K yang diambil</label>   
				<div class=\"col-lg-6\">
					<select class=form-control m-input name=nilaidiambil>";
						if ( $UNIVERSITAS != "STEI INDONESIA" )
						{
							echo "\r\n\t\t\t\t\t\t<option value='1'>Nilai Terakhir</option>";
						}
    echo "				<option value='0' selected>Nilai Terbaik</option>";
    echo "			</select>
				</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">Perlakuan terhadap Nilai Kosong/Tunda</label>\r\n    
				<div class=\"col-lg-6\">
					<select class=form-control m-input name=nilaikosong>";
						if ( $UNIVERSITAS != "STEI INDONESIA" )
						{
							echo "<option value='1'>Dihitung</option>\r\n\t\t\t\t\t\t<option value='0'>Tidak dihitung</option>";
						}
						else
						{
							echo "<option value='0'>Tidak dihitung</option>";
						}
    echo "			</select>
				</div>
			</div>
			<div class=\"form-group m-form__group row\" >
				<label class=\"col-lg-2 col-form-label\">Penempatan Semester Mata Kuliah</label>\r\n    
				<div class=\"col-lg-6\">
					<select class=form-control m-input name=penempatansemester>
						<option value='1'>Kurikulum</option>
						<option value='0'>Master Mata Kuliah</option>
					</select>
				</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">Nilai SP</label>
				<div class=\"col-lg-6\">
					<div class=\"m-checkbox-list\">
						<label class=\"m-checkbox\">";
							if ( $UNIVERSITAS == "STEI INDONESIA" )
							{
								$ceksp = "checked";
							}
    echo "					<input class=form-control m-input type=checkbox name=sp value=1 {$ceksp}>Ambil langsung dari nilai SP  (proses akan sedikit lebih lambat)
						<span></span>
						</label>
					</div>	
				</div>
			</div>
			<!--<div class=\"form-group m-form__group row\" >
				<label class=\"col-lg-2 col-form-label\">Cetak Diagram</label>
				<div class=\"col-lg-6\">
					<div class=\"m-radio-list\">
						<label class=\"m-radio\">
							<input type=radio class=form-control m-input name=diagram value=1 >Ya
							<span></span>
						</label>
						<label class=\"m-radio\">						
							<input type=radio class=form-control m-input name=diagram value=0 checked>Tidak
							<span></span>
						</label>
					</div>
				</div>
			</div>-->
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">Jenis Transkrip</label>
				<div class=\"col-lg-6\">
						<div class=\"m-radio-list\">
								";
					$checked = "checked ";
					if ( $FILETRANSKRIP != "" )
					{
						#echo "\r\n       \t\t<input type=radio class=form-control m-input name=jenistampilan value=99 checked >Transkrip {$UNIVERSITAS} ";
						echo "<label class=\"m-radio\"><input type=radio class=form-control m-input name=jenistampilan value=99 checked >Transkrip Bahasa Indonesia ";
						if ( $CSV == 1 )
						{
							echo "\r\n             <input type=checkbox name=iscsv value=1> CSV";
						}
						echo "<span></span>
								</label>";
						$checked = "";
					}
					if ( $UNIVERSITAS == "UNIKAL" )
					{
						echo "<label class=\"m-radio\">";
							echo "\r\n  \t\t\t<input type=radio class=form-control m-input name=jenistampilan value=unikal1 {$checked}>Transkrip UNIKAL <br>\r\n        ";
							echo "\r\n  \t\t\t<input type=radio class=form-control m-input name=jenistampilan value=unikal2 {$checked}>Transkrip Sementara UNIKAL <br>\r\n        ";
						echo "<span></span>
								</label>";
					}
					else if ( $UNIVERSITAS == "MITRA RIA HUSADA" )
					{
						echo "<label class=\"m-radio\">";
							echo "\r\n  \t\t\t<input type=radio class=form-control m-input name=jenistampilan value=mrh {$checked}>Transkrip MITRA RIA HUSADA (2) <br>\r\n        ";
						echo "<span></span>
								</label>";
					}
					#else if ( $UNIVERSITAS == "UNIVERSITAS BATAM" )
					#{
					#    echo "\r\n  \t\t\t<input type=radio class=form-control m-input name=jenistampilan value=bataminggris {$checked}>Transkrip UNIVERSITAS BATAM Bahasa Inggris<br>\r\n  \t\t\t<input type=radio class=form-control m-input name=jenistampilan value=batamsementara {$checked}>DAFTAR NILAI SEMENTARA<br>\r\n        ";
					#}
					else if ( $UNIVERSITAS == "UNIVERSITAS BATAM" )
					{
						echo "<label class=\"m-radio\">";
							echo "\r\n  \t\t\t<input type=radio class=form-control m-input name=jenistampilan value=bataminggris {$checked}>Transkrip Bahasa Inggris";
						echo "<span></span>
								</label>";
						echo "<label class=\"m-radio\">";
							echo "<input type=radio class=form-control m-input name=jenistampilan value=batamsementara {$checked}>DAFTAR NILAI SEMENTARA ";
						echo "<span></span>
								</label>";
					}
					else if ( $UNIVERSITAS == "UNIVERSITAS BOROBUDUR" )
					{
						echo "<label class=\"m-radio\">";
							echo "\r\n  \t\t\t<input type=radio class=form-control m-input name=jenistampilan value=borobudursementara {$checked}>Transkrip UNIVERSITAS BOROBUDUR SEMENTARA<br>\r\n         ";
						echo "<span></span>
								</label>";
					}
					else if ( $UNIVERSITAS == "STIKES SAMARINDA" )
					{
						echo "<label class=\"m-radio\">";	
							echo "\r\n  \t\t\t<input type=radio class=form-control m-input name=jenistampilan value=nonregulerstikessamarinda {$checked}>Transkrip Non Reguler<br>\r\n         ";
						echo "<span></span>
								</label>";
					}
					else if ( $UNIVERSITAS == "UNIVERSITAS 17 AGUSTUS 1945" )
					{
						echo "<label class=\"m-radio\">";	
							echo "<input type=radio class=form-control m-input name=jenistampilan value=untag {$checked} >Transkrip {$UNIVERSITAS} - Blanko<br>\r\n         ";
						echo "<span></span>
								</label>";
					}
					if ( $UNIVERSITAS != "STEI INDONESIA" )
					{
						$cek2 = "checked";
						echo "<label class=\"m-radio\">";	
							echo "<input type=radio class=form-control m-input name=jenistampilan value=1 {$checked}>Standar";
						echo "<span></span>
								</label>";
						echo "<label class=\"m-radio\">";
							echo "<input type=radio class=form-control m-input name=jenistampilan value=0>Dipisah Per Jenis Mata Kuliah";
						echo "<span></span>
								</label>";

						echo "<label class=\"m-radio\">";
							echo "\r\n\t\t\t<input type=radio class=form-control m-input name=jenistampilan value=2 {$cek2}>Per Kolom Semester";
						echo "<span></span>
								</label>";
						echo "<label class=\"m-radio\">";
							echo "\r\n\t\t\t<input type=radio class=form-control m-input name=jenistampilan value=3  >Dua Kolom";
						echo "<span></span>
								</label>";
					}
    echo "			</div>
				</div>
			</div>";
    if ( $UNIVERSITAS != "UNIVERSITAS 17 AGUSTUS 1945" )
    {
        echo "	<div class=\"form-group m-form__group row\" >
					<label class=\"col-lg-2 col-form-label\">Tanggal Laporan</label>
					<div class=\"col-lg-6\">".createinputtanggal( "tgllap", $tgllap, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."</div>
				</div>";
    }
    echo "		<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
					<label class=\"col-lg-2 col-form-label\">Data Per Halaman</label>
					<div class=\"col-lg-6\">
						<input type=text class=form-control m-input name=dataperhalaman value='{$maxdata}' size=2> Sebaiknya nilainya diperkecil karena pemrosesan transkrip akan memakan waktu relatif lama
					</div>
				</div>";
    #echo "\r\n\t<tr>\r\n\t\t<td class=judulform>Kop Surat\r\n\t\t</td>\r\n\t\t<td>\r\n\t\t\t<input type=radio class=form-control m-input name=kopsurat value='' checked>Tanpa Kop\r\n\t\t\t<input type=radio class=form-control m-input name=kopsurat value='1' >Cetak Kop Surat Umum\r\n\t\t\t<input type=radio class=form-control m-input name=kopsurat value='2' >Cetak Kop Surat Fakultas\r\n\t\t</td>\r\n\t</tr>";
    echo "		<div class=\"form-group m-form__group row\" >
					<label class=\"col-lg-2 col-form-label\">Kop Surat</label>
					<div class=\"col-lg-6\">
						<div class=\"m-radio-list\">
							<label class=\"m-radio\">
								<input type=radio name=kopsurat value='' checked>Tanpa Kop
							<span></span>
							</label>
							<label class=\"m-radio\">
								<input type=radio name=kopsurat value='1' >Cetak Kop Surat Umum
							<span></span>
							</label>
							<label class=\"m-radio\">
								<input type=radio name=kopsurat value='3' >Cetak Kop Surat Sendiri 
							<span></span>
							</label>
							".createinputtext( "judulkopsendiri","", " class=form-control m-input  size=30 maxlength=30" )."
						</div>
					</div>
				</div>";
    echo "		<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
					<label class=\"col-lg-2 col-form-label\">SK Pendirian</label>
					<div class=\"col-lg-6\">
						<input type=text class=form-control m-input name=skpendirian size=30>
					</div>
				</div>";
    
	/*if ( $jenisusers != 2 && $jenisusers != 3 && $jenisusers == 0 && $UNIVERSITAS == "STIKES_UBUDIYAH" )
    {
        echo "\r\n      \t<tr>\r\n      \t\t<td class=judulform>Nilai Ujian  Komprehensif\r\n      \t\t</td>\r\n      \t\t<td>\r\n      \t\t\t<input type=checkbox class=form-control m-input name=kompre value='1' >Tampilkan\r\n       \t\t</td>\r\n      \t</tr>\r\n        ";
    }*/
    #echo "\r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Tampilkan' class=\"btn blue\">\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\r\n\r\n\t\t</table>\r\n\t\t</form>\r\n \t</div></div></div></div></div>";
	echo "		<div class=\"form-group m-form__group row\">
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
