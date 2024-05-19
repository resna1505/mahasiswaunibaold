<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $aksi == "update" )
{
    if ( $aksi2 == "Hapus" && $REQUEST_METHOD == POST && is_array( $dataupdate ) )
    {
        foreach ( $dataupdate as $k => $v )
        {
            foreach ( $v as $k2 => $v2 )
            {
                echo $q = "\r\n  \t\t\t\t\tDELETE FROM trskr\r\n  \t\t\t\t\tWHERE\r\n  \t\t\t\t\tNIMHSTRSKR='{$idupdate}'\r\n  \t\t\t\t\tAND NORUTTRSKR='{$k2}' AND\r\n  \t\t\t\t\tTHSMSTRSKR='{$k}'\r\n  \t\t\t\t";
                doquery($koneksi,$q);
            }
        }
        $errmesg = "Data Skripsi Mahasiswa berhasil dihapus";
    }
    if ( $aksi2 == "Simpan" && $REQUEST_METHOD == POST && is_array( $dataupdate ) )
    {
        foreach ( $dataupdate as $k => $v )
        {
            foreach ( $v as $k2 => $v2 )
            {
                $q = "SELECT IDPRODI FROM mahasiswa WHERE ID='{$idupdate}'";
                $h = doquery($koneksi,$q);
                $d = sqlfetcharray( $h );
                $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$d['IDPRODI']}'";
                $h = doquery($koneksi,$q);
                if ( 0 < sqlnumrows( $h ) )
                {
                    $d = sqlfetcharray( $h );
                    $idpt = $d[KDPTIMSPST];
                    $kodejenjang = $d[KDJENMSPST];
                    $kodeps = $d[KDPSTMSPST];
                }
                $q = " UPDATE trskr SET\r\n\t\t\t   KDPTITRSKR='{$idpt}',\r\n         KDPSTTRSKR='{$kodeps}',\r\n         KDJENTRSKR ='{$kodejenjang}', \r\n          JUDULTRSKR ='".$datarp[$k][$k2][skripsi]."'    ,\r\n          THSMSTRSKR='".$datarp[$k][$k2][tahun]."".$datarp[$k][$k2][semester]."'\r\n\r\n \t\t\t   \r\n          WHERE NIMHSTRSKR ='{$idupdate}' AND NORUTTRSKR='{$k2}'  AND\r\n  \t\t\t\t\tTHSMSTRSKR='{$k}'\r\n         ";
                doquery($koneksi,$q);
            }
        }
        $errmesg = "Data Skripsi Mahasiswa berhasil disimpan";
    }
    if ( $aksi2 == "Tambah" && $REQUEST_METHOD == POST )
    {
        if ( trim( $skripsi ) == "" )
        {
            $errmesg = "Judul Skripsi harus diisi";
        }
        else
        {
            $q = "SELECT IDPRODI FROM mahasiswa WHERE ID='{$idupdate}'";
            $h = doquery($koneksi,$q);
            $d = sqlfetcharray( $h );
            $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$d['IDPRODI']}'";
            $h = doquery($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                $d = sqlfetcharray( $h );
                $idpt = $d[KDPTIMSPST];
                $kodejenjang = $d[KDJENMSPST];
                $kodeps = $d[KDPSTMSPST];
            }
            $idbaru = getnewidsyarat( "NORUTTRSKR", "trskr", "\r\n          WHERE NIMHSTRSKR='{$idupdate}' AND THSMSTRSKR='{$tahun}{$semester}'\r\n          " );
            $q = " INSERT INTO trskr \r\n\t\t\t   (THSMSTRSKR,KDPTITRSKR,KDJENTRSKR,KDPSTTRSKR,\r\n\t\t\t   NIMHSTRSKR ,NORUTTRSKR ,JUDULTRSKR)\r\n\t\t\t   VALUES\r\n         ('{$tahun}{$semester}','{$idpt}','{$kodejenjang}','{$kodeps}','{$idupdate}',\r\n         '{$idbaru}','{$skripsi}' )\r\n         ";
            doquery($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Data Skripsi Mahasiswa berhasil disimpan";
                $data = "";
                $strata = $gelar = $bidangilmu = $kodept = $namapt = $kotaasal = $kodenegara = "";
            }
            else
            {
                $errmesg = "Data Skripsi Mahasiswa tidak disimpan";
            }
        }
    }
}
if ( $aksi == "formupdate" )
{
    $q = "SELECT ID,NAMA FROM mahasiswa WHERE ID='{$idupdate}'";
    $h = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        printmesg( $errmesg );
        $d = sqlfetcharray( $h );
        echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tab", "{$tab}", "" )." <tr class=judulform>\r\n\t\t\t<td width=100><b>NIM Mahasiswa </td>\r\n\t\t\t<td><b>{$d['ID']}</td>\r\n\t\t</tr> \r\n \t\t<tr class=judulform>\r\n\t\t\t<td><b>Nama Mahasiswa </td>\r\n\t\t\t<td><b>{$d['NAMA']}</td>\r\n\t\t\t</tr> \r\n\t\t</table>\r\n \t\t\r\n \t\t<table border=1  class=form>\r\n<tr>\r\n  <td >Tahun/Semester Pelaporan Data</td>\r\n  <td >\r\n";
        $waktu = getdate( );
        echo "\r\n\t\t\t\t\t\t<select name=tahun class=masukan> \r\n\t\t\t\t\t\t ";
        $selected = "";
        $i = 1901;
        while ( $i <= $waktu[year] + 5 )
        {
            if ( $i == $waktu[year] )
            {
                $selected = "selected";
            }
            echo "\r\n\t\t\t\t\t\t\t<option value='{$i}'  {$selected}>".$i."/".( $i + 1 )."</option>\r\n\t\t\t\t\t\t\t";
            $selected = "";
            ++$i;
        }
        echo "\r\n\t\t\t\t\t\t</select>/\r\n\t\t\t\t\t\t<select name=semester class=masukan> \r\n\t\t\t\t\t\t ";
        unset( $arraysemester[3] );
        foreach ( $arraysemester as $k => $v )
        {
            if ( $k == $semester2 )
            {
                $selected = "selected";
            }
            echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$selected}>{$v}</option>\r\n\t\t\t\t\t\t\t";
            $selected = "";
        }
        echo "\r\n\t\t\t\t\t\t</select>\r\n  \r\n  \r\n  </td>\r\n</tr> \r\n \t\t\t<tr class=judulform>\r\n\t\t\t\t<td width=200 >Judul Skripsi</td>\r\n\t\t\t\t<td>".createinputtextarea( "skripsi", $skripsi, " class=masukan  cols=40 rows=4" )."</td>\r\n\t\t\t</tr>  \t\t\r\n \r\n  \t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit name=aksi2 value='Tambah' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \t\t</table>\r\n \t\t\r\n\t\t";
        $q = "SELECT * FROM trskr WHERE NIMHSTRSKR='{$idupdate}' \r\n        ORDER BY THSMSTRSKR DESC, NORUTTRSKR";
        $h = doquery($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            echo "\r\n\t\t\t<br>\r\n\t\t\t\t<table {$border} class=data >\r\n\t\t\t\t\t<tr  >\r\n \t\t\t\t\t\t<td align=right colspan=4>\r\n \t\t\t\t\t\t<input type=submit name=aksi2 value='Simpan' class=masukan>\r\n \t\t\t\t\t\t<input type=submit name=aksi2 value='Hapus' class=masukan>\r\n \t\t\t\t\t\t</td>\r\n\t\t\t\t\t</tr>\t\t\t\t\t\r\n\t\t\t\t\t<tr class=juduldata  align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n \t\t\t\t\t\t<td>Tahun/Semester Pelaporan</td>\r\n\t\t\t\t\t\t<td>Judul Skripsi</td>\r\n \r\n\t\t\t\t\t\t<td>Pilih</td>\r\n\t\t\t\t\t</tr>";
            $i = 1;
            while ( $d = sqlfetcharray( $h ) )
            {
                $kelas = kelas( $i );
                $tmp = $d[THSMSTRSKR];
                $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
                $semester = $tmp[4];
                echo "\r\n\t\t\t\t\t<tr {$kelas} >\r\n\t\t\t\t\t\t<td>{$i} </td>\r\n \t\t\t\t\t\t<td align=center>\r\n             ".createinputselect( "datarp[{$d['THSMSTRSKR']}][{$d['NORUTTRSKR']}][semester]", $arraysemester, $semester, "", " class=masukan  " )."\r\n             ".createinputtahun( "datarp[{$d['THSMSTRSKR']}][{$d['NORUTTRSKR']}][tahun]", $tahun, " class=masukan  " )."\r\n             </td>\r\n\t\t\t\t\t\t<td>".createinputtext( "datarp[{$d['THSMSTRSKR']}][{$d['NORUTTRSKR']}][skripsi]", $d[JUDULTRSKR], " class=masukan  size=40" )."</td>\r\n \t\t\t\t\t\t<td align=center><input type=checkbox name='dataupdate[{$d['THSMSTRSKR']}][{$d['NORUTTRSKR']}]' value=1></td>\r\n\t\t\t\t\t</tr>";
                ++$i;
            }
            echo "\r\n\t\t\t\t</table>\r\n\t\t\t";
        }
        else
        {
            echo "<p>";
            printmesg( "Data Skripsi tidak ada" );
            echo "</p>";
        }
        echo "\r\n\t\t</form>\r\n\t\t\r\n\t\t";
    }
    else
    {
        $errmesg = "Data Mahasiswa dengan ID = '{$idupdate}' tidak ada";
        $aksi = "";
    }
}
?>
