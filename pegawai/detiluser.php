<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$query = "SELECT NAMA,ALAMAT,TELPON,TINGKAT,PASSWORD, AGAMA,NIP,\r\n\t\t\tDAYOFMONTH(TGLLAHIR) AS TGL, MONTH(TGLLAHIR) AS BLN, YEAR(TGLLAHIR) AS THN, \r\n\t\t\tDAYOFMONTH(TMTJ) AS TGLJ, MONTH(TMTJ) AS BLNJ, YEAR(TMTJ) AS THNJ, \r\n\t\t\tDAYOFMONTH(TMTP) AS TGLP, MONTH(TMTP) AS BLNP, YEAR(TMTP) AS THNP, \r\n\t\t\tBIDANG, LOKASI,\r\n\t\t\tSTATUSPEGAWAI,JABATAN,\r\n\t\t\tSTATUSNIKAH,\r\n\t\t\tPENDIDIKAN,KETPENDIDIKAN,\r\n\t\t\tDATE_FORMAT(LASTUPDATE,'%d-%m-%Y %H:%i:%s') AS LASTUP, \r\n\t\t\tKELAMIN ,TEMPATLAHIR,\r\n\t\t\tSHIFT,STATUSLOGIN,\r\n\t\t\tPANGGILAN,HP,KTP,SIM,GOLDARAH,ANAKKE,JMLSAUDARA,\r\n\t\t\tJARAK,\r\n\t\t\tNAMAIBU,TEMPATIBU,\r\n\t\t\tDAYOFMONTH(TANGGALIBU) AS TGLIBU, MONTH(TANGGALIBU) AS BLNIBU, YEAR(TANGGALIBU) AS THNIBU, \r\n\t\t\tPENDIDIKANIBU,\r\n\t\t\tPEKERJAANIBU,ALAMATIBU,TELEPONIBU,\r\n\t\t\tNAMAAYAH,TEMPATAYAH,\r\n\t\t\tDAYOFMONTH(TANGGALAYAH) AS TGLAYAH, MONTH(TANGGALAYAH) AS BLNAYAH, YEAR(TANGGALAYAH) AS THNAYAH, \r\n\t\t\tPENDIDIKANAYAH,PEKERJAANAYAH,\r\n\t\t\tNAMAPAS,TEMPATPAS,\r\n\t\t\tDAYOFMONTH(TANGGALPAS) AS TGLPAS, MONTH(TANGGALPAS) AS BLNPAS, YEAR(TANGGALPAS) AS THNPAS, \r\n\t\t\tPENDIDIKANPAS,PEKERJAANPAS,GOLDARAHPAS,\r\n\t\t\tNAMAANAK,TEMPATANAK,\r\n\t\t\tDAYOFMONTH(TANGGALANAK) AS TGLANAK, MONTH(TANGGALANAK) AS BLNANAK, YEAR(TANGGALANAK) AS THNANAK, \r\n\t\t\tKELAMINANAK,\r\n\t\t\tWAKTUKERJA,\r\n\t\t\tDAYOFMONTH(TANGGALM) AS TGLM, MONTH(TANGGALM) AS BLNM, YEAR(TANGGALM) AS THNM,\r\n\t\t\tDAYOFMONTH(TANGGALBK) AS TGLBK, MONTH(TANGGALBK) AS BLNBK, YEAR(TANGGALBK) AS THNBK,\r\n\t\t\tPEKERJAAN,LAMA,JMLANAK,ALAMATBARU,TELEPONBARU,HPBARU,TELEPONPAS,HPPAS,\r\n\t\t\tDIVISI,PANGKAT,FUNGSIONAL,TANGGALF,STATUSKERJA\r\n\r\n\t\t\tFROM user WHERE ID='{$iduser}' AND ID!='superadmin'";
$hasil =mysqli_query($koneksi,$query);
if ( sqlnumrows( $hasil ) < 1 )
{
    $ok = false;
    if ( $iduser == "superadmin" )
    {
        $errmesg = "Data 'superadmin' tidak ada";
    }
    else
    {
        $errmesg = "Tidak ada user dengan ID='{$iduser}'";
    }
}
else
{
    $datauser = sqlfetcharray( $hasil );
    $nama = $datauser[NAMA];
    $nip = $datauser[NIP];
    $alamatuser = $datauser[ALAMAT];
    $telepon = $datauser[TELPON];
    $tgl = $datauser[TGL];
    $bln = $datauser[BLN];
    $thn = $datauser[THN];
    $tglj = $datauser[TGLJ];
    $blnj = $datauser[BLNJ];
    $thnj = $datauser[THNJ];
    $kelamin = $datauser[KELAMIN];
    $pwduser = $datauser[PASSWORD];
    $bidang = $datauser[BIDANG];
    $lokasi = $datauser[LOKASI];
    $statuspegawai = $datauser[STATUSPEGAWAI];
    $jabatan = $datauser[JABATAN];
    $statusnikah = $datauser[STATUSNIKAH];
    $pendidikan = $datauser[PENDIDIKAN];
    $ketpendidikan = $datauser[KETPENDIDIKAN];
    $tglp = $datauser[TGLP];
    $blnp = $datauser[BLNP];
    $thnp = $datauser[THNP];
    $shift = $datauser[SHIFT];
    $statuslogin = $datauser[STATUSLOGIN];
    $tempat = $datauser[TEMPATLAHIR];
    $agama = $datauser[AGAMA];
    $panggilan = $datauser[PANGGILAN];
    $hp = $datauser[HP];
    $ktp = $datauser[KTP];
    $sim = $datauser[SIM];
    $goldarah = $datauser[GOLDARAH];
    $anakke = $datauser[ANAKKE];
    $jmlsaudara = $datauser[JMLSAUDARA];
    $jarak = $datauser[JARAK];
    $namaibu = $datauser[NAMAIBU];
    $tempatibu = $datauser[TEMPATIBU];
    $tglibu = $datauser[TGLIBU];
    $blnibu = $datauser[BLNIBU];
    $thnibu = $datauser[THNIBU];
    $pendidikanibu = $datauser[PENDIDIKANIBU];
    $pekerjaanibu = $datauser[PEKERJAANIBU];
    $alamatibu = $datauser[ALAMATIBU];
    $teleponibu = $datauser[TELEPONIBU];
    $namaayah = $datauser[NAMAAYAH];
    $tempatayah = $datauser[TEMPATAYAH];
    $tglayah = $datauser[TGLAYAH];
    $blnayah = $datauser[BLNAYAH];
    $thnayah = $datauser[THNAYAH];
    $pendidikanayah = $datauser[PENDIDIKANAYAH];
    $pekerjaanayah = $datauser[PEKERJAANAYAH];
    $namapas = $datauser[NAMAPAS];
    $tempatpas = $datauser[TEMPATPAS];
    $tglpas = $datauser[TGLPAS];
    $blnpas = $datauser[BLNPAS];
    $thnpas = $datauser[THNPAS];
    $pendidikanpas = $datauser[PENDIDIKANPAS];
    $pekerjaanpas = $datauser[PEKERJAANPAS];
    $goldarahpas = $datauser[GOLDARAHPAS];
    $namaanak = $datauser[NAMAANAK];
    $tempatanak = $datauser[TEMPATANAK];
    $tglanak = $datauser[TGLANAK];
    $blnanak = $datauser[BLNANAK];
    $thnanak = $datauser[THNANAK];
    $kelaminanak = $datauser[KELAMINANAK];
    $waktukerja = $datauser[WAKTUKERJA];
    $tglm = $datauser[TGLM];
    $blnm = $datauser[BLNM];
    $thnm = $datauser[THNM];
    $tglbk = $datauser[TGLBK];
    $blnbk = $datauser[BLNBK];
    $thnbk = $datauser[THNBK];
    $pekerjaan = $datauser[PEKERJAAN];
    $lama = $datauser[LAMA];
    $jmlanak = $datauser[JMLANAK];
    $alamatuserbaru = $datauser[ALAMATBARU];
    $teleponbaru = $datauser[TELEPONBARU];
    $hpbaru = $datauser[HPBARU];
    $teleponpas = $datauser[TELEPONPAS];
    $hppas = $datauser[HPPAS];
    $divisi = $datauser[DIVISI];
    $pangkat = $datauser[PANGKAT];
    $fungsional = $datauser[FUNGSIONAL];
    $tanggalf = $datauser[TANGGALF];
    $tmp = explode( "-", $tanggalf );
    $tglf = $tmp[2];
    $blnf = $tmp[1];
    $thnf = $tmp[0];
    $statuskerja = $datauser[STATUSKERJA];
}
$judulmenu = "Rincian Data Operator";
$judulmenu2 = $errmesg;
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
echo "<br>\r\n\r\n<table ";
echo $border2;
echo "  class=data";
echo $cetak;
echo " >\r\n\t<tr >\r\n\t\t<td  class=judulform";
echo $cetak;
echo " >User ID </td>\r\n\t\t<td>:</td>\r\n\t\t<td>\r\n\t\t";
echo $iduser;
echo "</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  colspan=3>\r\n\t\t<hr size=1><b>Data Pribadi<hr size=1>\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >NIP</td>\r\n\t\t<td>:</td>\r\n\t\t<td>\r\n\t\t";
echo $nip;
echo "\t</tr>\r\n\t<tr>\r\n\t\t<td  >Nama Lengkap</td>\r\n\t\t<td>:</td>\r\n\t\t<td>";
echo $nama;
echo "</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Panggilan</td>\r\n\t\t<td>:</td>\r\n\t\t<td>";
echo $panggilan;
echo "</td>\r\n\t</tr>\r\n\r\n\t<tr>\r\n\t\t<td  >Tempat / Tgl Lahir</td>\r\n\t\t<td>:</td>\r\n\t\t<td>\r\n\t\t";
echo $tempat;
echo " / ";
echo " {$tgl} ".$arraybulan[$bln - 1]." {$thn}";
echo "\t</tr>\r\n\r\n\r\n\t<tr>\r\n\t\t<td  >Jenis kelamin</td>\r\n\t\t<td>:</td>\r\n\t\t<td>";
echo $kelamin;
echo "</td>\r\n\t</tr>\r\n\r\n\t<tr>\r\n\t\t<td  >Agama</td>\r\n\t\t<td>:</td>\r\n\t\t<td>\r\n\t\t\t";
echo $arrayagama[$agama];
echo "\t\t\t</td>\r\n\t</tr>\r\n\r\n\t<tr>\r\n\t\t<td  >Alamat</td>\r\n\t\t<td>:</td>\r\n\t\t<td>";
echo $alamatuser;
echo "</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Telepon Tempat Tinggal</td>\r\n\t\t<td>:</td>\r\n\t\t<td>";
echo $telepon;
echo "</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >No. HP</td>\r\n\t\t<td>:</td>\r\n\t\t<td>";
echo $hp;
echo "</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >No. KTP</td>\r\n\t\t<td>:</td>\r\n\t\t<td>";
echo $ktp;
echo "</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >No. SIM</td>\r\n\t\t<td>:</td>\r\n\t\t<td>";
echo $sim;
echo "</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Gol. Darah</td>\r\n\t\t<td>:</td>\r\n\t\t<td>\r\n\t\t\t";
echo $arraygoldarah[$goldarah];
echo "\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Status Pernikahan</td>\r\n\t\t<td>:</td>\r\n\t\t<td>\r\n\t\t\t";
echo $arraystatusnikah[$statusnikah];
echo "\t\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td>Jumlah Anak</td>\r\n\t\t<td>:</td>\r\n\t\t<td> ";
echo $jmlanak;
echo " \r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td>Anak Ke</td>\r\n\t\t<td>:</td>\r\n\t\t<td> ";
echo $anakke;
echo " Dari ";
echo $jmlsaudara;
echo " Bersaudara\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td>Jarak Tempuh dr Tempat Tinggal</td>\r\n\t\t<td>:</td>\r\n\t\t<td>\r\n\t\t\t";
echo $jarak;
echo " km\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Pendidikan Terakhir / TMT</td>\r\n\t\t<td>:</td>\r\n\t\t<td>\r\n\t\t\t";
echo $arraypendidikan[$pendidikan];
echo "\t\t\t / \r\n\t\t\t";
echo "{$tglp} ".$arraybulan[$blnp - 1]." {$thnp}";
echo "\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Keterangan Pendidikan</td>\r\n\t\t<td>:</td>\r\n\t\t<td>";
echo $ketpendidikan;
echo "</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Pekerjaan Terakhir</td>\r\n\t\t<td>:</td>\r\n\t\t<td>";
echo $pekerjaan;
echo "</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Lama Bekerja</td>\r\n\t\t<td>:</td>\r\n\t\t<td>";
echo $lama;
echo " tahun</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Alamat Tinggal Terbaru</td>\r\n\t\t<td>:</td>\r\n\t\t<td>";
echo $alamatuserbaru;
echo "</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Telepon Terbaru</td>\r\n\t\t<td>:</td>\r\n\t\t<td>";
echo $teleponbaru;
echo "</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >No. HP Terbaru</td>\r\n\t\t<td>:</td>\r\n\t\t<td>";
echo $hpbaru;
echo "</td>\r\n\t</tr>\r\n\t</table>\r\n";
$query = "SELECT * FROM pendidikan WHERE IDUSER='{$iduser}' ORDER BY TAHUN ";
$hasil =mysqli_query($koneksi,$query);
if ( 0 < sqlnumrows( $hasil ) )
{
    if ( $aksi != "cetak" )
    {
        printjudulmenukecil( "Daftar  Riwayat Pendidikan" );
    }
    else
    {
        printjudulmenukecilcetak( "Daftar  Riwayat Pendidikan" );
    }
    echo "\r\n\t\t\t\t\t<table {$border} class=data{$cetak}>\r\n \t\t\t\t\t\t<tr align=center class=juduldata{$cetak}>\r\n\t\t\t\t\t\t\t<td width=10>\r\n\t\t\t\t\t\t\t\tNo\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tTahun\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tSekolah/Universitas\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tFakultas/Jurusan\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tStrata\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tKota\r\n\t\t\t\t\t\t\t</td>\r\n \t\t\t\t\t\t</tr>\r\n\t\t\t\t";
    $i = 0;
    settype( $i, "integer" );
    while ( $datauser = sqlfetcharray( $hasil ) )
    {
        if ( $i % 2 == 0 )
        {
            $kelas = "class=datagenap{$cetak}";
        }
        else
        {
            $kelas = "class=dataganjil{$cetak}";
        }
        $sekolah = $datauser[SEKOLAH];
        $pendidikan = $datauser[ID];
        $tahun = $datauser[TAHUN];
        $jurusan = $datauser[JURUSAN];
        $strata = $datauser[STRATA];
        $kota = $datauser[KOTA];
        ++$i;
        echo "\r\n\t\t\t\t\t\t<tr valign=top {$kelas}>\r\n\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t{$i}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t{$tahun}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td  >\r\n\t\t\t\t\t\t\t\t{$sekolah}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td  >\r\n\t\t\t\t\t\t\t\t{$jurusan}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t{$strata}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td  >\r\n\t\t\t\t\t\t\t\t{$kota}\r\n\t\t\t\t\t\t\t</td>\r\n \t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
    }
    echo "\r\n\t\t\t\t\t</table>\r\n \r\n\t\t\t\t";
}
$query = "SELECT * FROM pekerjaan WHERE IDUSER='{$iduser}' ORDER BY TAHUN ";
$hasil =mysqli_query($koneksi,$query);
if ( 0 < sqlnumrows( $hasil ) )
{
    if ( $aksi != "cetak" )
    {
        printjudulmenukecil( "Daftar  Pengalaman Kerja" );
    }
    else
    {
        printjudulmenukecilcetak( "Daftar  Pengalaman Kerja" );
    }
    echo "\r\n\t\t\t\t\t<table {$border} class=data{$cetak}>\r\n \t\t\t\t\t\t<tr align=center class=juduldata{$cetak}>\r\n\t\t\t\t\t\t\t<td width=10>\r\n\t\t\t\t\t\t\t\tNo\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tTahun\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tJabatan\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tLembaga\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tKota\r\n\t\t\t\t\t\t\t</td>\r\n \t\t\t\t\t\t</tr>\r\n\t\t\t\t";
    $i = 0;
    settype( $i, "integer" );
    while ( $datauser = sqlfetcharray( $hasil ) )
    {
        if ( $i % 2 == 0 )
        {
            $kelas = "class=datagenap{$cetak}";
        }
        else
        {
            $kelas = "class=dataganjil{$cetak}";
        }
        $jabatan = $datauser[JABATAN];
        $pekerjaan = $datauser[ID];
        $tahun = $datauser[TAHUN];
        $lembaga = $datauser[LEMBAGA];
        $kota = $datauser[KOTA];
        ++$i;
        echo "\r\n\t\t\t\t\t\t<tr valign=top {$kelas}>\r\n\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t{$i}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t{$tahun}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td  >\r\n\t\t\t\t\t\t\t\t{$jabatan}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td  >\r\n\t\t\t\t\t\t\t\t{$lembaga}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td  >\r\n\t\t\t\t\t\t\t\t{$kota}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
    }
    echo "\r\n\t\t\t\t\t</table>\r\n \t\t\t\t";
}
echo "\t<table ";
echo $border2;
echo " class=data";
echo $cetak;
echo ">\r\n\t<tr>\r\n\t\t<td  colspan=3><hr size=1>\r\n\t\t<b>Data Orang Tua<hr size=1></td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td   class=judulform";
echo $cetak;
echo ">Nama Ibu</td>\r\n\t\t<td>:</td>\r\n\t\t<td>";
echo $namaibu;
echo "</td>\r\n\t</tr>\r\n\r\n\t<tr>\r\n\t\t<td  >Tempat / Tgl Lahir</td>\r\n\t\t<td>:</td>\r\n\t\t<td>\r\n\t\t";
echo $tempatibu;
echo " /\r\n\t\t\t";
echo "{$tglibu} ".$arraybulan[$blnibu - 1]." {$thnibu}";
echo "\t</tr>\r\n\t<tr>\r\n\t\t<td  >Pendidikan Terakhir</td>\r\n\t\t<td>:</td>\r\n\t\t<td>\r\n\t\t\t";
echo $arraypendidikan[$pendidikanibu];
echo "\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td>Pekerjaan</td>\r\n\t\t<td>:</td>\r\n\t\t<td>";
echo $pekerjaanibu;
echo "</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Alamat</td>\r\n\t\t<td>:</td>\r\n\t\t<td>";
echo $alamatibu;
echo "</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Telepon </td>\r\n\t\t<td>:</td>\r\n\t\t<td>";
echo $teleponibu;
echo "</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Nama Ayah</td>\r\n\t\t<td>:</td>\r\n\t\t<td>";
echo $namaayah;
echo "</td>\r\n\t</tr>\r\n\r\n\t<tr>\r\n\t\t<td  >Tempat / Tgl Lahir</td>\r\n\t\t<td>:</td>\r\n\t\t<td>\r\n\t\t";
echo $tempatayah;
echo " /\r\n\t\t\t";
echo "{$tglayah} ".$arraybulan[$blnayah - 1]." {$thnayah}";
echo "\t</tr>\r\n\t<tr>\r\n\t\t<td>Pendidikan</td>\r\n\t\t<td>:</td>\r\n\t\t<td>\r\n\t\t\t";
echo $arraypendidikan[$pendidikanayah];
echo "\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td>Pekerjaan</td>\r\n\t\t<td>:</td>\r\n\t\t<td>";
echo $pekerjaanayah;
echo "</td>\r\n\t</tr>\r\n\r\n\r\n\t<tr>\r\n\t\t<td  colspan=3><hr size=1>\r\n\t\t<b>Data Keluarga<hr size=1></td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  class=judulform";
echo $cetak;
echo ">Nama Istri/Suami</td>\r\n\t\t<td>:</td>\r\n\t\t<td>";
echo $namapas;
echo "</td>\r\n\t</tr>\r\n\r\n\t<tr>\r\n\t\t<td  >Tempat / Tgl Lahir</td>\r\n\t\t<td>:</td>\r\n\t\t<td>\r\n\t\t";
echo $tempatpas;
echo " / \r\n\t\t\t";
echo "{$tglpas} ".$arraybulan[$blnpas - 1]." {$thnpas}";
echo "\t</tr>\r\n\t<tr>\r\n\t\t<td  >Pendidikan Terakhir</td>\r\n\t\t<td>:</td>\r\n\t\t<td>\r\n\t\t\t";
echo $arraypendidikan[$pendidikanpas];
echo "\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td>Pekerjaan</td>\r\n\t\t<td>:</td>\r\n\t\t<td>";
echo $pekerjaanpas;
echo "</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Gol. Darah</td>\r\n\t\t<td>:</td>\r\n\t\t<td>\r\n\t\t\t";
echo $arraygoldarah[$goldarahpas];
echo "\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Telepon  </td>\r\n\t\t<td>:</td>\r\n\t\t<td>";
echo $teleponpas;
echo "</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >No. HP</td>\r\n\t\t<td>:</td>\r\n\t\t<td>";
echo $hppas;
echo "</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Nama Anak Pertama</td>\r\n\t\t<td>:</td>\r\n\t\t<td>";
echo $namaanak;
echo "</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Tempat / Tgl Lahir</td>\r\n\t\t<td>:</td>\r\n\t\t<td>\r\n\t\t";
echo $tempatanak;
echo " /\r\n\t\t\t";
echo "{$tglanak} ".$arraybulan[$blnanak - 1]." {$thnanak}";
echo "\t</tr>\r\n\t<tr>\r\n\t\t<td  >Jenis kelamin</td>\r\n\t\t<td>:</td>\r\n\t\t<td>";
echo $kelaminanak;
echo "\t\t</td>\r\n\t</tr>\r\n</table>\r\n";
$query = "SELECT * FROM anak WHERE IDUSER='{$iduser}' ORDER BY TANGGAL ";
$hasil =mysqli_query($koneksi,$query);
if ( 0 < sqlnumrows( $hasil ) )
{
    if ( $aksi != "cetak" )
    {
        printjudulmenukecil( "Daftar  Anak" );
    }
    else
    {
        printjudulmenukecilcetak( "Daftar  Anak" );
    }
    echo "\r\n\t\t\t\t\t<table {$border} class=data{$cetak}>\r\n \t\t\t\t\t\t<tr align=center class=juduldata{$cetak}>\r\n\t\t\t\t\t\t\t<td width=10>\r\n\t\t\t\t\t\t\t\tNo\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tNama Lengkap\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tKelamin\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tTempat dan Tanggal Lahir\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tPendidikan\r\n\t\t\t\t\t\t\t</td>\r\n \t\t\t\t\t\t</tr>\r\n\t\t\t\t";
    $ii = 0;
    settype( $i, "integer" );
    while ( $datauser = sqlfetcharray( $hasil ) )
    {
        if ( $ii % 2 == 0 )
        {
            $kelas = "class=datagenap{$cetak}";
        }
        else
        {
            $kelas = "class=dataganjil{$cetak}";
        }
        $nama = $datauser[NAMA];
        $anak = $datauser[ID];
        $kelamin = $datauser[KELAMIN];
        $tempat = $datauser[TEMPAT];
        $tanggal = $datauser[TANGGAL];
        $tmp = explode( "-", $tanggal );
        $tgl = $tmp[2];
        $bln = $tmp[1];
        $thn = $tmp[0];
        $pendidikan = $datauser[PENDIDIKAN];
        ++$ii;
        echo "\r\n\t\t\t\t\t\t<tr valign=top {$kelas}>\r\n\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t{$ii}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td  >\r\n\t\t\t\t\t\t\t\t{$nama}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center >".$arraykelamin[$kelamin]."\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td nowrap>\r\n\t\t\t\t\t\t\t\t{$tempat}, {$tgl}-{$bln}-{$thn}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center >\r\n\t\t\t\t\t\t\t\t{$pendidikan}\r\n\t\t\t\t\t\t\t</td>\r\n \t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
    }
    echo "\r\n\t\t\t\t\t</table>";
}
$query = "SELECT * FROM darurat WHERE IDUSER='{$iduser}' ORDER BY NAMA ";
$hasil =mysqli_query($koneksi,$query);
if ( 0 < sqlnumrows( $hasil ) )
{
    if ( $aksi != "cetak" )
    {
        printjudulmenukecil( "Daftar  Info Saat Darurat" );
    }
    else
    {
        printjudulmenukecilcetak( "Daftar  Info Saat Darurat" );
    }
    echo "\r\n\t\t\t\t\t<table {$border} class=data{$cetak}>\r\n \t\t\t\t\t\t<tr align=center class=juduldata{$cetak}>\r\n\t\t\t\t\t\t\t<td width=10>\r\n\t\t\t\t\t\t\t\tNo\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tNama\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tHubungan\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tTelepon\r\n\t\t\t\t\t\t\t</td>\r\n \t\t\t\t\t\t</tr>\r\n\t\t\t\t";
    $i = 0;
    settype( $i, "integer" );
    while ( $datauser = sqlfetcharray( $hasil ) )
    {
        if ( $i % 2 == 0 )
        {
            $kelas = "class=datagenap{$cetak}";
        }
        else
        {
            $kelas = "class=dataganjil{$cetak}";
        }
        $hubungan = $datauser[HUBUNGAN];
        $darurat = $datauser[ID];
        $nama = $datauser[NAMA];
        $telepon = $datauser[TELEPON];
        ++$i;
        echo "\r\n\t\t\t\t\t\t<tr valign=top {$kelas}>\r\n\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t{$i}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td >\r\n\t\t\t\t\t\t\t\t{$nama}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td >\r\n\t\t\t\t\t\t\t\t{$hubungan}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td >\r\n\t\t\t\t\t\t\t\t{$telepon}\r\n\t\t\t\t\t\t\t</td>\r\n \r\n\r\n\t\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
    }
    echo "\r\n\t\t\t\t\t</table>\r\n\t\t\t\t";
}
echo "<table ";
echo $border2;
echo " class=data";
echo $cetak;
echo ">\r\n\t<tr>\r\n\t\t<td  colspan=3><hr size=1><b>Data Pekerjaan<hr size=1></td>\r\n\t</tr>\r\n\r\n\r\n\t<tr>\r\n\t\t<td class=judulform";
echo $cetak;
echo ">Divisi</td>\r\n\t\t<td>:</td>\r\n\t\t<td>\r\n\t\t\t";
echo $arraydivisi[$divisi];
echo "\t\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Departemen</td>\r\n\t\t<td>:</td>\r\n\t\t<td>\r\n\t\t\t";
echo $bidanguser[$bidang];
echo "\t\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Pangkat</td>\r\n\t\t<td>:</td>\r\n\t\t<td>\r\n\t\t\t";
echo $arraypangkat[$pangkat];
echo "\t\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Status Operator</td>\r\n\t\t<td>:</td>\r\n\t\t<td>\r\n\t\t\t";
echo $arraystatuspegawai[$statuspegawai];
echo "\t</tr>\r\n\t<tr>\r\n\t\t<td  >Waktu Kerja</td>\r\n\t\t<td>:</td>\r\n\t\t<td>\r\n\t\t\t";
echo $arraywaktukerja[$waktukerja];
echo "\t</tr>\r\n\t<tr>\r\n\t\t<td  >Mulai Masuk Kerja</td>\r\n\t\t<td>:</td>\r\n\t\t<td>\r\n\t\t\t";
echo "{$tglm} ".$arraybulan[$blnm - 1]." {$thnm}";
echo "\t</tr>\r\n\t<tr>\r\n\t\t<td  >Masa Berakhir Kerja</td>\r\n\t\t<td>:</td>\r\n\t\t<td>\r\n\t\t\t";
echo $arraybulan[$blnbk - 1]." {$thnbk}";
echo "\t</tr>\r\n\t<tr>\r\n\t\t<td  >Jabatan Struktural/ TMT</td>\r\n\t\t<td>:</td>\r\n\t\t<td>\r\n\t\t\t";
echo $arrayjabatan[$jabatan];
echo "\t\t\t /\r\n\t\t\t";
echo "{$tglj} ".$arraybulan[$blnj - 1]." {$thnj}";
echo "\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Jabatan Fungsional/ TMT</td>\r\n\t\t<td>:</td>\r\n\t\t<td>\r\n\t\t\t";
echo $arrayfungsional[$fungsional];
echo "\t\t\t /\r\n\t\t\t";
echo "{$tglf} ".$arraybulan[$blnf - 1]." {$thnf}";
echo "\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Status Kerja</td>\r\n\t\t<td>:</td>\r\n\t\t<td>\r\n\t\t\t";
echo $arraystatuskerja[$statuskerja];
echo "\t</tr>\r\n\t\t\t\r\n\t\t\t\r\n\t<tr>\r\n\t\t<td  colspan=3><hr size=1>\r\n\t\t<b>Lain-lain<hr size=1></td>\r\n\t</tr>\r\n\r\n\t<tr>\r\n\t\t<td  >Lokasi Kerja</td>\r\n\t\t<td>:</td>\r\n\t\t<td>\r\n\t\t\t";
echo $arraylokasi[$lokasi];
echo "\t</tr>\r\n\t<tr>\r\n\t\t<td  >Tingkat Akses</td>\r\n\t\t<td>:</td>\r\n\t\t<td>\r\n\t\t\t";
unset( $tingkatakses );
$tingkatakses = explode( ",", $datauser[TINGKAT] );
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
echo $tingkatakses2;
echo "\t\t</td>\r\n\t</tr>\r\n\r\n\r\n\t<tr>\r\n\t\t<td  colspan=3><hr size=1></td>\r\n\t</tr>\r\n\r\n";
if ( $tingkataksesusers[$kodemenu] == "T" )
{
    echo "\t\r\n\t<tr>\r\n\t\t<td  colspan=3 align=left>\r\n\t\t\t<form action=index.php >\r\n\t\t\t\t<input class=tombol type=submit value='Update' >\r\n\t\t\t\t<input type=hidden value='";
    echo $iduser;
    echo "' name=iduser>\r\n\t\t\t\t<input type=hidden value='updateuser' name=aksi>\r\n\t\t\t\t<input type=hidden value='tambah' name=pilihan>\r\n\t\t\t</form>\r\n\t\t</td>\r\n\t</tr>\r\n";
}
if ( $aksi != "cetak" )
{
    echo "\t<tr>\r\n\t\t<td  colspan=3 align=left>\r\n\t\t\t<form action=cetakdetiluser.php target=_blank>\r\n\t\t\t\t<input class=tombol type=submit value='Cetak' >\r\n\t\t\t\t<input type=hidden value='";
    echo $iduser;
    echo "' name=iduser>\r\n\t\t\t</form>\r\n\t\t</td>\r\n\t</tr>\r\n</table>\r\n";
}
echo " ";
?>
