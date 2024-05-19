    <?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
set_time_limit(0);
#print_r($_POST);exit();
$t                  = $_POST["idmhs"];
$idprodi            = (!$_POST["idprodi"])?"":$_POST["idprodi"];
$iddosen            = (!$_POST["iddosen"])?"":$_POST["iddosen"];
$angkatan           = (!$_POST["angkatan"])?"":$_POST["angkatan"];
$id                 = (!$_POST["id"])?"":$_POST["id"];
$nama               = (!$_POST["nama"])?"":$_POST["nama"];
$status             = (!$_POST["status"])?"":$_POST["status"];
$tahun              = (!$_POST["tahun"])?"":$_POST["tahun"];
$semester           = (!$_POST["semester"])?"":$_POST["semester"];
$nilaidiambil       = (!$_POST["nilaidiambil"])?"":$_POST["nilaidiambil"];
$nilaikosong        = (!$_POST["nilaikosong"])?"":$_POST["nilaikosong"];
$sp                 = (!$_POST["sp"])?"":$_POST["sp"];
$diagram            = (!$_POST["diagram"])?"":$_POST["diagram"];
$jenistampilan      = (!$_POST["jenistampilan"])?"":$_POST["jenistampilan"];
/*$tanggalskpindahanlap['tgl']      = (!$_POST["tanggalskpindahanlap[tgl]"])?"":$_POST["tanggalskpindahanlap[tgl]"];
$tanggalskpindahanlap['bln']      = (!$_POST["tanggalskpindahanlap[bln]"])?"":$_POST["tanggalskpindahanlap[bln]"];
$tanggalskpindahanlap['thn']      = (!$_POST["tanggalskpindahanlap[thn]"])?"":$_POST["tanggalskpindahanlap[thn]"];*/

$tgllap['tgl']= (!$_POST["tgl"])?"":$_POST["tgl"];
$tgllap['bln']= (!$_POST["bln"])?"":$_POST["bln"];
$tgllap['thn']= (!$_POST["thn"])?"":$_POST["thn"];
#echo $tgllap['tgl'];exit(); 

$dataperhalaman     = (!$_POST["dataperhalaman"])?"":$_POST["dataperhalaman"] ;

$nim = $tmp ="";
for($a=0;$a<count($t);$a++) {
    if(!$tmp)
        $tmp = "'".$t[$a]."'";
    else
        $tmp.=", '".$t[$a]."'";
}
$nim = "(".$tmp.")";

//$vld[] = cekvaliditaskodeprodi( "Jurusan/Program Studi", $idprodi );
//$vld[] = cekvaliditaskode( "Dosen Wali", $iddosen );
//$vld[] = cekvaliditastahun( "Angkatan", $angkatan );
//$vld[] = cekvaliditaskode( "NIM", $id );
//$vld[] = cekvaliditasnama( "Nama", $nama );
//$vld[] = cekvaliditaskode( "Status", $status );
//$vld[] = cekvaliditaskode( "Nilai M-K yang diambil", $nilaidiambil, 1 );
//$vld[] = cekvaliditaskode( "Perlakuan terhadap nilai kosong", $nilaikosong, 1 );
//$vld[] = cekvaliditaskode( "Penempatan Semester Mata Kuliah", $penempatansemester, 2 );
//$vld[] = cekvaliditaskode( "Nilai SP", $sp );
//$vld[] = cekvaliditaskode( "Cetak Diagram", $diagram );
//$vld[] = cekvaliditaskode( "Jenis", $jenistampilan );
//$vld[] = cekvaliditastanggal( "Tanggal", $tanggalskpindahanlap['tgl'], $tanggalskpindahanlap['bln'], $tanggalskpindahanlap['thn'] );
//$vld[] = cekvaliditasinteger( "Data perhalaman", $dataperhalaman, 4 );
//$vld = array_filter( $vld, "filter_not_empty" );
//if ( isset( $vld ) && 0 < count( $vld ) )
//{
//    $errmesg = val_err_mesg( $vld, 2, CARI_DATA );
//    $aksi = "";
//}
//else
//{
    $href = "index.php?".$href."pilihan={$pilihan}&aksi={$aksi}&tgllap[tgl]={$tgllap['tgl']}&tgllap[bln]={$tgllap['bln']}&tgllap[thn]={$tgllap['thn']}&jenistampilan={$jenistampilan}&nilaidiambil={$nilaidiambil}&nilaikosong={$nilaikosong}&";
    $q = "\n\t\t\t\tSELECT NAMA,SYARAT,SYARATW,NAMA2 FROM konversipredikat\n\t\t\t\tORDER BY SYARAT DESC,SYARATW\n\t\t\t";
    $hkonversi = mysqli_query($koneksi,$q);
	if (sqlnumrows($hkonversi)>0) {
				while ($dkonversi=sqlfetcharray($hkonversi)) {
					$konpredikat[]=$dkonversi;
	 			}		
			}
    if ( $idprodi != "" )
    {
        $qfield .= " AND IDPRODI='{$idprodi}'";
        $qjudul .= " Jurusan/Program Studi '".$arrayprodidep[$idprodi]."' <br>";
        $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
        $href .= "idprodi={$idprodi}&";
    }
    if ( $iddosen != "" )
    {
        $qfield .= " AND IDDOSEN='{$iddosen}'";
        $qjudul .= " Dosen Wali '".$arraydosen[$iddosen]."' <br>";
        $qinput .= " <input type=hidden name=iddosen value='{$iddosen}'>";
        $href .= "iddosen={$iddosen}&";
    }
    if ( $angkatan != "" )
    {
        $qfield .= " AND ANGKATAN='{$angkatan}'";
        $qjudul .= " Angkatan '{$angkatan}' <br>";
        $qinput .= " <input type=hidden name=angkatan value='{$angkatan}'>";
        $href .= "angkatan={$angkatan}&";
    }
    if ( $id != "" )
    {
        $qfield .= " AND mahasiswa.ID LIKE '%{$id}%'";
        $qjudul .= " NIM '{$id}' <br>";
        $qinput .= " <input type=hidden name=id value='{$id}'>";
        $href .= "id={$id}&";
    }
    if ( $nim != "" )
    {
        $qfield .= " AND mahasiswa.ID IN {$nim}";
        $qjudul .= " NIM = '{$idmhs}' <br>";
        $qinput .= " <input type=hidden name=idmhs value='{$idmhs}'>";
        $href .= "idmhs={$idmhs}&";
    }
    if ( $nama != "" )
    {
        $qfield .= " AND mahasiswa.NAMA LIKE '%{$nama}%'";
        $qjudul .= " Nama mengandung kata '{$nama}' <br>";
        $qinput .= " <input type=hidden name=nama value='{$nama}'>";
        $href .= "nama={$nama}&";
    }
    if ( $status != "" )
    {
        $qfield .= " AND mahasiswa.STATUS='{$status}'";
        $qjudul .= " Status Mahasiswa '".$arraystatusmahasiswa["{$status}"]."' <br>";
        $qinput .= " <input type=hidden name=status value='{$status}'>";
        $href .= "status={$status}&";
    }
    if ( $jeniskelas != "" )
    {
        $qfield .= " AND mahasiswa.JENISKELAS='{$jeniskelas}'";
        $qjudul .= " Jenis Kelas '".$arraykelasstei["{$jeniskelas}"]."' <br>";
        $qinput .= " <input type=hidden name=jeniskelas value='{$jeniskelas}'>";
        $href .= "jeniskelas={$jeniskelas}&";
    }
    if ( $sort == "" )
    {
        $sort = " mahasiswa.ID";
    }
    $qinput .= " <input type=hidden name=sort value='{$sort}'>";
    $q = "SELECT COUNT(*) AS JML FROM mahasiswa,prodi,departemen \n\tWHERE 1=1 {$qprodidep5} AND\n\tmahasiswa.IDPRODI=prodi.ID AND\n\tprodi.IDDEPARTEMEN=departemen.ID\n\t{$qfieldtambahan2}\n\t{$qfield}\n \t{$qfieldx1} \n\t";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $total = $d[JML];
    $first = 0;
    //if ( 0 + $dataperhalaman <= 0 )
    //{
    //    $dataperhalaman = 1;
    //}
    $maxdata = $dataperhalaman;
    include( "../paginating.php" );
    $q = "SELECT mahasiswa.*,mahasiswa.NAMAAYAH,mahasiswa.NAMAIBU,\n\tIF(TANGGALKELUAR > TANGGALMASUK,\n\t(TO_DAYS(TANGGALKELUAR)-TO_DAYS(TANGGALMASUK))/365,0) \n\tAS MASABELAJAR,\n\tprodi.SKSMIN,\n\tprodi.JENIS, \n\tprodi.TINGKAT, \n\tprodi.NAMAJENJANG2, \n\tprodi.IDDEPARTEMEN, \n\tprodi.GELAR,\n\tprodi.NAMA NAMAP,\n\tprodi.NAMA2 NAMAP2,\n\tprodi.SKSMIN,\n\tprodi.NAMAPIMPINAN,\n\tprodi.NIPPIMPINAN,\n\tprodi.NAMAPUKET1AKADEMIK,\n\tdepartemen.IDFAKULTAS ,departemen.NAMA AS NAMAD,\n\tKDSTAMSPST,\n\tmsmhs.STPIDMSMHS,ASPTIMSMHS,\n\tmspst.KDSTAMSPST,mspst.NOMBAMSPST,\n\tCOUNT(diskonbeasiswa.IDMAHASISWA) AS JUMLAHBEASISWA,\n\tprodi.LABELSKRIPSI,prodi.LABELSKRIPSI2\n\tFROM mahasiswa LEFT JOIN diskonbeasiswa ON mahasiswa.ID=diskonbeasiswa.IDMAHASISWA \n  \n  ,msmhs,departemen,prodi LEFT JOIN mspst ON prodi.ID=mspst.IDX\n\tWHERE 1=1 {$qprodidep5} AND\n\tmahasiswa.ID=msmhs.NIMHSMSMHS AND \n\tmahasiswa.IDPRODI=prodi.ID AND\n\tprodi.IDDEPARTEMEN=departemen.ID\n\t{$qfieldtambahan2}\n\t{$qfield}\n\t{$qfieldx1} \n\t\n\tGROUP BY mahasiswa.ID\n\t\n\tORDER BY mahasiswa.ID";
    $h = mysqli_query($koneksi,$q);
    unset( $arraydatacsv );
    if ( 0 < sqlnumrows( $h ) )
    {
        $tmpcetakawal = "";
        if ( $UNIVERSITAS != "UNIVERSITAS MALAHAYATI" && $UNIVERSITAS != "UNIVERSITAS 17 AGUSTUS 1945" )
        {
            $tmpcetakawal .= "<center>";
        }
        if ( $aksi != "cetak" )
        {
            $tmpcetakawal .= "\n\t\t\t\t<table class=form>\n\t\t\t\t<tr><td> \n\t\t\t<form target=_blank action='cetaktranskrip.php'>";
            if ( $iscsv != 1 )
            {
                $tmpcetakawal .= "\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\n          ";
            }
            else
            {
                $tmpcetakawal .= "\n \t\t\t\t<input type=submit name=aksix class=tombol value='Simpan CSV'>  \n \t\t\t\t<input type=hidden name=aksi  value='Cetak'>\n         ";
            }
            $tmpcetakawal .= "\n    \t\t\t\t".createinputhidden( "tgllap[tgl]", "{$tgllap['tgl']}", "" )."\n\t\t\t".createinputhidden( "tgllap[bln]", "{$tgllap['bln']}", "" )."\n\t\t\t".createinputhidden( "tgllap[thn]", "{$tgllap['thn']}", "" )."\n\t\t\t".createinputhidden( "diagram", "{$diagram}", "" )."\n\t\t\t".createinputhidden( "nilaidiambil", "{$nilaidiambil}", "" )."\n\t\t\t".createinputhidden( "jenistampilan", "{$jenistampilan}", "" )."\n \t\t\t".createinputhidden( "dataperhalaman", "{$dataperhalaman}", "" )."\n\t\t\t".createinputhidden( "jenistampilan", "{$jenistampilan}", "" )."\n\t\t\t".createinputhidden( "nilaikosong", "{$nilaikosong}", "" )."\n \t\t\t".createinputhidden( "sp", "{$sp}", "" )."\n \t\t\t".createinputhidden( "penempatansemester", "{$penempatansemester}", "" )."\n \t\t\t".createinputhidden( "iscsv", "{$iscsv}", "" )."\n \t\t\t".createinputhidden( "kopsurat", "{$kopsurat}", "" )."\n \t\t\t\t{$qinput} {$input}\n\t\t\t</form>\n\t\t\t\t</td></tr></table>";
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
            if ( getaturan( "APPROVEBEASISWA" ) == 1 && 0 < $d[JUMLAHBEASISWA] && $d[APPROVEBEASISWA] == 0 )
            {
                $hasiltranskrip .= "\n            <div style='page-break-after:always'>\n            Mahasiswa ini ({$d['ID']}/{$d['NAMA']}) mendapatkan beasiswa dan belum diaprrove oleh supervisor, silahkan menghubungi supervisor\n            </div>\n          ";
            }
            else
            {
                $tmp = explode( "-", $d[TANGGALKELUAR] );
                $tanggalskpindahanlulus = $tmp[2];
                $blnlulus = $tmp[1];
                $thnlulus = $tmp[0];
                $tanggallulus = $tanggalskpindahanlulus." ".$arraybulan[$blnlulus - 1]." ".$thnlulus;
		if($d[TANGGALSKPINDAHAN]!="0000-00-00") {
		    $tmp = explode( "-", $d[TANGGALSKPINDAHAN]);
		    $tanggalskpindahan["thn"] = (!$tmp[0])?"":$tmp[0];
		    $tanggalskpindahan["tgl"] = (!$tmp[2])?"":$tmp[2];
		    $tanggalskpindahan["bln"] = (!$tmp[1])?"":$tmp[1];
		    $tanggalskpindahan = $tanggalskpindahan["tgl"]."-".$tanggalskpindahan["bln"]."-".$tanggalskpindahan["thn"];
		}    
                $idfakultas = $d[IDFAKULTAS];
                $idprodi = $d[IDPRODI];
                if ( $KODETRANSKRIP == 1 )
                {
                    $namaprodi = $d[NAMAP];
                    if ( $d[TINGKAT] == "C" )
                    {
                        $NAMAPROGRAM = "SARJANA";
                    }
                    else
                    {
                        if ( $d[TINGKAT] == "E" )
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
                $q = "SELECT NOIJATRLSM,TGLRETRLSM,NOTRANSKRIP,NOBLANKO,NILAIUAPTULIS,NILAIUAPPRAKTEK,SIMBOLUAPTULIS,SIMBOLUAPPRAKTEK,PEMINATAN\n                      FROM trlsm WHERE NIMHSTRLSM='{$d['ID']}' AND STMHSTRLSM ='L'";
                $hi = mysqli_query($koneksi,$q);
                if ( 0 < sqlnumrows( $hi ) )
                {
                    $di = sqlfetcharray( $hi );
                    $NO_SERIIJAZAH = $di[NOIJATRLSM];
                    $NO_SERITRANSKRIP = $di[NOTRANSKRIP];
                    $NO_BLANKO = $di[NOBLANKO];
                    $NILAIUAPTULIS = $di[NILAIUAPTULIS];
                    $NILAIUAPPRAKTEK = $di[NILAIUAPPRAKTEK];
                    $SIMBOLUAPTULIS = $di[SIMBOLUAPTULIS];
                    $SIMBOLUAPPRAKTEK = $di[SIMBOLUAPPRAKTEK];
                    $PEMINATAN = $di[PEMINATAN];
                    $tmp = explode( "-", $di[TGLRETRLSM] );
                    $tanggalskpindahanyudisium = "{$tmp['2']}-{$tmp['1']}-{$tmp['0']}";
                    $tanggalskpindahanyudisium2 = "{$tmp['2']} ".$arraybulan[$tmp[1] - 1]." {$tmp['0']}";
                }
                if ( $aksi != "cetak" )
                {
                    printjudulmenu( $JUDULTRANSKRIP );
                    $tmpcetakawal .= "{$tpage} {$tpage2}";
                }
                else
                {
                    $tmpkop = "";
                    if ( $kopsurat == 1 )
                    {
                        if ( $UNIVERSITAS == "UNIVERSITAS BOROBUDUR" )
                        {
                            include( "proseskoptranskrip.php" );
                        }
                        else
                        {
                            if ( $jenistampilan == "untag" )
                            {
                            }
                            else
                            {
                                include( "proseskop.php" );
                            }
                        }
                    }
                    else if ( $kopsurat == 2 )
                    {
                        if ( $UNIVERSITAS == "UNIVERSITAS BOROBUDUR" )
                        {
                            include( "proseskoptranskripfakultas.php" );
                        }
                        else if ( $jenistampilan == "untag" )
                        {
                        }
                        else
                        {
                            include( "proseskopfakultas.php" );
                        }
                    }
                    $tmpcetakawal .= "<div style='page-break-after:always'>".$tmpkop;
                    if ( $UNIVERSITAS == "UMJ" )
                    {
                        $NAMAPROGRAM = $namaprodi = "";
                        $tmpcetakawal .= "\n                      \t\t\t <table width=600><tr><td align=left>{$NOSERIIJASAH} : {$NO_SERIIJAZAH} </td></tr></table>\n                      \t\t\t<!--<br>\n                      \t\t\t<b style='font-size:16pt;'>UNIVERSITAS MUHAMMADIYAH JAKARTA</b><br>\n                      \t\t\t-->\n                            <br>\n                      \t\t\t<div align=center><b style='font-size:12pt;' >{$JUDULTRANSKRIP} {$NAMAPROGRAM} {$namaprodi}</b></div><br>\n                      \t\t\t<br>\n                      \t\t\t";
                    }
                    else if ( $UNIVERSITAS == "STEI INDONESIA" )
                    {
                        $qp = "SELECT * FROM mspst WHERE IDX='{$d['IDPRODI']}'";
                        $hp = doquery($koneksi,$qp);
                        $dp = sqlfetcharray($hp);
                        $tmp = explode( "-", $dp[TGLSKMSPST] );
                        $thn1 = $tmp[0];
                        $bln1 = $tmp[1];
                        $tanggalskpindahan1 = $tmp[2];
                        $tmp = explode( "-", $dp[TGLBAMSPST] );
                        $thnak1 = $tmp[0];
                        $blnak1 = $tmp[1];
                        $tanggalskpindahanak1 = $tmp[2];
                        $tmpcetakawal .= "\n                       \t\t\t<table width=600><tr><td align=center style='font-size:16pt;'><b>{$JUDULTRANSKRIP} {$NAMAPROGRAM} {$namaprodi}</b>  </td></tr></table>\n                  <br><br>\n                            \n                  <!--          Ketua Sekolah Tinggi Ilmu EKonomi Indonesia dengan persetujuan Senat Sekolah Tinggi atas rekomendasi Ketua Jurusan ".$arraydepartemen[$d[IDDEPARTEMEN]]." dan Surat Keputusan Mendikbud Republik Indonesia No: {$dp['NOMSKMSPST']} tanggal {$tanggalskpindahan1}-{$bln1}-{$thn1} tentang pembukaan jurusan ".$arraydepartemen[$d[IDDEPARTEMEN]]." dan Surat Keputusan Badan Akreditasi Nasional (BAN) No: {$dp['NOMBAMSPST']} tanggal {$tanggalskpindahanak1}-{$blnak1}-{$thnak1}, tentang akreditasi  program studi ".$arrayjenjang[$d[TINGKAT]]." ".$arrayprodi[$d[IDPRODI]]." dengan peringkat ".$arrayakreditasipt[$dp[KDSTAMSPST]]." menyatakan \n                       \t\t\t<br><br> -->\n                      \t\t\t";
                    }
                    else if ( $UNIVERSITAS == "UNIKAL" )
                    {
                        if ( $jenistampilan == "unikal2" )
                        {
                            $tmpcetakawal .= "\n                      \t\t\t <div align=center><b style='font-size:16pt;'>TRANSKRIP SEMENTARA </b></div> <br>\n                       \t\t\t<br><br>\n                      \t\t\t";
                        }
                    }
                    else if ( $UNIVERSITAS == "UNM" )
                    {
                        $tmpcetakawal .= "\n                      \t\t\t<div align=center> <b style='font-size:16pt;'>LAMPIRAN IJAZAH</b> <br><br>\n                      \t\t\t <b style='font-size:12pt;'>** DAFTAR MATA KULIAH YANG TELAH DILULUSI **</b> <br> </div>\n                       \t\t\t<br> \n                      \t\t\t";
                    }
                    else if ( $UNIVERSITAS == "STIKES SAMARINDA" )
                    {
                    }
                    else if ( $UNIVERSITAS == "MITRA RIA HUSADA" )
                    {
                    }
                    else if ( $UNIVERSITAS == "UNILAK" )
                    {
                    }
                    else if ( $UNIVERSITAS == "UNIVERSITAS BATAM" )
                    {
                    }
                    else if ( $UNIVERSITAS == "UNIVERSITAS BOROBUDUR" )
                    {
                    }
                    else if ( $UNIVERSITAS == "UNIVERSITAS 17 AGUSTUS 1945" )
                    {
                    }
                    else if ( $UNIVERSITAS == "UNIVERSITAS MALAHAYATI" )
                    {
                    }
                    else
                    {
                        $tmpcetakawal .= "\n                      \t\t\t<div align=center><b><u style='font-size:16pt;'>{$JUDULTRANSKRIP} {$NAMAPROGRAM} {$namaprodi}</u></b><br></div>\n                      \t\t\t<table><tr><td>{$NOSERIIJASAH} : {$NO_SERIIJAZAH} </td></tr></table>\n                      \t\t\t<br><br>\n                      \t\t\t";
                    }
                }
                $ketlog = "Cetak Transkrip {$d['ID']} / {$d['NAMA']}";
                buatlog( 57 );
                $totalsemua = 0;
                $bobotsemua = 0;
                $totals = "";
                $bobots = "";
                $tmp = explode( "-", $d[TANGGAL] );
				#echo $jenistampilan.$HEADERTRANSKRIP;
                if ( $HEADERTRANSKRIP == "" )
                {
                    $tmpcetakawal .= " \n                  \t\t\t<center> \n                  \t\t\t<table  width=630  >\n                  \t\t\t\t<tr valign=top>\n                  \t\t\t\t<td width=60%>\n                  \t\t\t\t<table    >\n                  \t\t\t\t\t<tr align=left>\n                  \t\t\t\t\t\t<td>Nama</td>\n                  \t\t\t\t\t\t<td>: {$d['NAMA']}</td>\n                  \t\t\t\t\t</tr>\n                  \t\t\t\t\t<tr align=left>\n                  \t\t\t\t\t\t<td class=judulform>NIM</td>\n                  \t\t\t\t\t\t<td>: {$d['ID']}</td>\n                  \t\t\t\t\t</tr>\n                  \t\t\t\t\t<tr align=left>\n                  \t\t\t\t\t\t<td nowrap>Tempat/Tgl Lahir</td>\n                  \t\t\t\t\t\t<td nowrap>: {$d['TEMPAT']},  {$tmp['2']} ".$arraybulan[$tmp[1] - 1]." {$tmp['0']}</td>\n                  \t\t\t\t\t</tr>\n                   \t\t\t\t</table>\n                  \t\t\t</td>\n                  \t\t\t<td  width=40%>\n                  \n                  \t\t\t\t<table   >";
                    if ( $POLITEKNIK == 0 )
                    {
                        $tmpcetakawal .= " \n                   \t\t\t\t\t<tr align=left>\n                  \t\t\t\t\t\t<td>Fakultas</td>\n                  \t\t\t\t\t\t<td>: ".$arrayfakultas[$d[IDFAKULTAS]]."</td>\n                  \t\t\t\t\t</tr>";
                    }
                    $tmpcetakawal .= " \n                  \t\t\t\t\t<tr align=left>\n                  \t\t\t\t\t\t<td>Jurusan</td>\n                  \t\t\t\t\t\t<td>: ".$arraydepartemen[$d[IDDEPARTEMEN]]."</td>\n                  \t\t\t\t\t</tr>\n                  \t\t\t\t\t<tr align=left>\n                  \t\t\t\t\t\t<td>Program Studi</td>\n                  \t\t\t\t\t\t<td>: ".$arrayprodi[$d[IDPRODI]]." (".$arrayjenjang[$d[TINGKAT]].")</td>\n                  \t\t\t\t\t</tr>\n                  \t\t\t\t</table>\t\t\t\t\n                  \t\t\t\t\n                  \t\t\t</td>\n                  \t\t</tr>\n                  \t\t</table>\n                  \t \n                  \t\t\t";
                }
                else if ( $UNIVERSITAS == "UNIVERSITAS BATAM" && $jenistampilan == "bataminggris" )
                {
                    include( "headertranskripuniversitasbataminggris.php" );
                }
                else if ( $UNIVERSITAS == "UNIVERSITAS BATAM" && $jenistampilan == "batamsementara" )
                {
                    include( "headertranskripuniversitasbatamsementara.php" );
                }
                else if ( $UNIVERSITAS == "UNIVERSITAS BOROBUDUR" && $jenistampilan == "borobudursementara" )
                {
                    include( "headertranskripuniversitasborobudursementara.php" );
                }
                else if ( $UNIVERSITAS == "UNIVERSITAS BOROBUDUR" && $d[STPIDMSMHS] == "P" )
                {
                    include( "headertranskripuniversitasborobudurpindahan.php" );
                }
                else if ( $UNIVERSITAS == "STIKES SAMARINDA" && $jenistampilan == "nonregulerstikessamarinda" )
                {
                    include( "headertranskripnonregulerstikessamarinda.php" );
                }
                else if ( $UNIVERSITAS == "UNIVERSITAS 17 AGUSTUS 1945" && $jenistampilan == "untag" )
                {
                    include( "headertranskripuntagblanko.php" );
                }
                else
                {
					#echo $jenistampilan.$HEADERTRANSKRIP.'<br>';
                    include( $HEADERTRANSKRIP );
                }
                $d2[STPIDMSMHS] = $d[STPIDMSMHS];
                $statuspindahan = $d2[STPIDMSMHS];
                $angkatanmhs = $d[ANGKATAN];
                $idmahasiswa = $d[ID];
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
                if ( $jenistampilan == 1 )
                {
                    include( "prosestranskripasli.php" );
                }
                else if ( $jenistampilan == "unikal1" )
                {
                    include( "prosestranskripunikal.php" );
                }
                else if ( $jenistampilan == "unikal2" )
                {
                    include( "prosestranskripunikal2.php" );
                }
                else if ( $jenistampilan == "mrh" )
                {
                    include( "prosestranskripmitrariahusada.php" );
                }
                else if ( $jenistampilan == "bataminggris" )
                {
                    include( "prosestranskripuniversitasbataminggris.php" );
                }
                else if ( $jenistampilan == "batamsementara" )
                {
					#echo "ll";exit();
                    include( "prosestranskripuniversitasbatamsementara.php" );
                }
                else if ( $jenistampilan == "borobudursementara" )
                {
                    include( "prosestranskripuniversitasborobudursementara.php" );
                }
                else if ( $jenistampilan == "nonregulerstikessamarinda" )
                {
                    include( "prosestranskripnonregulerstikessamarinda.php" );
                }
                else if ( $UNIVERSITAS == "UNIVERSITAS BOROBUDUR" && $d[STPIDMSMHS] == "P" )
                {
                    include( "prosestranskripuniversitasborobudurpindahan.php" );
                }
                else if ( $jenistampilan == "untag" )
                {
                    include( "prosestranskripuntagblanko.php" );
                }
                else if ( $jenistampilan == 0 )
                {
                    include( "prosestranskrip.php" );
                }
                else if ( $jenistampilan == 2 )
                {
                    include( "prosestranskripkolom.php" );
                }
                else if ( $jenistampilan == 3 )
                {
                    include( "prosestranskripduakolom.php" );
                }
                else if ( $jenistampilan == 99 && $FILETRANSKRIP != "" )
                {
					#echo $FILETRANSKRIP;
                    include( $FILETRANSKRIP );
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
        }
        if ( $pdf == 1 )
        {
            cetakpdf( $hasiltranskrip, $styletranskrip );
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
//}
?>
