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
if ( $prodis == "" )
{
    cekhaktulis( $kodemenu );
    //printjudulmenu( "Edit Waktu KRS SP Online -  KHUSUS" );
	echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
<div class=\"row\">
                <div class=\"col-md-12\">
                
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-body form\"><div class='tab-pane' id='tab_1'>
								<div class='portlet box blue'>
									<div class='portlet-title'>
										<div class='caption'>";
											printmesg("Edit Waktu KRS Semester Pendek Online -  KHUSUS");
								echo	"</div>
									</div>";
    if ( $aksi == "hapus" )
    {
        if ( $_GET['sessid'] != $_SESSION['token'] )
        {
            $errmesg = token_err_mesg( "Waktu KRS SP Online", HAPUS_DATA );
        }
        else
        {
            unset( $_SESSION['token'] );
            $q = "DELETE FROm waktukrsprodisp WHERE TAHUN='{$tahunhapus}' AND SEMESTER='{$semesterhapus}'\r\n  AND ANGKATAN='{$angkatanhapus}' AND PRODI='{$idprodihapus}'";
            mysqli_query($koneksi,$q);
        }
        $aksi = "Tampilkan";
    }
    if ( $aksi == "Simpan" )
    {
        if ( $_POST['sessid'] != $_SESSION['token'] )
        {
            $errmesg = token_err_mesg( "Waktu KRS SP Online", SIMPAN_DATA );
        }
        else
        {
            unset( $_SESSION['token'] );
            $vld[] = cekvaliditasthnajaran( "Tahun/Semester", $tahun, $semester );
            $vld[] = cekvaliditastanggal( "Tanggal Mulai", $mulai['tgl'], $mulai['bln'], $mulai['thn'] );
            $vld[] = cekvaliditastanggal( "Tanggal Selesai", $selesai['tgl'], $selesai['bln'], $selesai['thn'] );
            $vld = array_filter( $vld, "filter_not_empty" );
            if ( isset( $vld ) && 0 < count( $vld ) )
            {
                $errmesg = val_err_mesg( $vld, 1 );
            }
            else
            {
                unset( $_SESSION['token'] );
                $q = "INSERT INTO waktukrsprodisp \r\n  (TAHUN,SEMESTER,TANGGALMULAI,TANGGALSELESAI,LASTUPDATE,UPDATER,PRODI,ANGKATAN)\r\n  VALUES \r\n  ('{$tahun}','{$semester}',\r\n  '{$mulai['thn']}-{$mulai['bln']}-{$mulai['tgl']}',\r\n  '{$selesai['thn']}-{$selesai['bln']}-{$selesai['tgl']}',\r\n  NOW(),'{$users}','{$idprodi}','{$angkatan}'\r\n  )\r\n  ";
                mysqli_query($koneksi,$q);
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    $errmesg = "Data waktu KRS SP online berhasil disimpan";
                }
                else
                {
                    $q = "UPDATE waktukrsprodisp \r\n        SET\r\n        TANGGALMULAI='{$mulai['thn']}-{$mulai['bln']}-{$mulai['tgl']}',\r\n        TANGGALSELESAI='{$selesai['thn']}-{$selesai['bln']}-{$selesai['tgl']}',\r\n        LASTUPDATE=NOW(),\r\n        UPDATER='{$users}'\r\n        WHERE\r\n        TAHUN='{$tahun}' AND\r\n         SEMESTER='{$semester}' AND\r\n         ANGKATAN='{$angkatan}' AND\r\n         PRODI='{$idprodi}'\r\n        ";
                    mysqli_query($koneksi,$q);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        $errmesg = "Data waktu KRS SP online berhasil disimpan";
                    }
                    else
                    {
                        $errmesg = "Data waktu KRS SP online tidak disimpan";
                    }
                }
            }
        }
        $aksi = "";
    }
    if ( $aksi == "Tampilkan" )
    {
        $qfield = $jfield = $href = "";
        if ( $ifangkatan == 1 )
        {
            $qfield .= " AND ANGKATAN='{$angkatan}' ";
            $jfield .= " Angkatan {$angkatan} <br>";
            $href .= "&ifangkatan={$ifangkatan}&angkatan={$angkatan}";
        }
        if ( $ifprodi == 1 )
        {
            $qfield .= " AND PRODI='{$idprodi}' ";
            $jfield .= " Prodi ".$arrayprodidep[$idprodi]." <br>";
            $href .= "&ifprodi={$ifprodi}&idprodi={$idprodi}";
        }
        if ( $iftahun == 1 )
        {
            $qfield .= " AND TAHUN='{$tahun}' AND SEMESTER = '{$semester}' ";
            $jfield .= " Prodi ".( $tahun - 1 )."/{$tahun} ".$arraysemester[$semester]." <br>";
            $href .= "&iftahun={$iftahun}&tahun={$tahun}&semester={$semester}";
        }
        $aksi = "";
        $aksi2 = "Tampilkan";
    }
    if ( $aksi == "" )
    {
        $token = md5( uniqid( rand( ), TRUE ) );
        $_SESSION['token'] = $token;
        printmesg( $errmesg );
        echo "\r\n    <form action='index.php' method=post >\r\n      <input type=hidden name=pilihan value='{$pilihan}'>\r\n\t  <input type=hidden name=sessid value='{$token}'>";
		echo "<div class='portlet-body form'>
				<table class=\"table table-striped table-bordered table-hover\">";
		echo "		<tr>\r\n          <td>Tahun/Semester</td>\r\n          <td>\r\n            <select name=tahun>\r\n              ";
        $i = 1901;
        while ( $i <= $waktu[year] + 5 )
        {
            if ( $i == $waktu[year] + 1 )
            {
                $selected = "selected";
            }
            echo "<option {$selected} value='{$i}'>".( $i - 1 )."/{$i}</option>";
            $selected = "";
            ++$i;
        }
        echo "\r\n            </select>/\r\n            <select name=semester>\r\n            ";
        foreach ( $arraysemester as $k => $v )
        {
            echo "<option value='{$k}'>{$v}</option>";
        }
        echo "\r\n            </select>\r\n          </td>\r\n        </tr>\r\n        <tr class=judulform>\r\n    \t\t\t<td>Jurusan / Program Studi</td>\r\n    \t\t\t<td>".createinputselect( "idprodi", $arrayprodidep, $idprodi, "", " class=masukan" )."</td>\r\n    \t\t</tr>        \r\n    \r\n        <tr>\r\n          <td>Angkatan</td>\r\n          <td>";
        $q = "SELECT DISTINCT ANGKATAN FROM mahasiswa ORDER BY ANGKATAN";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            unset( $arrayangkatan );
            echo "\r\n                <select name=angkatan>\r\n                  ";
            while ( $d = sqlfetcharray( $h ) )
            {
                if ( $d[ANGKATAN] == $waktu[year] - 1 )
                {
                    $selected = "selected";
                }
                $arrayangkatan[$d[ANGKATAN]] = $d[ANGKATAN];
                echo "<option {$selected} value='{$d['ANGKATAN']}'>{$d['ANGKATAN']}</option>";
                $selected = "";
            }
            echo "\r\n                </select> ";
        }
        echo "\r\n          </td>\r\n        </tr>\r\n        <tr>\r\n          <td>Tanggal Mulai</td>\r\n          <td>".createinputtanggal( "mulai", "", "" )."</td>\r\n        </tr>\r\n        <tr>\r\n          <td>Tanggal Selesai</td>\r\n          <td>".createinputtanggal( "selesai", "", "" )."</td>\r\n        </tr>\r\n        <tr>\r\n          <td></td>\r\n          <td><input type=submit name=aksi value='Simpan' class=\"btn btn-brand\"></td>\r\n        </tr>\r\n      </table>\r\n    </form>\r\n    <hr>\r\n  ";
        echo "\r\n    <form action='index.php' method=post >\r\n      <input type=hidden name=pilihan value='{$pilihan}'>";
		echo "<div class='portlet-body form'>
				<table class=\"table table-striped table-bordered table-hover\">";
		echo "	<tr>\r\n          <td>Tahun/Semester</td>\r\n          <td>: \r\n          <input type=checkbox name=iftahun value=1>\r\n            <select name=tahun>\r\n              ";
        $i = 1901;
        while ( $i <= $waktu[year] + 5 )
        {
            if ( $i == $waktu[year] + 1 )
            {
                $selected = "selected";
            }
            echo "<option {$selected} value='{$i}'>".( $i - 1 )."/{$i}</option>";
            $selected = "";
            ++$i;
        }
        echo "\r\n            </select>/\r\n            <select name=semester>\r\n            ";
        foreach ( $arraysemester as $k => $v )
        {
            echo "<option value='{$k}'>{$v}</option>";
        }
        echo "\r\n            </select>\r\n          </td>\r\n        </tr>\r\n    <tr>\r\n      <td>\r\n        Prodi \r\n      </td>\r\n      <td>:  \r\n          <input type=checkbox name=ifprodi value=1>\r\n        <select name=idprodi>\r\n         ";
        foreach ( $arrayprodidep as $k => $v )
        {
            if ( $k == $idprodi )
            {
                $selected = "selected";
            }
            echo "<option {$selected} value='{$k}'>{$v}</option>";
            $selected = "";
        }
        echo "\r\n        </select>\r\n        \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        Angkatan \r\n        </td><td>: \r\n           <input type=checkbox name=ifangkatan value=1>\r\n       <select name=angkatan>\r\n         ";
        foreach ( $arrayangkatan as $k => $v )
        {
            if ( $k == $waktu[year] - 1 )
            {
                $selected = "selected";
            }
            echo "<option {$selected} value='{$k}'>{$k}</option>";
            $selected = "";
        }
        echo "\r\n        </select>\r\n      </td>\r\n    </tr>\r\n        <tr>\r\n          <td></td>\r\n          <td><input type=submit name=aksi value='Tampilkan' class=\"btn btn-brand\"></td>\r\n        </tr>\r\n  </table>\r\n</form>  \r\n  ";
        if ( $aksi2 == "Tampilkan" )
        {
            $q = "SELECT * FROM waktukrsprodisp \r\n  WHERE 1=1\r\n  {$qfield}\r\n  ORDER BY TAHUN DESC,SEMESTER,PRODI,ANGKATAN DESC";
            $h = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                #printjudulmenukecil( "<b>Data Waktu KRS SP Online Khusus</b>" );
                #printjudulmenukecil( $jfield );
                #echo "\r\n    <table>\r\n      <tr class=juduldata align=center>\r\n        <td>Tahun/Semester</td>\r\n        <td>Program Studi</td>\r\n        <td>Angkatan</td>\r\n        <td>Mulai</td>\r\n        <td>Selesai</td>\r\n        <td>Tgl Update</td>\r\n        <td>Pengubah</td>\r\n        <td>Hapus</td>\r\n      </tr>\r\n    ";
                echo "<div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">";
                                printmesg("Data Waktu KRS SP Online Khusus");
            echo "           </div>
                        </div>";
                                
            echo "<div class=\"m-portlet\">			
					<div class=\"m-section__content\">
						<div class=\"table-responsive\">
							<table class=\"table table-bordered table-hover\">";
			echo "				<thead>
									<tr class=juduldata align=center>\r\n        <td>Tahun/Semester</td>\r\n        <td>Program Studi</td>\r\n        <td>Angkatan</td>\r\n        <td>Mulai</td>\r\n        <td>Selesai</td>\r\n        <td>Tgl Update</td>\r\n        <td>Pengubah</td>\r\n        <td>Hapus</td>\r\n      </tr>\r\n  
								</thead>
								<tbody>";
				$i = 0;
                while ( $d = sqlfetcharray( $h ) )
                {
                    ++$i;
                    $kelas = kelas( $i );
                    $tmp = explode( "-", $d[TANGGALMULAI] );
                    $tglmulai = $tmp[2];
                    $blnmulai = $tmp[1];
                    $thnmulai = $tmp[0];
                    $tmp = explode( "-", $d[TANGGALSELESAI] );
                    $tglselesai = $tmp[2];
                    $blnselesai = $tmp[1];
                    $thnselesai = $tmp[0];
                    echo "\r\n      <tr {$kelas}>\r\n        <td nowrap>".( $d[TAHUN] - 1 )."/{$d['TAHUN']} ".$arraysemester[$d[SEMESTER]]."</td>\r\n        <td nowrap>".$arrayprodidep[$d[PRODI]]."</td>\r\n        <td align=center>{$d['ANGKATAN']}</td>\r\n        <td  nowrap align=center><b>{$tglmulai} ".$arraybulan[$blnmulai - 1]." {$thnmulai} </td>\r\n        <td   nowrap align=center><b>{$tglselesai} ".$arraybulan[$blnselesai - 1]." {$thnselesai} </td>\r\n        <td   nowrap align=center>{$d['LASTUPDATE']}</td>\r\n        <td align=center>{$d['UPDATER']}</td>\r\n       <td align=center><a href='index.php?pilihan={$pilihan}&tahunhapus={$d['TAHUN']}&semesterhapus={$d['SEMESTER']}&angkatanhapus={$d['ANGKATAN']}&idprodihapus={$d['PRODI']}&aksi=hapus&sessid={$token}{$href}'\r\n       onClick=\"return confirm('Hapus waktu KRS SP Online?');\"><i class=\"fa fa-trash\"></i></a></td>      \r\n       </tr>\r\n      ";
                }
                #echo "</table>\r\n    <br>";
				echo "					</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>";
            }
            else
            {
                printmesg( "Data Waktu KRS SP Online Khusus Tidak Ada. <br>{$jfield}" );
            }
        }
    }
}
else
{
    printmesg( "Operator Prodi tidak boleh mengakses fasilitas ini" );
}
?>
