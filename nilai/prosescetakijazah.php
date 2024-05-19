<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$q = "SELECT * FROM setingijazah";
$h = mysqli_query($koneksi,$q);
$d2 = sqlfetcharray( $h );
if ( $idprodi != "" )
{
    $qfield .= " AND IDPRODI='{$idprodi}'";
    $qjudul .= " Jurusan/Program Studi '".$arrayprodidep[$idprodi]."' <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
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
    $qjudul .= " NIM = '{$id}' <br>";
    $qinput .= " <input type=hidden name=id value='{$id}'>";
    $href .= "id={$id}&";
}
if ( $status != "" )
{
    $qfield .= " AND STATUS='{$status}'";
    $qjudul .= " Status Mahasiswa '".$arraystatusmahasiswa["{$status}"]."' <br>";
    $qinput .= " <input type=hidden name=status value='{$status}'>";
    $href .= "status={$status}&";
}
$q = "SELECT mahasiswa.*,\r\n prodi.NAMA as NAMAP ,\r\n  prodi.NAMA2 as NAMAP2 , \r\n prodi.GELAR,prodi.GELAR2,prodi.TINGKAT,prodi.ID AS IDX,prodi.NIPPIMPINAN,prodi.NAMAPIMPINAN,prodi.NAMAPUKET1AKADEMIK,\r\n prodi.NIPPUKET1AKADEMIK,\r\n mspst.NOMBAMSPST ,\r\n fakultas.NAMA as NAMAF,fakultas.ID as IDFAKULTAS, \r\n fakultas.NAMA2 as NAMAF2, \r\n fakultas.NAMAPIMPINAN as DEKAN, \r\n fakultas.NIPPIMPINAN as NIPDEKAN ,\r\n prodi.NAMAJENJANG2,\r\n\tCOUNT(diskonbeasiswa.IDMAHASISWA) AS JUMLAHBEASISWA\r\n FROM mahasiswa LEFT JOIN diskonbeasiswa ON mahasiswa.ID=diskonbeasiswa.IDMAHASISWA \r\n  \r\n  ,prodi,mspst,departemen LEFT JOIN fakultas ON  \r\ndepartemen.IDFAKULTAS=fakultas.ID\r\nWHERE 1=1  \r\nAND\r\nmahasiswa.IDPRODI=prodi.ID\r\nAND\r\ndepartemen.ID=prodi.IDDEPARTEMEN\r\n\r\nAND\r\nmspst.IDX=prodi.ID\r\n{$qfield}\r\n\r\nGROUP BY mahasiswa.ID\r\n\r\nORDER BY mahasiswa.ID\r\nLIMIT 0,{$dataperhalaman}";
#echo $q.'<br>';
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $count = 0;
    getpenandatangan( );
    while ( $d = sqlfetcharray( $h ) )
    {
	$idmhsyudisium=$d['ID'];
	$lunas=getstatusminimalpembayaranyudisiummahasiswa($idmhsyudisium);
	#print_r($lunas);
        ++$count;
        if ( 1 < $count && $pdf == 1 )
        {
            $bodyijazah .= "<PAGEBREAK>";
        }
        if ( getaturan( "APPROVEBEASISWA" ) == 1 && 0 < $d[JUMLAHBEASISWA] && $d[APPROVEBEASISWA] == 0 )
        {
            $bodyijazah .= "\r\n            <div style='page-break-after:always;text-align:center;'>\r\n            Mahasiswa ini ({$d['ID']}/{$d['NAMA']}) mendapatkan beasiswa dan belum diaprrove oleh supervisor, silahkan menghubungi supervisor\r\n            </div>\r\n          ";
        }else if ( $lunas[LUNAS] < 0 )
	{
		 $errmesg = "Mahasiswa ini belum melunasi kewajiban. Silakan hubungi bagian keuangan.<br>{$lunas['STATUS']}";
	    	 $bodyijazah .= "<div style='page-break-after:always;text-align:center;color:red;'>".$errmesg."</div>";

	}
        else
        {
            $tmp = explode( "-", $d[TANGGALKELUAR] );
            $tgllulus = $tmp[2];
            $blnlulus = $tmp[1];
            $thnlulus = $tmp[0];
            $tmp = explode( "-", $d[TANGGAL] );
            $q = "SELECT NOIJATRLSM,TGLRETRLSM,NOTRANSKRIP,NOBLANKO,NILAIUAPTULIS,NILAIUAPPRAKTEK,SIMBOLUAPTULIS,SIMBOLUAPPRAKTEK,PEMINATAN\r\n            FROM trlsm WHERE NIMHSTRLSM='{$d['ID']}' AND STMHSTRLSM ='L' ORDER BY  THSMSTRLSM DESC";
            $hl = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $hl ) )
            {
                $dl = sqlfetcharray( $hl );
                $noseriijazah = $dl[NOIJATRLSM];
                $noblanko = $dl[NOBLANKO];
                $NO_SERIIJAZAH = $dl[NOIJATRLSM];
                $NO_SERITRANSKRIP = $dl[NOTRANSKRIP];
                $NO_BLANKO = $dl[NOBLANKO];
                $NILAIUAPTULIS = $dl[NILAIUAPTULIS];
                $NILAIUAPPRAKTEK = $dl[NILAIUAPPRAKTEK];
                $SIMBOLUAPTULIS = $dl[SIMBOLUAPTULIS];
                $SIMBOLUAPPRAKTEK = $dl[SIMBOLUAPPRAKTEK];
                $PEMINATAN = $dl[PEMINATAN];
                $tmp = explode( "-", $dl[TGLRETRLSM] );
                $tglyudisium = "{$tmp['2']}-{$tmp['1']}-{$tmp['0']}";
                $tglyudisium2 = "{$tmp['2']} ".$arraybulan[$tmp[1] - 1]." {$tmp['0']}";
            }
            $tmp = explode( "-", $d[TANGGAL] );
		#echo $FILEIJAZAH.'<br>';
		#echo $d['IDX'].'<br>';
            #include($FILEIJAZAH);
			if($d['IDX']==1021){
				include("ijazahuniversitasbatamprofesi.php");
			}else{
				include($FILEIJAZAH);
			}	

        }
    }
	#echo $FILEIJAZAH;
    $hasilijazah = $bodyijazah;
    if ( $pdf == 1 )
    {
        cetakpdf( $hasilijazah, $styleijazah );
    }
    else
    {
        if ( $UNIVERSITAS == "UNIVERSITAS 17 AGUSTUS 1945" )
        {
        }
        else
        {
            printhtmlcetak();
        }
        echo $styleijazah.$hasilijazah;
    }
}
else
{
    echo "Data Mahasiswa tidak ada";
}
?>
