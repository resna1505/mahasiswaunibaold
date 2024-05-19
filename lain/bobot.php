<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
cekhaktulis( $kodemenu );
#printjudulmenu( "Konversi Nilai Default Per Semester Per Prodi" );
printmesg( $errmesg );
if ( $aksi == Hapus )
{
    if ( $_GET['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Bobot Nilai", HAPUS_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $q = "DELETE FROM tbbnl \r\n      WHERE KDPTITBBNL='{$kodept}' AND\r\n      KDPSTTBBNL='{$kodeps}' AND\r\n      KDJENTBBNL='{$kodejenjang}' \r\n      AND THSMSTBBNL='{$tahun}{$semester}' AND\r\n      NLAKHTBBNL='{$idupdate}'\r\n      ";
        mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( koneksi ) )
        {
            $errmesg = "Data berhasil dihapus";
        }
        else
        {
            $errmesg = "Data tidak dihapus";
        }
    }
    $aksi = "";
    $aksi2 = "Tampilkan";
}
if ( $aksi != "" )
{
    include( "formbobot.php" );
}
if ( $aksi == "" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    #printjudulmenukecil( "<b>".IKONTAMBAH." Entri Data Baru" );
   echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Edit Konversi Nilai Umum Per Semester Per Prodi");
				echo "	</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
		echo "					<div class=\"portlet-title\">";
												printmesg("Entri Data Baru");
		echo "			                            
								</div>
						<div class=\"portlet-body form\">";

		echo "				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" action=index.php method=post>\r\n  <input type=hidden name=pilihan value='{$pilihan}'>\r\n  <input type=hidden name=tab value='{$tab}'>
							<div class=\"m-portlet__body\">		
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
									<div class=\"col-lg-6\">
										<select name=idprodi class=form-control m-input>";
											foreach ( $arrayprodidep as $k => $v )
											{
												echo "<option value='{$k}' >{$v}</option>";
											}
    echo "								</select>
									</div>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Tahun Akademik / Semester</label>\r\n    
									<div class=\"col-lg-6\">".createinputtahunajaransemester( $semua = 0, "tahun", "semester", 0, 1 )."  </div>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
									<div class=\"col-lg-6\">
										<input type=submit name=aksi value='Lanjutkan' class=\"btn btn-brand\">										
									</div>
								</div>
							</div>			
							</form>
						</div>
					</div>
				";

   echo "			<div class=\"m-portlet\">	
						<div class=\"portlet-title\">";
												printmesg("Edit Data Bobot Nilai");
	echo "				<div>
						<div class=\"portlet-body form\">";

    #printjudulmenukecil( "<b>".IKONUPDATE." Edit Data Bobot Nilai" );
    echo "	<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" action=index.php method=post>
				<input type=hidden name=pilihan value='{$pilihan}'>\r\n  <input type=hidden name=tab value='{$tab}'>
				<div class=\"m-portlet__body\">		
					<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
						<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
						<div class=\"col-lg-6\">
							<select name=idprodi class=form-control m-input>";
								$selected = "";
								foreach ( $arrayprodidep as $k => $v )
								{
									if ( $idprodi == $k )
									{
										$selected = "selected";
									}
									echo "<option value='{$k}' {$selected}>{$v}</option>";
									$selected = "";
								}
	echo "					</select>
						</div>
					</div>
					<div class=\"form-group m-form__group row\">
						<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
						<div class=\"col-lg-6\">
							<input type=submit name=aksi2 value='Tampilkan' class=\"btn btn-brand\">
							
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	";
    if ( $aksi2 == "Tampilkan" )
    {
        $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$idprodi}'";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            $d = sqlfetcharray( $h );
            $kodept = $d[KDPTIMSPST];
            $kodejenjang = $d[KDJENMSPST];
            $kodeps = $d[KDPSTMSPST];
        }
        $q = "SELECT * FROM tbbnl \r\n      WHERE KDPTITBBNL='{$kodept}' AND\r\n      KDPSTTBBNL='{$kodeps}' AND\r\n      KDJENTBBNL='{$kodejenjang}'\r\n      ORDER BY\r\n      THSMSTBBNL DESC,BOBOTTBBNL DESC\r\n      ";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            #echo "\r\n    <br>\r\n      <table class=\"table table-striped table-bordered table-hover\">\r\n        <tr class=juduldata align=center>\r\n          <td>Semester/Tahun pelaporan</td>\r\n          <td>Nilai Huruf</td>\r\n          <td>Bobot</td>\r\n          <td>Syarat Nilai Angka >=</td>\r\n            <td colspan=2>Aksi</td>\r\n        </tr>";
            echo "<div class=\"m-portlet\">			
					<div class=\"m-section__content\">
						<div class=\"table-responsive\">
							<table class=\"table table-bordered table-hover\">
								<thead>
									 <tr class=juduldata align=center>\r\n          <td>Semester/Tahun pelaporan</td>\r\n          <td>Nilai Huruf</td>\r\n          <td>Bobot</td>\r\n          <td>Syarat Nilai Angka >=</td>\r\n            <td colspan=2>Aksi</td>\r\n        </tr>";
			echo "				</thead>
								<tbody>";
			while ( $d = sqlfetcharray( $h ) )
            {
                $tmp = $d[THSMSTBBNL];
                $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
                $semester = $tmp[4];
                $idupdate = $d[NLAKHTBBNL];
                ++$i;
                $kelas = kelas( $i );
                echo "\r\n          <tr {$kelas} valign=top>\r\n            <td align=center>".$arraysemester[$semester]." {$tahun}/".( $tahun + 1 )."</td>\r\n            <td align=center>{$d['NLAKHTBBNL']}</td>\r\n            <td align=center>{$d['BOBOTTBBNL']}</td>\r\n            <td align=center>{$d['SYARAT']}</td>\r\n            <td align=center><a href='index.php?pilihan={$pilihan}&tab={$tab}&aksi=Lanjutkan&idprodi={$idprodi}&tahun={$tahun}&semester={$semester}&kodept={$kodept}&kodeps={$kodeps}&kodejenjang={$kodejenjang}&idupdate=".urlencode($idupdate)."'><i class=\"fa fa-edit\"></i></td>\r\n            <td align=center ><a onClick='return confirm(\"Hapus data?\");' href='index.php?idprodi={$idprodi}&pilihan={$pilihan}&tab={$tab}&aksi=Hapus&idprodi={$idprodi}&tahun={$tahun}&semester={$semester}&kodept={$kodept}&kodeps={$kodeps}&kodejenjang={$kodejenjang}&idupdate=".urlencode($idupdate)."&sessid={$_SESSION['token']}'><i class=\"fa fa-trash\"></i></td>\r\n          </tr>\r\n          ";
            }
            #echo "\r\n      </table>\r\n    ";
			echo "				</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		
		";
        }
        else
        {
            printmesg( "Data Bobot Nilai untuk Program Studi ".$arrayprodidep[$idprodi]." tidak ada" );
        }
    }
	echo "</div>
		</div>
		</div>
		</div>";
}
?>
