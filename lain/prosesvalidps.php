<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

printjudulmenukecil( "<b>Validasi Data Program Studi (MSPST)" );
$q = "SELECT * FROM mspst \r\n   WHERE KDPSTMSPST ='{$kodeps}'\r\n   AND KDJENMSPST='{$kodejenjang}'\r\n   ";
$h = mysqli_query($koneksi,$q);
$jmlrec = sqlnumrows( $h );
$norec = $namabh = 1;
$norecw = $namabhw = $warnatidakvalid;
$pt = $ps = $tglawal = $nama = $sks = $sks2 = $tglizin = $ban1 = $ban2 = 0;
$ptw = $psw = $tglawalw = $namaw = $sksw = $sks2w = $tglizinw = $ban1w = $ban2w = "";
if ( 0 < $jmlrec )
{
    $norec = 0;
    $norecw = "";
    $d = sqlfetcharray( $h );
    if ( $d[KDPTIMSPST] != $kodept )
    {
        $pt = 1;
        $ptw = $warnatidakvalid;
    }
    $q = "SELECT NMPSTTBPST  FROM tbpst WHERE KDPSTTBPST='{$kodeps}'";
    $h2 = mysqli_query($koneksi,$q);
    if ( sqlnumrows( $h2 ) <= 0 )
    {
        $ps = 1;
        $psw = $warnatidakvalid;
    }
    $tmp = explode( "-", $d[TGAWLMSPST] );
    if ( $tmp[0] == "0000" || $tmp[1] == "00" || $tmp[2] == "00" )
    {
        $tglawal = 1;
        $tglawalw = $warnatidakvalid;
    }
    if ( trim( $d[NMPSTMSPST] ) == "" )
    {
        $nama = 1;
        $namaw = $warnatidakvalid;
    }
    if ( $d[SKSTTMSPST] <= 0 )
    {
        $sks = 1;
        $sksw = $warnatidakvalid;
    }
    $tmp = explode( "-", $d[TGLSKMSPST] );
    if ( $tmp[0] == "0000" || $tmp[1] == "00" || $tmp[2] == "00" )
    {
        $tglizin = 1;
        $tglizinw = $warnatidakvalid;
    }
    if ( trim( $d[NOMSKMSPST] ) == "" )
    {
        $sk = 1;
        $skw = $warnatidakvalid;
    }
    if ( trim( $d[NOMBAMSPST] ) != "" && ( $d[TGLBAMSPST] == "" || $d[KDSTAMSPST] == "" ) )
    {
        $ban1 = 1;
        $ban1w = $warnatidakvalid;
    }
    if ( trim( $d[NOMBAMSPST] ) == "" && ( $d[TGLBAMSPST] != "" || $d[KDSTAMSPST] != "" ) )
    {
        $ban2 = 1;
        $ban2w = $warnatidakvalid;
    }
}
echo "\r\n  <table width=95% class=form>\r\n    <tr class=juduldata align=center>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n      <td width=40%>URAIAN</td>\r\n      <td>VALIDITAS</td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td {$norecw} >Tidak ada record pada tabel</td>\r\n      <td align=center {$norecw}>{$norec} </td>\r\n      <td  {$jmlrecw}>Jumlah Record pada tabel</td>\r\n      <td  align=center {$jmlrecw}>{$jmlrec} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$ptw}>Kode Perguruan Tinggi # MSPTI</td>\r\n      <td  align=center {$pt}>{$pt} </td>\r\n      <td  {$tglawalw}>Tanggal Awal Berdiri PS kosong</td>\r\n      <td  align=center {$tglawalw}>{$tglawal} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$psw}>Kode Program Studi # TBPST</td>\r\n      <td  align=center {$psw}>{$ps} </td>\r\n      <td  {$namaw}>Nama Program Studi kosong</td>\r\n      <td  align=center {$namaw}>{$nama} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$sksw}>Jumlah SKS Lulus Kosong</td>\r\n      <td  align=center {$sksw}>{$sks} </td>\r\n      <td  >Jumlah SKS Lulus # Jenjang Studi</td>\r\n      <td  align=center>0 </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$tglizinw}>Tanggal Izin Operasional kosong</td>\r\n      <td align=center {$tglizinw}>{$tglizin} </td>\r\n      <td  {$skw}>No. SK Izin Operasional Kosong</td>\r\n      <td align=center {$skw}>{$sk} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  >Tanggal Izin Operasional tidak wajar</td>\r\n      <td align=center>0 </td>\r\n      <td  {$ban1w}>No. SK BAN ada, Tgl dan Status Kosong</td>\r\n      <td align=center {$ban1w}>{$ban1} </td>\r\n    </tr>\r\n    <tr class=datagenap   >\r\n      <td  {$ban2w}>No. SK BAN kosong, Tgl dan Status Ada</td>\r\n      <td align=center {$ban2w}>{$ban2} </td>\r\n      <td  >Kode Akreditasi # TBKOD Jenjang</td>\r\n      <td align=center>0 </td>\r\n    </tr>\r\n\r\n  </table>\r\n  ";
$q = "SELECT NIDNNTBDOS FROM tbdos WHERE NIDNNTBDOS='{$d['NOKPSMSPST']}'";
$hl = mysqli_query($koneksi,$q);
if ( sqlnumrows( $hl ) <= 0 )
{
    echo "<br><b style='color:#FF0000;'>-  NIDN Ketua Program Studi ({$d['NOKPSMSPST']}) tidak terdaftar di TBDOS NIDN</b>";
}
if ( trim( $d[TELPOMSPST] ) == "" )
{
    echo "<br><b style='color:#FF0000;'>-  Telepon Program Studi tidak boleh kosong</b>";
}
$q = "SELECT COUNT(*) AS JML FROM trkap WHERE THSMSTRKAP='{$tahun2}{$semester2}' AND\r\n    KDPSTTRKAP ='{$kodeps}'\r\n   AND KDJENTRKAP='{$kodejenjang}'\r\n    ";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
if ( $d[JML] <= 0 )
{
    echo "<br><b style='color:#FF0000;'>-  Kegiatan kuliah belum diisi. Harus diisi!!</b>";
}
echo " \r\n \r\n";
?>
