<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
#echo "ll";exit();
periksaroot( );
cekhaktulis( $kodemenu );
#printjudulmenu( "Biaya Komponen Keuangan" );
if ( $aksi == "Simpan" )
{
    if ( $ifubahlalu == 1 )
    {
        $q = "SELECT mahasiswa.ID FROM mahasiswa  \r\n     WHERE mahasiswa.ANGKATAN='{$angkatan}' AND mahasiswa.GELOMBANG='{$gelombang}' AND mahasiswa.IDPRODI='{$idprodi}'";
        $h2 = mysqli_query($koneksi,$q);
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $arraymahasiswa[$d2[ID]] = $d2[ID];
        }
    }
    foreach ( $arraybiaya as $k => $v )
    {
        $q = "INSERT INTO biayakomponen (IDKOMPONEN,IDPRODI,ANGKATAN,BIAYA,TANGGAL,DENDA,JENISDENDA,GELOMBANG,KRS,UTS,UAS,JENISKELAS,KATEGORIDENDA)\r\n\t\tVALUES ('{$k}','{$idprodi}','{$angkatan}','{$v}','".$arraytanggal[$k]."','".$arraydenda[$k]."','".$arrayjenisdenda[$k]."','{$gelombang}',\r\n    '".$arraykrs[$k]."','".$arrayuts[$k]."','".$arrayuas[$k]."','{$jeniskelas}','".$arraykategoridenda[$k]."')";
        mysqli_query($koneksi,$q);
        if ( sqlaffectedrows( $koneksi ) <= 0 )
        {
            $q = "\r\n\t\t\t\tUPDATE biayakomponen \r\n        SET BIAYA='{$v}',\r\n        TANGGAL='".$arraytanggal[$k]."',\r\n        DENDA='".$arraydenda[$k]."',\r\n        JENISDENDA='".$arrayjenisdenda[$k]."',\r\n\r\n        KRS='".$arraykrs[$k]."',\r\n        UTS='".$arrayuts[$k]."',\r\n        UAS='".$arrayuas[$k]."',KATEGORIDENDA='".$arraykategoridenda[$k]."' WHERE IDPRODI='{$idprodi}' AND\r\n\t\t\t\tIDKOMPONEN='{$k}' AND \r\n        ANGKATAN='{$angkatan}'  AND\r\n        GELOMBANG='{$gelombang}' AND\r\n        JENISKELAS='{$jeniskelas}'\r\n\t\t\t";
            mysqli_query($koneksi,$q);
            $ketlog = "Update Biaya Komponen Pembayaran dengan \r\n\t\t\tID Komponen={$k} ({$v}),ID Prodi={$idprodi},Angkatan={$angkatan},Gelombang={$gelombang},Jenis Kelas={$jeniskelas}\r\n\t\t\t";
            if ( $ifubahlalu == 1 && 0 < sqlaffectedrows( $koneksi ) && 0 < $v && ( $k == "032" || $k == "99" ) && is_array( $arraymahasiswa ) )
            {
                foreach ( $arraymahasiswa as $idmahasiswa => $v2 )
                {
                    $biayatransaksi = $v;
                    $q = "UPDATE bayarkomponen SET BIAYA='{$biayatransaksi}' WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$k}'";
                    mysqli_query($koneksi,$q);
                }
            }
            buatlog( 52 );
        }
        else
        {
            $ketlog = "Tambah Biaya Komponen Pembayaran dengan \r\n\t\t\tID Komponen={$k} ({$v}),ID Prodi={$idprodi},Angkatan={$angkatan},Gelombang={$gelombang}\r\n\t\t\t";
            buatlog( 51 );
        }
    }
    $errmesg = "Data Biaya Komponen sudah disimpan";
    $aksix = "Simpan";
    $aksi = "Lanjut";
}
if ( $aksi == "Lanjut" )
{
	#echo "mmm";exit();
    if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
    {
        $jeniskelaskeuangan = 1;
        $qcolumn = " ,JENISKELAS  ";
        $qfield = " AND JENISKELAS!='' AND JENISKELAS='{$jeniskelas}'";
    }
    /*printmesg( $errmesg );
    echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> BIAYA KOMPONEN KEUANGAN </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";
	*/
	 echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printtitle("Biaya Komponen Keuangan");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
    echo "					<form name=form action=index.php method=post>
								<input type=hidden name=pilihan value='{$pilihan}'>
								<input type=hidden name=angkatan value='{$angkatan}'>
								<input type=hidden name=gelombang value='{$gelombang}'>
								<input type=hidden name=idprodi value='{$idprodi}'>
								<input type=hidden name=jeniskelas value='{$jeniskelas}'>
								<div class=\"m-portlet__body\">
									<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
										<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
										<label class=\"col-form-label\">
											<b>{$angkatan}</b>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Gelombang</label>\r\n    
										<label class=\"col-form-label\">
											<b>{$gelombang}</b>
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
										<label class=\"col-lg-2 col-form-label\">Program Studi / Program Pendidikan</label>\r\n    
										<label class=\"col-form-label\">
											<b>".$arrayprodidep[$idprodi]."</b>
										</label>
									</div>";
    if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
    {
        echo "						<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Jenis Kelas</label>\r\n    
										<label class=\"col-form-label\">
											<b>".$arraykelasstei[$jeniskelas]."</b>
										</label>
									</div>
								";
    }
	
    $q = "SELECT * FROM aturan ";
	#echo $q;
    $h2 = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h2 ) )
    {
        $d2 = sqlfetcharray( $h2 );
        $aturankeuangan = $d2[KRSONLINE];
    }
    /*if ( $d2[KRSONLINE] == 2 )
    {
        echo "							<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Syarat Minimum Total Pembayaran (KRS)</label>\r\n    
											<label class=\"col-form-label\">";
        if ( $d2[SYARATKRSONLINE2] == "T" )
        {
            if ( $aksix == "Simpan" )
            {
                $q = "UPDATE biayakomponen SET SEMESTER1='{$semester1}' , SEMESTER2='{$semester2}' \r\n                WHERE IDPRODI='{$idprodi}' AND\r\n              \t\t\t\t \r\n                      ANGKATAN='{$angkatan}'  AND\r\n                      GELOMBANG='{$gelombang}' {$qfield}\r\n                ";
                mysqli_query($koneksi,$q);
            }
            $q = "SELECT SEMESTER1,SEMESTER2 FROM biayakomponen WHERE IDPRODI='{$idprodi}' AND\r\n              \t\t\t\t \r\n                      ANGKATAN='{$angkatan}'  AND\r\n                      GELOMBANG='{$gelombang}' {$qfield} LIMIT 0,1";
            $hs = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $hs ) )
            {
                $ds = sqlfetcharray( $hs );
                $semester1 = $ds[SEMESTER1];
                $semester2 = $ds[SEMESTER2];
            }
            echo "SEMESTER Ganjil <input type=text name=semester1 value='{$semester1}'> <br>";
            echo "SEMESTER Genap <input type=text name=semester2 value='{$semester2}'> (Akumulasi semester Ganjil dan Genap)";
        }
        else if ( $d2[SYARATKRSONLINE2] == "S" )
        {
            if ( $aksix == "Simpan" )
            {
                $q = "UPDATE biayakomponen SET SEMESTER1='{$semester1}' \r\n                WHERE IDPRODI='{$idprodi}' AND\r\n              \t\t\t\t \r\n                      ANGKATAN='{$angkatan}'  AND\r\n                      GELOMBANG='{$gelombang}' {$qfield}\r\n                ";
                mysqli_query($koneksi,$q);
            }
            $q = "SELECT SEMESTER1,SEMESTER2 FROM biayakomponen WHERE IDPRODI='{$idprodi}'   AND\r\n                      ANGKATAN='{$angkatan}'  AND\r\n                      GELOMBANG='{$gelombang}' {$qfield} LIMIT 0,1";
            $hs = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $hs ) )
            {
                $ds = sqlfetcharray( $hs );
                $semester1 = $ds[SEMESTER1];
            }
            echo "PER SEMESTER <input type=text name=semester1 value='{$semester1}'>";
        }
        echo "  </td>\r\n  \t\t\t</tr>";
    }*/
	echo 						"</div>";
    #echo "\r\n\r\n\t\t</table> ";
    $q = "SELECT komponenpembayaran.* FROM komponenpembayaran ,komponenpembayaran_prodi WHERE komponenpembayaran_prodi.IDPRODI='{$idprodi}' ".
	"AND komponenpembayaran.ID =komponenpembayaran_prodi.IDKOMPONEN  {$where992} ORDER BY komponenpembayaran.ID";
    #echo $q;
	$h = mysqli_query($koneksi,$q);
    echo mysqli_error($koneksi);
    if ( 0 < sqlnumrows( $h ) )
    {
		echo "			<div class='portlet-title'>";
								printmesg("Data Komponen Pembayaran");
		echo "			</div>";
        $colspan = 6;
		#echo $aturankeuangan.'<br>';
        if ( $aturankeuangan == 3 )
        {
            $colspan = 9;
        }
        #echo "\r\n \t\t\t<table {$border} class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t<tr class=juduldata  align=center>\r\n\t\t\t\t<td colspan={$colspan} align=right>\r\n\t\t\t".IKONUPDATE48."\r\n        <input class=\"btn blue\" type=submit name=aksi value=Simpan>\r\n        \r\n        ";
        echo "			<div class=\"tools\">
							<div class=\"table-scrollable\">
								<table class=\"table table-striped table-bordered table-hover\">
									<tr>
										<td colspan={$colspan} align=right>
											<input class=\"btn btn-brand\" type=submit name=aksi value=Simpan>\r\n  
										</td>
									</tr>
								</table>
							</div>
						</div>";
		if ( $UNIVERSITAS == "UNIVERSITAS BATAM" )
        {
           # echo "\r\n        <input class=masukan type=checkbox name=ifubahlalu value=1> Ubah biaya transaksi pembayaran yang lalu\r\n        ";
        }
		 echo "			<div class=\"m-portlet\">			
							<div class=\"m-section__content\">
								<div class=\"table-responsive\">
									<table class=\"table table-bordered table-hover\">
										<thead>
											<tr class=juduldata  align=center><td>No</td><td>Kode</td><td>Nama</td><td>Jenis</td><td>Biaya Rp.</td>";
        #echo "\r\n        </td>\r\n \t\t\t</tr>\r\n\t\t\t<tr class=juduldata  align=center>\r\n\t\t\t\t<td>No</td>\r\n \t\t\t\t<td>Kode</td>\r\n\t\t\t\t<td>Nama</td>\r\n\t\t\t\t<td>Jenis</td>\r\n\t\t\t\t<td>Biaya Rp.</td>";
        if ( $aturankeuangan == 3 )
        {
            echo "\r\n            <td>Syarat Minimal KRS</td>\r\n            <td>Syarat Minimal UTS</td>\r\n            <td>Syarat Minimal UAS</td>\r\n          ";
        }
        #echo "\r\n\t\t\t\t<td>Setting Khusus<br>Biaya per Bulan</td>\r\n \r\n \t\t\t</tr>\r\n\t\t";
	echo "\r\n\t\t\t\t<td>Setting Denda<br>Komponen</td>\r\n \r\n \t\t\t</tr>\r\n\t\t";
		echo "							</thead>
									<tbody>";
		$i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            unset( $d2 );
            $q = "SELECT * FROM biayakomponen WHERE\r\n\t\t\tIDPRODI='{$idprodi}' AND ANGKATAN='{$angkatan}' AND IDKOMPONEN='{$d['ID']}' AND GELOMBANG='{$gelombang}' {$qfield} ";
            $h2 = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $h2 ) )
            {
                $d2 = sqlfetcharray( $h2 );
            }
            if ( $BIAYASKSKULIAH == 1 && ( $d[ID] == 99 || $d[ID] == 98 ) )
            {
                if ( $d[ID] == 99 )
                {
                    $d[NAMA] = "BIAYA KULIAH PER SKS - SEMESTER REGULER";
                }
                else if ( $d[ID] == 98 )
                {
                    $d[NAMA] = "BIAYA KULIAH PER SKS - SEMESTER PENDEK";
                }
            }
            echo "\r\n\t\t\t\t<tr align=center {$kelas} >\r\n\t\t\t\t\t<td>{$i}</td>\r\n  \t\t\t\t\t<td align=left>{$d['ID']}</td>\r\n \t\t\t\t\t<td align=left  nowrap>{$d['NAMA']}</td>\r\n \t\t\t\t\t<td align=left nowrap>".$arrayjenispembayaran[$d[JENIS]]." </td>\r\n \t\t\t\t\t<td align=center>\r\n \t\t\t\t\t<input type=text size=8 class=masukan name='arraybiaya[{$d['ID']}]' value='{$d2['BIAYA']}'>\r\n \t\t\t\t\t</td>";
            if ( $aturankeuangan == 3 )
            {
                if ( $d[ID] != 99 && $d[ID] != 98 )
                {
                    #if ( $d[JENIS] == 5 || $d[JENIS] == 4 || $d[JENIS] == 1 || $d[JENIS] == 6 )
                    #{
                    #    echo "\r\n                <td>Tanpa Syarat</td>\r\n                <td>Tanpa Syarat</td>\r\n                <td>Tanpa Syarat</td>\r\n              ";
                    #}
                    #else
                    #{
                        echo "\r\n                <td><input type=text size=8 class=masukan name='arraykrs[{$d['ID']}]' value='{$d2['KRS']}'></td>\r\n                <td><input type=text size=8 class=masukan name='arrayuts[{$d['ID']}]' value='{$d2['UTS']}'></td>\r\n                <td><input type=text size=8 class=masukan name='arrayuas[{$d['ID']}]' value='{$d2['UAS']}'></td>\r\n              ";
                    #}
                }
                else
                {
                    echo "\r\n              <td>Harus Lunas <!-- Tanpa Syarat --></td>\r\n              <td>Harus Lunas</td>\r\n              <td>Harus Lunas</td>\r\n            ";
                }
            }
            #if ( $d[JENIS] == 5 )
            #{
                echo "\r\n          <td align=left>\r\n            <table>\r\n            <tr>\r\n                <td> Tanggal Batas Pembayaran</td>\r\n                <td>  <input type=text size=2 class=masukan name='arraytanggal[{$d['ID']}]' value='{$d2['TANGGAL']}'>\r\n            </tr>\r\n            <tr>\r\n   \t\t\t\t\t   <td> Denda</td>\r\n                 <td> <input type=text size=6 class=masukan name='arraydenda[{$d['ID']}]' value='{$d2['DENDA']}'> </td>\r\n            </tr><tr>\r\n   \t\t\t\t\t     <td> Jenis Denda</td>\r\n                  <td> <select  name='arraykategoridenda[{$d['ID']}]'>";
		if ( $d2[KATEGORIDENDA] == 0 )
                {
                        $txtkategoridenda1 = "selected";
                }else{
			$txtkategoridenda2 = "selected";
		}
		echo "<option value='0' {$txtkategoridenda1}>Persentase</option>";
		echo "<option value='1' {$txtkategoridenda2}>Nominal</option>
		</select></tr>";
		echo "<tr>\r\n   \t\t\t\t\t     <td> Waktu Denda</td>\r\n                  <td> <select  name='arrayjenisdenda[{$d['ID']}]'>";
                foreach ( $arraytipedenda as $k => $v )
                {
                    $selected = "";
                    if ( $d2[JENISDENDA] == $k )
                    {
                        $selected = "selected";
                    }
                    echo "<option value='{$k}' {$selected}>{$v}</option>";
                }
                echo "\r\n \t\t\t\t\t  </select></td>\r\n            </tr>\r\n            </table>\r\n   \t\t\t\t\t\r\n \t\t\t\t\t</td> \t\t\t\t\t\r\n \r\n           ";
            /*}
            else
            {
                echo "\r\n          <td align=center > - </td>\r\n \r\n          ";
            }*/
            echo "\r\n \t\t\t\t</tr>\r\n\t\t\t";
            ++$i;
        }
        #echo "</table></div></div></div></div></div>";
		echo "								</tbody>
										</table>
									</div>
								</div>
							</div>
							<!--end::Section-->
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>";
    }
    else
    {
        printmesg( "Tidak ada komponen pembayaran untuk Prodi ini." );
    }
    #echo "\r\n\t\t</form>\r\n\t";
}
if ( $aksi == "" )
{
    printmesg( $errmesg );
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
                                <span class=\"caption-subject bold uppercase\"> BIAYA KOMPONEN KEUANGAN </span>
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
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printtitle("Biaya Komponen Keuangan");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
    echo "					<form name=form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
								<input type=hidden name=pilihan value='{$pilihan}'>
								<div class=\"m-portlet__body\">
									<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
										<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
										<label class=\"col-form-label\">";
											$waktu = getdate( );
    echo "									<select name=angkatan class=form-control m-input> \r\n\t\t\t\t\t\t ";
												$cek = "";
												$i = 1900;
												while ( $i <= $waktu[year] + 5 )
												{
													if ( $i == $waktu[year] )
													{
														$cek = "selected";
													}
													echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t\t\t\t\t";
													$cek = "";
													++$i;
												}
    echo "									</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Gelombang Masuk</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "gelombang", $gelombang, " class=form-control m-input  size=2" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
										<label class=\"col-lg-2 col-form-label\">Program Studi / Program Pendidikan</label>\r\n    
										<label class=\"col-form-label\">
											<select class=form-control m-input name=idprodi>\r\n\t\t\t\t\t\t ";
												foreach ( $arrayprodidep as $k => $v )
												{
													echo "<option value='{$k}'>{$v}</option>";
												}
    echo "									</select>
										</label>
									</div>";
    if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
    {
        echo "						<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Jenis Kelas Default</label>\r\n    
										<label class=\"col-form-label\">
											<select name='jeniskelas' >\r\n             \r\n          ";
												foreach ( $arraykelasstei as $k => $v )
												{
													$selected = "";
													if ( $k == $d[JENISKELAS] )
													{
														$selected = "selected";
													}
													echo "<option value='{$k}' {$selected}>{$v}</option>";
												}
        echo "								</select>
										</label>
									</div>";
    }
    echo "							<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=submit name=aksi value='Lanjut' class=\"btn btn-brand\">
										</div>
									</div>
								</div>";
    if ( $aksitampil == "" )
    {
        if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
        {
            $jeniskelaskeuangan = 1;
            $qcolumn = " ,JENISKELAS  ";
            $qfield = " AND JENISKELAS!='' ";
        }
        $q = "SELECT  DISTINCT IDPRODI  FROM biayakomponen,prodi WHERE biayakomponen.IDPRODI=prodi.ID {$qfield} ORDER BY IDPRODI";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            /*echo "<br>";
            #printjudulmenukecil( "<b>DAFTAR BIAYA KOMPONEN" );
            echo "<div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\">DAFTAR BIAYA KOMPONEN</span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>";*/
            echo "			<div class='portlet-title'>";
								printtitle("Daftar Biaya Komponen");
			echo "			</div>";
											
			echo "				<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata>\r\n           <td><b>Program Studi</td>\r\n         </tr>";
			echo "									</thead>
													<tbody>";
            while ( $d = sqlfetcharray( $h ) )
            {
                echo "\r\n          \r\n            <tr>\r\n               <td><a href='index.php?pilihan={$pilihan}&aksi={$aksi}&aksitampil=prodi&idprodi={$d['IDPRODI']}'>".$arrayprodidep[$d[IDPRODI]]." </a></td>\r\n             </tr>\r\n          ";
            }
            #echo "\r\n      </table>\r\n</div> </div></div></div></div>";
			echo "									</tbody>
												</table>
											</div>
										</div>
									</div>
									<!--- end m-portlet-->	
								</form>		
							</div>
						</div>
					</div>
				</div>
			</div>";
        }
    }
    else
    {
        if ( $aksitampil == "prodi" )
        {
            if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
            {
                $jeniskelaskeuangan = 1;
                $qcolumn = " ,JENISKELAS  ";
                $qfield = " AND JENISKELAS!='' ";
            }
            $q = "SELECT  COUNT(IDKOMPONEN) AS JUMLAH, IDPRODI,ANGKATAN,GELOMBANG {$qcolumn}\r\n    FROM biayakomponen,prodi \r\n    WHERE biayakomponen.IDPRODI=prodi.ID AND\r\n    prodi.ID='{$idprodi}' {$qfield}\r\n     GROUP BY\r\n     IDPRODI,ANGKATAN,GELOMBANG {$qcolumn}\r\n    ORDER BY ANGKATAN DESC,GELOMBANG {$qcolumn}";
            $h = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                echo "			<div class='portlet-title'>";
								printmesg("DAFTAR BIAYA KOMPONEN PROGRAM STUDI ".$arrayprodidep[$idprodi]);
			echo "				</div>";
			echo "				<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata align=center>\r\n           <td><b>Angkatan</td>\r\n           <td><b>Gelombang</td>";
                if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
                {
                    echo "\r\n           <td><b>Jenis Kelas</td>";
                }
                echo "\r\n           <td><b>Edit</td>\r\n         </tr>";
				echo "									</thead>
													<tbody>";
                while ( $d = sqlfetcharray( $h ) )
                {
                    echo "\r\n          \r\n            <tr>\r\n               <td align=center>{$d['ANGKATAN']}</td>\r\n               <td align=center>{$d['GELOMBANG']}</td>";
                    if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
                    {
                        echo "\r\n               <td align=center>".$arraykelasstei[$d[JENISKELAS]]."</td>";
                    }
                    echo "\r\n               <td align=center><a href='index.php?pilihan={$pilihan}&aksi=Lanjut&idprodi={$d['IDPRODI']}&angkatan={$d['ANGKATAN']}&gelombang={$d['GELOMBANG']}&jeniskelas={$d['JENISKELAS']}'>Edit</a></td>\r\n             </tr>\r\n     ";
                }
                #echo "\r\n      </table>\r\n </div> </div></div></div></div>  ";
				echo "									</tbody>
												</table>
											</div>
										</div>
									</div>
									<!--- end m-portlet-->	
								</form>		
							</div>
						</div>
					</div>
				</div>
			</div>";
            }
        }
    }
}
?>
