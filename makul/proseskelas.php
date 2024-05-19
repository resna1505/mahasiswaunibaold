<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function add0( $angka )
{
    $hasil = "{$angka}";
    if ( $angka <= 10 )
    {
        $hasil = "0{$angka}";
    }
    return $hasil;
}

if ( $Update == "Update Kelas" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Kelas", SIMPAN_DATA );
        unset( $_SESSION['token'] );
    }
    else if ( is_array( $kelasbaru ) )
    {
        $vld[] = cekvaliditasinteger( "Semester", $semesterk, 2 );
        $vld[] = cekvaliditaskodemakul( "Kode Makul", $idupdate, 2 );
        foreach ( $kelasbaru as $k => $v )
        {
            $vld[] = cekvaliditasnim( "NIM {$k}", $k );
            $vld[] = cekvaliditasinteger( "KELAS '{$v}' untuk mahasiswa dengan NIM '{$k}'", $v, 2 );
        }
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2 );
        }
        else
        {
            foreach ( $kelasbaru as $k => $v )
            {
                $q = "\r\n        UPDATE pengambilanmk SET\r\n        KELAS='{$v}' WHERE\r\n        IDMAHASISWA='{$k}' AND TAHUN='{$tahunk}' AND SEMESTER='{$semesterk}' AND\r\n        IDMAKUL='{$idupdate}' \r\n      ";
                mysqli_query($koneksi,$q);
            }
        }
    }
}
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
#printjudulmenu( "Pembagian Kelas Mata Kuliah" );
printmesg( $errmesg );
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
                                <span class=\"caption-subject bold uppercase\"> Pembagian Kelas Mata Kuliah </span>
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
                    <div class=\"portlet light\">
                        <div class=\"portlet-body form\"><div class='tab-pane' id='tab_1'>
								<div class='portlet box blue'>
									<div class='portlet-title'>
										<div class='caption'>";
											printmesg("Pembagian Kelas Mata Kuliah");
								echo	"</div>
									</div>";
#echo "\r\n  <form method=post action=index.php>\r\n  <table class=\"table table-striped table-bordered table-hover\">\r\n  <tr>\r\n    <td>Kurikulum</td>\r\n    <td>:</td>\r\n    <td><b>".( $tahunk - 1 )."/{$tahunk} ".$arraysemester[$semesterk]."</td>\r\n  </tr>\r\n  <tr>\r\n    <td>Program Studi</td>\r\n    <td>:</td>\r\n    <td><b>".$arrayprodidep[$idprodi]."</td>\r\n  </tr>\r\n  <tr>\r\n    <td>Mata Kuliah</td>\r\n    <td>:</td>\r\n    <td><b> {$idupdate} - ".getnamamk( $idupdate, ( $tahunk - 1 )."{$semesterk}", $idprodi )."</td>\r\n  </tr>\r\n  <tr>\r\n    <td>SKS/Semester</td>\r\n    <td>:</td>\r\n    <td><b> {$sks}/{$semkul}</td>\r\n  </tr>\r\n  </table> </div></div></div>";
echo "<form method=post action=index.php>
			<div class=\"m-portlet\">			
					<div class=\"m-section__content\">
						<div class=\"table-responsive\">
							<table class=\"table table-bordered table-hover\">
								";
echo " <tr>\r\n    <td>Kurikulum</td>\r\n    <td>:</td>\r\n    <td><b>".( $tahunk - 1 )."/{$tahunk} ".$arraysemester[$semesterk]."</td>\r\n  </tr>\r\n  <tr>\r\n    <td>Program Studi</td>\r\n    <td>:</td>\r\n    <td><b>".$arrayprodidep[$idprodi]."</td>\r\n  </tr>\r\n  <tr>\r\n    <td>Mata Kuliah</td>\r\n    <td>:</td>\r\n    <td><b> {$idupdate} - ".getnamamk( $idupdate, ( $tahunk - 1 )."{$semesterk}", $idprodi )."</td>\r\n  </tr>\r\n  <tr>\r\n    <td>SKS/Semester</td>\r\n    <td>:</td>\r\n    <td><b> {$sks}/{$semkul}</td>\r\n  </tr>\r\n  </table> </div></div></div>";
if ( $aksi != "cetak" )
{
    /*echo "<div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Filter/Aturan Pembagian Kelas </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>";*/
	echo "<div class=\"portlet light\">
                        <div class=\"portlet-body form\"><div class='tab-pane' id='tab_1'>
								<div class='portlet box blue'>
									<div class='portlet-title'>
										<div class='caption'>";
											printmesg("Filter/Aturan Pembagian Kelas");
								echo	"</div>
									</div>";
   # echo "\r\n  <table class=\"table table-striped table-bordered table-hover\">\r\n  <tr>\r\n    \r\n   </tr>\r\n  <tr>\r\n    <td>Jumlah Maksimum Mhs Per kelas</td>\r\n    <td>:</td>";
    echo "<div class=\"m-portlet\">			
					<div class=\"m-section__content\">
						<div class=\"table-responsive\">
							<table class=\"table table-bordered table-hover\">
								";
	echo "<tr>\r\n    \r\n   </tr>\r\n  <tr>\r\n    <td>Jumlah Maksimum Mhs Per kelas</td>\r\n    <td>:</td>";
	if ( $jmlmax == "" || $jmlmax == 0 )
    {
        $jmlmax = 10;
    }
    echo "\r\n    <td ><input type=text size=2 name=jmlmax value='{$jmlmax}'></td></tr><tr><td colspan=3> <input type=submit name=Update value='Simulasi Pembagian Kelas' class=\"btn btn-brand\">\r\n    </td>\r\n  </tr>\r\n\r\n</table></div></div></div>";
    $q = "SELECT count(IDMAHASISWA) AS JML\r\nFROM pengambilanmk,mahasiswa\r\nWHERE\r\npengambilanmk.IDMAHASISWA=mahasiswa.ID AND\r\nTAHUN='{$tahunk}' AND SEMESTER='{$semesterk}'\r\nAND IDMAKUL='{$idupdate}' AND IDPRODI='{$idprodi}'\r\n \r\n";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $totalmhs = $d[JML];
    $maxkelas = ceil( $totalmhs / $jmlmax );
}
$q = "SELECT mahasiswa.ID,mahasiswa.NAMA,pengambilanmk.KELAS \r\nFROM pengambilanmk,mahasiswa\r\nWHERE\r\npengambilanmk.IDMAHASISWA=mahasiswa.ID AND\r\nTAHUN='{$tahunk}' AND SEMESTER='{$semesterk}'\r\nAND IDMAKUL='{$idupdate}' AND IDPRODI='{$idprodi}'\r\nORDER BY KELAS,ID\r\n";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    #echo "\r\n  \r\n\r\n  <input type=hidden name=pilihan value='{$pilihan}'>\r\n  <input type=hidden name=aksi value='{$aksi}'>\r\n  <input type=hidden name=tahunk value='{$tahunk}'>\r\n  <input type=hidden name=semesterk value='{$semesterk}'>\r\n  <input type=hidden name=idupdate value='{$idupdate}'>\r\n  <input type=hidden name=idprodi value='{$idprodi}'>\r\n  <input type=hidden name=sks value='{$sks}'>\r\n  <input type=hidden name=semkul value='{$semkul}'>\r\n  <input type=hidden name=sessid value='{$token}'>\r\n \r\n  <table class=\"table table-striped table-bordered table-hover\">";
    echo "\r\n  \r\n\r\n  <input type=hidden name=pilihan value='{$pilihan}'>\r\n  <input type=hidden name=aksi value='{$aksi}'>\r\n  <input type=hidden name=tahunk value='{$tahunk}'>\r\n  <input type=hidden name=semesterk value='{$semesterk}'>\r\n  <input type=hidden name=idupdate value='{$idupdate}'>\r\n  <input type=hidden name=idprodi value='{$idprodi}'>\r\n  <input type=hidden name=sks value='{$sks}'>\r\n  <input type=hidden name=semkul value='{$semkul}'>\r\n  <input type=hidden name=sessid value='{$token}'>";
    
	if ( $aksi != "cetak" )
    {
		echo "<div class=\"m-portlet\">			
					<div class=\"m-section__content\">
						<div class=\"table-responsive\">
							<table class=\"table table-bordered table-hover\">
								<thead>";
        echo "\r\n    <tr class=juduldata  align=center>\r\n       \r\n      <td colspan=6 align=right> <input type=submit name=Update value='Update Kelas' class=\"btn btn-brand\"></td>\r\n    </tr>   ";

	}
    echo "\r\n     <tr class=juduldata{$cetak}  align=center>\r\n      <td>No</td>\r\n      <td>NIM</td>\r\n      <td>Nama Mahasiswa</td>\r\n      <td>Status</td>\r\n      <td>Kelas </td>";
    if ( $aksi != "cetak" )
    {
        echo "\r\n      <td>Kelas<br>Baru/Simulasi</td>";
    }
    echo "\r\n    </tr>\r\n  ";
			echo "					</thead>
								<tbody>";

    $i = 1;
    $jmlbaru = $jmllama = 0;
    $kelasawal = 1;
    $arraykelassim[$kelasawal] = 0;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        $q = "SELECT COUNT(*) AS JML \r\n    FROM pengambilanmk\r\n    WHERE IDMAHASISWA='{$d['ID']}' AND IDMAKUL='{$idupdate}'\r\n    AND TAHUN<='{$tahunk}'";
        $hj = mysqli_query($koneksi,$q);
        $dj = sqlfetcharray( $hj );
        $statusdj = $dj[JML];
        if ( $statusdj <= 1 )
        {
            $statuspengambilan = "Baru";
            ++$jmlbaru;
        }
        else
        {
            $statuspengambilan = "Mengulang";
            ++$jmllama;
        }
        if ( $Update == "Simulasi Pembagian Kelas" )
        {
            if ( $statusdj <= 1 )
            {
                if ( $arraykelassim[$kelasawal] < $jmlmax )
                {
                    ++$arraykelassim[$kelasawal];
                    $kelassimulasi = add0( $kelasawal );
                }
                else
                {
                    ++$kelasawal;
                    ++$arraykelassim[$kelasawal];
                    $kelassimulasi = add0( $kelasawal );
                }
            }
            else
            {
                $kelassimulasi = add0( $maxkelas );
            }
        }
        else
        {
            $kelassimulasi = $d[KELAS];
        }
        $styletd = "";
        if ( $kelassimulasi != $d[KELAS] )
        {
            $styletd = "style='background-color:#FFFF00'";
        }
        echo "\r\n  \r\n      <tr {$kelas}{$cetak}>\r\n        <td  align=center>{$i}</td>\r\n        <td  align=center>{$d['ID']}</td>\r\n        <td>{$d['NAMA']}</td>\r\n        <td align=center>{$statuspengambilan}</td>\r\n        <td align=center {$styletd}>{$d['KELAS']}</td>";
        if ( $aksi != "cetak" )
        {
            echo "\r\n        <td align=center {$styletd}><input type=text size=2 name='kelasbaru[{$d['ID']}]' value='{$kelassimulasi}'></td>";
        }
        echo "\r\n      </tr>\r\n    ";
        ++$i;
    }
    #echo "</table>\r\n  \r\n  ";
	echo "				</tbody>
					</table>
				</div>
			</div>
		</div>
		<input type=hidden name=jmlbaru value='{$jmlbaru}'>\r\n  <input type=hidden name=jmllama value='{$jmllama}'>\r\n  </form>";
	if ( $aksi != "cetak" )
    {
        echo "\r\n    <form method=post action=cetakkelas.php target=_blank>\r\n  <input type=hidden name=pilihan value='{$pilihan}'>\r\n  <input type=hidden name=aksi value='{$aksi}'>\r\n  <input type=hidden name=tahunk value='{$tahunk}'>\r\n  <input type=hidden name=semesterk value='{$semesterk}'>\r\n  <input type=hidden name=idupdate value='{$idupdate}'>\r\n  <input type=hidden name=idprodi value='{$idprodi}'>\r\n  <input type=hidden name=sks value='{$sks}'>\r\n  <input type=hidden name=semkul value='{$semkul}'>  \r\n  <input type=submit name=aksi value=Cetak class=\"btn btn-brand\">\r\n  </form>\r\n  ";
    }
	echo "				</div>
					</div>
				</div>
			</div>";
}
else
{
    printmesg( "Belum ada mahasiswa yang mengambil mata kuliah ini." );
}
?>
