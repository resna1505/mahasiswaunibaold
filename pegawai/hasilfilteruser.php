<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$id = trim( $id );
if ( $id != "" )
{
    $qid = " AND ID = '{$id}'";
    $id = htmlspecialchars( $id );
    $jid = " ID Operator = '{$id}' ";
}
$namadicari2 = trim( $namadicari );
if ( $namadicari2 != "" )
{
    $qnama = " AND NAMA LIKE '%{$namadicari2}%'";
    $namadicari2 = htmlspecialchars( $namadicari2 );
    $jnama = " Nama mengandung kata '{$namadicari2}'";
}
$queryfilteruser = "\r\n\t\t\t{$qagama}\r\n\t\t{$qtanggal}\r\n\t\t{$qbidang} {$qlokasi} \r\n\t\t{$qlokasigaji}\r\n\t\t{$qstatuspegawai} \r\n\t\t{$qstatuspegawai2} \r\n\t\t{$qstatuskerja} \r\n\t\t{$qnama} {$qusia} {$qkelamin}\r\n\t\t{$qjabatan} \r\n\t\t{$qjabatan2} \r\n\t\t{$qgol} {$qsubgol}\r\n\t\t{$qpendidikan} \r\n\t\t{$qshift}\r\n\t\t{$qstatusl}\r\n\t\t{$qstatusnikah} \r\n\t\t{$qgoldarah} \r\n\t\t{$qdivisi} \r\n\t\t{$qpangkat} \r\n\t\t{$qfungsional} \r\n\t\t{$qid}\t\r\n\t";
$judulfilteruser = $jid.$jnama.$jagama.$jtanggal.$jusia.$jkelamin.$jbidang.$jstatuspegawai.$jstatuspegawai2.$jstatuskerja.$jjabatan.$jjabatan2.$jgol.$jsubgol.$jpendidikan.$jstatusnikah.$jgoldarah.$jlokasi.$jlokasigaji.$jshift.$jstatusl.$jdivisi.$jpangkat.$jfungsional.$jstatuskerja;
$hreffilteruser = "agama={$agama}&\r\n\t\ttgld={$tgld}&blnd={$blnd}&thnd={$thnd}&\r\n\t\ttgls={$tgls}&blns={$blns}&thns={$thns}&\r\n\t\tisthn={$isthn}&\t\t\r\n\t\tpendidikan={$pendidikan}&bidang={$bidang}&jk={$jk}&\r\n\t\tstatuspegawai={$statuspegawai}&statuspegawai2={$statuspegawai2}&\r\n\t\twaktukerja={$waktukerja}&lokasi={$lokasi}&lokasigaji={$lokasigaji}&\r\n\t\tnamadicari={$namadicari2}&usia1={$usia1}&usia2={$usia2}&jabatan={$jabatan}&\r\n\t\tjabatan2={$jabatan2}&gol={$gol}&subgol={$subgol}&shift={$shift}&\r\n\t\tstatuslogin={$statuslogin}&statusnikah={$statusnikah}&\r\n\t\tgoldarah={$goldarah}&\r\n\t\tdivisi={$divisi}&pangkat={$pangkat}&fungsional={$fungsional}&id={$id}&\r\n\t\tstatuskerja={$statuskerja}&";
$inputfilteruser = "\r\n\t\t<input type=hidden name=namadicari value='{$namadicari}'>\r\n\t\t<input type=hidden name=usia1 value='{$usia1}'>\r\n\t\t<input type=hidden name=usia2 value='{$usia2}'>\r\n\t\t<input type=hidden name=agama value='{$agama}'>\r\n\t\t<input type=hidden name='tgld' value='{$tgld}'>\r\n\t\t<input type=hidden name='blnd' value='{$blnd}'>\r\n\t\t<input type=hidden name='thnd' value='{$thnd}'>\r\n\t\t<input type=hidden name='tgls' value='{$tgls}'>\r\n\t\t<input type=hidden name='blns' value='{$blns}'>\r\n\t\t<input type=hidden name='thns' value='{$thns}'>\r\n\t\t<input type=hidden name='isthn' value='{$isthn}'>\r\n\t\t<input type=hidden name=jk value='{$jk}'>\r\n\t\t<input type=hidden name=pendidikan value='{$pendidikan}'>\r\n\t\t<input type=hidden name=statusnikah value='{$statusnikah}'>\r\n\t\t<input type=hidden name=goldarah value='{$goldarah}'>\r\n\t\t<input type=hidden name=bidang value='{$bidang}'>\r\n\t\t<input type=hidden name=lokasi value='{$lokasi}'>\r\n\t\t<input type=hidden name=jabatan value='{$jabatan}'>\r\n\t\t<input type=hidden name=statuspegawai value='{$statuspegawai}'>\r\n\t\t<input type=hidden name=statuskerja value='{$statuskerja}'>\r\n\t\t<input type=hidden name=waktukerja value='{$waktukerja}'>\r\n\t\t<input type=hidden name=divisi value='{$divisi}'>\r\n\t\t<input type=hidden name=pangkat value='{$pangkat}'>\r\n\t\t<input type=hidden name=fungsional value='{$fungsional}'>\r\n\t\t<input type=hidden name=id value='{$id}'>\r\n\t\r\n\t";
?>
