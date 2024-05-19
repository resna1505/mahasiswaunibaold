<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi == "Simpan" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Kapasitas Mahasiswa Baru", SIMPAN_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditasthnajaran( "Tahun/Semester Pelaporan Data", $tahun, $semester );
        $vld[] = cekvaliditaskodeprodi( "Kode Prodi", $kodeps );
        $vld[] = cekvaliditasinteger( "Jumlah Target Mahasiswa Baru", $target1 );
        $vld[] = cekvaliditasinteger( "Jumlah Calon Yang Mendaftar/Beli Formulir", $target2 );
        $vld[] = cekvaliditasinteger( "Jumlah Calon Yang Dinyatakan Lulus Seleksi", $target3 );
        $vld[] = cekvaliditasinteger( "Jumlah Calon Yang Mendaftar Sebagai Mahasiswa", $target4 );
        $vld[] = cekvaliditasinteger( "umlah Calon Mengundurkan Diri karena diterima di SPMB(UMPTN) atau perguruan tinggi lain", $target5 );
        $vld[] = cekvaliditasinteger( "Jumlah Mahasiswa Pindahan (diantara YangMendaftar Sebagai Mahasiswa)", $target6 );
        $vld[] = cekvaliditastanggal( "Tanggal Awal kuliah semester Ganjil", $tgl1, $bln1, $thn1 );
        $vld[] = cekvaliditastanggal( "Tanggal Akhir kuliah semester Ganjil", $tgl2, $bln2, $thn2 );
        $vld[] = cekvaliditasinteger( "Jumlah Minggu Kuliah Semester Ganjil", $jumlahganjil );
        $vld[] = cekvaliditastanggal( "Tanggal Awal kuliah semester Genap", $tgl3, $bln3, $thn3 );
        $vld[] = cekvaliditastanggal( "Tanggal Akhir kuliah semester Genap", $tgl4, $bln4, $thn4 );
        $vld[] = cekvaliditasinteger( "Jumlah Minggu Kuliah Semester Genap", $jumlahgenap );
        $vld[] = cekvaliditaskode( "Metode Hari Perkuliahan", $metode );
        $vld[] = cekvaliditaskode( "Ada Kelas Ekstensi", $ekstensi );
        $vld[] = cekvaliditaskode( "Metode Hari Perkuliahan Ekstensi", $metode2 );
        $vld[] = cekvaliditaskode( "Ada Semester Pendek", $pendek );
        $vld[] = cekvaliditasinteger( "Jumlah Semester Pendek dalam 1 tahun", $jumlahpendek );
        $vld[] = cekvaliditaskode( "Metode pelaksanaan Semester Pendek", $metode3 );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
            unset( $vld );
        }
        else
        {
            $q = "INSERT INTO trkap \r\n  (THSMSTRKAP,KDPTITRKAP,KDPSTTRKAP,KDJENTRKAP,\r\n  JMGETTRKAP,JMCALTRKAP,  JMTERTRKAP, JMDAFTRKAP, JMMUNTRKAP,JMPINTRKAP,TGAW1TRKAP,TGAK1TRKAP,\r\n   TMRE1TRKAP, TGAW2TRKAP,  TGAK2TRKAP,  TMRE2TRKAP, MTKLHTRKAP, KDEKSTRKAP,  MTKLETRKAP,\r\n   SMPDKTRKAP, JMPDKTRKAP, MTPDKTRKAP)\r\n  VALUES\r\n  ('{$tahun}{$semester}','{$kodept}','{$kodeps}','{$kodejenjang}',\r\n  '{$target1}','{$target2}','{$target3}','{$target4}','{$target5}','{$target6}','{$thn1}-{$bln1}-{$tgl1}',\r\n  '{$thn2}-{$bln2}-{$tgl2}','{$jumlahganjil}','{$thn3}-{$bln3}-{$tgl3}','{$thn4}-{$bln4}-{$tgl4}','{$jumlahgenap}',\r\n  '{$metode}','{$ekstensi}','{$metode2}','{$pendek}','{$jumlahpendek}','{$metode3}')";
            mysqli_query($koneksi,$q);
            if ( sqlaffectedrows( $koneksi ) <= 0 )
            {
                $q = "\r\n      UPDATE trkap SET\r\n      JMGETTRKAP='{$target1}',\r\n      JMCALTRKAP='{$target2}',\r\n      JMTERTRKAP='{$target3}',\r\n      JMDAFTRKAP='{$target4}',\r\n      JMMUNTRKAP='{$target5}',\r\n      JMPINTRKAP='{$target6}',\r\n      TGAW1TRKAP='{$thn1}-{$bln1}-{$tgl1}',\r\n      TGAK1TRKAP='{$thn2}-{$bln2}-{$tgl2}',\r\n      TMRE1TRKAP='{$jumlahganjil}',\r\n      TGAW2TRKAP='{$thn3}-{$bln3}-{$tgl3}',\r\n      TGAK2TRKAP='{$thn4}-{$bln4}-{$tgl4}',\r\n      TMRE2TRKAP='{$jumlahgenap}',\r\n      MTKLHTRKAP='{$metode}',\r\n      KDEKSTRKAP='{$ekstensi}',\r\n      MTKLETRKAP='{$metode2}',\r\n      SMPDKTRKAP='{$pendek}',\r\n      JMPDKTRKAP='{$jumlahpendek}',\r\n      MTPDKTRKAP='{$metode3}'\r\n      WHERE\r\n       KDPTITRKAP='{$kodept}' AND\r\n        KDPSTTRKAP='{$kodeps}' AND\r\n        KDJENTRKAP='{$kodejenjang}' AND\r\n        THSMSTRKAP='{$tahun}{$semester}'\r\n    ";
                mysqli_query($koneksi,$q);
            }
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Data Kapasitas Mahasiswa Baru berhasil disimpan";
            }
        }
    }
}
$q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$idprodi}'";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
    $kodept = $d[KDPTIMSPST];
    $kodejenjang = $d[KDJENMSPST];
    $kodeps = $d[KDPSTMSPST];
}
$q = "SELECT * FROM trkap  \r\nWHERE\r\n KDPTITRKAP='{$kodept}' AND\r\n      KDPSTTRKAP='{$kodeps}' AND\r\n      KDJENTRKAP='{$kodejenjang}' AND\r\n      THSMSTRKAP='{$tahun}{$semester}'\r\n";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $ada = 1;
    $d = sqlfetcharray( $h );
    $tmp = explode( "-", $d[TGAW1TRKAP] );
    $thn1 = $tmp[0];
    $bln1 = $tmp[1];
    $tgl1 = $tmp[2];
    $tmp = explode( "-", $d[TGAK1TRKAP] );
    $thn2 = $tmp[0];
    $bln2 = $tmp[1];
    $tgl2 = $tmp[2];
    $tmp = explode( "-", $d[TGAW2TRKAP] );
    $thn3 = $tmp[0];
    $bln3 = $tmp[1];
    $tgl3 = $tmp[2];
    $tmp = explode( "-", $d[TGAK2TRKAP] );
    $thn4 = $tmp[0];
    $bln4 = $tmp[1];
    $tgl4 = $tmp[2];
}
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
printmesg( $errmesg );
echo "\r\n<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-body form\"><div class='tab-pane' id='tab_1'>
								<div class='portlet box blue'>
									<div class='portlet-title'>
										<div class='caption'>
											<i class='fa fa-gift'></i>Kapasitas Mahasiswa Baru
										</div>
										
									</div>
									<div class='portlet-body form'><form action=index.php method=post>\r\n<input type=hidden name=pilihan value='{$pilihan}'>\r\n<input type=hidden name=idprodi value='{$idprodi}'>\r\n<input type=hidden name=sessid value='{$_SESSION['token']}'>\r\n<input type=hidden name=kodept value='{$kodept}'>\r\n<input type=hidden name=kodeps value='{$kodeps}'>\r\n<input type=hidden name=kodejenjang value='{$kodejenjang}'>\r\n<input type=hidden name=tahun value='{$tahun}'>\r\n<input type=hidden name=semester value='{$semester}'>\r\n\r\n<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">\r\n  <tr>\r\n    <td >Tahun Semester Pelaporan Data   </td>\r\n    <td>".$arraysemester[$semester]." {$tahun}/".( $tahun + 1 )."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jurusan/Prodi    </td>\r\n    <td>".$arrayprodidep[$idprodi]."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah Target Mahasiswa Baru</td>\r\n    <td>\r\n    <input type=text size=10 name=target1 value='{$d['JMGETTRKAP']}'> \r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah Calon Yang Mendaftar/Beli Formulir</td>\r\n    <td> <input type=text size=10 name=target2 value='{$d['JMCALTRKAP']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td  >Jumlah Calon Yang Dinyatakan Lulus Seleksi</td>\r\n    <td> <input type=text size=10 name=target3 value='{$d['JMTERTRKAP']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah Calon Yang Mendaftar Sebagai Mahasiswa</td>\r\n    <td> <input type=text size=10 name=target4 value='{$d['JMDAFTRKAP']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah Calon Mengundurkan Diri karena\r\nditerima di SPMB(UMPTN) atau perguruan tinggi\r\nlain</td>\r\n    <td> <input type=text size=10 name=target5 value='{$d['JMMUNTRKAP']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah Mahasiswa Pindahan (diantara Yang\r\nMendaftar Sebagai Mahasiswa)</td>\r\n    <td> <input type=text size=10 name=target6 value='{$d['JMPINTRKAP']}'> </td>\r\n  </tr>\r\n   \r\n    <tr>\r\n    <td nowrap colspan=2>\r\n    <br>\r\n    <b>DATA KEGIATAN PERKULIAHAN</b> \r\n    <br>\r\n      </td>\r\n  </tr>\r\n    <tr>\r\n    <td nowrap>Tanggal awal kuliah Semester Ganjil</td>\r\n    <td>\r\n    <input type=text size=2 name=tgl1 value='{$tgl1}'>-\r\n    <input type=text size=2 name=bln1 value='{$bln1}'>-\r\n    <input type=text size=4 name=thn1 value='{$thn1}'>\r\n    </td>\r\n  </tr>\r\n   <tr>\r\n    <td nowrap>Tanggal akhir kuliah Semester Ganjil</td>\r\n    <td>\r\n    <input type=text size=2 name=tgl2 value='{$tgl2}'>-\r\n    <input type=text size=2 name=bln2 value='{$bln2}'>-\r\n    <input type=text size=4 name=thn2 value='{$thn2}'>\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah minggu kuliah semester Ganjil</td>\r\n    <td> <input type=text size=10 name=jumlahganjil value='{$d['TMRE1TRKAP']}'> </td>\r\n  </tr>\r\n\r\n   <tr>\r\n    <td nowrap>Tanggal awal kuliah Semester Genap</td>\r\n    <td>\r\n    <input type=text size=2 name=tgl3 value='{$tgl3}'>-\r\n    <input type=text size=2 name=bln3 value='{$bln3}'>-\r\n    <input type=text size=4 name=thn3 value='{$thn3}'>\r\n    </td>\r\n  </tr>\r\n   <tr>\r\n    <td nowrap>Tanggal akhir kuliah Semester Genap</td>\r\n    <td>\r\n    <input type=text size=2 name=tgl4 value='{$tgl4}'>-\r\n    <input type=text size=2 name=bln4 value='{$bln4}'>-\r\n    <input type=text size=4 name=thn4 value='{$thn4}'>\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah minggu kuliah semester Genap</td>\r\n    <td> <input type=text size=10 name=jumlahgenap value='{$d['TMRE2TRKAP']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Metode Hari Perkuliahan</td>\r\n    <td>".createinputselect( "metode", $arraymetodekuliah, $d[MTKLHTRKAP], "", " class=masukan " )."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Ada kelas Ekstensi/Non-reguler/Eksekutif?</td>\r\n    <td>".createinputselect( "ekstensi", $arrayya2, $d[KDEKSTRKAP], "", " class=masukan " )."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Metode Hari Perkuliahan Kelas Ekstensi</td>\r\n    <td>".createinputselect( "metode2", $arraymetodekuliah, $d[MTKLETRKAP], "", " class=masukan " )."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Ada kegiatan semester pendek/padat?</td>\r\n    <td>".createinputselect( "pendek", $arrayya2, $d[SMPDKTRKAP], "", " class=masukan " )."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jumlah Semester Pendek/Padat dalam 1 tahun</td>\r\n    <td> <input type=text size=2 name=jumlahpendek value='{$d['JMPDKTRKAP']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td width=300>Metode pelaksanaan Semester Pendek</td>\r\n    <td>".createinputselect( "metode3", $arraymetodependek, $d[MTPDKTRKAP], "", " class=masukan " )."</td>\r\n  </tr>\r\n\r\n \r\n  <tr>\r\n    <td ></td>\r\n    <td>\r\n    ".IKONUPDATE48."\r\n    <input type=\"submit\" class=\"btn blue\" value=Simpan></input>
                                            <input type=\"reset\" class=\"btn red\" value=Reset></input>\r\n     </form>\r\n    </td> \r\n  </tr>\r\n</table></div></div></div></div></div></div></div>";
if ( $ada == 1 )
{
    echo "\r\n  <form action=cetakmhsbaru.php target=_blank method=post>\r\n    ".IKONCETAK32."\r\n    <input type=submit name=aksi value=Cetak>\r\n    <input type=hidden name=pilihan value='{$pilihan}'>\r\n    <input type=hidden name=idprodi value='{$idprodi}'>\r\n    <input type=hidden name=kodept value='{$kodept}'>\r\n    <input type=hidden name=kodeps value='{$kodeps}'>\r\n    <input type=hidden name=kodejenjang value='{$kodejenjang}'>\r\n    <input type=hidden name=tahun value='{$tahun}'>\r\n    <input type=hidden name=semester value='{$semester}'>\r\n  </form>\r\n ";
}
?>
