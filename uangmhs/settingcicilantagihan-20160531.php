<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
cekhaktulis( $kodemenu );
printjudulmenu( "SETTING CICILAN TAGIHAN" );
if ( $aksi == "Lanjut" )
{
    if ( $aksi2 == "editcicilan" )
    {
        $errmesg = "";
        if ( $aksi3 == "x" )
        {
            $q = "DELETE FROM  biayakomponen_tagihan\r\n              WHERE \r\n              \tbiayakomponen_tagihan.IDPRODI='{$idprodi}' AND biayakomponen_tagihan.ANGKATAN='{$angkatan}' AND   biayakomponen_tagihan.GELOMBANG='{$gelombang}' AND biayakomponen_tagihan.TANGGAL='{$tanggalhapus}'  AND \r\n  \tbiayakomponen_tagihan.IDKOMPONEN='{$idkomponen}' {$qfield} ";
            mysqli_query($koneksi,$q);
            echo mysqli_error($koneksi);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Data setting   cicilan tagihan tanggal {$tanggalhapus} berhasil dihapus.";
            }
            else
            {
                $errmesg = "Data setting   cicilan tagihan tanggal {$tanggalhapus}  tidak berhasil dihapus.";
            }
        }
        if ( $aksi3 == "+" )
        {
            if ( $biayaangsuran <= 0 && !( $idkomponen == 99 || $idkomponen == 98 ) )
            {
                $errmesg = "Biaya Angsuran harus diisi lebih dari Nol (0).";
            }
            else
            {
                $q = "REPLACE INTO biayakomponen_tagihan\r\n              (IDKOMPONEN,IDPRODI,ANGKATAN,GELOMBANG,JENISKELAS,TANGGAL,BIAYA,TAHUN,SEMESTER,\r\n              TANGGALBAYAR1,TANGGALBAYAR2) \r\n              VALUES \r\n              ('{$idkomponen}','{$idprodi}','{$angkatan}','{$gelombang}','{$jeniskelas}','{$tgl['thn']}-{$tgl['bln']}-{$tgl['tgl']}','{$biayaangsuran}',\r\n              '{$tahunajaran}' ,'{$semester}',\r\n              '{$tglbayar1['thn']}-{$tglbayar1['bln']}-{$tglbayar1['tgl']}',\r\n              '{$tglbayar2['thn']}-{$tglbayar2['bln']}-{$tglbayar2['tgl']}')";
                mysqli_query($koneksi,$q);
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    $errmesg = "Data setting   cicilan tagihan berhasil disimpan.";
                }
                else
                {
                    $errmesg = "Data setting   cicilan tagihan tidak berhasil disimpan.";
                }
            }
        }
    }
    if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
    {
        $jeniskelaskeuangan = 1;
        $qcolumn = " ,JENISKELAS  ";
        $qfield = " AND JENISKELAS!='' AND JENISKELAS='{$jeniskelas}'";
    }
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=angkatan value='{$angkatan}'>\r\n\t\t\t<input type=hidden name=gelombang value='{$gelombang}'>\r\n\t\t\t<input type=hidden name=idprodi value='{$idprodi}'>\r\n\t\t\t<input type=hidden name=jeniskelas value='{$jeniskelas}'>\r\n \t\t<table class=form>\r\n\t\t\t<tr class=judulform>\r\n\t\t\t\t<td width=200>Angkatan</td>\r\n\t\t\t\t<td><b>{$angkatan}</td>\r\n\t\t\t</tr>\r\n\t\t\t<tr  >\r\n\t\t\t\t<td >Gelombang</td>\r\n\t\t\t\t<td><b>{$gelombang}</td>\r\n\t\t\t</tr>\r\n\t\t\t<tr>\r\n\t\t\t\t<td>Program Studi / Program Pendidikan</td>\r\n\t\t\t\t<td><b>".$arrayprodidep[$idprodi]."</td>\r\n\t\t\t</tr>";
    if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
    {
        echo "\r\n        <tr>\r\n  \t\t\t\t<td>Jenis Kelas</td>\r\n  \t\t\t\t<td><b>".$arraykelasstei[$jeniskelas]."</td>\r\n  \t\t\t</tr>";
    }
    echo "\r\n\r\n\t\t</table> ";
    $q = "SELECT komponenpembayaran.*,biayakomponen.* FROM komponenpembayaran,komponenpembayaran_prodi ,biayakomponen\r\n\tWHERE \r\n'{$idprodi}'=komponenpembayaran_prodi.IDPRODI AND\r\n  komponenpembayaran.ID =komponenpembayaran_prodi.IDKOMPONEN AND  \r\n  \r\n  komponenpembayaran.ID=biayakomponen.IDKOMPONEN AND\r\n\tbiayakomponen.IDPRODI='{$idprodi}' AND biayakomponen.ANGKATAN='{$angkatan}' AND   biayakomponen.GELOMBANG='{$gelombang}' AND\r\n  biayakomponen.BIAYA > 0 {$qfield}\r\n  {$where992}\r\n\tORDER BY ID";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        printjudulmenukecil( "Data Setting Tagihan" );
        $colspan = 6;
        if ( $aturankeuangan == 3 )
        {
            $colspan = 9;
        }
        echo "\r\n \t\t\t<table {$border} class=data >\r\n \t\t\t<tr class=juduldata  align=center>\r\n\t\t\t\t<td>No</td>\r\n \t\t\t\t<td>Kode</td>\r\n\t\t\t\t<td>Nama /  Label SPC</td>\r\n\t\t\t\t<td>Jenis</td>\r\n\t\t\t\t<td>Biaya Rp.</td> \r\n \r\n \r\n\t\t\t\t<td>Rincian Tagihan</td> \r\n \r\n\t\t\t\t<td>Aksi</td> \r\n \t\t\t</tr>\r\n\t\t";
        $i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            unset( $d2 );
            if ( $BIAYASKSKULIAH == 1 && ( $d[ID] == 99 || $d[ID] == 98 ) )
            {
                $d[NAMA] = "BIAYA KULIAH PER SKS";
            }
            if ( 0 * $d[JENIS] == 6 )
            {
                if ( $d[JENIS] == 6 )
                {
                    $tabeljumlahtagihan = "Tagihan keluar setelah data cuti ditambahkan";
                }
                else
                {
                    if ( $d[ID] == 98 )
                    {
                        $tabeljumlahtagihan = "Angsuran ke-1 Rp. ".cetakuang( $d[BIAYA], 0 )." per SKS";
                        $tabelwaktutagihan = "Setelah Mengisi KRS Semester Pendek";
                    }
                    else
                    {
                        if ( $d[ID] == 99 )
                        {
                            $tabeljumlahtagihan = "Angsuran ke-1 Rp. ".cetakuang( $d[BIAYA], 0 )." per SKS";
                            $tabelwaktutagihan = "Setelah Mengisi KRS Semester Reguler";
                        }
                    }
                }
            }
            else
            {
                $q = "SELECT  biayakomponen_tagihan.*,\r\n             DATE_FORMAT(TANGGAL,'%d-%m-%Y') AS TANGGALANGSURAN,\r\n             DATE_FORMAT(TANGGALBAYAR1,'%d-%m-%Y') AS TGLBAYAR1,\r\n             DATE_FORMAT(TANGGALBAYAR2,'%d-%m-%Y') AS TGLBAYAR2\r\n             FROM biayakomponen_tagihan\r\n          \tWHERE \r\n          \tbiayakomponen_tagihan.IDPRODI='{$idprodi}' AND \r\n            biayakomponen_tagihan.ANGKATAN='{$angkatan}' AND   \r\n            biayakomponen_tagihan.GELOMBANG='{$gelombang}' AND\r\n          \tbiayakomponen_tagihan.IDKOMPONEN='{$d['ID']}'  \r\n          \tORDER BY TAHUN,SEMESTER,TANGGAL";
                $h3 = mysqli_query($koneksi,$q);
                echo mysqli_error($koneksi);
                $jenisangsuran = sqlnumrows( $h3 );
                $caraangsur = "";
                $tabeljumlahtagihan = "";
                $tabelwaktutagihan = "";
                $idkomponenx = $d[ID];
                $i3 = 0;
                $periode = "-";
                if ( 0 < $jenisangsuran )
                {
                    if ( $jenisangsuran == 1 )
                    {
                        $caraangsur = "Satu Kali";
                    }
                    else
                    {
                        $caraangsur = "Angsuran";
                    }
                    $tabeljumlahtagihan = "\r\n                <table>\r\n                  <tr class=juduldata>\r\n                    <td>Periode</td>\r\n                    <td>Angsuran Ke</td>\r\n                    <td>Jumlah Tagihan</td>\r\n                    <td>Waktu Penagihan</td>\r\n                    <td>Periode Pembayaran</td>\r\n                  </tr>\r\n                ";
                    $jeniskomponen = $arrayjeniskomponenpembayaran[$d[ID]];
                    $tahuns = $semesters = $bulans = 0;
                    $totaltagihan = 0;
                    unset( $totaltagihan_tahunan );
                    unset( $totaltagihan_semester );
                    unset( $totaltagihan_bulan );
                    unset( $totaltagihan_cuti );
                    while ( $d3 = sqlfetcharray( $h3 ) )
                    {
                        $totaltagihan += $d3[BIAYA];
                        if ( $jeniskomponen == 2 )
                        {
                            $totaltagihan_tahunan += $d3[TAHUN];
                            if ( $d3[TAHUN] != $tahuns )
                            {
                                if ( $tahuns != 0 )
                                {
                                    $tabeljumlahtagihan .= "\r\n                                <tr>\r\n                                  <td colspan=2 align=left><b>Total   </td>\r\n                                  <td align=right><b>".cetakuang( $totaltagihan_tahunan[$tahuns], 0 )."</td>\r\n                                  <td>  </td>\r\n                                </tr>                  \r\n                              ";
                                }
                                $tahuns = $d3[TAHUN];
                                $i3 = 0;
                            }
                            $periode = "".( $d3[TAHUN] - 1 )."/{$d3['TAHUN']}";
                        }
                        else if ( $jeniskomponen == 3 || $jeniskomponen == 6 )
                        {
                            $totaltagihan_semester += $d3[TAHUN].$d3[SEMESTER];
                            if ( $idkomponen == "99" || $idkomponen == "98" )
                            {
                                $semesters = $d3[TAHUN].$d3[SEMESTER];
                                $i3 = 0;
                            }
                            else if ( $d3[TAHUN].$d3[SEMESTER] != $semesters )
                            {
                                if ( $semesters != 0 )
                                {
                                    $tabeljumlahtagihan .= "\r\n                                    <tr>\r\n                                      <td colspan=2 align=left><b>Total   </td>\r\n                                      <td align=right><b>".cetakuang( $totaltagihan_semester[$semesters], 0 )."</td>\r\n                                      <td>  </td>\r\n                                    </tr>                  \r\n                                  ";
                                }
                                $semesters = $d3[TAHUN].$d3[SEMESTER];
                                $i3 = 0;
                            }
                            $periode = "".( $d3[TAHUN] - 1 )."/{$d3['TAHUN']} ".$arraysemester[$d3[SEMESTER]];
                        }
                        else if ( $jeniskomponen == 5 )
                        {
                            $totaltagihan_bulan += $d3[TAHUN].$d3[SEMESTER];
                            if ( $d3[TAHUN].$d3[SEMESTER] != $bulans )
                            {
                                if ( $bulans != 0 )
                                {
                                    $tabeljumlahtagihan .= "\r\n                                <tr>\r\n                                  <td colspan=2 align=left><b>Total   </td>\r\n                                  <td align=right><b>".cetakuang( $totaltagihan_bulan[$bulans], 0 )."</td>\r\n                                  <td>  </td>\r\n                                </tr>                  \r\n                              ";
                                }
                                $bulans = $d3[TAHUN].$d3[SEMESTER];
                                $i3 = 0;
                            }
                            $periode = $arraybulan2[$d3[SEMESTER]]." {$d3['TAHUN']} ";
                        }
                        ++$i3;
                        if ( $idkomponenx == "99" || $idkomponenx == "98" )
                        {
                            $d3[BIAYA] = "";
                        }
                        $tabeljumlahtagihan .= "\r\n                  <tr>\r\n                    <td>{$periode}</td>\r\n                    <td align=center>{$i3}</td>\r\n                    <td align=right>".cetakuang( $d3[BIAYA], 0 )."</td>\r\n                    <td align=center>{$d3['TANGGALANGSURAN']}</td>\r\n                    <td align=center>{$d3['TGLBAYAR1']}<br>s.d.<br>{$d3['TGLBAYAR2']}</td>\r\n                    </tr>\r\n                   ";
                    }
                    if ( $jeniskomponen == 0 || $jeniskomponen == 1 || $jeniskomponen == 4 )
                    {
                        $tabeljumlahtagihan .= "  \r\n                          <tr>\r\n                            <td colspan=2><b>Total</td>\r\n                            <td align=right><b>".cetakuang( $totaltagihan, 0 )."</td>\r\n                            <td>  </td>\r\n                          </tr>";
                    }
                    else if ( $jeniskomponen == 2 )
                    {
                        $totaltagihan_tahunan += $d3[TAHUN];
                        if ( $d3[TAHUN] != $tahuns )
                        {
                            if ( $tahuns != 0 )
                            {
                                $tabeljumlahtagihan .= "\r\n                                <tr>\r\n                                  <td colspan=2 align=left><b>Total  </td>\r\n                                  <td align=right><b>".cetakuang( $totaltagihan_tahunan[$tahuns], 0 )."</td>\r\n                                  <td>  </td>\r\n                                </tr>                  \r\n                              ";
                            }
                            $tahuns = $d3[TAHUN];
                            $i3 = 0;
                        }
                        $periode = "".( $d3[TAHUN] - 1 )."/{$d3['TAHUN']}";
                    }
                    else if ( $jeniskomponen == 3 || $jeniskomponen == 6 )
                    {
                        $totaltagihan_semester += $d3[TAHUN].$d3[SEMESTER];
                        if ( $idkomponen == "99" || $idkomponen == "98" )
                        {
                            $semesters = $d3[TAHUN].$d3[SEMESTER];
                            $i3 = 0;
                        }
                        else if ( $d3[TAHUN].$d3[SEMESTER] != $semesters )
                        {
                            if ( $semesters != 0 )
                            {
                                $tabeljumlahtagihan .= "\r\n                                      <tr>\r\n                                        <td colspan=2 align=left><b>Total  </td>\r\n                                        <td align=right><b>".cetakuang( $totaltagihan_semester[$semesters], 0 )."</td>\r\n                                        <td>  </td>\r\n                                      </tr>                  \r\n                                    ";
                            }
                            $semesters = $d3[TAHUN].$d3[SEMESTER];
                            $i3 = 0;
                        }
                        $periode = "".( $d3[TAHUN] - 1 )."/{$d3['TAHUN']} ".$arraysemester[$d3[SEMESTER]];
                    }
                    else if ( $jeniskomponen == 5 )
                    {
                        $totaltagihan_bulan += $d3[TAHUN].$d3[SEMESTER];
                        if ( $d3[TAHUN].$d3[SEMESTER] != $bulans )
                        {
                            if ( $bulans != 0 )
                            {
                                $tabeljumlahtagihan .= "\r\n                                <tr>\r\n                                  <td colspan=2 align=left><b>Total  </td>\r\n                                  <td align=right><b>".cetakuang( $totaltagihan_bulan[$bulans], 0 )."</td>\r\n                                  <td>  </td>\r\n                                </tr>                  \r\n                              ";
                            }
                            $bulans = $d3[TAHUN].$d3[SEMESTER];
                            $i3 = 0;
                        }
                        $periode = $arraybulan2[$d3[SEMESTER]]." {$d3['TAHUN']} ";
                    }
                    $tabeljumlahtagihan .= "\r\n                </table>";
                }
            }
            echo "\r\n\t\t\t\t<tr align=center {$kelas} >\r\n\t\t\t\t\t<td>{$i}</td>\r\n  \t\t\t\t\t<td align=left>{$d['ID']}</td>\r\n \t\t\t\t\t<td align=left   >{$d['NAMA']} / {$d['LABELSPC']}</td>\r\n \t\t\t\t\t<td align=left nowrap>".$arrayjenispembayaran[$d[JENIS]]." </td>\r\n \t\t\t\t\t<td align=right>".cetakuang( $d[BIAYA], 0 )."\r\n \t\t\t\t\t</td> \r\n \t\t \r\n \t\t \r\n \t\t\t\t\t<td nowrap>{$tabeljumlahtagihan} </td> \t\t\t\t\r\n        \r\n \t\t\t\t\t<td>";
            if ( 0 )
            {
                echo "-";
            }
            else
            {
                echo "<a href='index.php?pilihan={$pilihan}&aksi={$aksi}&aksi2=editcicilan&idprodi={$d['IDPRODI']}&angkatan={$d['ANGKATAN']}&gelombang={$d['GELOMBANG']}&jeniskelas={$d['JENISKELAS']}&idkomponen={$d['ID']}#formcicilan'>Edit</a>\r\n           ";
            }
            echo "\r\n            </td>                  \r\n           \r\n           </tr>\r\n\t\t\t";
            ++$i;
        }
        echo "</table>\r\n    \r\n \r\n    ";
        if ( $aksi2 == "editcicilan" )
        {
            unset( $totaltagihan );
            unset( $totaltagihan_tahunan );
            unset( $totaltagihan_semester );
            unset( $totaltagihan_bulan );
            printjudulmenukecil( "<b>SETTING CICILAN" );
            printmesg( $errmesg );
            $q = "SELECT komponenpembayaran.*,biayakomponen.* FROM komponenpembayaran ,biayakomponen\r\n\tWHERE komponenpembayaran.ID=biayakomponen.IDKOMPONEN AND\r\n\tbiayakomponen.IDPRODI='{$idprodi}' AND biayakomponen.ANGKATAN='{$angkatan}' AND   biayakomponen.GELOMBANG='{$gelombang}' AND\r\n\tIDKOMPONEN='{$idkomponen}' AND\r\n  biayakomponen.BIAYA > 0 {$qfield} \r\n  {$where992}\r\n\tORDER BY ID";
			echo $q.'<br>';
		   $h2 = mysqli_query($koneksi,$q);
            $d2 = sqlfetcharray( $h2 );
            $jeniskomponen = $d2[JENIS];
			echo $jeniskomponen.'<br>';
            echo "\r\n      </form> \r\n      \r\n      \r\n      <form action=index.php?#formcicilan method=post id=formcicilan>\r\n        <input type=hidden name='pilihan' value='{$pilihan}'> \r\n        <input type=hidden name='aksi' value='{$aksi}'> \r\n        <input type=hidden name='aksi2' value='{$aksi2}'> \r\n        <input type=hidden name='idprodi' value='{$idprodi}'> \r\n        <input type=hidden name='angkatan' value='{$angkatan}'> \r\n        <input type=hidden name='gelombang' value='{$gelombang}'> \r\n        <input type=hidden name='jeniskelas' value='{$jeniskelas}'> \r\n        <input type=hidden name='idkomponen' value='{$idkomponen}'> \r\n      \r\n      <table>\r\n        <tr>\r\n          <td width=150>ID Komponen</td>\r\n          <td>{$idkomponen} /  ".$arraykomponenpembayaran[$idkomponen]." / {$d2['LABELSPC']}</td>\r\n        </tr>\r\n        <tr>\r\n          <td  >Biaya</td>\r\n          <td>".cetakuang( $d2[BIAYA], 0 )."</td>\r\n        </tr> \r\n        <tr>\r\n          <td  colspan=2><b>Detil Setting Cicilan</td>\r\n         </tr>         \r\n        <tr>\r\n           <td colspan=2>\r\n            <table {$border} class=data>\r\n              <tr align=center class=juduldata>\r\n                <td >No</td>\r\n                <td >Periode</td>\r\n                <td >Biaya Angsuran</td>\r\n                <td >Waktu Penagihan</td>\r\n                <td >Periode Pembayaran</td>\r\n                <td > </td>\r\n              </tr>\r\n              <tr align=center  >\r\n                <td >*</td>\r\n                <td nowrap> ";
            if ( $jeniskomponen == 0 || $jeniskomponen == 1 || $jeniskomponen == 4 )
            {
                echo "-";
            }
            else if ( $jeniskomponen == 2 )
            {
                echo "<select name=tahunajaran class=masukan> \r\n        \t\t\t\t\t\t ";
                $arrayangkatan = getarrayangkatan( "", 0, $angkatan );
                $k = $angkatan;
                while ( $k <= $angkatan + 8 )
                {
                    $selected = "";
                    if ( $k + 1 == $tahunajaran )
                    {
                        $selected = "selected";
                    }
                    echo "\r\n        \t\t\t\t\t\t\t<option value='".( $k + 1 )."' {$selected} >".$k."/".( $k + 1 )."</option>\r\n        \t\t\t\t\t\t\t";
                    ++$k;
                }
                echo "\r\n        \t\t\t\t\t\t</select> ";
            }
            else if ( $jeniskomponen == 3 || $jeniskomponen == 6 )
            {
                echo "<select name=tahunajaran class=masukan> \r\n        \t\t\t\t\t\t ";
                $arrayangkatan = getarrayangkatan( "", 0, $angkatan );
                $k = $angkatan;
                while ( $k <= $angkatan + 8 )
                {
                    $selected = "";
                    if ( $k + 1 == $tahunajaran )
                    {
                        $selected = "selected";
                    }
                    echo "\r\n        \t\t\t\t\t\t\t<option value='".( $k + 1 )."' {$selected} >".$k."/".( $k + 1 )."</option>\r\n        \t\t\t\t\t\t\t";
                    ++$k;
                }
                echo "\r\n        \t\t\t\t\t\t</select> ";
                echo "".createinputselect( "semester", $arraysemester, $semester, "", "" )."";
            }
            else if ( $jeniskomponen == 5 )
            {
                echo "".createinputselect( "semester", $arraybulan2, $semester, "", "" )."";
                echo "<select name=tahunajaran class=masukan> \r\n        \t\t\t\t\t\t ";
                $arrayangkatan = getarrayangkatan( "", 0, $angkatan );
                $k = $angkatan;
                while ( $k <= $angkatan + 8 )
                {
                    $selected = "";
                    if ( $k == $tahunajaran )
                    {
                        $selected = "selected";
                    }
                    echo "\r\n        \t\t\t\t\t\t\t<option value='".$k."' {$selected} >".$k."</option>\r\n        \t\t\t\t\t\t\t";
                    ++$k;
                }
                echo "\r\n        \t\t\t\t\t\t</select> ";
            }
            echo "\r\n                  </td>\r\n                <td >";
            if ( $idkomponen == "99" || $idkomponen == "98" )
            {
                echo "-";
            }
            else
            {
                echo "<input type=text name=biayaangsuran value='{$biayaangsuran}' size=10>";
            }
            echo "</td>\r\n                <td nowrap>".createinputtanggal( "tgl", $tgl, "", "" )."</td>\r\n                <td  >\r\n                  ".createinputtanggal( "tglbayar1", $tglbayar1, "", "" )."\r\n                  <br> s.d. <br> \r\n                  ".createinputtanggal( "tglbayar2", $tglbayar2, "", "" )."\r\n                </td>\r\n                 <td ><input type=submit name=aksi3 value='+' onClick=\"return confirm('Simpan setting tagihan ?')\"></td>\r\n              </tr>\r\n          ";
            $q = "SELECT  biayakomponen_tagihan.*,DATE_FORMAT(TANGGAL,'%d-%m-%Y') AS TANGGALANGSURAN\r\n            ,DATE_FORMAT(TANGGALBAYAR1,'%d-%m-%Y') AS TGLBAYAR1\r\n            ,DATE_FORMAT(TANGGALBAYAR2,'%d-%m-%Y') AS TGLBAYAR2\r\n             FROM biayakomponen_tagihan\r\n          \tWHERE \r\n          \tbiayakomponen_tagihan.IDPRODI='{$idprodi}' AND \r\n            biayakomponen_tagihan.ANGKATAN='{$angkatan}' AND   \r\n            biayakomponen_tagihan.GELOMBANG='{$gelombang}' AND\r\n          \tbiayakomponen_tagihan.IDKOMPONEN='{$idkomponen}'  \r\n          \tORDER BY TAHUN,SEMESTER,TANGGAL";
            #echo $q.'<br>';
			$h3 = mysqli_query($koneksi,$q);
            echo mysqli_error($koneksi);
            if ( 0 < sqlnumrows( $h3 ) )
            {
                $i = 0;
                $totaltagihan = 0;
                $tahuns = 0;
                $semesters = 0;
                $bulans = 0;
                while ( $d3 = sqlfetcharray( $h3 ) )
                {
                    $kelas = kelas( $i );
                    if ( $jeniskomponen == 2 )
                    {
                        if ( $d3[TAHUN] != $tahuns )
                        {
                            if ( $tahuns != 0 )
                            {
                                $kettotaltagihan = "";
                                if ( $d2[BIAYA] != $totaltagihan_tahunan[$tahuns] )
                                {
                                    $kettotaltagihan = "<b style='color:#FF0000;'>Total cicilan belum sama dengan total tagihan (Selisih ".cetakuang( $d2[BIAYA] - $totaltagihan_tahunan[$tahuns], 0 ).")</b>";
                                }
                                echo "\r\n                        <tr>\r\n                          <td colspan=2><b>Total    </td>\r\n                          <td align=center><b>".cetakuang( $totaltagihan_tahunan[$tahuns], 0 )."</td>\r\n                          <td>{$kettotaltagihan} </td>\r\n                        </tr>                  \r\n                      ";
                            }
                            $tahuns = $d3[TAHUN];
                            $i = 0;
                        }
                    }
                    else if ( $jeniskomponen == 3 || $jeniskomponen == 6 )
                    {
                        if ( $idkomponen == "99" || $idkomponen == "98" )
                        {
                            $semesters = $d3[TAHUN].$d3[SEMESTER];
                            $i = 0;
                        }
                        else
                        {
                            if ( $d3[TAHUN].$d3[SEMESTER] != $semesters )
                            {
                                if ( $semesters != 0 )
                                {
                                    $kettotaltagihan = "";
                                    if ( $d2[BIAYA] != $totaltagihan_semester[$semesters] )
                                    {
                                        $kettotaltagihan = "<b style='color:#FF0000;'>Total cicilan belum sama dengan total tagihan (Selisih ".cetakuang( $d2[BIAYA] - $totaltagihan_semester[$semesters], 0 ).")</b>";
                                    }
                                    echo "\r\n                            <tr>\r\n                              <td colspan=2><b>Total  </td>\r\n                              <td align=center><b>".cetakuang( $totaltagihan_semester[$semesters], 0 )."</td>\r\n                              <td>{$kettotaltagihan} </td>\r\n                            </tr>                  \r\n                          ";
                                }
                                $semesters = $d3[TAHUN].$d3[SEMESTER];
                                $i = 0;
                            }
                        }
                    }
                    else if ( $jeniskomponen == 5 && $d3[TAHUN].$d3[SEMESTER] != $bulans )
                    {
                        if ( $bulans != 0 )
                        {
                            $kettotaltagihan = "";
                            if ( $d2[BIAYA] != $totaltagihan_bulan[$bulans] )
                            {
                                $kettotaltagihan = "<b style='color:#FF0000;'>Total cicilan belum sama dengan total tagihan (Selisih ".cetakuang( $d2[BIAYA] - $totaltagihan_bulan[$bulans], 0 ).")</b>";
                            }
                            echo "\r\n                        <tr>\r\n                          <td colspan=2><b>Total  </td>\r\n                          <td align=center><b>".cetakuang( $totaltagihan_bulan[$bulans], 0 )."</td>\r\n                          <td>{$kettotaltagihan} </td>\r\n                        </tr>                  \r\n                      ";
                        }
                        $bulans = $d3[TAHUN].$d3[SEMESTER];
                        $i = 0;
                    }
                    ++$i;
                    $totaltagihan += $d3[BIAYA];
                    if ( $idkomponen == "99" || $idkomponen == "98" )
                    {
                        $d3[BIAYA] = "";
                    }
                    echo "\r\n                  <tr align=center  {$kelas} >\r\n                    <td >{$i}</td>\r\n                    <td >";
                    if ( $jeniskomponen == 0 || $jeniskomponen == 1 || $jeniskomponen == 4 )
                    {
                        echo "-";
                    }
                    else if ( $jeniskomponen == 2 )
                    {
                        echo "APASIH".( $d3[TAHUN] - 1 )."/{$d3['TAHUN']}";
                        $totaltagihan_tahunan += $d3[TAHUN];
                    }
                    else if ( $jeniskomponen == 3 || $jeniskomponen == 6 )
                    {
                        echo "NAONSIH".( $d3[TAHUN] - 1 )."/{$d3['TAHUN']} ".$arraysemester[$d3[SEMESTER]];
                        $totaltagihan_semester += $d3[TAHUN].$d3[SEMESTER];
                    }
                    else if ( $jeniskomponen == 5 )
                    {
                        #echo $arraybulan2[$d3[SEMESTER]]." {$d3['TAHUN']} ";
                        $totaltagihan_bulan += $d3[TAHUN].$d3[SEMESTER];
                    }
                    echo "\r\n                     </td>\r\n                    <td >".cetakuang( $d3[BIAYA], 0 )."</td>\r\n                    <td >{$d3['TANGGALANGSURAN']}</td>\r\n                    <td >{$d3['TGLBAYAR1']} s.d {$d3['TGLBAYAR2']}</td>\r\n                    <td ><a href='index.php?pilihan={$pilihan}&aksi={$aksi}&aksi2=editcicilan&aksi3=x&idprodi={$d2['IDPRODI']}&angkatan={$d2['ANGKATAN']}&gelombang={$d2['GELOMBANG']}&jeniskelas={$d2['JENISKELAS']}&idkomponen={$d2['ID']}&tanggalhapus={$d3['TANGGAL']}#formcicilan' onClick=\"return confirm('Hapus data setting tagihan tanggal {$d3['TANGGALANGSURAN']} ? ')\">x</a></td>\r\n                  </tr>                \r\n                ";
                }
            }
			print_r($totaltagihan_semester).'<br>';
            if ( $jeniskomponen == 0 || $jeniskomponen == 1 || $jeniskomponen == 4 )
            {
                $kettotaltagihan = "";
                if ( $d2[BIAYA] != $totaltagihan )
                {
                    $kettotaltagihan = "<b style='color:#FF0000;'>Total cicilan belum sama dengan total tagihan (Selisih ".cetakuang( $d2[BIAYA] - $totaltagihan, 0 ).")</b>";
                }
                echo "\r\n                  <tr>\r\n                    <td colspan=2><b>Total</td>\r\n                    <td align=center><b>".cetakuang( $totaltagihan, 0 )."</td>\r\n                    <td>{$kettotaltagihan} </td>\r\n                  </tr>";
            }
            else if ( $jeniskomponen == 2 )
            {
                if ( $d3[TAHUN] != $tahuns )
                {
                    if ( $tahuns != 0 )
                    {
                        $kettotaltagihan = "";
                        if ( $d2[BIAYA] != $totaltagihan_tahunan[$tahuns] )
                        {
                            $kettotaltagihan = "<b style='color:#FF0000;'>Total cicilan belum sama dengan total tagihan (Selisih ".cetakuang( $d2[BIAYA] - $totaltagihan_tahunan[$tahuns], 0 ).")</b>";
                        }
                        echo "\r\n                        <tr>\r\n                          <td colspan=2><b>Total   </td>\r\n                          <td align=center><b>".cetakuang( $totaltagihan_tahunan[$tahuns], 0 )."</td>\r\n                          <td>{$kettotaltagihan} </td>\r\n                        </tr>                  \r\n                      ";
                    }
                    $tahuns = $d3[TAHUN];
                    $i = 0;
                }
            }
            else if ( $jeniskomponen == 3 || $jeniskomponen == 6 )
            {
				#$semesters = $d3[TAHUN].$d3[SEMESTER];
				#echo "KKK".$idkomponen."DDD".$jeniskomponen.'<br>';
                if ( $idkomponen == "99" || $idkomponen == "98" )
                {
                    $semesters = $d3[TAHUN].$d3[SEMESTER];
                    $i = 0;
                }
                else
                {
					echo "ZZZ".$d3[TAHUN].$d3[SEMESTER].$semesters.'<br>';
                    if ( $d3[TAHUN].$d3[SEMESTER] != $semesters )
					#if ( $bulans != $semesters )
                    {
						echo "GGG".'<br>';
                        if ( $semesters != 0 )
                        {
                            $kettotaltagihan = "";
							print_r($totaltagihan_semester).'WWWW<br>';
                            if ( $d2[BIAYA] != $totaltagihan_semester[$semesters] )
                            {
								echo "AAA".$totaltagihan_semester[$semesters];
                                $kettotaltagihan = "<b style='color:#FF0000;'>Total cicilan belum sama dengan total tagihan (Selisih ".cetakuang( $d2[BIAYA] - $totaltagihan_semester[$semesters], 0 ).")</b>";
                            }
                            echo "\r\n                            <tr>\r\n                              <td colspan=2><b>Total    </td>\r\n                              <td align=center><b>".cetakuang( $totaltagihan_semester[$semesters], 0 )."</td>\r\n                              <td>{$kettotaltagihan} </td>\r\n                            </tr>                  \r\n                          ";
                        }
                        $semesters = $d3[TAHUN].$d3[SEMESTER];
						#$semesters = $bulans;
                        $i = 0;
                    }
                }
            }
            else if ( $jeniskomponen == 5 && $d3[TAHUN].$d3[SEMESTER] != $bulans )
            {
                if ( $bulans != 0 )
                {
                    $kettotaltagihan = "";
                    if ( $d2[BIAYA] != $totaltagihan_bulan[$bulans] )
                    {
                        $kettotaltagihan = "<b style='color:#FF0000;'>Total cicilan belum sama dengan total tagihan (Selisih ".cetakuang( $d2[BIAYA] - $totaltagihan_bulan[$bulans], 0 ).")</b>";
                    }
                    echo "\r\n                        <tr>\r\n                          <td colspan=2><b>Total  </td>\r\n                          <td align=center><b>".cetakuang( $totaltagihan_bulan[$bulans], 0 )."</td>\r\n                          <td>{$kettotaltagihan} </td>\r\n                        </tr>                  \r\n                      ";
                }
                $bulans = $d3[TAHUN].$d3[SEMESTER];
                $i = 0;
            }
            echo "\r\n          </table>\r\n           </td>\r\n        </tr>\r\n     \r\n        </table>\r\n      ";
        }
    }
    else
    {
        printmesg( "Tidak ada komponen pembayaran untuk Prodi ini atau tidak ada biaya komponen yang sudah diisi.." );
    }
    echo "\r\n\t\t</form>\r\n\t";
}
if ( $aksi == "" )
{
    printmesg( $errmesg );
    if ( $gelombang == "" )
    {
        $gelombang = 1;
    }
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n \t\t<table class=form>\r\n\t\t\t<tr class=judulform>\r\n\t\t\t\t<td>Angkatan</td>\r\n\t\t\t\t<td>";
    $waktu = getdate( );
    echo "\r\n\t\t\t\t\t\t<select name=angkatan class=masukan> \r\n\t\t\t\t\t\t ";
    $cek = "";
    $i = 1900;
    while ( $i <= $waktu[year] + 5 )
    {
        if ( $i == $waktu[year] )
        {
            $cek = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t\t\t\t\t";
        $cek = "";
        ++$i;
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  \t\t <tr class=judulform>\r\n\t\t\t<td>Gelombang Masuk</td>\r\n\t\t\t<td>".createinputtext( "gelombang", $gelombang, " class=masukan  size=2" )."</td>\r\n\t\t</tr> \r\n\t\t\t<tr>\r\n\t\t\t\t<td>Program Studi / Program Pendidikan</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=idprodi>\r\n\t\t\t\t\t\t ";
    foreach ( $arrayprodidep as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t\r\n\t\t\t\t</td>\r\n\t\t\t</tr>";
    if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
    {
        echo "\r\n     \t\t <tr class=judulform>\r\n    \t\t\t<td>Jenis Kelas Default </td>\r\n    \t\t\t<td>\r\n            <select name='jeniskelas' >\r\n             \r\n          ";
        foreach ( $arraykelasstei as $k => $v )
        {
            $selected = "";
            if ( $k == $d[JENISKELAS] )
            {
                $selected = "selected";
            }
            echo "<option value='{$k}' {$selected}>{$v}</option>";
        }
        echo "\r\n          </select>\r\n          \r\n          </td>\r\n    \t\t</tr>\r\n         ";
    }
    echo "\r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit name=aksi value='Lanjut' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t</table>\r\n\t\t</form>\r\n\t";
    if ( $aksitampil == "" )
    {
        if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
        {
            $jeniskelaskeuangan = 1;
            $qcolumn = " ,JENISKELAS  ";
            $qfield = " AND JENISKELAS!='' ";
        }
        $q = "SELECT  DISTINCT IDPRODI  FROM biayakomponen,prodi WHERE biayakomponen.IDPRODI=prodi.ID {$qfield} ORDER BY IDPRODI";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            echo "<br>";
            printjudulmenukecil( "<b>DAFTAR BIAYA KOMPONEN" );
            echo "\r\n      <table>\r\n        <tr class=juduldata>\r\n           <td><b>Program Studi</td>\r\n         </tr>";
            while ( $d = sqlfetcharray( $h ) )
            {
                echo "\r\n          \r\n            <tr>\r\n               <td><a href='index.php?pilihan={$pilihan}&aksi={$aksi}&aksitampil=prodi&idprodi={$d['IDPRODI']}'>".$arrayprodidep[$d[IDPRODI]]." </a></td>\r\n             </tr>\r\n          ";
            }
            echo "\r\n      </table>\r\n     ";
        }
    }
    else
    {
        if ( $aksitampil == "prodi" )
        {
            if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
            {
                $jeniskelaskeuangan = 1;
                $qcolumn = " ,JENISKELAS  ";
                $qfield = " AND JENISKELAS!='' ";
            }
            $q = "SELECT  COUNT(IDKOMPONEN) AS JUMLAH, IDPRODI,ANGKATAN,GELOMBANG {$qcolumn}\r\n    FROM biayakomponen,prodi \r\n    WHERE biayakomponen.IDPRODI=prodi.ID AND\r\n    prodi.ID='{$idprodi}' {$qfield}\r\n     GROUP BY\r\n     IDPRODI,ANGKATAN,GELOMBANG {$qcolumn}\r\n    ORDER BY ANGKATAN DESC,GELOMBANG {$qcolumn}";
            $h = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                echo "<br>";
                printjudulmenukecil( "<b>DAFTAR BIAYA KOMPONEN PROGRAM STUDI ".$arrayprodidep[$idprodi] );
                echo "\r\n      <table >\r\n        <tr class=juduldata align=center>\r\n           <td><b>Angkatan</td>\r\n           <td><b>Gelombang</td>";
                if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
                {
                    echo "\r\n           <td><b>Jenis Kelas</td>";
                }
                echo "\r\n           <td><b>Edit</td>\r\n         </tr>";
                while ( $d = sqlfetcharray( $h ) )
                {
                    echo "\r\n          \r\n            <tr>\r\n               <td align=center>{$d['ANGKATAN']}</td>\r\n               <td align=center>{$d['GELOMBANG']}</td>";
                    if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
                    {
                        echo "\r\n               <td align=center>".$arraykelasstei[$d[JENISKELAS]]."</td>";
                    }
                    echo "\r\n               <td align=center><a href='index.php?pilihan={$pilihan}&aksi=Lanjut&idprodi={$d['IDPRODI']}&angkatan={$d['ANGKATAN']}&gelombang={$d['GELOMBANG']}&jeniskelas={$d['JENISKELAS']}'>Edit</a></td>\r\n             </tr>\r\n          ";
                }
                echo "\r\n      </table>\r\n     ";
            }
        }
    }
}
?>
