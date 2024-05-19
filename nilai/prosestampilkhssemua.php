<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$t                  = $_POST["idmhs"];
$idprodi            = $_POST["idprodi"];
$iddosen            = $_POST["iddosen"];
$angkatan           = $_POST["angkatan"];
$id                 = $_POST["id"];
$nama               = $_POST["nama"];
$status             = $_POST["status"];
$tahun              = $_POST["tahun"];
$semester           = $_POST["semester"];
$nilaidiambil       = $_POST["nilaidiambil"];
$nilaikosong        = $_POST["nilaikosong"];
$sp                 = $_POST["sp"];
$diagram            = $_POST["diagram"];
$jenistampilan      = $_POST["jenistampilan"];
/*$tgllap['tgl']      = $_POST["tgllap[tgl]"];
$tgllap['bln']      = $_POST["tgllap[bln]"];
$tgllap['thn']      = $_POST["tgllap[thn]"];*/
$tgllap['tgl']      = $_POST["tgl"];
$tgllap['bln']      = $_POST["bln"];
$tgllap['thn']      = $_POST["thn"];
$dataperhalaman     = $_POST["dataperhalaman"];

$nim = $tmp ="";
for($a=0;$a<count($t);$a++) {
    if(!$tmp)
        $tmp = "'".$t[$a]."'";
    else
        $tmp.=", '".$t[$a]."'";
}
$nim = "(".$tmp.")";
$vld[] = cekvaliditaskodeprodi( "Jurusan/Program Studi", $idprodi );
$vld[] = cekvaliditaskode( "Dosen Wali", $iddosen );
$vld[] = cekvaliditastahun( "Angkatan", $angkatan );
$vld[] = cekvaliditaskode( "NIM", $id );
$vld[] = cekvaliditasnama( "Nama", $nama );
$vld[] = cekvaliditaskode( "Status", $status );
$vld[] = cekvaliditasthnajaran( "Tahun/Semester Ajaran", $tahun, $semester, false );
$vld[] = cekvaliditaskode( "Nilai M-K yang diambil", $nilaidiambil, 1 );
$vld[] = cekvaliditaskode( "Perlakuan terhadap nilai kosong", $nilaikosong, 1 );
$vld[] = cekvaliditaskode( "Nilai SP", $sp );
$vld[] = cekvaliditaskode( "Cetak Diagram", $diagram );
$vld[] = cekvaliditaskode( "Jenis", $jenistampilan );
$vld[] = cekvaliditastanggal( "Tanggal", $tgllap['tgl'], $tgllap['bln'], $tgllap['thn'] );
$vld[] = cekvaliditasinteger( "Data perhalaman", $dataperhalaman, 4 );
$vld = array_filter( $vld, "filter_not_empty" );
//print_r($_POST);

//if ( isset( $vld ) && 0 < count( $vld ) )
//{
//    $errmesg = val_err_mesg( $vld, 2, CARI_DATA );
//    $aksi = "";
//}
//else
//{
    include( "fungsinilai.php" );
    #include( "../libchart/libchart.php" );
    $href = "index.php?".$href."dataperhalaman={$dataperhalaman}&pilihan={$pilihan}&aksi={$aksi}&tgllap[tgl]={$tgllap['tgl']}&tgllap[bln]={$tgllap['bln']}&tgllap[thn]={$tgllap['thn']}&jenistampilan={$jenistampilan}&nilaidiambil={$nilaidiambil}&nilaikosong={$nilaikosong}&sp={$sp}&";
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
            
        $qfield .= " AND mahasiswa.ANGKATAN='{$angkatan}'";
        $qjudul .= " Angkatan '{$angkatan}' <br>";
        $qinput .= " <input type=hidden name=angkatan value='{$angkatan}'>";
        $href .= "angkatan={$angkatan}&";
    }
    if ( $id != "" )
    {
        $qfield .= " AND mahasiswa.ID LIKE '%{$id}%'";
        $qjudul .= " NIM mengandung kata '{$id}' <br>";
        $qinput .= " <input type=hidden name=id value='{$id}'>";
        $href .= "id={$id}&";
    }
    if ( ismahasiswa( ) || iswali( ) )
    {
        $idmhs = $users;
    }
    if ( $idmhs != "" )
    {
        $qfield .= " AND mahasiswa.ID IN {$nim}";
        //$qjudul .= " NIM = '{$idmhs}' <br>";
        //$qinput .= " <input type=hidden name=idmhs value='{$nim}'>";
        //$href .= "idmhs={$idmhs}&";
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
    if ( $tahun != "" )
    {
        $qinput .= " <input type=hidden name=tahun value='{$tahun}'>";
        $href .= "tahun={$tahun}&";
    }
    $qinput .= " <input type=hidden name=semester value='{$semester}'>";
    if ( $semester == "" )
    {
        $semester = 1;
    }
    $href .= "semester={$semester}&";
    $qinput .= " <input type=hidden name=sort value='{$sort}'>";
    $q = "SELECT COUNT(*) AS JML FROM mahasiswa,prodi,departemen  \r\n\tWHERE 1=1 {$qprodidep5} AND\r\n\tmahasiswa.IDPRODI=prodi.ID AND\r\n\tprodi.IDDEPARTEMEN=departemen.ID\r\n\t{$qfieldtambahan2}\r\n\t{$qfield}\r\n \t{$qfieldx1} \r\n\t";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $total = $d[JML];
    $first = 0;
    //if ( 0 + $dataperhalaman <= 0 )
    //{
    //    $dataperhalaman = 1;
    //}
    //$maxdata = $dataperhalaman;
    include( "../paginating.php" );
    $q = "SELECT mahasiswa.*,prodi.SKSMIN , \r\n\tprodi.IDDEPARTEMEN, \tprodi.TINGKAT,\r\n\tdepartemen.IDFAKULTAS,dosen.NAMA AS NAMADOSEN \r\n\tFROM mahasiswa LEFT JOIN dosen ON mahasiswa.IDDOSEN=dosen.ID ,prodi,departemen  ,trakm,mspst\r\n\tWHERE 1=1 {$qprodidep5} \r\n  AND  trakm.THSMSTRAKM=CONCAT('".( $tahun - 1 )."','{$semester}')\r\n  AND  trakm.NIMHSTRAKM=mahasiswa.ID\r\n  AND\r\n\tmahasiswa.IDPRODI=prodi.ID AND\r\n\tprodi.IDDEPARTEMEN=departemen.ID AND\r\n\tprodi.ID=mspst.IDX AND\r\n\tmspst.KDPTIMSPST = trakm.KDPTITRAKM AND\r\n\tmspst.KDJENMSPST = trakm.KDJENTRAKM AND\r\n\tmspst.KDPSTMSPST\t = trakm.KDPSTTRAKM  \r\n\t{$qfieldtambahan2}\r\n\t{$qfield}\r\n\t{$qfieldx1}\r\n\tORDER BY {$sort}";
    //print_r($q);
    //exit();
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        if ( $aksi != "cetak" )
        {
            printjudulmenu( "Kartu Hasil Studi (KHS)" );
            echo "{$tpage} {$tpage2}";
        }
        if ( $aksi != "cetak" )
        {
            echo "\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakkhs.php'>\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n  \t\t\t\t".createinputhidden( "tgllap[tgl]", "{$tgllap['tgl']}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[bln]", "{$tgllap['bln']}", "" )."\r\n\t\t\t".createinputhidden( "nilaidiambil", "{$nilaidiambil}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[thn]", "{$tgllap['thn']}", "" )."\r\n \t\t\t".createinputhidden( "dataperhalaman", "{$dataperhalaman}", "" )."\r\n \t\t\t".createinputhidden( "diagram", "{$diagram}", "" )."\r\n\t\t\t".createinputhidden( "catatan", "{$catatan}", "" )."\r\n\t\t\t".createinputhidden( "jenistampilan", "{$jenistampilan}", "" )."\r\n\t\t\t".createinputhidden( "nilaikosong", "{$nilaikosong}", "" )."\r\n\t\t\t".createinputhidden( "sp", "{$sp}", "" )."\r\n\t\t\t".createinputhidden( "kopsurat", "{$kopsurat}", "" )."\r\n \t\t\t\t{$qinput}\r\n \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
        }
        $totalsemua = 0;
        $bobotsemua = 0;
        $totals = "";
        $bobots = "";
        $headerkhs = $bodykhs = $footerkhs = "";
        $count = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            $count++;
            if ( 1 < $count && $pdf == 1 )
            {
                $hasilkhs .= "<PAGEBREAK>";
            }
			#echo $count.'<br>';
            $q = "SELECT SMAWLMSMHS FROM msmhs WHERE NIMHSMSMHS='{$d['ID']}'";
            $hxx = mysqli_query($koneksi,$q);
            $semesterawal = 1;
            if ( 0 < sqlnumrows( $hxx ) )
            {
                $dxx = sqlfetcharray( $hxx );
                $semesterawal = substr( $dxx[SMAWLMSMHS], 4, 1 );
            }
            if ( $semesterawal == 1 )
            {
                $tambahansemester = 0;
            }
            else
            {
                $tambahansemester = 0 - 1;
            }
            $idfakultas = $d[IDFAKULTAS];
            $totalsemua = 0;
            $bobotsemua = 0;
            $totals = "";
            $bobots = "";
            $semesterhitung = $kurawal = $kurakhir = "";
            if ( $semester != 3 )
            {
                $semesterhitung = ( $tahun - 1 - $d[ANGKATAN] ) * 2 + $semester - get_jumlah_cuti_mahasiswa( $d[ID], $tahun - 1, $semester ) + $tambahansemester;
                $kurawal = "(";
                $kurakhir = ")";
            }
            $batasstudimhs = $batasstudi + get_jumlah_cuti_mahasiswa( $d[ID], $tahun - 1, $semester );
            if ( $aksi == "cetak" )
            {
                $tmpkop = "";
                if ( $UNIVERSITAS != "UNIVERSITAS BOROBUDUR" )
                {
                    if ( $kopsurat == 1 )
                    {
						#if($count==3){
						
							#echo "lll";
						#	include( "proseskoptambahanlampung.php" );
							
						#}else{
						
							include( "proseskop.php" );
						
						#}
				    }
                    else if ( $kopsurat == 2 )
                    {
                        include( "proseskopfakultas.php" );
                    }
                }
				
				if ($count==2){	
				
					$headerkhs .=$tmpcetakawal .= "<div style='page-break-after:always;margin:0px;padding:0px;'>";
				
				}else{
			
					$headerkhs .= $tmpcetakawal .= "<div style='page-break-after:always;margin:0px;padding:0px;'>\r\n         ".$tmpkop;
			
				}
                if ( $UNIVERSITAS == "STEI INDONESIA" )
                {
                    $headerkhs .= "<center>\r\n  \t\t\t<h3 align=center>Kartu Hasil Studi Semester ".$arraysemester[$semester]."</h3>\r\n  \t\t\t<div align=center>Tahun Akademik ".( $tahun - 1 )."/{$tahun} </div> <br><br>";
                }
                else if ( $UNIVERSITAS == "STIKES_UBUDIYAH" )
                {
                    $headerkhs .= "<center>\r\n  \t\t\t<h1 align=center style='font-size:20px;'>KARTU HASIL STUDI</h1>\r\n\t\t\t";
                }
                else if ( $UNIVERSITAS == "MITRA RIA HUSADA" )
                {
                    $headerkhs .= "<center>\r\n  \t\t\t<h2 align=center>KARTU HASIL STUDI (KHS) <br>\r\n TAHUN AKADEMIK ".( $tahun - 1 )."/{$tahun}</h2> ";
                }
                else if ( $UNIVERSITAS == "UNIVERSITAS BOROBUDUR" )
                {
                    $headerkhs .= "<br><center>\r\n        <table>\r\n        <td>\r\n  \t\t\t<b align=center style='font-size:26px; text-decoration:none;'>KARTU HASIL STUDI \r\n        </td>\r\n        </tr><tr>\r\n        <td>\r\n          <hr width=240 style='color:#000000;'>\r\n        </td>\r\n        </table>\r\n         ";
                }
                else if ( $JUDULKHS != "" && $UNIVERSITAS != "UMJ" && $UNIVERSITAS != "UNIKAL" && $UNIVERSITAS != "UNIVERSITAS 17 AGUSTUS 1945" )
                {
                    $headerkhs .= "<center>\r\n  \t\t\t<h1 align=center style='font-size:26px; text-decoration:none;'>KARTU HASIL STUDI </h1>";
                }
                else if ( $UNIVERSITAS == "UNIKAL" )
                {
                }
                else if ( $JUDULKHS != 0 )
                {
                    $headerkhs .= "<center> \r\n  \t\t\t<h3 align=center>{$JUDULKHS}</h3>";
                }
            }
            $idmahasiswa = $d[ID];
            $sem = $semester;
            $tahunlama = $tahun;
            if ( $HEADERKHS == "" )
            {
                $headerkhs .= " \r\n\t\t\t \r\n\t\t\t\t<center><br>\r\n\t\t\t<table   width=660 >\r\n\t\t\t\t<tr valign=top>\r\n\t\t\t\t<td width=60%  class='loseborder' valign=top >\r\n\t\t\t\t<table    >\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>Nama </td>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>: {$d['NAMA']}&nbsp;</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left class='loseborder' >\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>NIM</td>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>: {$d['ID']}&nbsp;</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top> Semester</td>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>: \r\n            \r\n          {$semesterhitung} {$kurawal} ".$arraysemester[$semester]." {$kurakhir}   \r\n            &nbsp;</td>\r\n\t\t\t\t\t</tr>\r\n \t\t\t\t</table>\r\n\t\t\t</td>\r\n\t\t\t<td  width=40% class='loseborder' valign=top>\r\n\r\n\t\t\t\t<table    >";
                if ( $POLTITEKNIK == 0 )
                {
                    $headerkhs .= "\r\n \t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>Fakultas</td>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>: ".$arrayfakultas[$d[IDFAKULTAS]]."&nbsp;</td>\r\n\t\t\t\t\t</tr>";
                }
                $headerkhs .= "\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>Jurusan</td>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>: ".$arraydepartemen[$d[IDDEPARTEMEN]]."&nbsp;</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left valign=top>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>Program Studi</td>\r\n\t\t\t\t\t\t<td class='loseborder' nowrap valign=top>: ".$arrayprodi[$d[IDPRODI]]." (".$arrayjenjang[$d[TINGKAT]].") &nbsp;</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t</table>\t\t\t\t\r\n\t\t\t\t\r\n\t\t\t</td>\r\n\t\t</table>\r\n\t\t\r\n\t \r\n\t\t\t";
            }
            else if ( $jenistampilan == "untag" )
            {
            }
            else
            {
                include( $HEADERKHS );
            }
            $angkatanmhs = $d[ANGKATAN];
            $idmahasiswa = $d[ID];
            #echo $HEADERKHS;
            if ( 0 < $semesterhitung )
            {
                if ( $jenistampilan == 1 )
                {
                    include( "proseskhs.php" );
                }
                else if ( $jenistampilan == 99 && $FILEKHS2 != "" )
                {
                    include( $FILEKHS2);
                    
                }
                else if ( $jenistampilan == "untag" )
                {
                    include( "proseskhsuntagblanko.php" );
                }
            }
            
            if ( $aksi != "cetak" )
            {
                echo "<hr>";
            }
            else if ( $pdf != 1 && 1 < $count )
            {
                echo $tmpcetakawal = " </div>";
            }
			#echo $footerkhs;
			if($count==1){
				$hasilkhs .= $headerkhs.$bodykhs.$footerkhs.'<br><br><br><br><br><br><br><br>';
			}else{
				$hasilkhs .= $headerkhs.$bodykhs.$footerkhs;
			}
            $headerkhs = $bodykhs = $footerkhs = "";
        }
        if ( $pdf == 1 )
        {
            cetakpdf( $hasilkhs, $stylekhs );
        }
        else
        {
            echo $stylekhs.$hasilkhs;
        }
    }
    else
    {
        $errmesg = "Data mahasiswa tidak ada";
        $aksi = "";
    }
//}
?>
