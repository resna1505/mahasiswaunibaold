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
if ( $aksi == "Cetak" )
{
    printhtmlcetak( );
    $cetak = $aksi = "cetak";
    $border = " border=1 width=600 ";
    include( "prosestampiluser.php" );
}
else
{
    printhtmlcetak( );
    $cetak = $aksi = "cetak";
    $border = " border=1 width=600 ";
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
        $jnama = ". Nama mengandung kata '{$namadicari2}'";
    }
    $usia1 = trim( $usia1 );
    $usia2 = trim( $usia2 );
    if ( $usia1 != "" && is_numeric( $usia1 ) && $usia2 != "" && is_numeric( $usia2 ) )
    {
        $qusia = " AND ((YEAR(NOW())-YEAR(TGLLAHIR)) +  \r\n  \tIF(MONTH(NOW())>MONTH(TGLLAHIR),0,IF(MONTH(NOW())<MONTH(TGLLAHIR),-1,IF(DAYOFMONTH(NOW())>=DAYOFMONTH(TGLLAHIR),0,-1))) >= {$usia1} \r\n  \tAND (YEAR(NOW())-YEAR(TGLLAHIR)) +  \r\n  \tIF(MONTH(NOW())>MONTH(TGLLAHIR),0,IF(MONTH(NOW())<MONTH(TGLLAHIR),-1,IF(DAYOFMONTH(NOW())>=DAYOFMONTH(TGLLAHIR),0,-1))) <= {$usia2}) ";
        $jusia = ". Usia antara {$usia1} s.d {$usia2}. ";
    }
    if ( $sort == "" )
    {
        $sort = "NAMA";
        $qsort = "ORDER BY {$sort}";
    }
    else if ( $sort == "usia" )
    {
        $qsort = "ORDER BY TO_DAYS(NOW())-TO_DAYS(TGLLAHIR)";
    }
    else
    {
        $qsort = "ORDER BY {$sort},NAMA";
    }
    if ( $jk != "semua" )
    {
        $qkelamin = " AND KELAMIN = '{$jk}'";
        $jkelamin = ". Jenis Kelamin: {$jk}";
    }
    if ( $agama != "semua" )
    {
        $qagama = " AND AGAMA = {$agama} ";
        $jagama = ". Agama: ".$arrayagama[$agama]."";
    }
    if ( $isthn == 1 )
    {
        $qtanggal = "\r\n\t\t\tAND \r\n\t\t\t(\r\n\t\t\t\tDATE_FORMAT(user.TGLLAHIR,'1901-%m-%d') >= DATE_FORMAT('1901-{$blnd}-{$tgld}','%Y-%m-%d') AND\r\n\t\t\t\tDATE_FORMAT(user.TGLLAHIR,'1901-%m-%d') <= DATE_FORMAT('1901-{$blns}-{$tgls}','%Y-%m-%d') \r\n\t\t\t)\r\n\t\t";
        $jtanggal = "<br> Tanggal Lahir dari '{$tgld}-{$blnd}' s.d '{$tgls}-{$blns}'";
    }
    else
    {
        $qtanggal = "\r\n\t\t\tAND \r\n\t\t\t(\r\n\t\t\t\tuser.TGLLAHIR >=DATE_FORMAT('{$thnd}-{$blnd}-{$tgld}','%Y-%m-%d') AND\r\n\t\t\t\tuser.TGLLAHIR <=DATE_FORMAT('{$thns}-{$blns}-{$tgls}','%Y-%m-%d') \r\n\t\t\t)\r\n\t\t";
        $jtanggal = "<br> Tanggal Lahir dari '{$tgld}-{$blnd}-{$thnd}' s.d '{$tgls}-{$blns}-{$thns}'";
    }
    if ( $bidang != "semua" )
    {
        $qbidang = " AND BIDANG = {$bidang} ";
        $jbidang = ". Departemen: ".$bidanguser[$bidang]."";
    }
    if ( $jabatan != "semua" )
    {
        $qjabatan = " AND JABATAN = {$jabatan} ";
        $jjabatan = ". Jabatan Struktural: ".$arrayjabatan[$jabatan]."";
    }
    if ( $divisi != "semua" )
    {
        $qdivisi = " AND DIVISI = {$divisi} ";
        $jdivisi = ". Divisi: ".$arraydivisi[$divisi]."";
    }
    if ( $pangkat != "semua" )
    {
        $qpangkat = " AND PANGKAT = {$pangkat} ";
        $jpangkat = ". Pangkat: ".$arraypangkat[$pangkat]."";
    }
    if ( $fungsional != "semua" )
    {
        $qfungsional = " AND FUNGSIONAL = {$fungsional} ";
        $jfungsional = ". Jabatan Fungsional: ".$arrayfungsional[$fungsional]."";
    }
    if ( $pendidikan != "semua" )
    {
        $qpendidikan = " AND PENDIDIKAN = '{$pendidikan}' ";
        $jpendidikan = ". Pendidikan Terakhir: ".$arraypendidikan[$pendidikan]."";
    }
    if ( $statusnikah != "semua" )
    {
        $qstatusnikah = " AND STATUSNIKAH = '{$statusnikah}' ";
        $jstatusnikah = ". Status Nikah: ".$arraystatusnikah[$statusnikah]."";
    }
    if ( $goldarah != "semua" )
    {
        $qgoldarah = " AND GOLDARAH = '{$goldarah}' ";
        $jgoldarah = ". Gol. Darah: ".$arraygoldarah[$goldarah]."";
    }
    if ( $lokasi != "semua" )
    {
        $qlokasi = " AND LOKASI = {$lokasi} ";
        $jlokasi = ". Lokasi Kerja: ".$arraylokasi[$lokasi]."";
    }
    if ( $statuspegawai != "semua" )
    {
        $qstatuspegawai = " AND STATUSPEGAWAI = {$statuspegawai} ";
        $jstatuspegawai = ". Status Operator: ".$arraystatuspegawai[$statuspegawai]."";
    }
    if ( $waktukerja != "semua" )
    {
        $qstatuskerja = " AND WAKTUKERJA = {$waktukerja} ";
        $jstatuskerja = ". Waktu Kerja: ".$arraywaktukerja[$waktukerja]."";
    }
    if ( $statuskerja != "semua" )
    {
        $qstatuskerja = " AND STATUSKERJA = {$statuskerja} ";
        $jstatuskerja = ". Status Kerja: ".$arraystatuskerja[$statuskerja]."";
    }
    $query = "SELECT user.*,\r\n  \t(YEAR(NOW())-YEAR(TGLLAHIR)) +  \r\n  \tIF(MONTH(NOW())>MONTH(TGLLAHIR),\r\n  \t\t0,\r\n  \t\tIF(MONTH(NOW())<MONTH(TGLLAHIR),\r\n  \t\t\t-1,\r\n  \t\t\tIF(DAYOFMONTH(NOW())>=DAYOFMONTH(TGLLAHIR),\r\n  \t\t\t\t0,\r\n  \t\t\t\t-1\r\n  \t\t\t)\r\n  \t\t)\r\n  \t) \r\n  \tAS USIA,\r\n\r\n  \tIF(MONTH(NOW())>MONTH(TGLLAHIR),\r\n  \t\tMONTH(NOW())-MONTH(TGLLAHIR),\r\n  \t\tIF(MONTH(NOW())<MONTH(TGLLAHIR),\r\n  \t\t\t12+MONTH(NOW())-MONTH(TGLLAHIR),\r\n  \t\t\tIF(DAYOFMONTH(NOW())<DAYOFMONTH(TGLLAHIR),\r\n\t  \t\t\t11,\r\n  \t\t\t\t0\r\n  \t\t\t)\r\n  \t\t)\r\n  \t) \r\n  \tAS BLNUSIA\r\n\t\tFROM user WHERE ID!='superadmin' \r\n\t\t{$qagama}\r\n\t\t{$qtanggal}\r\n\t\t{$qbidang} {$qlokasi} \r\n\t\t{$qlokasigaji}\r\n\t\t{$qstatuspegawai} \r\n\t\t{$qstatuspegawai2} \r\n\t\t{$qstatuskerja} \r\n\t\t{$qnama} {$qusia} {$qkelamin}\r\n\t\t{$qjabatan} \r\n\t\t{$qjabatan2} \r\n\t\t{$qgol} {$qsubgol}\r\n\t\t{$qpendidikan} \r\n\t\t{$qshift}\r\n\t\t{$qstatusl}\r\n\t\t{$qstatusnikah} \r\n\t\t{$qgoldarah} \r\n\t\t{$qdivisi} \r\n\t\t{$qpangkat} \r\n\t\t{$qfungsional} \r\n\t\t{$qid}\r\n\t\t{$qsort} ";
    $hasil =mysqli_query($koneksi,$query);
    if ( 0 < sqlnumrows( $hasil ) )
    {
        $judulmenu = "Rincian Data Operator";
        $judulmenu2 = $jid.$jnama.$jagama.$jtanggal.$jusia.$jkelamin.$jbidang.$jstatuspegawai.$jstatuspegawai2.$jstatuskerja.$jjabatan.$jjabatan2.$jgol.$jsubgol.$jpendidikan.$jstatusnikah.$jgoldarah.$jlokasi.$jlokasigaji.$jshift.$jdivisi.$jpangkat.$jfungsional.$jstatusl.$jstatuskerja;
        if ( $aksi == "cetak" )
        {
            printjudulmenucetak( $judulmenu );
            printmesgcetak( $judulmenu2 );
        }
        else
        {
            printjudulmenu( $judulmenu );
            printmesg( $judulmenu2 );
        }
        $i = 1;
        settype( $i, "integer" );
        echo "\r\n\t\t\t<table {$border} class=datacetak >\r\n\t\t\t\t<tr class=juduldatacetak  align=center valign=middle>\r\n\t\t\t\t\t<td rowspan=2>No</td>\r\n\t\t\t\t\t<td  rowspan=2>ID</td>\r\n\t\t\t\t\t<td rowspan=2>NIKS</td>\r\n\t \t\t\t\t<td rowspan=2>Nama</td>\r\n\t \t\t\t\t<td rowspan=2>Panggilan</td>\r\n\t \t\t\t\t<td colspan=20>Data Pribadi</td>\r\n\t \t\t\t\t<td colspan=10>Data Orang Tua</td>\r\n\t \t\t\t\t<td colspan=10>Data Keluarga</td>\r\n\t \t\t\t\t<td colspan=8>Data Pekerjaan</td>\r\n\t\t\t\t\t<td rowspan=2>Tingkat Akses</td>\r\n\t\t\t\t</tr>\r\n\t\t\t\t<tr class=juduldatacetak align=center valign=middle>\r\n\t \t\t\t\t<td  >TTL</td>\r\n\t \t\t\t\t<td  >Usia</td>\r\n\t \t\t\t\t<td  >JK</td>\r\n\t \t\t\t\t<td  >Agama</td>\r\n\t \t\t\t\t<td  >Alamat</td>\r\n\t \t\t\t\t<td  >Telepon</td>\r\n\t \t\t\t\t<td  >HP</td>\r\n\t \t\t\t\t<td  >KTP</td>\r\n\t \t\t\t\t<td  >SIM</td>\r\n\t \t\t\t\t<td  >Gol. Darah</td>\r\n\t \t\t\t\t<td  >Status Nikah</td>\r\n\t \t\t\t\t<td  >Jml Anak</td>\r\n\t \t\t\t\t<td  >Anak ke</td>\r\n\t \t\t\t\t<td  >Jml Saudara</td>\r\n\t \t\t\t\t<td  >Jarak Tempuh</td>\r\n\t\t\t\t\t<td  >Pendidikan Terakhir/TMT</td>\r\n\t\t\t\t\t<td  >Pekerjaan Terakhir/Lamanya</td>\r\n\t \t\t\t\t<td  >Alamat Terbaru</td>\r\n\t \t\t\t\t<td  >Telepon  Terbaru</td>\r\n\t \t\t\t\t<td  >HP Terbaru</td>\r\n\r\n\t \t\t\t\t<td  >Nama Ibu</td>\r\n\t \t\t\t\t<td  >TTL</td>\r\n\t \t\t\t\t<td  >Pendidikan</td>\r\n\t \t\t\t\t<td  >Pekerjaan</td>\r\n\t \t\t\t\t<td  >Alamat</td>\r\n\t \t\t\t\t<td  >Telepon</td>\r\n\t \t\t\t\t<td  >Nama Ayah</td>\r\n\t \t\t\t\t<td  >TTL</td>\r\n\t \t\t\t\t<td  >Pendidikan</td>\r\n\t \t\t\t\t<td  >Pekerjaan</td>\r\n\t\t\t\t\t\r\n\t \t\t\t\t<td  >Nama Istri/Suami</td>\r\n\t \t\t\t\t<td  >TTL</td>\r\n\t \t\t\t\t<td  >Pendidikan</td>\r\n\t \t\t\t\t<td  >Pekerjaan</td>\r\n\t \t\t\t\t<td  >Gol. Darah</td>\r\n\t \t\t\t\t<td  >Telepon</td>\r\n\t \t\t\t\t<td  >HP</td>\r\n\t \t\t\t\t<td  >Nama Anak Pertama</td>\r\n\t \t\t\t\t<td  >TTL</td>\r\n\t \t\t\t\t<td  >JK</td>\r\n\t\t\t\t\t\t\t\t\t\r\n\t \t\t\t\t<td  >Divisi</td>\r\n\t \t\t\t\t<td  >Departemen</td>\r\n\t \t\t\t\t<td  >Pangkat</td>\r\n\t\t\t\t\t<td  >Jabatan Struktural/TMT</td>\r\n\t\t\t\t\t<td  >Jabatan Fungsional/TMT</td>\r\n\t\t\t\t\t<td  >Status<br>Operator</td>\r\n\t\t\t\t\t<td  >Waktu<br>Kerja</td>\r\n\t\t\t\t\t<td  >Status<br>Kerja</td>\r\n\t\t\t\t\t";
        echo "\r\n\t\t\t\t</tr>\r\n\t\t\t\t";
        while ( $data = sqlfetcharray( $hasil ) )
        {
            if ( $data[KELAMIN] == "L" )
            {
                $jenis = "L";
            }
            else
            {
                $jenis = "P";
            }
            if ( $i % 2 == 0 )
            {
                $kelas = "class=datagenapcetak";
            }
            else
            {
                $kelas = "class=dataganjilcetak";
            }
            $tmp = explode( "-", $data[TGLLAHIR] );
            $tgl = $tmp[2];
            $bln = $tmp[1];
            $thn = $tmp[0];
            $tmp = explode( "-", $data[TMTJ] );
            $tglj = $tmp[2];
            $blnj = $tmp[1];
            $thnj = $tmp[0];
            $tmp = explode( "-", $data[TMTF] );
            $tglf = $tmp[2];
            $blnf = $tmp[1];
            $thnf = $tmp[0];
            $tmp = explode( "-", $data[TMTP] );
            $tglp = $tmp[2];
            $blnp = $tmp[1];
            $thnp = $tmp[0];
            $tmp = explode( "-", $data[TANGGALIBU] );
            $tglibu = $tmp[2];
            $blnibu = $tmp[1];
            $thnibu = $tmp[0];
            $tmp = explode( "-", $data[TANGGALAYAH] );
            $tglayah = $tmp[2];
            $blnayah = $tmp[1];
            $thnayah = $tmp[0];
            $tmp = explode( "-", $data[TANGGALPAS] );
            $tglpas = $tmp[2];
            $blnpas = $tmp[1];
            $thnpas = $tmp[0];
            $tmp = explode( "-", $data[TANGGALANAK] );
            $tglanak = $tmp[2];
            $blnanak = $tmp[1];
            $thnanak = $tmp[0];
            echo "\r\n\t\t\t\t\t<tr {$kelas} valign=top>\r\n\t\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\t\t\t\t\t<td align=center>".printid( $data[ID] )."</td>\r\n\t\t\t\t\t\t<td nowrap  >{$data['NIP']}</td>\r\n\t\t\t\t\t\t<td >{$data['NAMA']}</td>\r\n\t\t\t\t\t\t<td >{$data['PANGGILAN']}</td>\r\n\t\t\t\t\t\t<td >{$data['TEMPATLAHIR']}, {$tgl}-{$bln}-{$thn}</td>\r\n\t\t\t\t\t\t<td >{$data['USIA']} thn {$data['BLNUSIA']} bln</td>\r\n\t\t\t\t\t\t<td >{$data['KELAMIN']}</td>\r\n\t\t\t\t\t\t<td >".$arrayagama[$data[AGAMA]]."</td>\r\n\t\t\t\t\t\t<td >{$data['ALAMAT']}</td>\r\n\t\t\t\t\t\t<td >{$data['TELPON']}</td>\r\n\t\t\t\t\t\t<td >{$data['HP']}</td>\r\n\t\t\t\t\t\t<td >{$data['KTP']}</td>\r\n\t\t\t\t\t\t<td >{$data['SIM']}</td>\r\n\t\t\t\t\t\t<td >".$arraygoldarah[$data[GOLDARAH]]."</td>\r\n\t\t\t\t\t\t<td >".$arraystatusnikah[$data[STATUSNIKAH]]."</td>\r\n\t\t\t\t\t\t<td >{$data['JMLANAK']}</td>\r\n\t\t\t\t\t\t<td >{$data['ANAKKE']}</td>\r\n\t\t\t\t\t\t<td >{$data['JMLSAUDARA']}</td>\r\n\t\t\t\t\t\t<td >{$data['JARAK']} km</td>\r\n\t\t\t\t\t\t<td >".$arraypendidikan[$data[PENDIDIKAN]]." /  {$tglp}-{$blnp}-{$thnp} \r\n\t\t\t\t\t\t{$data['KETPENDIDIKAN']}</td>\r\n\t\t\t\t\t\t<td >{$data['PEKERJAAN']} / {$data['LAMA']} tahun</td>\r\n\t\t\t\t\t\t<td >{$data['ALAMATBARU']}</td>\r\n\t\t\t\t\t\t<td >{$data['TELPONBARU']}</td>\r\n\t\t\t\t\t\t<td >{$data['HPBARU']}</td>\r\n\r\n\t\t\t\t\t\t<td >{$data['NAMAIBU']}</td>\r\n\t\t\t\t\t\t<td >{$data['TEMPATIBU']}, {$tglibu}-{$blnibu}-{$thnibu}</td>\r\n\t\t\t\t\t\t<td >".$arraypendidikan[$data[PENDIDIKANIBU]]."</td>\r\n\t\t\t\t\t\t<td >{$data['PEKERJAANIBU']}</td>\r\n\t\t\t\t\t\t<td >{$data['ALAMATIBU']}</td>\r\n\t\t\t\t\t\t<td >{$data['TELEPONIBU']}</td>\r\n\t\t\t\t\t\t<td >{$data['NAMAAYAH']}</td>\r\n\t\t\t\t\t\t<td >{$data['TEMPATAYAH']}, {$tglayah}-{$blnayah}-{$thnayah}</td>\r\n\t\t\t\t\t\t<td >".$arraypendidikan[$data[PENDIDIKANAYAH]]."</td>\r\n\t\t\t\t\t\t<td >{$data['PEKERJAANAYAH']}</td>";
            $pendidikanpas = $arraypendidikan[$data[PENDIDIKANPAS]];
            $goldarahpas = $arraygoldarah[$data[GOLDARAHPAS]];
            if ( trim( $data[NAMAPAS] ) == "" )
            {
                $data[TEMPATPAS] = $tglpas = $blnpas = $thnpas = $data[PEKERJAANPAS] = $pendidikanpas = $goldarahpas = "";
            }
            if ( trim( $data[NAMAANAK] ) == "" )
            {
                $data[TEMPATANAK] = $tglanak = $blnanak = $thnanak = $data[KELAMINANAK] = "";
            }
            echo "\r\n\r\n\t\t\t\t\t\t<td >{$data['NAMAPAS']}</td>\r\n\t\t\t\t\t\t<td >{$data['TEMPATPAS']}, {$tglpas}-{$blnpas}-{$thnpas}</td>\r\n\t\t\t\t\t\t<td >".$pendidikanpas."</td>\r\n\t\t\t\t\t\t<td >{$data['PEKERJAANPAS']}</td>\r\n\t\t\t\t\t\t<td >".$goldarahpas."</td>\r\n\t\t\t\t\t\t<td >{$data['TELPONPAS']}</td>\r\n\t\t\t\t\t\t<td >{$data['HPBARUPAS']}</td>\r\n\t\t\t\t\t\t<td >{$data['NAMAANAK']}</td>\r\n\t\t\t\t\t\t<td >{$data['TEMPATANAK']}, {$tglanak}-{$blnanak}-{$thnanak}</td>\r\n\t\t\t\t\t\t<td >{$data['KELAMINANAK']}</td>\r\n\r\n\r\n\t\t\t\t\t\t<td >".$arraydivisi[$data[DIVISI]]."</td>\r\n\t\t\t\t\t\t<td >".$bidanguser[$data[BIDANG]]."</td>\r\n\t\t\t\t\t\t<td >".$arraypangkat[$data[PANGKAT]]."</td>\r\n\t\t\t\t\t\t<td >".$arrayjabatan[$data[JABATAN]]." /  {$tglj}-{$blnj}-{$thnj}</td>\r\n\t\t\t\t\t\t<td >".$arrayfungsional[$data[FUNGSIONAL]]." /  {$tglf}-{$blnf}-{$thnf}</td>\r\n\t\t\t\t\t\t<td align=center>".$arraystatuspegawai[$data[STATUSPEGAWAI]]."</td>\r\n\t\t\t\t\t\t<td  align=center>".$arraywaktukerja[$data[WAKTUKERJA]]."</td>\r\n\t\t\t\t\t\t<td >".$arraystatuskerja[$data[STATUSKERJA]]."</td>\r\n\t\t\t\t\t\t";
            unset( $tingkatakses );
            $tingkatakses = explode( ",", $data[TINGKAT] );
            unset( $tmp );
            foreach ( $tingkatakses as $k => $v )
            {
                $tmp2 = explode( ":", $v );
                $tmp["{$tmp2['0']}"] = $tmp2[1];
            }
            $tingkatakses = $tmp;
            $tingkatakses2 = "";
            foreach ( $tingkatakses as $k => $v )
            {
                $tingkatakses2 .= $tingkatuser[$k]." (".$v.")<br>";
            }
            echo "\r\n\t\t\t\t\t\t<td >".$tingkatakses2."</td>";
            echo "</tr>";
            ++$i;
        }
        echo "</table>\r\n\t\t";
    }
    else
    {
        $errmesg = "Data Operator tidak ada";
        $aksi = "";
    }
}
?>
