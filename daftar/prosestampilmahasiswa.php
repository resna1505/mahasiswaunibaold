<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
unset( $arraysort );
$arraysort[0] = "calonmahasiswa.ID";
$arraysort[1] = "calonmahasiswa.NAMA";
$arraysort[2] = "calonmahasiswa.TAHUN";
$arraysort[3] = "calonmahasiswa.GELOMBANG";
$arraysort[4] = "calonmahasiswa.PILIHAN";
$arraysort[5] = "calonmahasiswa.PRODI1";
$arraysort[6] = "calonmahasiswa.HP";
$arraysort[7] = "calonmahasiswa.ASALSMA";
$arraysort[8] = "calonmahasiswa.EMAIL";
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $istglentri == 1 )
{
    $qfield .= "\r\n \t\t\tAND \r\n \t\t\t(\r\n \t\t\t\tcalonmahasiswa.TANGGALDAFTAR >= DATE_FORMAT('{$tglentri['thn']}-{$tglentri['bln']}-{$tglentri['tgl']}','%Y-%m-%d')\r\n \t\t\t\tAND\r\n \t\t\t\tcalonmahasiswa.TANGGALDAFTAR <= DATE_FORMAT('{$tglentri2['thn']}-{$tglentri2['bln']}-{$tglentri2['tgl']}','%Y-%m-%d')\r\n \t\t\t)\r\n \t\t";
    $qjudul .= " Tanggal Daftar  {$tglentri['tgl']}-{$tglentri['bln']}-{$tglentri['thn']} s.d\r\n\t\t {$tglentri2['tgl']}-{$tglentri2['bln']}-{$tglentri2['thn']} \r\n\t\t <br>";
    $qinput .= " \r\n\t\t\t<input type=hidden name=istglentri value='{$istglentri}'>\r\n\t\t\t<input type=hidden name=tglentri[thn] value='{$tglentri['thn']}'>\r\n\t\t\t<input type=hidden name=tglentri[bln] value='{$tglentri['bln']}'>\r\n\t\t\t<input type=hidden name=tglentri[tgl] value='{$tglentri['tgl']}'>\r\n\t\t\t<input type=hidden name=tglentri2[thn] value='{$tglentri2['thn']}'>\r\n\t\t\t<input type=hidden name=tglentri2[bln] value='{$tglentri2['bln']}'>\r\n\t\t\t<input type=hidden name=tglentri2[tgl] value='{$tglentri2['tgl']}'>\r\n\t\t";
    $href .= "istglentri={$istglentri}&tglentri[tgl]={$tglentri['tgl']}&tglentri[bln]={$tglentri['bln']}&tglentri[thn]={$tglentri['thn']}&\r\n\t\ttglentri2[tgl]={$tglentri2['tgl']}&tglentri2[bln]={$tglentri2['bln']}&tglentri2[thn]={$tglentri2['thn']}&";
}
if ( $tahunmasuk != "" )
{
    $qfield .= " AND TAHUN='{$tahunmasuk}'";
    $qjudul .= " Tahun Masuk '{$tahunmasuk}' <br>";
    $qinput .= " <input type=hidden name=tahunmasuk value='{$tahunmasuk}'>";
    $href .= "tahunmasuk={$tahunmasuk}&";
}
if ( $notes != "" )
{
    $qfield .= " AND NOTES = '{$notes}'";
    $qjudul .= " No. Tes '{$notes}' <br>";
    $qinput .= " <input type=hidden name=notes value='{$notes}'>";
    $href .= "notes={$notes}&";
}
if ( $id != "" )
{
    $qfield .= " AND ID = '{$id}'";
    $qjudul .= " Urutan '{$id}' <br>";
    $qinput .= " <input type=hidden name=id value='{$id}'>";
    $href .= "id={$id}&";
}
if ( $gelombang != "" )
{
    $qfield .= " AND GELOMBANG = '{$gelombang}'";
    $qjudul .= " Gelombang '{$gelombang}' <br>";
    $qinput .= " <input type=hidden name=gelombang value='{$gelombang}'>";
    $href .= "gelombang={$gelombang}&";
}
if ( $nama != "" )
{
    $qfield .= " AND NAMA LIKE '%{$nama}%'";
    $qjudul .= " Nama mengandung kata '{$nama}' <br>";
    $qinput .= " <input type=hidden name=nama value='{$nama}'>";
    $href .= "nama={$nama}&";
}
if ( $idpilihan != "" )
{
    $qfield .= " AND PILIHAN='{$idpilihan}'";
    $qjudul .= " Pilihan '".$arraypilihanpmb["{$idpilihan}"]."' <br>";
    $qinput .= " <input type=hidden name=idpilihan value='{$idpilihan}'>";
    $href .= "idpilihan={$idpilihan}&";
}
if ( $idprodi1 != "" )
{
    $qfield .= " AND PRODI1='{$idprodi1}'";
    $qjudul .= " Pilihan 1 '".$arrayprodi[$idprodi1]."' <br>";
    $qinput .= " <input type=hidden name=idprodi1 value='{$idprodi1}'>";
    $href .= "idprodi1={$idprodi1}&";
}
if ( $idprodi2 != "" )
{
    $qfield .= " AND PRODI2='{$idprodi2}'";
    $qjudul .= " Pilihan 2 '".$arrayprodi[$idprodi2]."' <br>";
    $qinput .= " <input type=hidden name=idprodi2 value='{$idprodi2}'>";
    $href .= "idprodi2={$idprodi2}&";
}
if ( $statusprodi1 != "" )
{
    $qfield .= " AND STATUSPRODI1='{$statusprodi1}'";
    $qjudul .= " Status Pilihan 1 '".$arraystatuslulus[$statusprodi1]."' <br>";
    $qinput .= " <input type=hidden name=statusprodi1 value='{$statusprodi1}'>";
    $href .= "statusprodi1={$statusprodi1}&";
}
if ( $statusprodi2 != "" )
{
    $qfield .= " AND STATUSPRODI2='{$statusprodi2}'";
    $qjudul .= " Status Pilihan 2 '".$arraystatuslulus[$statusprodi2]."' <br>";
    $qinput .= " <input type=hidden name=statusprodi2 value='{$statusprodi2}'>";
    $href .= "statusprodi2={$statusprodi2}&";
}
if ( $arraysort[$sort] == "" )
{
    $sort = 0;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(*) AS JML FROM calonmahasiswa \r\n\tWHERE 1=1  \r\n\t{$qfield}\r\n\t";
$h = doquery($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
include( "../paginating.php" );
$q = "SELECT *,YEAR(NOW())-YEAR(TANGGALLAHIR) AS UMUR \r\n  FROM calonmahasiswa \r\n\tWHERE 1=1 \r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
$h = doquery($koneksi,$q);
//echo mysql_error( );
if ( 0 < sqlnumrows( $h ) )
{
	echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">";	
								printmesg("Data Calon Mahasiswa");
    /*if ( $aksi != "cetak" )
    {
        #printjudulmenu( "Data Calon Mahasiswa" );
        printmesg( $qjudul );
    }
    else
    {
        #printjudulmenucetak( "Data Calon Mahasiswa" );
        printmesgcetak( $qjudul );
    }*/
    if ( $aksi != "cetak" )
    {
		printmesg( $qjudul );	
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
                                <span class=\"caption-subject bold uppercase\"> Data Calon Mahasiswa </span>
                            </div>
                            <div class=\"actions\">
                                <form target=_blank action='cetakmahasiswa.php'>\r\n\t\t\t".IKONCETAK32."<input type=submit name=aksi2 class=\"btn green\" value='Cetak'>&nbsp;&nbsp;

                                <input type='submit' name='printbtn' value='Aktivasi' class=\"btn green\">";

        echo "\r\n \t\t\t\t{$qinput} \t\t\t\t{$input}\r\n\t\t\t</form>
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
		echo "					{$tpage} {$tpage2}<div class=\"tools\">
										
										<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td width=\"1%;\">
														<form target=_blank action='cetakmahasiswa.php' method=post>
															{$qinput} \t\t\t\t{$input}
															<input type=submit name=aksi2 value=Cetak class=\"btn btn-brand\">
														</form>
													</td>
												</tr>
											</table>
										</div>
									</div>";
											
			/*echo "											<form method='post' action='?pilihan=aktivasi'>
															<input type='hidden' name='dataperhalaman' value='{$dataperhalaman}'>
															<input type='hidden' name='pilihan' value='{$pilihan}'>
															<input type='hidden' name='aksi' value='aktivasicalon'>
															<input type='hidden' name='jenistampilan' value='{$jenistampilan}'>
															<input type='hidden' name='nilaidiambil' value='{$nilaidiambil}'>
															<input type='hidden' name='nilaikosong' value='{$nilaikosong}'>
															<input type='hidden' name='sp' value='{$sp}'>
															<input type='hidden' name='semester' value='{$semester}'>
															<input type='hidden' name='tahun' value='{$tahun}'>
															<input type='hidden' name='kopsurat' value='{$kopsurat}'>
															<input type='hidden' name='diagram' value='{$diagram}'>
															<input type='hidden' name='tgl' value='{$tgllap['tgl']}'>
															<input type='hidden' name='bln' value='{$tgllap['bln']}'>
															<input type='hidden' name='thn' value='{$tgllap['thn']}'>
															<input type='hidden' name='skpendirian' value='{$skpendirian}'>														
															<input type='submit' name='printbtn' value='Aktivasi' class=\"btn btn-brand\">
													</td>
												</tr>
											</table>										
									";*/
        #echo " \t{$tpage} {$tpage2}\r\n\t\t\t\t<table class=form border=0>\r\n\t\t\t\t<tr><td width='1%'>\r\n\t\t\t<form target=_blank action='cetakmahasiswa.php'>\r\n\t\t\t".IKONCETAK32."\r\n \t\t\t\t<input type=submit name=aksi2 class=tombol value='Cetak'>";
        #echo "\r\n \t\t\t\t{$qinput} \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td><td>";
		/* echo "<form method='post' action='?pilihan=aktivasi'>";
        echo "<input type='hidden' name='dataperhalaman' value='{$dataperhalaman}'>
              <input type='hidden' name='pilihan' value='{$pilihan}'>
              <input type='hidden' name='aksi' value='aktivasicalon'>
              <input type='hidden' name='jenistampilan' value='{$jenistampilan}'>
              <input type='hidden' name='nilaidiambil' value='{$nilaidiambil}'>
              <input type='hidden' name='nilaikosong' value='{$nilaikosong}'>
              <input type='hidden' name='sp' value='{$sp}'>
              <input type='hidden' name='semester' value='{$semester}'>
              <input type='hidden' name='tahun' value='{$tahun}'>
              <input type='hidden' name='kopsurat' value='{$kopsurat}'>
              <input type='hidden' name='diagram' value='{$diagram}'>
			  <input type='hidden' name='tgl' value='{$tgllap['tgl']}'>
			  <input type='hidden' name='bln' value='{$tgllap['bln']}'>
			  <input type='hidden' name='thn' value='{$tgllap['thn']}'>
			  <input type='hidden' name='skpendirian' value='{$skpendirian}'>
        ";
		echo "</td></tr></table>";*/
    }
    #echo "\r\n \t\t\t<table class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td><input type='checkbox' name='chkall' id='chkall'></td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>No. Tes</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Nama</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>Tahun</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Gel.</td>\r\n\t\t\t<!--\t<td><a class='{$cetak}' href='{$href}"."&sort=7'>Urutan</td> -->\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>Pilihan</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Pilihan 1</td>\r\n\t\t\t\t \r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=6'>Pilihan 2</td>\r\n\t\t\t \r\n\r\n\r\n\t\t\t\t ";
    echo "											<form method='post' action='index.php'>
															<input type='hidden' name='aksi' value='aktivasicalon'>
															";
	echo "							<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata{$aksi} align=center>";
														if($aksi !="cetak"){
															echo "<td><input type='checkbox' name='chkall' id='chkall'></td>";
														}
														echo "<td><a class='{$cetak}' href='{$href}"."&sort=0'>No. Tes</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Nama</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>Tahun</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Gel.</td>\r\n\t\t\t<!--\t<td><a class='{$cetak}' href='{$href}"."&sort=7'>Urutan</td> -->\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>Pilihan</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Pilihan</td><td><a class='{$cetak}' href='{$href}"."&sort=6'>No. HP</td><td><a class='{$cetak}' href='{$href}"."&sort=7'>SEKOLAH ASAL</td><td><a class='{$cetak}' href='{$href}"."&sort=8'>EMAIL</td><!--<td><a class='{$cetak}' href='{$href}"."&sort=6'>Pilihan 2</td>-->";
														if($aksi =="cetak"){
															echo "<td><a class='{$cetak}'>Nama Referal</a></td>";
														}
	if ( !( $jenisusers == 0 ) || $tingkataksesusers[$kodemenu] == "T" )
    {
        echo "\r\n\t\t\t\t\t\t\t<td nowrap colspan=2  >Aksi</td>\r\n\t\t\t\t\t\t\t";
    }
    #echo "\r\n\t\t\t</tr>\r\n\t\t";
	echo "			</tr> 
				</thead>
					<tbody>";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        if ( $d[UMUR] <= 15 && $aksi != "cetak" )
        {
            $kelas = "style='background-color:#ffff00'";
        }
		
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>";
		if($aksi !="cetak"){
			echo "<td><input type='checkbox' class='chkbox' name='idcalonmhs[]' value='".$d["ID"]."' ></td>";
		}
		echo "<td align=left>{$d['ID']}</td>\r\n \t\t\t\t\t<td align=left nowrap>{$d['NAMA']}</td>\r\n \t\t\t\t\t<td align=center>{$d['TAHUN']}</td>\r\n \t\t\t\t\t<td align=center>{$d['GELOMBANG']}</td>\r\n \t\t\t\t\t<!--<td align=center>{$d['ID']}</td>-->\r\n \t\t\t\t\t<td align=center>".$arraypilihanpmb[$d[PILIHAN]]."</td><td align=left nowrap>".$arrayprodidep[$d[PRODI1]]."</td><td align=left nowrap>".$d[HP]."</td><td align=left nowrap>".$d[ASALSMA]."</td><td align=left nowrap>".$d[EMAIL]."</td><!--<td align=left nowrap>".$arrayprodidep[$d[PRODI2]]."</td>-->";
        if($aksi =="cetak"){
		echo "<td align=left nowrap>{$d['REFERAL']}</td>";
	}
	
if ( $tingkataksesusers[$kodemenu] == "T" && $jenisusers == 0 )
        {
            echo "\r\n\t\t\t\t\t\t\t\t<td   align=center><a class=\"btn green\" href='index.php?pilihan={$pilihan}&aksi=formupdate&idupdate={$d['ID']}&gelupdate={$d['GELOMBANG']}&tahunupdate={$d['TAHUN']}&pilihanupdate={$d['PILIHAN']}'><i class=\"fa fa-edit\"></i></td>\r\n\t\t\t\t\t\t\t\t<td   align=center ><a class=\"btn red\" \r\n\t\t\t\t\t\t\t\tonclick=\"return confirm('Hapus Data Calon Mahasiswa Dengan Nama = {$d['NAMA']} ? ');\"\r\n\t\t\t\t\t\t\t\thref='{$href}&aksi=hapus&idhapus={$d['ID']}&gelhapus={$d['GELOMBANG']}&tahunhapus={$d['TAHUN']}&pilihanhapus={$d['PILIHAN']}'><i class=\"fa fa-trash\"></i></td>\r\n\t\t\t\t\t\t\t\t";
        }
        echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
    #echo "</table></div></div>{$tpage} {$tpage2}</div></div></div>";
	echo "								</tbody>
								</table>
							</div>
						</div>
					</div>
					<!--end::Section-->";
	if($aksi !="cetak"){
		echo "		<div class=\"tools\">										
						<div class=\"table-scrollable\">
							<table class=\"table table-striped table-bordered table-hover\">
								<tr>
									<td width=\"1%;\">
										<input type='submit' name='printbtn' value='Aktivasi' class=\"btn btn-brand\">
									</td>
								</tr>
							</table>
						</div>
					</div>";
	}
	echo "			</div>
				<!--end::Form-->
				</form>
			</div>
			<!--end::Portlet-->";
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Calon Mahasiswa Tidak Ada";
    $aksi = "";
}
?>
