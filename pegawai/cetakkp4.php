<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$root = "../";
include( $root."sesiuser.php" );
include( $root."header.php" );
include( $root."style.inc" );
@cekuser( "" );
$konfiglap = file( "../gaji/konfiglaporan" );
foreach ( $konfiglap as $k => $v )
{
    $tmp = explode( "::", $v );
    $klap[$tmp[0]] = trim( $tmp[1] );
}
$q = "SELECT NIP,NAMA FROM user WHERE JABATAN=0";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
    $namakepala = $d[NAMA];
    $nipkepala = $d[NIP];
}
$qsort = "ORDER BY GOLONGAN,SUBGOLONGAN,TMTG";
if ( trim( $iduser ) != "" )
{
    $qiduser = "AND ID='{$iduser}'";
}
else
{
    $namadicari2 = trim( $namadicari );
    if ( $namadicari2 !== "" )
    {
        $qnama = " AND NAMA LIKE '%{$namadicari2}%'";
        $namadicari2 = htmlspecialchars( $namadicari2 );
        $jnama = ". Nama mengandung kata '{$namadicari2}'";
    }
    if ( $bidang != "semua" )
    {
        $qbidang = " AND BIDANG = {$bidang} ";
        $jbidang = ". Bidang: ".$bidanguser[$bidang]."";
    }
    if ( $jabatan != "semua" )
    {
        $qjabatan = " AND JABATAN = {$jabatan} ";
        $jjabatan = ". Jabatan Struktural: ".$arrayjabatan[$jabatan]."";
    }
    if ( $jabatan2 != "semua" )
    {
        $qjabatan2 = " AND JABATANS = {$jabatan2} ";
        $jjabatan2 = ". Jabatan Fungsional: ".$arrayjabatans[$jabatan2]."";
    }
    if ( $lokasi != "semua" )
    {
        $qlokasi = " AND LOKASI = {$lokasi} ";
        $jlokasi = ". Lokasi Kerja: ".$arraylokasi[$lokasi]."";
    }
    if ( $lokasigaji != "semua" )
    {
        $qlokasigaji = " AND LOKASIGAJI = {$lokasigaji} ";
        $jlokasigaji = ". Lokasi Gaji: ".$arraylokasi[$lokasigaji]."";
    }
    if ( $gol != "semua" )
    {
        $qgol = " AND GOLONGAN = {$gol} ";
        $jgol = ". Golongan: ".$arraygolongan[$gol]."";
    }
    if ( $subgol != "semua" )
    {
        $qsubgol = " AND SUBGOLONGAN = '{$subgol}' ";
        $jsubgol = ". Ruang: ".$arraysubgolongan[$subgol]."";
    }
    if ( $statuspegawai != "semua" )
    {
        $qstatuspegawai = " AND STATUSPEGAWAI = {$statuspegawai} ";
        $jstatuspegawai = ". Status Operator: ".$arraystatuspegawai[$statuspegawai]."";
    }
    if ( $statuspegawai2 != "semua" )
    {
        $qstatuspegawai2 = " AND STATUSPEGAWAI2 = {$statuspegawai2} ";
        $jstatuspegawai2 = ". Status PNS: ".$arraystatuspegawai2[$statuspegawai2]."";
    }
    if ( $statuskerja != "semua" )
    {
        $qstatuskerja = " AND STATUSKERJA = {$statuskerja} ";
        $jstatuskerja = ". Status Kerja: ".$arraystatuskerja[$statuskerja]."";
    }
}
$query = "SELECT ID,GAJI, NAMA,NIP,IF(KELAMIN='L','Laki-laki','Perempuan') AS JENIS,TEMPATLAHIR,\r\n    \tDATE_FORMAT(TGLLAHIR,'%d-%m-%Y') AS TGL,\r\n    \tAGAMA,STATUSPEGAWAI,JABATANS,JABATAN,GOLCPNS,GOLONGAN,SUBGOLONGAN,ALAMAT,\r\n  \t(YEAR(NOW())-YEAR(TMTCPNS)) +  \r\n  \tIF(MONTH(NOW())>MONTH(TMTCPNS),\r\n  \t\t0,\r\n  \t\tIF(MONTH(NOW())<MONTH(TMTCPNS),\r\n  \t\t\t-1,\r\n  \t\t\tIF(DAYOFMONTH(NOW())>=DAYOFMONTH(TMTCPNS),\r\n  \t\t\t\t0,\r\n  \t\t\t\t-1\r\n  \t\t\t)\r\n  \t\t)\r\n  \t) \r\n  \tAS TMKCPNS,\r\n\r\n  \tIF(MONTH(NOW())>MONTH(TMTCPNS),\r\n  \t\tMONTH(NOW())-MONTH(TMTCPNS),\r\n  \t\tIF(MONTH(NOW())<MONTH(TMTCPNS),\r\n  \t\t\t12+MONTH(NOW())-MONTH(TMTCPNS),\r\n  \t\t\tIF(DAYOFMONTH(NOW())<DAYOFMONTH(TMTCPNS),\r\n\t  \t\t\t11,\r\n  \t\t\t\t0\r\n  \t\t\t)\r\n  \t\t)\r\n  \t) \r\n  \tAS BMKCPNS,\r\n\r\n  \t(YEAR(NOW())-YEAR(TMTPNS)) +  \r\n  \tIF(MONTH(NOW())>MONTH(TMTPNS),\r\n  \t\t0,\r\n  \t\tIF(MONTH(NOW())<MONTH(TMTPNS),\r\n  \t\t\t-1,\r\n  \t\t\tIF(DAYOFMONTH(NOW())>=DAYOFMONTH(TMTPNS),\r\n  \t\t\t\t0,\r\n  \t\t\t\t-1\r\n  \t\t\t)\r\n  \t\t)\r\n  \t) \r\n  \tAS TMKPNS,\r\n\r\n  \tIF(MONTH(NOW())>MONTH(TMTPNS),\r\n  \t\tMONTH(NOW())-MONTH(TMTPNS),\r\n  \t\tIF(MONTH(NOW())<MONTH(TMTPNS),\r\n  \t\t\t12+MONTH(NOW())-MONTH(TMTPNS),\r\n  \t\t\tIF(DAYOFMONTH(NOW())<DAYOFMONTH(TMTPNS),\r\n\t  \t\t\t11,\r\n  \t\t\t\t0\r\n  \t\t\t)\r\n  \t\t)\r\n  \t) \r\n  \tAS BMKPNS,MBULAN,MTAHUN\r\n    \t\r\n\t\tFROM user,gaji WHERE \r\n\t\tuser.ID!='superadmin' \r\n\t\tAND user.ID=gaji.IDUSER\r\n\t\t\r\n\t\t{$qiduser}\r\n\t\t{$qjabatan} {$qjabatan2} {$qgol} {$qsubgol} {$qbidang} {$qlokasi} \r\n\t\t{$qlokasigaji}\r\n\t\t{$qstatuspegawai} \r\n\t\t{$qstatuspegawai2} \r\n\t\t{$qstatuskerja} \r\n\t\t{$qshift} {$qstatusl}\r\n\t\t{$qnama} \r\n\t\t{$qsort} ";
$hasil =mysqli_query($koneksi,$query);
if ( 0 < sqlnumrows( $hasil ) )
{
    echo "<html>\r\n\t\t<head>\r\n\t\t\t<style>\t\r\n\t\t\t\t{$style}\r\n\t\t\t</style>\r\n\t\t</head>\r\n\t\t<body>\r\n\t";
    $i = 1;
    settype( $i, "integer" );
    $width = 150;
    while ( $data = sqlfetcharray( $hasil ) )
    {
        if ( $i % 2 == 0 )
        {
            $kelas = "class=datagenap";
        }
        else
        {
            $kelas = "class=dataganjil";
        }
        if ( $data[MBULAN] != "" )
        {
            $data += BMKCPNS;
            if ( 12 < $data[BMKPNS] )
            {
                $data[BMKCPNS] = $data[BMKCPNS] - 12;
                $data += TMKCPNS;
            }
        }
        if ( $data[MTAHUN] != "" )
        {
            $data += TMKCPNS;
        }
        $masakerja = "";
        if ( $data[TMKCPNS] != "" )
        {
            $masakerja = "{$data['TMKCPNS']} thn {$data['BMKCPNS']} bln";
        }
        $dk = @file( @"kp4/{$data['ID']}" );
        if ( is_array( $dk ) )
        {
            foreach ( $dk as $v )
            {
                $t = explode( "=", $v );
                $datak[$t[0]] = $t[1];
            }
        }
        if ( $arraygolongan[$data[GOLCPNS]] == "I" && $arraygolongan[$data[GOLONGAN]] == "II" )
        {
            $data[MTAHUN] = 6;
            $data[MBULAN] = 0;
        }
        else if ( $arraygolongan[$data[GOLCPNS]] == "I" && ( $arraygolongan[$data[GOLONGAN]] == "III" || $arraygolongan[$data[GOLONGAN]] == "IV" ) )
        {
            $data[MTAHUN] = 11;
            $data[MBULAN] = 0;
        }
        else if ( $arraygolongan[$data[GOLCPNS]] == "II" && ( $arraygolongan[$data[GOLONGAN]] == "III" || $arraygolongan[$data[GOLONGAN]] == "IV" ) )
        {
            $data[MTAHUN] = 5;
            $data[MBULAN] = 0;
        }
        else
        {
            $data[MTAHUN] = 0;
            $data[MBULAN] = 0;
        }
        $masakerjatambahan = "{$data['MTAHUN']} thn {$data['MBULAN']} bln";
        $masakerjagolongan = $data[TMKCPNS] - $data[MTAHUN]." tahun {$data['BMKCPNS']} bulan";
        echo "<CENTER>\r\n\t\t\t<p class=page>\r\n\t\t\t\t<table width=600 style='font-family:Arial;font-size:9pt;color:#000000;'>\r\n\t\t\t\t<tr>\r\n\t\t\t\t<td >\r\n\t\t\t\t\t<center>\r\n\t\t\t\t\t <font style='font-size:9pt;'><b>SURAT KETERANGAN</font><br>\r\n\t\t\t\t\t<font style='font-size:10pt;'><U><b>UNTUK MENDAPATKAN PEMBAYARAN TUNJANGAN KELUARGA</U></font> \r\n\t\t\t\t\t</center>\r\n\t\t\t\t\t<BR><BR>\r\n\t\t\t\t\t &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Saya yang bertanda tangan di bawah ini:\r\n\t\t\t\t\t<br><br>\r\n\t\t\t\t\t<table cellpadding=1 width=100% style='font-family:Arial;font-size:9pt;color:#000000;text-decoration:bold;'>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td align=right width=20> 1.</td>\r\n\t\t\t\t\t\t\t<td width={$width}> Nama Lengkap</td>\r\n\t\t\t\t\t\t\t<td width=5> :</td>\r\n\t\t\t\t\t\t\t<td> {$data['NAMA']}\r\n\t\t\t\t\t\t\t&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n\t\t\t\t\t\t\t&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n\t\t\t\t\t\t\t&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n\t\t\t\t\t\t\tNIP: {$data['NIP']}</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td align=right width=20> 2.</td>\r\n\t\t\t\t\t\t\t<td width={$width}> Tempat/Tanggal Lahir</td>\r\n\t\t\t\t\t\t\t<td width=5> :</td>\r\n\t\t\t\t\t\t\t<td> {$data['TEMPATLAHIR']} / {$data['TGL']}</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td align=right width=20> 3.</td>\r\n\t\t\t\t\t\t\t<td width={$width}> Jenis Kelamin</td>\r\n\t\t\t\t\t\t\t<td width=5> :</td>\r\n\t\t\t\t\t\t\t<td> {$data['JENIS']}</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td align=right width=20> 4.</td>\r\n\t\t\t\t\t\t\t<td width={$width}> Agama</td>\r\n\t\t\t\t\t\t\t<td width=5> :</td>\r\n\t\t\t\t\t\t\t<td> ".$arrayagama[$data[AGAMA]]."</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td align=right width=20> 5.</td>\r\n\t\t\t\t\t\t\t<td width={$width}> Status Kepegawaian</td>\r\n\t\t\t\t\t\t\t<td width=5> :</td>\r\n\t\t\t\t\t\t\t<td> ".$arraystatuspegawai[$data[STATUSPEGAWAI]]."</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td align=right width=20> 6.</td>\r\n\t\t\t\t\t\t\t<td width={$width}> Jabatan Struktural<BR>Jabatan Fungsional</td>\r\n\t\t\t\t\t\t\t<td width=5> :<BR>:</td>\r\n\t\t\t\t\t\t\t<td>";
        if ( trim( $arrayjabatan[$data[JABATAN]] ) == "Tidak Ada" )
        {
            $namajabatan = "-";
        }
        else
        {
            $namajabatan = $arrayjabatan[$data[JABATAN]];
        }
        if ( trim( $arrayjabatans[$data[JABATANS]] ) == "Tidak Ada" )
        {
            $namajabatans = "-";
        }
        else
        {
            $namajabatans = $arrayjabatans[$data[JABATANS]];
        }
        echo "\r\n\t\t\t\t\t\t\t\t ".$namajabatan."<BR>\r\n\t\t\t\t\t\t\t\t ".$namajabatans."</td>\r\n\t\t\t\t\t\t\t\t \r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td align=right width=20> 7.</td>\r\n\t\t\t\t\t\t\t<td width={$width}> Pangkat/Golongan</td>\r\n\t\t\t\t\t\t\t<td width=5> :</td>\r\n\t\t\t\t\t\t\t<td>\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t ".$arraypangkat[$arraygolongan[$data[GOLONGAN]]][$arraysubgolongan[$data[SUBGOLONGAN]]]." - \r\n\t\t\t\t\t\t\t\t ".$arraygolongan[$data[GOLONGAN]]."/".$arraysubgolongan[$data[SUBGOLONGAN]]."</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td align=right width=20> 8.</td>\r\n\t\t\t\t\t\t\t<td width={$width}> Pada Instansi/Departemen</td>\r\n\t\t\t\t\t\t\t<td width=5> :</td>\r\n\t\t\t\t\t\t\t<td> {$namakantor}</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td align=right width=20> 9.</td>\r\n\t\t\t\t\t\t\t<td width={$width}> Masa Kerja Golongan</td>\r\n\t\t\t\t\t\t\t<td width=5> :</td>\r\n\t\t\t\t\t\t\t<td> Masa kerja golongan {$masakerjagolongan}, masa kerja tambahan {$masakerjatambahan}, masa kerja seluruhnya =  {$masakerja}</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td align=right width=20> 10.</td>\r\n\t\t\t\t\t\t\t<td width={$width}> Digaji Menurut</td>\r\n\t\t\t\t\t\t\t<td width=5> :</td>\r\n\t\t\t\t\t\t\t<td> {$klap['pp']},  Gaji Pokok Rp. ".cetakuang( $data[GAJI] )."</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td align=right width=20> 11.</td>\r\n\t\t\t\t\t\t\t<td width={$width}> Alamat/Tempat Tinggal</td>\r\n\t\t\t\t\t\t\t<td width=5> :</td>\r\n\t\t\t\t\t\t\t<td> {$data['ALAMAT']}</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td align=right width=20></td>\r\n\t\t\t\t\t\t\t<td colspan=3><BR> Menerangkan dengan sesungguhnya bahwa saya :</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td align=right width=20> a.</td>\r\n\t\t\t\t\t\t\t<td colspan=3> Disamping jabatan utama tersebut, bekerja pula sebagai:\r\n\t\t\t\t\t\t\t<br>\r\n\t\t\t\t\t\t\tdengan mendapatkan penghasilan sebesar \r\n\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n\t\t\t\t\t\t\tRp. ".cetakuang( $datak[plain] )." sebulan\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td align=right width=20> b.</td>\r\n\t\t\t\t\t\t\t<td colspan=3> Mempunyai Pensiun/Pensiun Janda  \r\n\t\t\t\t\t\t\t&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n\t\t\t\t\t\t\t&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n\t\t\t\t\t\t\tRp. ".cetakuang( $datak[ppensiun] )." sebulan\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td align=right width=20> c.</td>\r\n\t\t\t\t\t\t\t<td colspan=3> Mempunyai susunan keluarga sebagai berikut:\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t<BR><BR>\r\n\r\n\t\t\t\t\t<table width=100% style='font-size:9pt;' {$tabelisiankecilcetak}\t>\r\n\t\t\t\t\t\t<tr valign=middle>\r\n\t\t\t\t\t\t\t<td align=center rowspan=2> No.</td>\r\n\t\t\t\t\t\t\t<td align=center rowspan=2> NAMA<BR>ISTRI/SUAMI/ANAK<BR>TANGGUNGAN</td>\r\n\t\t\t\t\t\t\t<td align=center colspan=2> TANGGAL</td>\r\n\t\t\t\t\t\t\t<td align=center rowspan=2> PEKERJAAN/<BR>SEKOLAH</td>\r\n\t\t\t\t\t\t\t<td align=center rowspan=2> KETERANGAN<BR>CATATAN</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr valign=middle >\r\n\t\t\t\t\t\t\t<td align=center> KELAHIRAN</td>\r\n\t\t\t\t\t\t\t<td align=center> PERKAWINAN</td>\r\n\t\t\t\t\t\t</tr>\r\n\r\n\t\t\t\t";
        $q = "SELECT NAMA,KET,PEKERJAAN,\r\n\t\t\t\tDATE_FORMAT(TGLLAHIR,'%d-%m-%Y') AS TGL,\r\n\t\t\t\tIF(KET<2,DATE_FORMAT(TGLKAWIN,'%d-%m-%Y'),'') AS TGLP\r\n\t\t\t\tFROM tanggunganp\r\n\t\t\t\tWHERE IDUSER='{$data['ID']}'\r\n\t\t\t\tORDER BY TGLLAHIR\r\n\t\t\t\t";
        $ht = mysqli_query($koneksi,$q);
        $jmlanak = 0;
        if ( 0 < sqlnumrows( $ht ) )
        {
            $j = 1;
            $jmlanak = 0;
            while ( $datat = sqlfetcharray( $ht ) )
            {
                echo "\r\n\t\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t\t<td align=center> {$j}</td>\r\n\t\t\t\t\t\t\t\t<td> {$datat['NAMA']}</td>\r\n\t\t\t\t\t\t\t\t<td align=center> {$datat['TGL']}</td>\r\n\t\t\t\t\t\t\t\t<td align=center> {$datat['TGLP']}</td>\r\n\t\t\t\t\t\t\t\t<td align=center> {$datat['PEKERJAAN']}</td>\r\n\t\t\t\t\t\t\t\t<td align=center> ".$arraystatustanggungan[$datat[KET]]."</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
                if ( 1 < $datat[KET] )
                {
                    ++$jmlanak;
                }
                ++$j;
            }
        }
        echo "\r\n\t\t\t\t\t\t\t<tr valign=top height=150>\r\n\t\t\t\t\t\t\t\t<td> </td>\r\n\t\t\t\t\t\t\t\t<td> </td>\r\n\t\t\t\t\t\t\t\t<td> </td>\r\n\t\t\t\t\t\t\t\t<td> </td>\r\n\t\t\t\t\t\t\t\t<td> </td>\r\n\t\t\t\t\t\t\t\t<td> </td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
        echo "\r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t<BR><BR>\r\n\t\t\t\t\t<table cellpadding=1 width=100% style='font-family:Arial;font-size:9pt;color:#000000;text-decoration:bold;'>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td align=right width=20> d.</td>\r\n\t\t\t\t\t\t\t<td width={$width}> Jumlah anak seluruhnya\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td width=5> :</td>\r\n\t\t\t\t\t\t\t<td> {$jmlanak} ( ".angkatoteks( $jmlanak )." ) \r\n\t\t\t\t\t\t\t(yang menjadi tanggungan termasuk yang tidak masuk dalam daftar gaji)\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t</table>\r\n\r\n\t\t\t\t\t<table cellpadding=1 width=100% style='font-family:Arial;font-size:9pt;color:#000000;text-decoration:bold;'>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td align=right width=20></td>\r\n\t\t\t\t\t\t\t<td > \r\n\t\t\t\t\t\t\tKeterangan ini saya buat dengan sesungguhnya dan apabila keterangan ini ternyata\r\n\t\t\t\t\t\t\ttidak benar (palsu), saya bersedia dituntut di muka pengadilan berdasarkan Undang\r\n\t\t\t\t\t\t\t- undang yang berlaku, dan bersedia mengembalikan semua penghasilan yang \r\n\t\t\t\t\t\t\ttelah saya terima yang seharusnya bukan menjadi hak saya.\r\n\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t<BR><BR>\r\n\t\t\t\t\t<table cellpadding=1 width=100% style='font-family:Arial;font-size:9pt;color:#000000;text-decoration:bold;'>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td align=right width=20> </td>\r\n\t\t\t\t\t\t\t<td width=60%> \r\n\t\t\t\t\t\t\tMengetahui:<BR>\r\n\t\t\t\t\t\t\tKepala {$namakantor}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td > \r\n\t\t\t\t\t\t\t{$arraylokasi[$idlokasikantor]},  \r\n\t\t\t\t\t\t\t{$w['mday']} ".$arraybulan[$w[mon]]." {$w['year']}<br>\r\n\t\t\t\t\t\t\tYang menerangkan\r\n\t\t\t\t\t\t\t<BR><BR><BR><BR>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td align=right width=20> </td>\r\n\t\t\t\t\t\t\t<td > \r\n\t\t\t\t\t\t\t<u>{$namakepala}</u><br>\r\n\t\t\t\t\t\t\tNIP: {$nipkepala}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td > \r\n\t\t\t\t\t\t\t<u>{$data['NAMA']}</u><br>\r\n\t\t\t\t\t\t\tNIP: {$data['NIP']}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t</table>\r\n\t\t\t\t\r\n\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t\t</table>\r\n\t\t\t</p>\r\n\t\t\t";
        ++$i;
    }
    echo "\t\r\n\t</body></html>\r\n";
}
else
{
    printmesg( "Data Operator untuk pencetakan KP4 tidak ada" );
    $aksi = "";
}
?>
