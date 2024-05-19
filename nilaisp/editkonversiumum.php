<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksitambah == "Hapus" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Konversi Nilai", HAPUS_DATA );
        unset( $_SESSION['token'] );
    }
    else if ( is_array( $data ) )
    {
        $jmlaf = 0;
        foreach ( $data as $k => $v )
        {
            if ( $v[hapus] == 1 )
            {
                $q = "\r\n\t\t\t\t\t\tDELETE FROM konversiumumsp \r\n\t\t\t\t\t\tWHERE\r\n \t\t\t\t\t\tIDKONVERSI='{$k}'\r\n\t\t\t\t\t\t\r\n\t\t\t\t\t";
                mysqli_query($koneksi,$q);
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    $ketlog = "Hapus Konversi Nilai Umum dengan \r\n\t\t\t\t\t\tID Konversi={$k} \r\n\t\t\t\t\t\t";
                    buatlog( 32 );
                    ++$jmlaf;
                }
            }
        }
        if ( 0 < $jmlaf )
        {
            $errmesg = "Data konversi nilai berhasil dihapus";
        }
        else
        {
            $errmesg = "Data konversi nilai tidak dihapus";
        }
    }
}
if ( $aksitambah == "Update" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Konversi Nilai", SIMPAN_DATA );
        unset( $_SESSION['token'] );
    }
    else if ( is_array( $data ) )
    {
        foreach ( $data as $k => $v )
        {
            $vld[] = cekvaliditasnilaihuruf( "Simbol ".$v['simbol'], $v['simbol'] );
            $vld[] = cekvaliditasnilaibobot( "Nilai ".$v['nilai'], $v['nilai'] );
            $vld[] = cekvaliditasnumerik( "Syarat ".$v['syarat'], $v['syarat'] );
        }
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 1, SIMPAN_DATA );
        }
        else
        {
            $jmlaf = 0;
            foreach ( $data as $k => $v )
            {
                if ( $v[update] == 1 )
                {
                    $q = "\r\n\t\t\t\t\t\t\tUPDATE konversiumumsp \r\n\t\t\t\t\t\t\tSET \r\n\t\t\t\t\t\t\t\tSIMBOL='{$v['simbol']}',\r\n\t\t\t\t\t\t\t\tSYARAT='{$v['syarat']}',\r\n\t\t\t\t\t\t\t\tNILAI='{$v['nilai']}'\r\n\t\t\t\t\t\t\tWHERE\r\n\t \t\t\t\t\t\tIDKONVERSI='{$k}'\r\n\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t";
                    mysqli_query($koneksi,$q);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        $ketlog = "Update Konversi Nilai Umum dengan \r\n\t\t\t\t\t\t\tID Konversi={$k}  ({$v['simbol']}/{$v['syarat']}/{$v['nilai']})\r\n\t\t\t\t\t\t\t";
                        buatlog( 31 );
                        ++$jmlaf;
                    }
                }
            }
            if ( 0 < $jmlaf )
            {
                $errmesg = "Data konversi nilai berhasil diupdate";
            }
            else
            {
                $errmesg = "Data konversi nilai tidak diupdate";
            }
        }
    }
}
if ( $aksi == "tambah" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Konversi Nilai", HAPUS_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditasnilaihuruf( "Simbol ".$simbol, $simbol );
        $vld[] = cekvaliditasnilaibobot( "Nilai ".$data['nilai'], $data['nilai'] );
        $vld[] = cekvaliditasnumerik( "Syarat ".$data['syarat'], $data['syarat'] );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 1, SIMPAN_DATA );
        }
        else if ( trim( $simbol ) == "" )
        {
            $errmesg = "Simbol konversi nilai harus diisi (contoh: A)";
        }
        else if ( trim( $data[nilai] ) == "" || $data[nilai] < 0 )
        {
            $errmesg = "Nilai ekivalen harus diisi >= 0";
        }
        else if ( trim( $data[syarat] ) == "" || $data[syarat] < 0 )
        {
            $errmesg = "Syarat konversi nilai harus diisi >= 0";
        }
        else
        {
            $idbaru = getnewidsyarat( "IDKONVERSI", "konversiumumsp", "" );
            $q = "\r\n\t\t\t\tINSERT INTO konversiumumsp (IDKONVERSI,SIMBOL,NILAI,SYARAT) \r\n\t\t\t\tVALUES ('{$idbaru}','{$simbol}','{$data['nilai']}','{$data['syarat']}')\r\n\t\t\t";
            mysqli_query($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $ketlog = "Tambah Konversi Nilai Umum dengan \r\n\t\t\t\t\t\tID Konversi={$idbaru}  ({$simbol}/{$data['syarat']}/{$data['nilai']})\r\n\t\t\t\t\t\t";
                buatlog( 31 );
                $errmesg = "Data Konversi Nilai berhasil ditambah";
                $data = "";
                $simbol = "";
            }
            else
            {
                $errmesg = "Data Konversi Nilai  tidak berhasil ditambah";
            }
        }
    }
}
#printjudulmenu( "Edit Konversi Nilai Umum Default" );
#printmesg( $errmesg );
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Edit Konversi Nilai Umum Default Semester Pendek");
				echo "	</div>";
				
				echo "	<div class='portlet-title'>";
								printmesg("Data Konversi Nilai Baru");										
		echo "			</div>	
						<div class=\"m-portlet\">
				
							<!--begin::Form-->";
echo "							<form name=form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" action=index.php method=post>
								".createinputhidden( "aksi", "tambah", "" ).
								createinputhidden( "sessid", "{$token}", "" ).
								createinputhidden( "tab", "{$tab}", "" ).
								createinputhidden( "pilihan", $pilihan, "" );
#printjudulmenukecil( "Data Konversi Nilai Baru" );
echo "						<div class=\"m-portlet__body\">		
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Simbol</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "simbol", "{$simbol}", "size=4 class=masukan" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Nilai Ekivalen (SKS)</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[nilai]", "{$data['nilai']}", "size=4 class=masukan" )."
									</label>
								</div>"."
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Syarat</label>\r\n    
									<label class=\"col-form-label\">
										Nilai >= ".createinputtext( "data[syarat]", "{$data['syarat']}", "size=4 class=masukan" )." 
									</label>
								</div>"."
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
									<div class=\"col-lg-6\">
										<input type=submit value='Tambah' class=\"btn btn-brand\">
										<input type=reset value='Reset' class=\"btn btn-secondary\">
									</div>
								</div>
							</div>";
echo "					</form>
					</div>
					<script>form.nama.focus();</script>";
#printjudulmenukecil( "Rincian Konversi Nilai" );
/*echo "<div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                
                                <span class=\"caption-subject bold uppercase\"> Rincian Konversi Nilai </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>";*/
$q = "	SELECT IDKONVERSI,SIMBOL,NILAI,SYARAT FROM konversiumumsp ORDER BY NILAI DESC";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    echo "	<form name=form action=index.php method=post>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "tab", $tab, "" ).createinputhidden( "sessid", $token, "" )."
	<div class=\"portlet light\">
                        <div class=\"portlet-body form\">
							<div class='tab-pane' id='tab_1'>
								<div class='portlet box blue'>
									<div class='portlet-title'>
										<div class='caption'>";
											printmesg("Rincian Konversi Nilai");
								echo	"</div>
									</div>";
	echo "						 	<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata align=center><td colspan=4></td><td><input type=submit name=aksitambah value='Update' class=\"btn btn-brand\"></td><td ><input type=submit name=aksitambah value='Hapus' class=\"btn btn-secondary\"\r\n\t\t\t\t\t\tonClick=\"return confirm('Hapus Data Konversi?')\"\r\n\t\t\t\t\t\t></td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr class=juduldata align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t\t<td>Simbol</td>\r\n\t\t\t\t\t\t<td>Nilai</td>\r\n\t\t\t\t\t\t<td>Syarat</td>\r\n\t\t\t\t\t\t<td >Pilih Update</td>\r\n\t\t\t\t\t\t<td >Pilih Hapus</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t";
    echo "											</thead>
													<tbody>";
	$i = 1;
    $totalbobot = 0;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t\t\t<tr {$kelas}  align=center>\r\n\t\t\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\t\t\t\t\t\t<td  >".createinputtext( "data[{$d['IDKONVERSI']}][simbol]", "{$d['SIMBOL']}", " class=masukan size=4" )."</td>\r\n\t\t\t\t\t\t\t<td  >".createinputtext( "data[{$d['IDKONVERSI']}][nilai]", "{$d['NILAI']}", " class=masukan size=4" )."</td>\r\n\t\t\t\t\t\t\t<td  >Nilai >=".createinputtext( "data[{$d['IDKONVERSI']}][syarat]", "{$d['SYARAT']}", " class=masukan size=4" )."</td>\r\n\t\t\t\t\t\t\t<td align=center>".createinputcek( "data[{$d['IDKONVERSI']}][update]", "1", "", "", " class=masukan size=4" )."</td>\r\n\t\t\t\t\t\t\t<td align=center>".createinputcek( "data[{$d['IDKONVERSI']}][hapus]", "1", "", "", " class=masukan size=4" )."</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
        $totalbobot += $d[NILAI];
        ++$i;
    }
    #echo "</table>\r\n\t\t\t\t<br><br></div></div></div></div></div>";
	echo "											</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
		</div>
	</div>
	</div>";
}
else
{
    $errmesg = "Konversi Nilai belum ada";
    printmesg( $errmesg );
}
?>
