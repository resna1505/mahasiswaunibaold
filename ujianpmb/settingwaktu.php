<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

cekhaktulis( $kodemenu );
if ( $aksi == 3 )
{
    #printjudulmenu( "SETTING WAKTU UJIAN PER TAHUN MASUK, FAKULTAS, DAN GELOMBANG" );
    if ( $aksi2 == "hapus" )
    {
        if ( $_GET['sessid'] != $_SESSION['token'] )
        {
            $errmesg = token_err_mesg( "Setting Waktu Ujian PMB", HAPUS_DATA );
        }
        else
        {
            unset( $_SESSION['token'] );
            $q = "DELETE FROM waktuujianpmb_tahunfakultasgelombang WHERE TAHUN='{$tahunhapus}' AND FAKULTAS='{$fakultashapus}' AND GELOMBANG='{$gelombanghapus}'";
            mysqli_query($koneksi,$q);
        }
        $aksi2 = "";
    }
    if ( $aksi2 == "Simpan" )
    {
        if ( $_POST['sessid'] != $_SESSION['token'] )
        {
            $errmesg = token_err_mesg( "Jadwal Ujian PMB", SIMPAN_DATA );
        }
        else
        {
            unset( $_SESSION['token'] );
            $vld[] = cekvaliditastahun( "Tahun", $tahun );
            $vld[] = cekvaliditasinteger( "Waktu Ujian", $waktuujian );
            $vld[] = cekvaliditasinteger( "Gelombang", $gelombang );
            $vld = array_filter( $vld, "filter_not_empty" );
            if ( isset( $vld ) && 0 < count( $vld ) )
            {
                $errmesg = val_err_mesg( $vld, 1 );
            }
            else
            {
                unset( $_SESSION['token'] );
                $q = "INSERT INTO waktuujianpmb_tahunfakultasgelombang \r\n  (TAHUN,WAKTUUJIAN, LASTUPDATE,UPDATER,FAKULTAS,GELOMBANG)\r\n  VALUES \r\n  ('{$tahun}','{$waktuujian}', \r\n  NOW(),'{$users}','{$fakultas}','{$gelombang}'\r\n  )\r\n  ";
                mysqli_query($koneksi,$q);
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    $errmesg = "Data Setting Waktu Ujian PMB berhasil disimpan";
                }
                else
                {
                    $q = "UPDATE waktuujianpmb_tahunfakultasgelombang\r\n        SET\r\n        WAKTUUJIAN='{$waktuujian}' ,\r\n        LASTUPDATE=NOW(),\r\n        UPDATER='{$users}'\r\n        WHERE\r\n        TAHUN='{$tahun}'  AND FAKULTAS='{$fakultas}' AND GELOMBANG='{$gelombang}'\r\n        ";
                    mysqli_query($koneksi,$q);
                    echo mysqli_error($koneksi);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        $errmesg = "Data Setting Waktu Ujian PMB berhasil disimpan";
                    }
                    else
                    {
                        $errmesg = "Data Setting Waktu Ujian PMB tidak disimpan";
                    }
                }
            }
        }
        $aksi2 = "";
    }
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    printmesg( $errmesg );
    if ( $gelombang == "" )
    {
        $gelombang = 1;
    }
    echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Setting Waktu Per Tahun Masuk, Fakultas dan Gelombang");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
    echo " 						<form action='index.php' method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
									<input type=hidden name=pilihan value='{$pilihan}'>
									<input type=hidden name=aksi value='{$aksi}'>
									<input type=hidden name=sessid value='{$token}'>
									<div class=\"m-portlet__body\">		
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Tahun Masuk</label>\r\n    
											<label class=\"col-form-label\">
												<select name=tahun class=form-control m-input>";
													$i = 1901;
													while ( $i <= $waktu[year] + 5 )
													{
														if ( $i == $waktu[year] )
														{
															$selected = "selected";
														}
														echo "<option {$selected} value='{$i}'>{$i}</option>";
														$selected = "";
														++$i;
													}
	echo "										</select>
											</label>
										</div>";
    unset( $arrayfakultas[''] );
    echo "							<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Fakultas</label>\r\n    
										<label class=\"col-form-label\">
											".createinputselect( "fakultas", $arrayfakultas, "{$fakultas}", "", "class=form-control m-input" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Gelombang</label>\r\n    
										<label class=\"col-form-label\">
											<input type=text size=2 value='{$gelombang}' name=gelombang class=form-control m-input>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Waktu Ujian</label>\r\n    
										<label class=\"col-form-label\">
											<input type=text size=4 value='{$waktuujian}' name=waktuujian class=form-control m-input style=\"width:auto;display:inline-block;\"> menit
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=submit name=aksi2 value='Simpan' class=\"btn btn-brand\">
										</div>
									</div>
								</div>";
    $q = "SELECT * FROM waktuujianpmb_tahunfakultasgelombang ORDER BY TAHUN";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        /*printjudulmenukecil( "<b>Data Waktu Ujian PMB</b>" );
        echo "\r\n    <table>\r\n      <tr class=juduldata align=center>\r\n        <td>Tahun Masuk</td>\r\n        <td>Fakultas</td>\r\n        <td>Gelombang</td>\r\n         <td>Waktu Ujian (Menit)</td>\r\n        <td>Tgl Update</td>\r\n        <td>Pengubah</td>\r\n        <td>Hapus</td>\r\n      </tr>\r\n    ";
        */
		echo "			<div class='portlet-title'>";
								printmesg("Data Waktu Ujian PMB");
		echo "			</div>";
		echo "					<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata align=center>\r\n        <td>Tahun Masuk</td>\r\n        <td>Fakultas</td>\r\n        <td>Gelombang</td>\r\n         <td>Waktu Ujian (Menit)</td>\r\n        <td>Tgl Update</td>\r\n        <td>Pengubah</td>\r\n        <td>Hapus</td>\r\n      </tr>\r\n    ";
		echo "										</thead>
													<tbody>";
		$i = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            ++$i;
            $kelas = kelas( $i );
            echo "\r\n      <tr {$kelas}>\r\n        <td align=center>{$d['TAHUN']} </td>\r\n        <td align=center> ".$arrayfakultas[$d[FAKULTAS]]." </td>\r\n        <td align=center>{$d['GELOMBANG']} </td>\r\n        <td align=center> {$d['WAKTUUJIAN']} </td>\r\n         <td  align=center>{$d['LASTUPDATE']}</td>\r\n        <td align=center>{$d['UPDATER']}</td>\r\n       <td align=center><a href='index.php?pilihan={$pilihan}&aksi={$aksi}&tahunhapus={$d['TAHUN']}&fakultashapus={$d['FAKULTAS']}&gelombanghapus={$d['GELOMBANG']}&aksi2=hapus&sessid={$token}'\r\n       onClick=\"return confirm('Hapus Setting Waktu Ujian?');\">hapus</a></td>      \r\n       </tr>\r\n      ";
        }
        #echo "</table></div>";
		echo "								</tbody>
								</table>
							</div>
						</div>
					</div>
					<!--end::Section-->
				</div>
				<!--end::Form-->
			</form>
		</div>
		<!--end::Portlet-->";
    }
    else
    {
        printmesg( "Data Setting Waktu Ujian PMB Tidak Ada" );
    }
}
if ( $aksi == 2 )
{
    #printjudulmenu( "SETTING WAKTU UJIAN PER TAHUN MASUK DAN FAKULTAS" );
    if ( $aksi2 == "hapus" )
    {
        if ( $_GET['sessid'] != $_SESSION['token'] )
        {
            $errmesg = token_err_mesg( "Setting Waktu Ujian PMB", HAPUS_DATA );
        }
        else
        {
            unset( $_SESSION['token'] );
            $q = "DELETE FROM waktuujianpmb_tahunfakultas WHERE TAHUN='{$tahunhapus}' AND FAKULTAS='{$fakultashapus}' ";
            mysqli_query($koneksi,$q);
        }
        $aksi2 = "";
    }
    if ( $aksi2 == "Simpan" )
    {
        if ( $_POST['sessid'] != $_SESSION['token'] )
        {
            $errmesg = token_err_mesg( "Jadwal Ujian PMB", SIMPAN_DATA );
        }
        else
        {
            unset( $_SESSION['token'] );
            $vld[] = cekvaliditastahun( "Tahun", $tahun );
            $vld[] = cekvaliditasinteger( "Waktu Ujian", $waktuujian );
            $vld = array_filter( $vld, "filter_not_empty" );
            if ( isset( $vld ) && 0 < count( $vld ) )
            {
                $errmesg = val_err_mesg( $vld, 1 );
            }
            else
            {
                unset( $_SESSION['token'] );
                $q = "INSERT INTO waktuujianpmb_tahunfakultas \r\n  (TAHUN,WAKTUUJIAN, LASTUPDATE,UPDATER,FAKULTAS)\r\n  VALUES \r\n  ('{$tahun}','{$waktuujian}', \r\n  NOW(),'{$users}','{$fakultas}'\r\n  )\r\n  ";
                mysqli_query($koneksi,$q);
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    $errmesg = "Data Setting Waktu Ujian PMB berhasil disimpan";
                }
                else
                {
                    $q = "UPDATE waktuujianpmb_tahunfakultas\r\n        SET\r\n        WAKTUUJIAN='{$waktuujian} ,\r\n        LASTUPDATE=NOW(),\r\n        UPDATER='{$users}'\r\n        WHERE\r\n        TAHUN='{$tahun}'  AND FAKULTAS='{$fakultas}'\r\n        ";
                    mysqli_query($koneksi,$q);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        $errmesg = "Data Setting Waktu Ujian PMB berhasil disimpan";
                    }
                    else
                    {
                        $errmesg = "Data Setting Waktu Ujian PMB tidak disimpan";
                    }
                }
            }
        }
        $aksi2 = "";
    }
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    #printmesg( $errmesg );
    
	echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Setting Waktu Per Tahun Masuk Dan Fakultas");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
    echo "					<form action='index.php' method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
								<input type=hidden name=pilihan value='{$pilihan}'>
								<input type=hidden name=aksi value='{$aksi}'>
								<input type=hidden name=sessid value='{$token}'>
								<div class=\"m-portlet__body\">		
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Tahun Masuk</label>\r\n    
										<label class=\"col-form-label\">
											<select name=tahun class=form-control m-input>";
												$i = 1901;
												while ( $i <= $waktu[year] + 5 )
												{
													if ( $i == $waktu[year] )
													{
														$selected = "selected";
													}
													echo "<option {$selected} value='{$i}'>{$i}</option>";
													$selected = "";
													++$i;
												}
    echo "									</select>
										</label>
									</div>";
    unset( $arrayfakultas[''] );
    echo "							<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Fakultas</label>\r\n    
										<label class=\"col-form-label\">
											".createinputselect( "fakultas", $arrayfakultas, "{$fakultas}", "", "class=form-control m-input" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Waktu Ujian</label>\r\n    
										<label class=\"col-form-label\">
											<input type=text size=4 value='{$waktuujian}' name=waktuujian class=form-control m-input style=\"width:auto;display:inline-block;\"> menit
										</label>
									</div> 
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=submit name=aksi2 value='Simpan' class=\"btn btn-brand\">
										</div>
									</div>
								</div>";
    $q = "SELECT * FROM waktuujianpmb_tahunfakultas ORDER BY TAHUN";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        /*printjudulmenukecil( "<b>Data Waktu Ujian PMB</b>" );
        echo "\r\n    <table class=\"table table-striped table-bordered table-hover\">\r\n      <tr class=juduldata align=center>\r\n        <td>Tahun Masuk</td>\r\n        <td>Fakultas</td>\r\n         <td>Waktu Ujian (Menit)</td>\r\n        <td>Tgl Update</td>\r\n        <td>Pengubah</td>\r\n        <td>Hapus</td>\r\n      </tr>\r\n    ";
        */
		echo "			<div class='portlet-title'>";
								printmesg("Data Waktu Ujian PMB");
		echo "			</div>";
		echo "					<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata align=center>\r\n        <td>Tahun Masuk</td>\r\n        <td>Fakultas</td>\r\n         <td>Waktu Ujian (Menit)</td>\r\n        <td>Tgl Update</td>\r\n        <td>Pengubah</td>\r\n        <td>Hapus</td>\r\n      </tr>\r\n    ";
		echo "										</thead>
													<tbody>";
		$i = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            ++$i;
            $kelas = kelas( $i );
            echo "\r\n      <tr {$kelas}>\r\n        <td align=center>{$d['TAHUN']} </td>\r\n        <td align=center> ".$arrayfakultas[$d[FAKULTAS]]." </td>\r\n        <td align=center> {$d['WAKTUUJIAN']} </td>\r\n         <td  align=center>{$d['LASTUPDATE']}</td>\r\n        <td align=center>{$d['UPDATER']}</td>\r\n       <td align=center><a class=\"btn red\" href='index.php?pilihan={$pilihan}&aksi={$aksi}&tahunhapus={$d['TAHUN']}&fakultashapus={$d['FAKULTAS']}&aksi2=hapus&sessid={$token}'\r\n       onClick=\"return confirm('Hapus Setting Waktu Ujian?');\"><i class=\"fa fa-trash\"></i></a></td>      \r\n       </tr>\r\n      ";
        }
        #echo "</table>";
		echo "								</tbody>
								</table>
							</div>
						</div>
					</div>
					<!--end::Section-->
				</div>
				<!--end::Form-->
			</form>
		</div>
		<!--end::Portlet-->";
    }
    else
    {
        printmesg( "Data Setting Waktu Ujian PMB Tidak Ada" );
    }
}
if ( $aksi == 1 )
{
    #printjudulmenu( "SETTING WAKTU UJIAN PER TAHUN MASUK" );
    if ( $aksi2 == "hapus" )
    {
        if ( $_GET['sessid'] != $_SESSION['token'] )
        {
            $errmesg = token_err_mesg( "Setting Waktu Ujian PMB", HAPUS_DATA );
        }
        else
        {
            unset( $_SESSION['token'] );
            $q = "DELETE FROM waktuujianpmb_tahun WHERE TAHUN='{$tahunhapus}'  ";
            mysqli_query($koneksi,$q);
        }
        $aksi2 = "";
    }
    if ( $aksi2 == "Simpan" )
    {
        if ( $_POST['sessid'] != $_SESSION['token'] )
        {
            $errmesg = token_err_mesg( "Jadwal Ujian PMB", SIMPAN_DATA );
        }
        else
        {
            unset( $_SESSION['token'] );
            $vld[] = cekvaliditastahun( "Tahun", $tahun );
            $vld[] = cekvaliditasinteger( "Waktu Ujian", $waktuujian );
            $vld = array_filter( $vld, "filter_not_empty" );
            if ( isset( $vld ) && 0 < count( $vld ) )
            {
                $errmesg = val_err_mesg( $vld, 1 );
            }
            else
            {
                unset( $_SESSION['token'] );
                $q = "INSERT INTO waktuujianpmb_tahun \r\n  (TAHUN,WAKTUUJIAN, LASTUPDATE,UPDATER)\r\n  VALUES \r\n  ('{$tahun}','{$waktuujian}', \r\n  NOW(),'{$users}'\r\n  )\r\n  ";
                mysqli_query($koneksi,$q);
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    $errmesg = "Data Setting Waktu Ujian PMB berhasil disimpan";
                }
                else
                {
                    $q = "UPDATE waktuujianpmb_tahun\r\n        SET\r\n        WAKTUUJIAN='{$waktuujian} ,\r\n        LASTUPDATE=NOW(),\r\n        UPDATER='{$users}'\r\n        WHERE\r\n        TAHUN='{$tahun}'  \r\n        ";
                    mysqli_query($koneksi,$q);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        $errmesg = "Data Setting Waktu Ujian PMB berhasil disimpan";
                    }
                    else
                    {
                        $errmesg = "Data Setting Waktu Ujian PMB tidak disimpan";
                    }
                }
            }
        }
        $aksi2 = "";
    }
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    #printmesg( $errmesg );
    
	 echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Setting Waktu Per Tahun Masuk");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
    echo "					<form action='index.php' method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
								<input type=hidden name=pilihan value='{$pilihan}'>
								<input type=hidden name=aksi value='{$aksi}'>
								<input type=hidden name=sessid value='{$token}'>
								<div class=\"m-portlet__body\">		
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Tahun Masuk</label>\r\n    
										<label class=\"col-form-label\">
											<select name=tahun class=form-control m-input>\r\n              ";
												$i = 1901;
												while ( $i <= $waktu[year] + 5 )
												{
													if ( $i == $waktu[year] )
													{
														$selected = "selected";
													}
													echo "<option {$selected} value='{$i}'>{$i}</option>";
													$selected = "";
													++$i;
												}
echo "										</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Waktu Ujian</label>\r\n    
										<label class=\"col-form-label\">
												<input type=text size=4 value='{$waktuujian}' name=waktuujian class=form-control m-input style=\"width:auto;display:inline-block;\"> menit
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=submit name=aksi2 value='Simpan' class=\"btn btn-brand\">
										</div>
									</div>
								</div>";
    $q = "SELECT * FROM waktuujianpmb_tahun ORDER BY TAHUN";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        /*printjudulmenukecil( "<b>Data Waktu Ujian PMB</b>" );
        echo "\r\n    <table class=\"table table-striped table-bordered table-hover\">\r\n      <tr class=juduldata align=center>\r\n        <td>Tahun Masuk</td>\r\n         <td>Waktu Ujian (Menit)</td>\r\n        <td>Tgl Update</td>\r\n        <td>Pengubah</td>\r\n        <td>Hapus</td>\r\n      </tr>\r\n    ";
        */
		echo "<div class='portlet-title'>";
								printmesg("Data Waktu Ujian PMB");
			echo "			</div>";
			echo "					<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata align=center>\r\n        <td>Tahun Masuk</td>\r\n         <td>Waktu Ujian (Menit)</td>\r\n        <td>Tgl Update</td>\r\n        <td>Pengubah</td>\r\n        <td>Hapus</td>\r\n      </tr>\r\n    
													</thead>
													<tbody>";	
		$i = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            ++$i;
            $kelas = kelas( $i );
            echo "\r\n      <tr {$kelas}>\r\n        <td align=center>{$d['TAHUN']} </td>\r\n        <td align=center> {$d['WAKTUUJIAN']} </td>\r\n         <td  align=center>{$d['LASTUPDATE']}</td>\r\n        <td align=center>{$d['UPDATER']}</td>\r\n       <td align=center><a class=\"btn red\" href='index.php?pilihan={$pilihan}&aksi={$aksi}&tahunhapus={$d['TAHUN']}&aksi2=hapus&sessid={$token}'\r\n       onClick=\"return confirm('Hapus Setting Waktu Ujian?');\"><i class=\"fa fa-trash\"></i></a></td>      \r\n       </tr>\r\n      ";
        }
       # echo "</table></div></div></div></div></div>";
		echo "								</tbody>
								</table>
							</div>
						</div>
					</div>
					<!--end::Section-->
				<!--end::Form-->
			</form>
		</div>
		<!--end::Portlet-->
	</div>
	</div>
	</div>
	</div>";
    }
    else
    {
        printmesg( "Data Setting Waktu Ujian PMB Tidak Ada" );
    }
}
if ( $aksi == "" )
{
    echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
<div class=\"row\">
                <div class=\"col-md-12\">
                
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-body form\">
							<div class='tab-pane' id='tab_1'>
								<div class='portlet box blue'>
									<div class='portlet-title'>
										<div class='caption'>";
											printmesg("Setting Waktu Ujian");
								echo	"</div>
									</div>
									<div class='portlet-body form'>
										<ul>
											<li><a href='index.php?pilihan={$pilihan}&aksi=1'>SETTING UMUM PER TAHUN MASUK</a></li>
											<li><a href='index.php?pilihan={$pilihan}&aksi=2'>SETTING UMUM PER TAHUN MASUK DAN FAKULTAS</a></li>
											<li><a href='index.php?pilihan={$pilihan}&aksi=3'>SETTING UMUM PER TAHUN MASUK, FAKULTAS, DAN GELOMBANG</a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>";
}
?>
