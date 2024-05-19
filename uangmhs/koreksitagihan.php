<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

if ( $aksi == "hapus" )
{
    if ( $sessid != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Tagihan", HAPUS_DATA );
    }
    else
    {
        $q = "DELETE FROM buattagihan WHERE TANGGALTAGIHAN='{$tanggal}' AND IDMAHASISWA='{$idmhs}' AND IDKOMPONEN='{$idkomponen}'
		AND TAHUN='{$tahun}' AND SEMESTER='{$semester}'";
        #echo $q;exit();
		mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Data tagihan telah dihapus.";
        }
    }
    $aksi = "";
}
if ( $aksi == "simpandata" )
{
	echo 'simpan'.'<br>';
	print_r($_POST);exit();
	if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Tagihan", HAPUS_DATA );
    }
    else
    {
		$ids                  = $_POST["ids"];
		#foreach($ids as $id) {
		#for($a=0;$a<count($ids);$a++) {
		foreach($ids as $id){		
			
			/*$tgl_tagihan_array = $_POST['tgl_tagihan_'.$ids[$a]];
			$komponen_tagihan_array = $_POST['komponen_tagihan_'.$ids[$a]];
			$id_mhs_array = $_POST['id_mhs_'.$ids[$a]];
			$jml_tagihan_array = $_POST['jml_tagihan_'.$ids[$a]];*/
			#echo "ID=".$id.'<br>';
			#print_r($_POST);
			#echo "<br>";
			$tgl_tagihan = $_POST['tgl_tagihan_'][$id];
			$komponen_tagihan = $_POST['komponen_tagihan_'][$id];
			$id_mhs = $_POST['id_mhs_'][$id];
			$jml_tagihan = $_POST['jml_tagihan_'][$id];
			$semester_ajaran = $_POST['semester_ajaran_'][$id];
			$tahun_ajaran = $_POST['tahun_ajaran_'][$id];
			$query = "UPDATE buattagihan SET JUMLAH = '{$jml_tagihan}' WHERE IDKOMPONEN = '{$komponen_tagihan}' AND TANGGALTAGIHAN='{$tgl_tagihan}'
						AND IDMAHASISWA='{$id_mhs}' AND TAHUN='{$tahun_ajaran}' AND SEMESTER='{$semester_ajaran}'";
							#echo $query.'<br>';
							mysqli_query($koneksi,$query);
			if ( 0 < sqlaffectedrows( $koneksi ) )
			{
				$errmesg = "Data tagihan tanggal {$tanggal} telah diupdate.";
			}				
			
		}
		
		
	}
	#exit();
	#$nim = "(".$tmp.")";
	
	
    $aksi = "";
}
if ( $aksi == "tampilkan" )
{
	#echo "aaa";exit();
    $aksi = " ";
    include( "prosestampiltagihan.php" );
}
if ( $aksi == "" )
{
    #printmesg( $errmesg );
    if ( $gelombang == "" )
    {
        $gelombang = 1;
    }
    /*echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br><br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> BUAT TAGIHAN </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
	echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
				
	
    $q = "SELECT COUNT(*) AS JUMLAHDATA,SUM(STATUS) AS SUDAHDIPROSES, TANGGALTAGIHAN,JENISKOLOM,DATE_FORMAT(TANGGALTAGIHAN,'%d-%m-%Y') AS TGL \r\n    FROM buattagihan WHERE 1=1 \r\n    GROUP BY TANGGALTAGIHAN \r\n    ORDER BY TANGGALTAGIHAN DESC  ";
    $h = mysqli_query($koneksi,$q);
    $jml = sqlnumrows( $h );
    if ( 0 < $jml )
    {
        while ( $d = sqlfetcharray( $h ) )
        {
            $arraytagihan[$d[TANGGALTAGIHAN]] = $d;
        }
        $jeniskolom = $d[JENISKOLOM];
        $strunduh = str_replace( "name=jeniskolom value=\"\"", "name=jeniskolom value=\"{$jeniskolom}\"", $strunduh );
        #printjudulmenukecil( "<b>UNDUH HASIL PEMBUATAN TAGIHAN SEBELUMNYA   " );
        /*echo "<div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\">UNDUH HASIL PEMBUATAN TAGIHAN SEBELUMNYA</span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>";*/
						printmesg( $errmesg );
		echo "		<div class=\"m-portlet\">";
		
		echo "			<div class='portlet-title'>";
								printtitle("Koreksi Hasil Pembuatan Tagihan S1 Sebelumnya");
		echo "			</div>";
        echo "			<form method=post action=index.php class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
							<input type=hidden name=pilihan value='{$pilihan}'>
							<input type=hidden name=aksi value='tampilkan'>
							<div class=\"m-portlet__body\">
								<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
									<label class=\"col-lg-2 col-form-label\">Tanggal Tagihan</label>\r\n    
									<label class=\"col-form-label\">
										<select name=tanggal class=form-control m-input>";
											foreach ( $arraytagihan as $k => $v )
											{
												echo "<option value='{$k}'>{$v['TGL']}</option>";
											}
        #echo "\r\n              </select>\r\n            </td>\r\n        </tr>\r\n        \r\n        <tr>\r\n          <td width=150 >\r\n            Tipe \r\n           </td>\r\n          <td   >\r\n            <input type=hidden name=jeniskolom value=\"{$jeniskolom}\" >\r\n            <input type=radio name=jenisfile value=\"CSV\" checked> CSV, delimiter <input type=text size=1 name=delimiter value=\";\"> <br>\r\n            <input type=radio name=jenisfile value=\"HTML\"> HTML   <br>\r\n            <input type=radio name=jenisfile value=\"EXCEL\"> Excel \r\n           </td>\r\n        </tr>\r\n        <tr>\r\n          <td  colspan=2>\r\n            <input type=submit name=aksi value=UNDUH>\r\n            <input type=submit name=aksi value=\"PERIKSA HASIL\">\r\n          </td>\r\n        </tr>\r\n        </table>\r\n        </form>      \r\n      \r\n      \r\n      ";
        #echo "\r\n              </select>\r\n            </td>\r\n        </tr><tr>\r\n        <td  >Jenis Kolom</td>\r\n        <td> \r\n          <input type=radio name=jeniskolom value='SPC' checked> Komponen dengan Label SPC saja <br>\r\n          <input type=radio name=jeniskolom value=''> Komponen Non SPC Saja\r\n        \r\n        </td>\r\n      </tr>\      <tr>\r\n          <td width=150 >\r\n            Tipe \r\n           </td>\r\n          <td   >\r\n            <!--<input type=hidden name=jeniskolom value=\"{$jeniskolom}\" >\r\n -->           <input type=radio name=jenisfile value=\"CSV\" checked> CSV, delimiter <input type=text size=1 name=delimiter value=\";\">   </td>\r\n        </tr>\r\n        <tr>\r\n          <td  colspan=2>\r\n            <input type=submit name=aksi value=UNDUH>\r\n            <input type=submit name=aksi value=\"PERIKSA HASIL\">\r\n          </td>\r\n        </tr>\r\n        </table>\r\n        </form>      \r\n      \r\n      \r\n      ";
        echo "\r\n              		</select>
									</label>
								</div>";
									$arrayangkatan = getarrayangkatan( );
    echo "						<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
									<label class=\"col-form-label\">";
										$waktu = getdate( );
    echo "								<select name=angkatancari class=form-control m-input><option value=''>Semua</option>\r\n\t\t\t\t\t\t ";
											$cek = "";
											foreach ( $arrayangkatan as $k => $v )
											{
												echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$k}</option>\r\n\t\t\t\t\t\t\t";
												$cek = "";
											}
    echo "								</select>
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
									<label class=\"col-lg-2 col-form-label\">Program Studi</label>\r\n    
									<label class=\"col-form-label\">
										<select class=form-control m-input name=idprodicari>\r\n\t\t\t\t\t\t<option value=''>Semua</option>\r\n\t\t\t\t\t\t ";
											foreach ( $arrayprodidep as $k => $v )
											{
												echo "<option value='{$k}'>{$v}</option>";
											}
    echo "								</select>
									</label>
								</div>";
		#echo "<!--<tr>\r\n        <td  >Jenis Kolom</td>\r\n        <td> \r\n          <input type=radio name=jeniskolom value='SPC' checked> Komponen dengan Label SPC saja <br>\r\n          <input type=radio name=jeniskolom value=''> Komponen Non SPC Saja\r\n        \r\n        </td>\r\n      </tr>\   -->   <tr>\r\n          <td width=150 >\r\n            Tipe \r\n           </td>\r\n          <td   >\r\n            <!--<input type=hidden name=jeniskolom value=\"{$jeniskolom}\" >\r\n -->           <input type=radio name=jenisfile value=\"CSV\" checked> CSV, delimiter <input type=text size=1 name=delimiter value=\";\">   </td>\r\n        </tr>\r\n        <tr>\r\n          <td  colspan=2>\r\n  <input type='hidden' name='jeniskolom' value='SPC' class=\"btn blue\">          <input type=submit name=aksi value=UNDUH class=\"btn blue\">\r\n            <input type=submit name=aksi value=\"PERIKSA HASIL\" class=\"btn blue\">\r\n          </td>\r\n        </tr>\r\n        </table>\r\n        </form>      \r\n      \r\n      \r\n      ";
    echo "						
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=\"submit\" class=\"btn btn-brand\" value=Tampilkan></input>
										</div>
									</label>
								</div>
							</div>
						</form>";
            
		$token = md5( uniqid( rand( ), TRUE ) );
        $_SESSION['token'] = $token;
        echo "
					</div>
				</div>
			</div>
		</div>";
    }
}
?>
