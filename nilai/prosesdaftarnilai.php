<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

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
    $href = "index.php?".$href."pilihan={$pilihan}&aksi={$aksi}&tgllap['tgl']={$tgllap['tgl']}&tgllap['bln']={$tgllap['bln']}&tgllap['thn']={$tgllap['thn']}&jenistampilan={$jenistampilan}&nilaidiambil={$nilaidiambil}&nilaikosong={$nilaikosong}&";
    $q = "SELECT NAMA,SYARAT,SYARATW,NAMA2 FROM konversipredikat ORDER BY SYARAT DESC,SYARATW ";
    $hkonversi = mysqli_query($koneksi,$q);
	if(sqlnumrows($hkonversi)>0 ){
		while ($dkonversi = sqlfetcharray($hkonversi))
		{
			$konpredikat[] = $dkonversi;
		}
	}
    if ( $users != "" )
    {
        $qfield .= " AND mahasiswa.ID = '{$users}'";
        $qjudul .= " NIM '{$id}' <br>";
        $qinput .= " <input type=hidden name=id value='{$id}'>";
        $href .= "id={$id}&";
    }
    if ( $sort == "" )
    {
        $sort = " mahasiswa.ID";
    }
    $qinput .= " <input type=hidden name=sort value='{$sort}'>";
    $q = "SELECT COUNT(*) AS JML FROM mahasiswa,prodi,departemen \n\tWHERE 1=1 {$qprodidep5} AND\n\tmahasiswa.IDPRODI=prodi.ID AND\n\tprodi.IDDEPARTEMEN=departemen.ID\n\t{$qfieldtambahan2}\n\t{$qfield}\n \t{$qfieldx1} \n\t";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $total = $d['JML'];
    $first = 0;
    if ( 0 + $dataperhalaman <= 0 )
    {
        $dataperhalaman = 1;
    }
    $maxdata = $dataperhalaman;
    include( "../paginating.php" );
    $q = "SELECT mahasiswa.*,mahasiswa.NAMAAYAH,mahasiswa.NAMAIBU,\n\tIF(TANGGALKELUAR > TANGGALMASUK,\n\t(TO_DAYS(TANGGALKELUAR)-TO_DAYS(TANGGALMASUK))/365,0) \n\tAS MASABELAJAR,\n\tprodi.SKSMIN,\n\tprodi.JENIS, \n\tprodi.TINGKAT, \n\tprodi.NAMAJENJANG2, \n\tprodi.IDDEPARTEMEN, \n\tprodi.GELAR,\n\tprodi.NAMA NAMAP,\n\tprodi.NAMA2 NAMAP2,\n\tprodi.SKSMIN,\n\tprodi.NAMAPIMPINAN,\n\tprodi.NIPPIMPINAN,\n\tprodi.NAMAPUKET1AKADEMIK,\n\tdepartemen.IDFAKULTAS ,departemen.NAMA AS NAMAD,\n\tKDSTAMSPST,\n\tmsmhs.STPIDMSMHS,ASPTIMSMHS\n\tFROM mahasiswa,msmhs,departemen,prodi LEFT JOIN mspst ON prodi.ID=mspst.IDX\n\tWHERE 1=1 {$qprodidep5} AND\n\tmahasiswa.ID=msmhs.NIMHSMSMHS AND \n\tmahasiswa.IDPRODI=prodi.ID AND\n\tprodi.IDDEPARTEMEN=departemen.ID\n\t{$qfieldtambahan2}\n\t{$qfield}\n\t{$qfieldx1} \n\tORDER BY {$sort} {$qlimit}";
    #echo $q.'<br>';
    $h = mysqli_query($koneksi,$q);
    unset( $arraydatacsv );
    if ( 0 < sqlnumrows( $h ) )
    {
		 echo "	<div class=\"page-content\">
					<div class=\"container-fluid\">
						<div class=\"row\">
							<div class=\"col-md-12\">
								<!-- BEGIN SAMPLE FORM PORTLET-->
								";	
										#printmesg( $qjudul );
										#printmesg( $errmesg );
			echo "						<div class='portlet-title'>";
											printmesg("Daftar Nilai Ujian");
			echo "						</div>
									<div class=\"m-portlet\">
										<!--begin::Form-->";
        $tmpcetakawal = "";
        $tmpcetakawal .= "<center>";
        if ( $aksi != "cetak" && $jenisusers!=2 )
        {
            /*$tmpcetakawal .= "\n\t\t\t\t<table class=form>\n\t\t\t\t<tr><td> \n\t\t\t<form target=_blank action='cetakdaftarnilai.php'>";
            $tmpcetakawal .= "\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\n          ";
            $tmpcetakawal .= "\n    \t\t\t\t".createinputhidden( "tgllap[tgl]", "{$tgllap['tgl']}", "" )."\n\t\t\t".createinputhidden( "tgllap[bln]", "{$tgllap['bln']}", "" )."\n\t\t\t".createinputhidden( "tgllap[thn]", "{$tgllap['thn']}", "" )."\n\t\t\t".createinputhidden( "diagram", "{$diagram}", "" )."\n\t\t\t".createinputhidden( "nilaidiambil", "{$nilaidiambil}", "" )."\n\t\t\t".createinputhidden( "jenistampilan", "{$jenistampilan}", "" )."\n \t\t\t".createinputhidden( "dataperhalaman", "{$dataperhalaman}", "" )."\n\t\t\t".createinputhidden( "jenistampilan", "{$jenistampilan}", "" )."\n\t\t\t".createinputhidden( "nilaikosong", "{$nilaikosong}", "" )."\n \t\t\t".createinputhidden( "sp", "{$sp}", "" )."\n \t\t\t".createinputhidden( "penempatansemester", "{$penempatansemester}", "" )."\n \t\t\t".createinputhidden( "iscsv", "{$iscsv}", "" )."\n \t\t\t".createinputhidden( "kopsurat", "{$kopsurat}", "" )."\n \t\t\t\t{$qinput} {$input}\n\t\t\t</form>\n\t\t\t\t</td></tr></table>";
			*/
			$tmpcetakawal .= "<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" target=_blank action='cetakdaftarnilai.php'>";
            $tmpcetakawal .= "\n \t\t\t\t<input type=submit name=aksi class=\"btn btn-brand\" value='Cetak'>\n          ";
            $tmpcetakawal .= "\n    \t\t\t\t".createinputhidden( "tgllap[tgl]", "{$tgllap['tgl']}", "" )."\n\t\t\t".createinputhidden( "tgllap[bln]", "{$tgllap['bln']}", "" )."\n\t\t\t".createinputhidden( "tgllap[thn]", "{$tgllap['thn']}", "" )."\n\t\t\t".createinputhidden( "diagram", "{$diagram}", "" )."\n\t\t\t".createinputhidden( "nilaidiambil", "{$nilaidiambil}", "" )."\n\t\t\t".createinputhidden( "jenistampilan", "{$jenistampilan}", "" )."\n \t\t\t".createinputhidden( "dataperhalaman", "{$dataperhalaman}", "" )."\n\t\t\t".createinputhidden( "jenistampilan", "{$jenistampilan}", "" )."\n\t\t\t".createinputhidden( "nilaikosong", "{$nilaikosong}", "" )."\n \t\t\t".createinputhidden( "sp", "{$sp}", "" )."\n \t\t\t".createinputhidden( "penempatansemester", "{$penempatansemester}", "" )."\n \t\t\t".createinputhidden( "iscsv", "{$iscsv}", "" )."\n \t\t\t".createinputhidden( "kopsurat", "{$kopsurat}", "" )."\n \t\t\t\t{$qinput} {$input}\n\t\t\t</form>";
			
			
		}
        $totalsemua = 0;
        $bobotsemua = 0;
        $totals = "";
        $bobots = "";
        $headertranskrip = $bodytranskrip = $footertranskrip = "";
        $count = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            ++$count;
            if ( 1 < $count && $pdf == 1 )
            {
                $hasiltranskrip .= "<PAGEBREAK>";
            }
            $tmp = explode( "-", $d['TANGGAL'] );
            $tgllahir = $tmp;
            $tmp = explode( "-", $d['TANGGALKELUAR'] );
            $tgllulus = $tmp[2];
            $blnlulus = $tmp[1];
            $thnlulus = $tmp[0];
            $tanggallulus = $tgllulus." ".$arraybulan[$blnlulus - 1]." ".$thnlulus;
            $tmp = explode( "-", $d['TANGGALSKPINDAHAN'] );
            $tanggalskpindahan['thn'] = $tmp[0];
            $tanggalskpindahan['tgl'] = $tmp[2];
            $tanggalskpindahan['bln'] = $tmp[1];
            $tanggalskpindahan = $tanggalskpindahan['tgl']."-".$tanggalskpindahan['bln']."-".$tanggalskpindahan['thn'];
            $idfakultas = $d['IDFAKULTAS'];
            $idprodi = $d['IDPRODI'];
            if ( $KODETRANSKRIP == 1 )
            {
                $namaprodi = $d['NAMAP'];
                if ( $d['TINGKAT'] == "C" )
                {
                    $NAMAPROGRAM = "SARJANA";
                }
                else
                {
                    if ( $d['TINGKAT'] == "E" )
                    {
                        $NAMAPROGRAM = "DIPLOMA III";
                    }
                }
            }
            else
            {
                $namaprodi = "";
                $NAMAPROGRAM = "";
            }
            $NO_SERIIJAZAH = "";
            $q = "SELECT NOIJATRLSM,TGLRETRLSM,NOTRANSKRIP,NOBLANKO,NILAIUAPTULIS,NILAIUAPPRAKTEK,SIMBOLUAPTULIS,SIMBOLUAPPRAKTEK,PEMINATAN ".
	    "FROM trlsm WHERE NIMHSTRLSM='{$d['ID']}' AND STMHSTRLSM ='L'";
            $hi = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $hi ) )
            {
                $di = sqlfetcharray( $hi );
                $NO_SERIIJAZAH = $di['NOIJATRLSM'];
                $NO_SERITRANSKRIP = $di['NOTRANSKRIP'];
                $NO_BLANKO = $di['NOBLANKO'];
                $NILAIUAPTULIS = $di['NILAIUAPTULIS'];
                $NILAIUAPPRAKTEK = $di['NILAIUAPPRAKTEK'];
                $SIMBOLUAPTULIS = $di['SIMBOLUAPTULIS'];
                $SIMBOLUAPPRAKTEK = $di['SIMBOLUAPPRAKTEK'];
                $PEMINATAN = $di['PEMINATAN'];
                $tmp = explode( "-", $di['TGLRETRLSM'] );
                $tglyudisium = "{$tmp['2']}-{$tmp['1']}-{$tmp['0']}";
                $tglyudisium2 = "{$tmp['2']} ".$arraybulan[$tmp[1] - 1]." {$tmp['0']}";
            }
            if ( $aksi != "cetak" )
            {
                #printjudulmenu( "DAFTAR NILAI UJIAN" );
            }
            if ( $DAFTARNILAISEMENTARA == "" )
            {
                $totalsemua = 0;
                $bobotsemua = 0;
                $totals = "";
                $bobots = "";
                /*$tmpcetakawal .= "<center><b>DAFTAR NILAI UJIAN</b>
									<table  width=630  >\n\t\t\t\t<tr valign=top>\n\t\t\t\t<td width=60%>\n\t\t\t\t<table    >\n\t\t\t\t\t<tr align=left>\n\t\t\t\t\t\t<td>Nama</td>\n\t\t\t\t\t\t<td>: {$d['NAMA']}</td>\n\t\t\t\t\t</tr>\n\t\t\t\t\t<tr align=left>\n\t\t\t\t\t\t<td class=judulform>NIM</td>\n\t\t\t\t\t\t<td>: {$d['ID']}</td>\n\t\t\t\t\t</tr>\n\t\t\t\t\t<tr align=left>\n\t\t\t\t\t\t<td nowrap>Tempat/Tgl Lahir</td>\n\t\t\t\t\t\t<td nowrap>: {$d['TEMPAT']},  {$tgllahir['2']} ".$arraybulan[$tgllahir[1] - 1]." {$tgllahir['0']}</td>\n\t\t\t\t\t</tr>\n \t\t\t\t</table>\n\t\t\t</td>\n\t\t\t<td  width=40%>\n\n\t\t\t\t<table   >  \n \t\t\t\t\t<tr align=left>\n\t\t\t\t\t\t<td>Fakultas</td>\n\t\t\t\t\t\t<td>: ".$arrayfakultas[$d[IDFAKULTAS]]."</td>\n\t\t\t\t\t</tr> \n\t\t\t\t\t<tr align=left>\n\t\t\t\t\t\t<td>Jurusan</td>\n\t\t\t\t\t\t<td>: ".$arraydepartemen[$d[IDDEPARTEMEN]]."</td>\n\t\t\t\t\t</tr>\n\t\t\t\t\t<tr align=left>\n\t\t\t\t\t\t<td>Program Studi</td>\n\t\t\t\t\t\t<td>: ".$arrayprodi[$d[IDPRODI]]." (".$arrayjenjang[$d[TINGKAT]].")</td>\n\t\t\t\t\t</tr>\n\t\t\t\t</table>\t\t\t\t\n\t\t\t\t\n\t\t\t</td>\n\t\t</tr>\n\t\t</table>\n\t \n\t\t\t";
				*/
				$tmpcetakawal .="		<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" >
											<div class=\"m-portlet__body\">
												<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
													<label class=\"col-lg-2 col-form-label\">Nama</label>\r\n    
													<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
														: {$d['NAMA']}
													</label>
												</div>
												<div class=\"form-group m-form__group row\">
													<label class=\"col-lg-2 col-form-label\">NIM</label>\r\n    
													<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
														: {$d['ID']}
													</label>
												</div>
												<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
													<label class=\"col-lg-2 col-form-label\">Tempat/Tgl Lahir</label>\r\n    
													<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
														: {$d['TEMPAT']},  {$tgllahir['2']} ".$arraybulan[$tgllahir[1] - 1]." {$tgllahir['0']}
													</label>
												</div>
												<div class=\"form-group m-form__group row\">
													<label class=\"col-lg-2 col-form-label\">Fakultas</label>\r\n    
													<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
														: ".$arrayfakultas[$d['IDFAKULTAS']]."
													</label>
												</div>
												<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
													<label class=\"col-lg-2 col-form-label\">Jurusan</label>\r\n    
													<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
														: ".$arraydepartemen[$d['IDDEPARTEMEN']]."
													</label>
												</div>
												<div class=\"form-group m-form__group row\">
													<label class=\"col-lg-2 col-form-label\">Program Studi</label>\r\n    
													<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
														: ".$arrayprodi[$d['IDPRODI']]." (".$arrayjenjang[$d['TINGKAT']].")
													</label>
												</div>
											</div>
										</form>";				
												
			}
            $d2['STPIDMSMHS'] = $d['STPIDMSMHS'];
            $statuspindahan = $d2['STPIDMSMHS'];
            $angkatanmhs = $d['ANGKATAN'];
            $idmahasiswa = $d['ID'];
            if ( $iscsv == 1 )
            {
                if ( $aksi != "cetak" )
                {
                    echo $tmpcetakawal;
                }
            }
            else
            {
                $headertranskrip = $tmpcetakawal;
            }
            if ( $DAFTARNILAISEMENTARA == "" )
            {
                include( "prosesdetildaftarnilai.php" );
            }
            else
            {
                include( "{$DAFTARNILAISEMENTARA}" );
            }
            if ( $aksi != "cetak" )
            {
                $tmpcetakawal = "<hr>";
            }
            else
            {
                $tmpcetakawal = "</div>";
            }
            if ( $iscsv == 1 && $aksi != "cetak" )
            {
                echo $tmpcetakawal;
            }
            $hasiltranskrip .= $headertranskrip.$bodytranskrip.$footertranskrip;
            $headertranskrip = $bodytranskrip = $footertranskrip = "";
        }
        if ( $pdf == 1 )
        {
            cetakpdfPortrait( $hasiltranskrip, $styletranskrip );
        }
        else
        {
            echo $styletranskrip.$hasiltranskrip;
        }
    }
    else
    {
        $errmesg = "Data mahasiswa tidak ada";
        $aksi = "";
    }
}
?>
