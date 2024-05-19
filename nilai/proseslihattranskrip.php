<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
#echo "lll";exit();
periksaroot( );
$vld[] = cekvaliditaskodeprodi( "Jurusan/Program Studi", $idprodi );
$vld[] = cekvaliditaskode( "Dosen Wali", $iddosen );
$vld[] = cekvaliditastahun( "Angkatan", $angkatan );
$vld[] = cekvaliditaskode( "NIM", $id );
$vld[] = cekvaliditasnama( "Nama", $nama );
$vld[] = cekvaliditaskode( "Status", $status );
$vld[] = cekvaliditaskode( "Nilai M-K yang diambil", $nilaidiambil, 1 );
$vld[] = cekvaliditaskode( "Perlakuan terhadap nilai kosong", $nilaikosong, 1 );
$vld[] = cekvaliditaskode( "Penempatan Semester Mata Kuliah", $penempatansemester, 2 );
$vld[] = cekvaliditaskode( "Nilai SP", $sp );
$vld[] = cekvaliditaskode( "Cetak Diagram", $diagram );
$vld[] = cekvaliditaskode( "Jenis", $jenistampilan );
$vld[] = cekvaliditastanggal( "Tanggal", $tgllap['tgl'], $tgllap['bln'], $tgllap['thn'] );
$vld[] = cekvaliditasinteger( "Data perhalaman", $dataperhalaman, 4 );
$vld = array_filter( $vld, "filter_not_empty" );
if ( isset( $vld ) && 0 < count( $vld ) )
{
    $errmesg = val_err_mesg( $vld, 2, CARI_DATA );
    $aksi = "";
}
else
{
    include( "fungsinilai.php" );
    include( "../libchart/libchart.php" );
    $href = "dataperhalaman={$dataperhalaman}&pilihan={$pilihan}&aksi={$aksi}&tgllap[tgl]={$tgllap['tgl']}&tgllap[bln]={$tgllap['bln']}&tgllap[thn]={$tgllap['thn']}&jenistampilan={$jenistampilan}&nilaidiambil={$nilaidiambil}&nilaikosong={$nilaikosong}&sp={$sp}&kopsurat={$kopsurat}&diagram={$diagram}&penempatansemester={$penempatansemester}&kompre={$kompre}&skpendirian={$skpendirian}&";
    if ( $idprodi != "" )
    {
        $qfield .= " AND IDPRODI='{$idprodi}'";
        $qjudul .= " Jurusan/Program Studi '".$arrayprodidep[$idprodi]."' <br>";
        $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
        $href .= "idprodi={$idprodi}&";
        /*$qtabel .= "<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
						<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
						<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$arrayprodidep[$idprodi]."</label>
					</div> ";*/
    }
    if ( $iddosen != "" )
    {
        $qfield .= " AND IDDOSEN='{$iddosen}'";
        $qjudul .= " Dosen Wali '".$arraydosen[$iddosen]."' <br>";
        $qinput .= " <input type=hidden name=iddosen value='{$iddosen}'>";
        $href .= "iddosen={$iddosen}&";
        /*$qtabel .= "<div class=\"form-group m-form__group row\">
						<label class=\"col-lg-2 col-form-label\">Dosen Wali</label>\r\n    
						<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$arraydosen[$iddosen]."</label>
					</div>  ";*/
    }
    if ( $angkatan != "" )
    {
        $qfield .= " AND mahasiswa.ANGKATAN='{$angkatan}'";
        $qjudul .= " Angkatan '{$angkatan}' <br>";
        $qinput .= " <input type=hidden name=angkatan value='{$angkatan}'>";
        $href .= "angkatan={$angkatan}&";
        /*$qtabel .= "<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
						<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
						<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$angkatan."</label>
					</div>  ";*/
    }
    if ( $id != "" )
    {
        $qfield .= " AND mahasiswa.ID LIKE '%{$id}%'";
        $qjudul .= " NIM mengandung kata '{$id}' <br>";
        $qinput .= " <input type=hidden name=id value='{$id}'>";
        $href .= "id={$id}&";
        /*$qtabel .= "<div class=\"form-group m-form__group row\">
						<label class=\"col-lg-2 col-form-label\">NIM</label>\r\n    
						<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$id."</label>
					</div>  ";*/
    }
    if ( $nama != "" )
    {
        $qfield .= " AND mahasiswa.NAMA LIKE '%{$nama}%'";
        $qjudul .= " Nama mengandung kata '{$nama}' <br>";
        $qinput .= " <input type=hidden name=nama value='{$nama}'>";
        $href .= "nama={$nama}&";
        /*$qtabel .= "<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
						<label class=\"col-lg-2 col-form-label\">Nama Mhs</label>\r\n    
						<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$nama."</label>
					</div>  ";*/
    }
    if ( $status != "" )
    {
        $qfield .= " AND mahasiswa.STATUS='{$status}'";
        $qjudul .= " Status Mahasiswa '".$arraystatusmahasiswa["{$status}"]."' <br>";
        $qinput .= " <input type=hidden name=status value='{$status}'>";
        $href .= "status={$status}&";
        /*$qtabel .= "<div class=\"form-group m-form__group row\">
						<label class=\"col-lg-2 col-form-label\">Status Mahasiswa</label>\r\n    
						<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$arraystatusmahasiswa["{$status}"]."</label>
					</div>  ";*/
    }
    if ( $jeniskelas != "" )
    {
        $qfield .= " AND mahasiswa.JENISKELAS='{$jeniskelas}'";
        $qjudul .= " Jenis Kelas '".$arraykelasstei["{$jeniskelas}"]."' <br>";
        $qinput .= " <input type=hidden name=jeniskelas value='{$jeniskelas}'>";
        $href .= "jeniskelas={$jeniskelas}&";
        /*$qtabel .= "<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
						<label class=\"col-lg-2 col-form-label\">Jenis Kelas</label>\r\n    
						<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$arraykelasstei["{$jeniskelas}"]."</label>
					</div>  ";*/
    }
    if ( $sort == "" )
    {
        $sort = " mahasiswa.ID";
    }
    if ( $tahun != "" )
    {
        $qinput .= " <input type=hidden name=tahun value='{$tahun}'>";
        $href .= "tahun={$tahun}&";
    }
	if ( $judulkopsendiri != "" )
    {
        $qinput .= " <input type=hidden name=judulkopsendiri value='{$judulkopsendiri}'>";
        $href .= "judulkopsendiri={$judulkopsendiri}&";
    }
	
    $qinput .= " <input type=hidden name=semester value='{$semester}'>";
    if ( $semester == "" )
    {
        $semester = 1;
    }
    $href .= "semester={$semester}&";
    $href2 = "{$href}";
    $href = "index.php?{$href}";
    $qinput .= " <input type=hidden name=sort value='{$sort}'>";
    $q = "SELECT COUNT(*) AS JML FROM mahasiswa,prodi,departemen  \r\n\tWHERE 1=1 {$qprodidep5} AND\r\n\tmahasiswa.IDPRODI=prodi.ID AND\r\n\tprodi.IDDEPARTEMEN=departemen.ID\r\n\t{$qfieldtambahan2}\r\n\t{$qfield}\r\n \t{$qfieldx1} \r\n\t";
    $h = doquery($koneksi,$q );
    $d = sqlfetcharray( $h );
    $total = $d[JML];
    $first = 0;
    if ( 0 + $dataperhalaman <= 0 )
    {
        $dataperhalaman = 1;
    }
    $maxdata = $dataperhalaman;
    include( "../paginating.php" );
    $q = "SELECT mahasiswa.*,msmhs.STPIDMSMHS,\r\n  prodi.SKSMIN , \r\n\tprodi.IDDEPARTEMEN, \tprodi.TINGKAT,\r\n\tdepartemen.IDFAKULTAS \r\n\tFROM mahasiswa,msmhs,prodi,departemen  \r\n\tWHERE 1=1 {$qprodidep5} AND\r\n\tmahasiswa.ID=msmhs.NIMHSMSMHS AND\r\n\tmahasiswa.IDPRODI=prodi.ID AND\r\n\tprodi.IDDEPARTEMEN=departemen.ID\r\n\t{$qfieldtambahan2}\r\n\t{$qfield}\r\n\t{$qfieldx1}\r\n\tORDER BY {$sort} {$qlimit}";
    $h = doquery($koneksi,$q );
    if ( 0 < sqlnumrows( $h ) )
    {
        if ( $aksi != "cetak" )
        {
			#echo "jjj";exit();
            #printjudulmenu( "Transkrip Nilai" );
           /* echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Filter/Setting </span>
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
								<!-- BEGIN SAMPLE FORM PORTLET-->
								";	
										printmesg( $qjudul );
										printmesg( $errmesg );
			echo "						<div class='portlet-title'>";
											printmesg("Filter / Setting");
			echo "						</div>
									<div class=\"m-portlet\">
										<!--begin::Form-->
										<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" method='post' action='cetaktranskrip2.php' target='_blank'>
											<input type='hidden' name='dataperhalaman' value='{$dataperhalaman}'>
												  <input type='hidden' name='pilihan' value='{$pilihan}'>
												  <input type='hidden' name='aksi' value='tampilsemua'>
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
											<div class=\"m-portlet__body\">	";			
            echo "								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
													<label class=\"col-lg-2 col-form-label\">Nilai MK yg diambil</label>\r\n    
													<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">";
            if ( $nilaidiambil == 0 )
            {
                echo "Nilai Terbaik";
            }
            else
            {
                echo "Nilai Terakhir";
            }
            echo "									</label>
												</div>
												<div class=\"form-group m-form__group row\">
													<label class=\"col-lg-2 col-form-label\">Perlakuan terhadap Nilai Kosong/Tunda</label>\r\n    
													<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">";
            if ( $nilaikosong == 0 )
            {
                echo "Tidak dihitung";
            }
            else
            {
                echo "Dihitung";
            }
            echo "									</label>
												</div>
												<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
													<label class=\"col-lg-2 col-form-label\">Penempatan Semester Mata Kuliah</label>\r\n    
													<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">";
            if ( $penempatansemester == 0 )
            {
                echo "Master Mata Kuliah";
            }
            else
            {
                echo "Kurikulum";
            }
            echo "									</label>
												</div>
												<div class=\"form-group m-form__group row\">
													<label class=\"col-lg-2 col-form-label\">Nilai SP</label>\r\n    
													<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">";
            if ( $sp == 1 )
            {
                echo "Ambil langsung dari nilai SP  (proses akan sedikit lebih lambat)";
            }
            else
            {
                echo "Tidak diambil langsung.";
            }
            echo "									</label>
												</div>";
			/*echo "									<tr>\r\n\t\t<td  >Cetak Diagram\r\n\t\t</td>\r\n\t\t<td>";
            if ( $diagram == 0 )
            {
                echo "Tidak ";
            }
            else
            {
                echo "Ya";
            }
            echo "\r\n\r\n\t\t</td>\r\n\t</tr>";*/
			echo "<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
						<label class=\"col-lg-2 col-form-label\">Jenis</label>\r\n    
						<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">";
            if ( $jenistampilan == 99 )
            {
                echo "\r\n       \t\tTranskrip {$UNIVERSITAS}\r\n        ";
            }
            else if ( $jenistampilan == "unikal1" )
            {
                echo "Transkrip UNIKAL";
            }
            else if ( $jenistampilan == "unikal2" )
            {
                echo "Transkrip Sementara UNIKAL";
            }
            else if ( $jenistampilan == "mrh" )
            {
                echo "Transkrip MITRA RIA HUSADA (2)";
            }
            else if ( $jenistampilan == "bataminggris" )
            {
                echo "Transkrip BAHASA INGGRIS";
            }
            else if ( $jenistampilan == "batamsementara" )
            {
                echo "DAFTAR NILAI SEMENTARA";
            }
            else if ( $jenistampilan == "borobudursementara" )
            {
                echo "Transkrip UNIVERSITAS BOROBUDUR SEMENTARA";
            }
            else if ( $jenistampilan == "borobudurpindahan" )
            {
                echo "Transkrip UNIVERSITAS BOROBUDUR PINDAHAN";
            }
            else if ( $jenistampilan == "nonregulerstikessamarinda" )
            {
                echo "Transkrip Non Reguler STIKES SAMARINDA";
            }
            else if ( $jenistampilan == "untag" )
            {
                echo "Transkrip {$UNIVERSITAS} - Blanko";
            }
            else if ( $jenistampilan == 0 )
            {
                echo "Dipisah Per Jenis Mata Kuliah";
            }
            else if ( $jenistampilan == 1 )
            {
                echo "Standar";
            }
            else if ( $jenistampilan == 2 )
            {
                echo "Per Kolom Semester";
            }
            else if ( $jenistampilan == 3 )
            {
                echo "Dua Kolom";
            }
            echo "			</label>
						</div>
					<div class=\"form-group m-form__group row\">
						<label class=\"col-lg-2 col-form-label\">Tanggal Laporan</label>
						<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">{$tgllap['tgl']}-{$tgllap['bln']}-{$tgllap['thn']} </label>
					</div>";
            if ( $jenisusers != 2 )
            {
                echo "	<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Data Per Halaman</label>
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">{$maxdata}\r\n \t\t</label>
						</div>";
                if ( $jenisusers == 0 )
                {
                    echo "<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Kop Surat</label>
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">";
                    if ( $kopsurat == 1 )
                    {
                        echo "Cetak Kop Surat Umum";
                    }
                    else if ( $kopsurat == 2 )
                    {
                        echo "Cetak Kop Surat Fakultas";
                    }
					else if ( $kopsurat == 3 )
                    {
                        echo "Cetak Kop Surat Sendiri";
                    }
                    else if ( $kopsurat == "" )
                    {
                        echo "Tidak dicetak.";
                    }
                    echo "\r\n\t\t</label>\r\n\t</div>";
                    if ( $UNIVERSITAS == "STIKES_UBUDIYAH" )
                    {
                        echo "\r\n\t<tr>\r\n\t\t<td  >Nilai Ujian Komprehensif\r\n\t\t</td>\r\n\t\t<td>";
                        if ( $kompre == 1 )
                        {
                            echo "Tampilkan";
                        }
                        else
                        {
                            echo "Tidak ditampilkan";
                        }
                        echo "\r\n\t\t</td>\r\n\t</tr>";
                    }
                }
                echo "	<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Catatan</label>
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"> ".nl2br( $catatan )."</label>
						</div>
					</div><hr>";
            }
            echo "{$tpage} {$tpage2}";
        }
        if ( $aksi != "cetak" )
        {
            #echo "\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetaktranskrip.php'>\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'> \r\n \t\t\t\t<input type=checkbox name=pdf value=1> PDF \r\n             <a class='settingpdf' href='../lib/settingpdf.php' >Setting</a> \r\n  \t\t\t\t\t\t\r\n  \t\t\t<script>\r\n            jQuery(document).ready(function () {\r\n                jQuery('a.settingpdf').colorbox();\r\n            });\r\n        </script>\r\n    \t\t\t\t".createinputhidden( "tgllap[tgl]", "{$tgllap['tgl']}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[bln]", "{$tgllap['bln']}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[thn]", "{$tgllap['thn']}", "" )."\r\n\t\t\t".createinputhidden( "diagram", "{$diagram}", "" )."\r\n\t\t\t".createinputhidden( "nilaidiambil", "{$nilaidiambil}", "" )."\r\n\t\t\t".createinputhidden( "jenistampilan", "{$jenistampilan}", "" )."\r\n \t\t\t".createinputhidden( "dataperhalaman", "{$dataperhalaman}", "" )."\r\n\t\t\t".createinputhidden( "jenistampilan", "{$jenistampilan}", "" )."\r\n\t\t\t".createinputhidden( "nilaikosong", "{$nilaikosong}", "" )."\r\n \t\t\t".createinputhidden( "sp", "{$sp}", "" )."\r\n \t\t\t".createinputhidden( "penempatansemester", "{$penempatansemester}", "" )."\r\n \t\t\t".createinputhidden( "iscsv", "{$iscsv}", "" )."\r\n \t\t\t".createinputhidden( "kopsurat", "{$kopsurat}", "" )."\r\n \t\t\t".createinputhidden( "kompre", "{$kompre}", "" )."\r\n \t\t\t\t{$qinput} {$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
		    #echo "\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetaktranskrip.php'>\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'> \r\n \t\t\t\t<input type=checkbox name=pdf value=1> PDF \r\n             <a class='settingpdf' href='../lib/settingpdf.php' >Setting</a> \r\n  \t\t\t\t\t\t\r\n  \t\t\t<script>\r\n            jQuery(document).ready(function () {\r\n                jQuery('a.settingpdf').colorbox();\r\n            });\r\n        </script>\r\n    \t\t\t\t".createinputhidden( "tgllap[tgl]", "{$tgllap['tgl']}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[bln]", "{$tgllap['bln']}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[thn]", "{$tgllap['thn']}", "" )."\r\n\t\t\t".createinputhidden( "diagram", "{$diagram}", "" )."\r\n\t\t\t".createinputhidden( "nilaidiambil", "{$nilaidiambil}", "" )."\r\n\t\t\t".createinputhidden( "jenistampilan", "{$jenistampilan}", "" )."\r\n \t\t\t".createinputhidden( "dataperhalaman", "{$dataperhalaman}", "" )."\r\n\t\t\t".createinputhidden( "jenistampilan", "{$jenistampilan}", "" )."\r\n\t\t\t".createinputhidden( "nilaikosong", "{$nilaikosong}", "" )."\r\n \t\t\t".createinputhidden( "sp", "{$sp}", "" )."\r\n \t\t\t".createinputhidden( "penempatansemester", "{$penempatansemester}", "" )."\r\n \t\t\t".createinputhidden( "iscsv", "{$iscsv}", "" )."\r\n \t\t\t".createinputhidden( "kopsurat", "{$kopsurat}", "" )."\r\n \t\t\t".createinputhidden( "kompre", "{$kompre}", "" )."\r\n \t\t\t\t{$qinput} {$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
       
		}
        $totalsemua = 0;
        $bobotsemua = 0;
        $totals = "";
        $bobots = "";
        #echo "<form method='post' action='cetaktranskrip2.php' target='_blank'>";
        
        #echo "<br>&nbsp;&nbsp;<input type='submit' name='printbtn' value='Cetak' class=\"btn btn-brand\"><br><br>";
        #echo "\r\n \t\t\t<table {$border} class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t<tr class=juduldata align=center>\r\n<td><input type='checkbox' name='chkall' id='chkall'></td>        <td>ID Mahasiswa</td>\r\n        <td>Nama Mahasiswa</td>\r\n        <td>Program Studi</td>\r\n        <td>Status Mahasiswa</td>\r\n        <td>Status Pindahan</td>\r\n        <td>Cetak Transkrip</td>\r\n      </tr>\r\n    ";
       echo "<div class=\"m-portlet\">			
				<div class=\"m-section__content\">
					<div class=\"table-responsive\">
						<table class=\"table table-bordered table-hover\">
							<thead>
								<tr class=juduldata align=center>\r\n<td><input type='checkbox' name='chkall' id='chkall'></td>        <td>ID Mahasiswa</td>\r\n        <td>Nama Mahasiswa</td>\r\n        <td>Program Studi</td>\r\n        <td>Status Mahasiswa</td>\r\n        <td>Status Pindahan</td>\r\n        <td>Cetak Transkrip</td>\r\n      </tr>
							</thead>
							<tbody>";
		$i = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            ++$i;
            $kelas = kelas( $i );
           # echo "\r\n        <tr {$kelas}>\r\n          <td>{$d['ID']}</td>\r\n          <td>{$d['NAMA']}</td>\r\n          <td>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n          <td>".$arraystatusmahasiswa[$d[STATUS]]."</td>\r\n          <td>".$arraystatusmhsbaru[$d[STPIDMSMHS]]."</td>\r\n          <td align=center nowrap><a target=_blank href='cetaktranskrip.php?idmhs={$d['ID']}&".$href2."'>cetak</a> | <a target=_blank href='cetaktranskrip.php?idmhs={$d['ID']}&".$href2."&pdf=1'>PDF</a></td>\r\n        </tr>\r\n        ";
	    echo "\r\n        <tr {$kelas}>\r\n <td> <input type='checkbox' class='chkbox' name='idmhs[]' value='".$d["ID"]."' ></td><td>{$d['ID']}</td>\r\n          <td>{$d['NAMA']}</td>\r\n          <td>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n          <td>".$arraystatusmahasiswa[$d[STATUS]]."</td>\r\n          <td>".$arraystatusmhsbaru[$d[STPIDMSMHS]]."</td>\r\n          <td align=center nowrap><a target=_blank href='cetaktranskrip.php?idmhs={$d['ID']}&".$href2."'>cetak</a> </td>\r\n        </tr>\r\n        ";
        
	}
        #echo "</table></div></div>{$tpage} {$tpage2}</div></div></div>";
		echo "				</tbody>
						</table>
					</div>
				</div>				
			</div>";
		if($aksi !="cetak" && $jenisusers==0){
		echo "		<div class=\"tools\">										
						<div class=\"table-scrollable\">
							<table class=\"table table-striped table-bordered table-hover\">
								<tr>
									<td width=\"1%;\">
										<!--<input type='submit' name='printbtn' value='Aktivasi' class=\"btn btn-brand\">-->
									</td>
								</tr>
							</table>
						</div>
					</div>";
	}	
	echo "		</form>
			</div>
		</div>
		</div>
		</div>
		</div>";
    }
    else
    {
        $errmesg = "Data mahasiswa tidak ada";
        $aksi = "";
    }
}
?>
