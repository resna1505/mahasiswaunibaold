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
if ( $aksi == "Simpan" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "penandatangan", SIMPAN_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditasnama( "Nama Jabatan di transkrip(1)", $jabatandirektur );
        $vld[] = cekvaliditaskode( "NIDN penandatangan di transkrip(1)", $nipdirektur, 23 );
        $vld[] = cekvaliditasnama( "Nama penandatangan di transkrip(1)", $namadirektur );
        $vld[] = cekvaliditasnama( "Nama Jabatan di transkrip(2)", $jabatandirektur2 );
        $vld[] = cekvaliditaskode( "NIDN penandatangan di transkrip(2)", $nipdirektur2, 23 );
        $vld[] = cekvaliditasnama( "Nama penandatangan di transkrip(2)", $namadirektur2 );
        $vld[] = cekvaliditasnama( "Nama Jabatan di KHS Mengetahui", $jabatankabag );
        $vld[] = cekvaliditaskode( "NIDN penandatangan di KHS Mengetahui", $nipkabag, 23 );
        $vld[] = cekvaliditasnama( "Nama penandatangan di KHS Mengetahui", $namakabag );
        $vld[] = cekvaliditasnama( "Nama Jabatan di KRS", $jabatanbaak );
        $vld[] = cekvaliditaskode( "NIDN penandatangan di KRS", $nipbaak, 23 );
        $vld[] = cekvaliditasnama( "Nama penandatangan di KRS", $namabaak );
        if ( is_array( $jabatan1 ) )
        {
            foreach ( $jabatan1 as $k => $v )
            {
                $vld[] = cekvaliditasnama( "Nama Jabatan di ".$arrayprodi[$k], $jabatan1[$k] );
                $vld[] = cekvaliditaskode( "NIDN di ".$arrayprodi[$k], $nip1[$k] );
                $vld[] = cekvaliditasnama( "Nama di ".$arrayprodi[$k], $nama1[$k] );
                $vld[] = cekvaliditasnama( "Nama Jabatan di ".$arrayprodi[$k], $jabatan2[$k] );
                $vld[] = cekvaliditaskode( "NIDN di ".$arrayprodi[$k], $nip2[$k] );
                $vld[] = cekvaliditasnama( "Nama di ".$arrayprodi[$k], $nama2[$k] );
            }
        }
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $mesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
        }
        else
        {
            $isifile1 = $qupdatefile1 = "";
            if ( $filettd1 != "" )
            {
                $ext = strtolower( array_pop( explode( ".", $filettd1_name ) ) );
                if ( $ext == "jpg" || $ext == "jpeg" || $ext == "png" )
                {
                    $isifile1 = addslashes( file_get_contents( $filettd1 ) );
                    $qupdatefile1 = ",FILE1='{$isifile1}'";
                }
            }
            $isifile2 = $qupdatefile2 = "";
            if ( $filettd2 != "" )
            {
                $ext = strtolower( array_pop( explode( ".", $filettd2_name ) ) );
                if ( $ext == "jpg" || $ext == "jpeg" || $ext == "png" )
                {
                    $isifile2 = addslashes( file_get_contents( $filettd2 ) );
                    $qupdatefile2 = ",FILE2='{$isifile2}'";
                }
            }
            $isifile3 = $qupdatefile3 = "";
            if ( $filettd3 != "" )
            {
                $ext = strtolower( array_pop( explode( ".", $filettd3_name ) ) );
                if ( $ext == "jpg" || $ext == "jpeg" || $ext == "png" )
                {
                    $isifile3 = addslashes( file_get_contents( $filettd3 ) );
                    $qupdatefile3 = ",FILE3='{$isifile3}'";
                }
            }
            $isifile4 = $qupdatefile4 = "";
            if ( $filettd4 != "" )
            {
                $ext = strtolower( array_pop( explode( ".", $filettd4_name ) ) );
                if ( $ext == "jpg" || $ext == "jpeg" || $ext == "png" )
                {
                    $isifile4 = addslashes( file_get_contents( $filettd4 ) );
                    $qupdatefile4 = ",FILE4='{$isifile4}'";
                }
            }
            $isifile5 = $qupdatefile5 = "";
            if ( $filettd5 != "" )
            {
                $ext = strtolower( array_pop( explode( ".", $filettd5_name ) ) );
                if ( $ext == "jpg" || $ext == "jpeg" || $ext == "png" )
                {
                    $isifile5 = addslashes( file_get_contents( $filettd5 ) );
                    $qupdatefile5 = ",FILE5='{$isifile5}'";
                }
            }
            $isifile6 = $qupdatefile6 = "";
            if ( $filettd6 != "" )
            {
                $ext = strtolower( array_pop( explode( ".", $filettd6_name ) ) );
                if ( $ext == "jpg" || $ext == "jpeg" || $ext == "png" )
                {
                    $isifile6 = addslashes( file_get_contents( $filettd6 ) );
                    $qupdatefile6 = ",FILE6='{$isifile6}'";
                }
            }
            $isifile7 = $qupdatefile7 = "";
            if ( $filettd7 != "" )
            {
                $ext = strtolower( array_pop( explode( ".", $filettd7_name ) ) );
                if ( $ext == "jpg" || $ext == "jpeg" || $ext == "png" )
                {
                    $isifile7 = addslashes( file_get_contents( $filettd7 ) );
                    $qupdatefile7 = ",FILE7='{$isifile7}'";
                }
            }
            if ( $hapusfilettd1 == 1 )
            {
                $qupdatefile1 = ",FILE1=''";
            }
            if ( $hapusfilettd2 == 1 )
            {
                $qupdatefile2 = ",FILE2=''";
            }
            if ( $hapusfilettd3 == 1 )
            {
                $qupdatefile3 = ",FILE3=''";
            }
            if ( $hapusfilettd4 == 1 )
            {
                $qupdatefile4 = ",FILE4=''";
            }
            if ( $hapusfilettd5 == 1 )
            {
                $qupdatefile5 = ",FILE5=''";
            }
            if ( $hapusfilettd6 == 1 )
            {
                $qupdatefile6 = ",FILE6=''";
            }
            if ( $hapusfilettd7 == 1 )
            {
                $qupdatefile7 = ",FILE7=''";
            }
            $q = "UPDATE penandatanganumum SET  NIPDIREKTUR='{$nipdirektur}',  NAMADIREKTUR='{$namadirektur}', NIPKABAG='{$nipkabag}',  NAMAKABAG='{$namakabag}', JABATANDIREKTUR='{$jabatandirektur}', JABATANKABAG='{$jabatankabag}',NAMABAAK='{$namabaak}',JABATANBAAK='{$jabatanbaak}',NIPBAAK='{$nipbaak}',NAMADIREKTUR2='{$namadirektur2}',NIPDIREKTUR2='{$nipdirektur2}',JABATANDIREKTUR2='{$jabatandirektur2}', NAMADIREKTUR5='{$namadirektur5}',NIPDIREKTUR5='{$nipdirektur5}',JABATANDIREKTUR5='{$jabatandirektur5}',NAMAKHS='{$namakhs}',NIPKHS='{$nipkhs}',JABATANKHS='{$jabatankhs}',NAMAPASCA='{$namapasca}',NIPPASCA='{$nippasca}',JABATANPASCA='{$jabatanpasca}',LASTUPDATE=NOW(),UPDATER= '{$users}'  {$qupdatefile1}  {$qupdatefile2} {$qupdatefile3} {$qupdatefile4} {$qupdatefile5} {$qupdatefile6} {$qupdatefile7} WHERE ID=0 ";
            mysqli_query($koneksi,$q);
            if ( is_array( $jabatan1 ) )
            {
                foreach ( $jabatan1 as $k => $v )
                {
                    $isifile1 = $qupdatefile1 = "";
                    if ( $file1[$k] != "" )
                    {
                        $ext = strtolower( array_pop( explode( ".", $file1_name[$k] ) ) );
                        if ( $ext == "jpg" || $ext == "jpeg" || $ext == "png" )
                        {
                            $isifile1 = addslashes( file_get_contents( $file1[$k] ) );
                            $qupdatefile1 = ",FILE1='{$isifile1}'";
                        }
                    }
                    $isifile2 = $qupdatefile2 = "";
                    if ( $file2[$k] != "" )
                    {
                        $ext = strtolower( array_pop( explode( ".", $file2_name[$k] ) ) );
                        if ( $ext == "jpg" || $ext == "jpeg" || $ext == "png" )
                        {
                            $isifile2 = addslashes( file_get_contents( $file2[$k] ) );
                            $qupdatefile2 = ",FILE2='{$isifile2}'";
                        }
                    }
                    $isifile3 = $qupdatefile3 = "";
                    if ( $file3[$k] != "" )
                    {
                        $ext = strtolower( array_pop( explode( ".", $file3_name[$k] ) ) );
                        if ( $ext == "jpeg" || $ext == "png" )
                        {
                            $isifile3 = addslashes( file_get_contents( $file3[$k] ) );
                            $qupdatefile3 = ",FILE3='{$isifile3}'";
                        }
                    }
                    if ( $hapusfile1[$k] == 1 )
                    {
                        $qupdatefile1 = ",FILE1=''";
                    }
                    if ( $hapusfile2[$k] == 1 )
                    {
                        $qupdatefile2 = ",FILE2=''";
                    }
                    if ( $hapusfile3[$k] == 1 )
                    {
                        $qupdatefile3 = ",FILE3=''";
                    }
                    $q = "INSERT INTO penandatangan \r\n      (IDPRODI,JABATAN1,NIP1,NAMA1,JABATAN2,NIP2,NAMA2,TANGGALUPDATE,UPDATER,FILE1,FILE2,JABATAN3,NIP3,NAMA3,FILE3) \r\n      VALUES\r\n      ('{$k}','{$v}','".$nip1[$k]."','".$nama1[$k]."',\r\n      '".$jabatan2[$k]."','".$nip2[$k]."','".$nama2[$k]."',\r\n      NOW(),'{$users}','{$isifile1}','{$isifile2}','".$jabatan3[$k]."','".$nip3[$k]."','".$nama3[$k]."','{$isifile3}')\r\n      ";
                    mysqli_query($koneksi,$q);
                    if ( sqlaffectedrows( $koneksi ) <= 0 )
                    {
                        $q = "UPDATE penandatangan \r\n        SET\r\n        JABATAN1='{$v}',NIP1='".$nip1[$k]."',NAMA1='".$nama1[$k]."',\r\n        JABATAN2='".$jabatan2[$k]."',NIP2='".$nip2[$k]."',NAMA2='".$nama2[$k]."',\r\n        JABATAN3='".$jabatan3[$k]."',NIP3='".$nip3[$k]."',NAMA3='".$nama3[$k]."',\r\n        TANGGALUPDATE=NOW(),UPDATER= '{$users}'\r\n        {$qupdatefile1}\r\n        {$qupdatefile2}\r\n        {$qupdatefile3}\r\n \r\n        WHERE\r\n        IDPRODI='{$k}'\r\n        ";
                        mysqli_query($koneksi,$q);
                    }
                }
            }
            $mesg = "Data penandatangan telah disimpan";
        }
    }
}
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
#printjudulmenu( "Penanda Tangan Umum" );
#printmesg( $mesg );
$q = "SELECT * from penandatanganumum WHERE ID=0 ";
$h = mysqli_query($koneksi,$q);
echo mysqli_error($koneksi);
unset( $d );
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
    $nipdirektur = $d[NIPDIREKTUR];
    $namadirektur = $d[NAMADIREKTUR];
    $nipkabag = $d[NIPKABAG];
    $namakabag = $d[NAMAKABAG];
    $jabatandirektur = $d[JABATANDIREKTUR];
    $jabatankabag = $d[JABATANKABAG];
    $namabaak = $d[NAMABAAK];
    $jabatanbaak = $d[JABATANBAAK];
    $nipbaak = $d[NIPBAAK];
    $namadirektur2 = $d[NAMADIREKTUR2];
    $nipdirektur2 = $d[NIPDIREKTUR2];
    $jabatandirektur2 = $d[JABATANDIREKTUR2];
    $namadirektur5 = $d[NAMADIREKTUR5];
    $nipdirektur5 = $d[NIPDIREKTUR5];
    $jabatandirektur5 = $d[JABATANDIREKTUR5];
    $namakhs = $d[NAMAKHS];
    $nipkhs = $d[NIPKHS];
    $jabatankhs = $d[JABATANKHS];
    $namapasca = $d[NAMAPASCA];
    $nippasca = $d[NIPPASCA];
    $jabatanpasca = $d[JABATANPASCA];
}
 echo "	<div class=\"page-content\">
					<div class=\"container-fluid\">
						<div class=\"row\">
							<div class=\"col-md-12\">
								<!-- BEGIN SAMPLE FORM PORTLET-->
								";	
										
			echo "						<div class='portlet-title'>";
											printmesg("Penandatangan Umum");
											printmesg( $errmesg );
			echo "						</div>
								<form name=form action=index.php method=post  ENCTYPE='MULTIPART/FORM-DATA'>
										<input type=hidden name=pilihan value='{$pilihan}'>
										<input type=hidden name=sessid value='{$token}'>\r\n\t";
			echo "					<div class=\"m-portlet\">									
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr align=center>\r\n\t\t\t<td  class=isianjudul>\r\n\t\t\t\t <b>Dokumen\r\n\t\t\t</td>\r\n\t\t\t<td  class=isianjudul>\r\n\t\t\t\t<b>Nama Jabatan\r\n\t\t\t</td>\r\n\t\t\t<td>\r\n\t\t\t\t<b>NIDN\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t<b>Nama\r\n\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t<b>TANDA TANGAN <br>\r\n\t\t\t\t(gambar:jpeg/png)\r\n\t\t\t</td>\r\n\t\t</tr>
													</thead>
													<tbody>
													<tr valign=top>\r\n\t\t\t<td  class=isianjudul>\r\n\t\t\t\tTranskrip (1)\r\n\t\t\t</td>\r\n\t\t\t<td   class=isianjudul>\r\n\t\t\t\t<input type=text name=jabatandirektur size=20 value='{$jabatandirektur}'>\r\n\t\t\t</td>\r\n\t\t\t<td>\r\n \t\t\t\t<input type=text name=nipdirektur size=15 value='{$nipdirektur}'>\r\n\t\t\t\t </td><td>\r\n\t\t\t\t<input type=text name=namadirektur size=20 value='{$namadirektur}'>\r\n\t\t\t</td>\r\n\t\t\t<td>\r\n      <input size=10  type=file name='filettd1'  ><br>";
if ( $d[FILE1] != "" )
{
    echo "\r\n        <img src='lihat.php?field=FILE1' height=75> <br>\r\n        ";
}
echo "\r\n      <input   type=checkbox name='hapusfilettd1' value=1 > hapus file\r\n      </td>\r\n\t\t</tr> \r\n \t\t<tr valign=top>\r\n\t\t\t<td  class=isianjudul>\r\n\t\t\t\tTranskrip (2)\r\n\t\t\t</td>\r\n\t\t\t<td   class=isianjudul>\r\n\t\t\t\t<input type=text name=jabatandirektur2 size=20 value='{$jabatandirektur2}'>\r\n\t\t\t</td>\r\n\t\t\t<td>\r\n\t\t\t\t \r\n\t\t\t\t<input type=text name=nipdirektur2 size=15 value='{$nipdirektur2}'>\r\n\t\t\t\t </td><td>\r\n\t\t\t\t<input type=text name=namadirektur2 size=20 value='{$namadirektur2}'>\r\n\t\t\t</td>\r\n\t\t\t<td>\r\n      <input size=10  type=file name='filettd2'  ><br>";
if ( $d[FILE2] != "" )
{
    echo "\r\n        <img src='lihat.php?field=FILE2' height=75> <br>\r\n        ";
}
echo "\r\n      <input   type=checkbox name='hapusfilettd2' value=1 > hapus file\r\n      </td>\r\n\t\t</tr>";
if ( $UNIVERSITAS == "UNIKAL" )
{
    echo "\r\n \t\t<tr valign=top>\r\n\t\t\t<td  class=isianjudul>\r\n\t\t\t\tTranskrip Sementara\r\n\t\t\t</td>\r\n\t\t\t<td   class=isianjudul>\r\n\t\t\t\t<input type=text name=jabatandirektur5 size=20 value='{$jabatandirektur5}'>\r\n\t\t\t</td>\r\n\t\t\t<td>\r\n\t\t\t\t \r\n\t\t\t\t<input type=text name=nipdirektur5 size=15 value='{$nipdirektur5}'>\r\n\t\t\t\t </td><td>\r\n\t\t\t\t<input type=text name=namadirektur5 size=20 value='{$namadirektur5}'>\r\n\t\t\t</td>\r\n\t\t\t<td>\r\n      <input size=10  type=file name='filettd5'  ><br>";
    if ( $d[FILE5] != "" )
    {
        echo "\r\n        <img src='lihat.php?field=FILE5' height=75> <br>\r\n        ";
    }
    echo "\r\n      <input   type=checkbox name='hapusfilettd5' value=1 > hapus file\r\n      </td>\r\n\t\t</tr>\t\t\r\n\r\n";
}
echo "\t\t\r\n \t\t<tr valign=top>\r\n\t\t\t<td   class=isianjudul>\r\n\t\t\t\tKHS-Kiri (Mengetahui)\r\n\t\t\t</td>\r\n\t\t\t<td   class=isianjudul>\r\n\t\t\t\t<input type=text name=jabatankabag size=20 value='{$jabatankabag}'>\r\n\t\t\t</td>\r\n\t\t\t<td>\r\n\t\t\t \r\n\t\t\t\t<input type=text name=nipkabag size=15 value='{$nipkabag}'>\r\n\t\t\t\t </td><td>\r\n\t\t\t\t<input type=text name=namakabag size=20 value='{$namakabag}'>\r\n\t\t\t</td>\r\n\t\t\t<td>\r\n      <input size=10  type=file name='filettd3'  ><br>";
if ( $d[FILE3] != "" )
{
    echo "\r\n        <img src='lihat.php?field=FILE3' height=75> <br>\r\n        ";
}
echo "\r\n      <input   type=checkbox name='hapusfilettd3' value=1 > hapus file\r\n      </td>\r\n\t\t</tr>\r\n \t\t<tr valign=top>\r\n\t\t\t<td   class=isianjudul>\r\n\t\t\t\tKHS-Kanan  <br>\r\n\t\t\t\t(Jika dikosongkan akan diambil dari data Ka-Prodi)\r\n\t\t\t</td>\r\n\t\t\t<td   class=isianjudul>\r\n\t\t\t\t<input type=text name=jabatankhs size=20 value='{$jabatankhs}'>\r\n\t\t\t</td>\r\n\t\t\t<td>\r\n\t\t\t \r\n\t\t\t\t<input type=text name=nipkhs size=15 value='{$nipkhs}'>\r\n\t\t\t\t </td><td>\r\n\t\t\t\t<input type=text name=namakhs  size=20 value='{$namakhs}'>\r\n\t\t\t</td>\r\n\t\t\t<td>\r\n      <input size=10  type=file name='filettd6'  ><br>";
if ( $d[FILE6] != "" )
{
    echo "\r\n        <img src='lihat.php?field=FILE6' height=75> <br>\r\n        ";
}
echo "\r\n      <input   type=checkbox name='hapusfilettd6' value=1 > hapus file\r\n      </td>\r\n\t\t</tr>\r\n\r\n\r\n \t\t<tr valign=top>\r\n\t\t\t<td   class=isianjudul>\r\n\t\t\t\tKRS\r\n\t\t\t</td>\r\n\t\t\t<td   class=isianjudul>\r\n\t\t\t\t<input type=text name=jabatanbaak size=20 value='{$jabatanbaak}'>\r\n\t\t\t</td>\r\n\t\t\t<td>\r\n\t\t\t \r\n\t\t\t\t<input type=text name=nipbaak size=15 value='{$nipbaak}'>\r\n\t\t\t\t </td><td>\r\n\t\t\t\t<input type=text name=namabaak size=20 value='{$namabaak}'>\r\n\t\t\t</td>\r\n\t\t\t<td>\r\n      <input size=10  type=file name='filettd4'  ><br>";
if ( $d[FILE4] != "" )
{
    echo "\r\n        <img src='lihat.php?field=FILE4' height=75> <br>\r\n        ";
}
echo "\r\n      <input   type=checkbox name='hapusfilettd4' value=1 > hapus file\r\n      </td>\r\n\t\t</tr>";
if ( $UNIVERSITAS == "UNIVERSITAS 17 AGUSTUS 1945" )
{
    echo "\r\n \t\t<tr valign=top>\r\n\t\t\t<td   class=isianjudul>\r\n\t\t\t\tTranskrip Pasca Sarjana\r\n\t\t\t</td>\r\n\t\t\t<td   class=isianjudul>\r\n\t\t\t\t<input type=text name=jabatanpasca size=20 value='{$jabatanpasca}'>\r\n\t\t\t</td>\r\n\t\t\t<td>\r\n\t\t\t \r\n\t\t\t\t<input type=text name=nippasca size=15 value='{$nippasca}'>\r\n\t\t\t\t </td><td>\r\n\t\t\t\t<input type=text name=namapasca size=20 value='{$namapasca}'>\r\n\t\t\t</td>\r\n\t\t\t<td>\r\n      <input size=10  type=file name='filettd7'  ><br>";
    if ( $d[FILE7] != "" )
    {
        echo "\r\n        <img src='lihat.php?field=FILE7' height=75> <br>\r\n        ";
    }
    echo "\r\n      <input   type=checkbox name='hapusfilettd7' value=1 > hapus file\r\n      </td>\r\n\t\t</tr>";
}
echo "					<tr>\r\n \r\n\t\t\t<td colspan=5>\r\n\t\t\t<br>\r\n\t\t\t\t<input type=submit name=aksi value='Simpan' class=\"btn btn-brand\"><input type=reset value='Reset' class=\"btn btn-secondary\">\r\n\t\t\t</td>\r\n\t\t</tr>";
echo "				</tbody>
				</table>
			</div>
		</div>
	</div>";

echo "				<div class='portlet-title'>";
						printmesg("Data Penandatangan Per Program Studi");			
echo "				</div>
					<div class='portlet-title'>";
						printmesg("Catatan: Penandatangan KHS/KRS yang diprioritaskan adalah data Program Studi, jika tidak ada/kosong, maka digunakan data penandatangan Umum.");
echo "				</div>";
					
/*echo "\r\n  Catatan: Penandatangan KHS/KRS yang diprioritaskan adalah data Program Studi, jika tidak ada/kosong, maka digunakan data penandatangan Umum.\r\n\t<table   border=0  class=isian width=95%>\r\n\t   <tr  valign=top align=center>\r\n      <td><b>Program Studi</td>\r\n      <td><b>Dokumen</td>\r\n      <td><b>Keterangan</td>\r\n       <td><b>TANDA TANGAN (gambar:jpg/png)</td>\r\n     </tr>\r\n \r\n  \r\n  ";
*/
echo "			<div class=\"m-portlet\">			
					<div class=\"m-section__content\">
						<div class=\"table-responsive\">
							<table class=\"table table-bordered table-hover\">
								<thead>
									<tr  valign=top align=center>\r\n      <td><b>Program Studi</td>\r\n      <td><b>Dokumen</td>\r\n      <td><b>Keterangan</td>\r\n       <td><b>TANDA TANGAN (gambar:jpg/png)</td>\r\n     </tr>\r\n \r\n  \r\n 
								</thead>
								<tbody>";
foreach ( $arrayprodidep as $k => $v )
{
    $q = "SELECT * from penandatangan WHERE IDPRODI='{$k}'";
    $h = mysqli_query($koneksi,$q);
    unset( $d );
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
    }
    echo "\r\n\t   <tr valign=top>\r\n      <td   valign=center rowspan=3>\r\n          <b>{$v} \r\n      </td>\r\n       <td nowrap >KHS-Kiri (Mengetahui)</td>\r\n       <td nowrap>\r\n       <b>Jabatan<br>\r\n       <input size=25 type=text name='jabatan1[{$k}]' value='{$d['JABATAN1']}'><br>\r\n       NIDN<br>\r\n       <input size=25 type=text name='nip1[{$k}]' value='{$d['NIP1']}'><br>\r\n       Nama<br>\r\n       <input size=25 type=text name='nama1[{$k}]' value='{$d['NAMA1']}'></td>\r\n      <td nowrap>\r\n      <input  size=10 type=file name='file1[{$k}]'  ><br>";
    if ( $d[FILE1] != "" )
    {
        echo "\r\n        <img src='lihat.php?idprodi={$k}&field=FILE1' height=75> <br>\r\n        ";
    }
    echo "\r\n      <input   type=checkbox name='hapusfile1[{$k}]' value=1 > hapus file\r\n      </td>\r\n     </tr>\r\n\t   <tr valign=top>\r\n \r\n       <td nowrap >KHS-Kanan  </td>\r\n       <td nowrap>\r\n       <b>Jabatan<br>\r\n       <input size=25 type=text name='jabatan3[{$k}]' value='{$d['JABATAN3']}'><br>\r\n       NIDN<br>\r\n       <input size=25 type=text name='nip3[{$k}]' value='{$d['NIP3']}'><br>\r\n       Nama<br>\r\n       <input size=25 type=text name='nama3[{$k}]' value='{$d['NAMA3']}'></td>\r\n      <td nowrap>\r\n      <input  size=10 type=file name='file3[{$k}]'  ><br>";
    if ( $d[FILE3] != "" )
    {
        echo "\r\n        <img src='lihat.php?idprodi={$k}&field=FILE3' height=75> <br>\r\n        ";
    }
    echo "\r\n      <input   type=checkbox name='hapusfile3[{$k}]' value=1 > hapus file\r\n      </td>\r\n     </tr>\r\n\r\n\r\n\r\n\t   <tr  valign=top>\r\n       <td  >KRS</td>\r\n       <td nowrap>\r\n       <b>Jabatan<br>\r\n       <input size=25 type=text name='jabatan2[{$k}]' value='{$d['JABATAN2']}'> <br>\r\n       NIDN<br>\r\n       <input size=25 type=text name='nip2[{$k}]' value='{$d['NIP2']}'> <br>\r\n       Nama<br>\r\n       <input size=25 type=text name='nama2[{$k}]' value='{$d['NAMA2']}'></td>\r\n      <td nowrap>\r\n      <input size=10  type=file name='file2[{$k}]'  ><br>";
    if ( $d[FILE2] != "" )
    {
        echo "\r\n        <img src='lihat.php?idprodi={$k}&field=FILE2' height=75> <br>\r\n        ";
    }
    echo "\r\n      <input   type=checkbox name='hapusfile2[{$k}]' value=1 > hapus file\r\n      </td>\r\n     </tr>\r\n     \r\n     ";
}
echo "							</tbody>
							</table>
						</div>
					</div>
				</div>
			</form>
			</div>
		</div>
	</div>
	</div>";
?>
