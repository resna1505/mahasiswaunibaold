<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function getipk( $idmahasiswa, $tahun, $semester, $nilaidiambil = 1, $nilaikosong = 1 )
{
    global $koneksi;
    $q = "SELECT ID,ANGKATAN,STPIDMSMHS  STATUS FROM mahasiswa,msmhs WHERE ID='{$idmahasiswa}' AND mahasiswa.ID=msmhs.NIMHSMSMHS ";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $statuspindahan = $d[STATUS];
        $semestermahasiswa = ( $tahun - 1 - $d[ANGKATAN] ) * 2 + $semester;
        if ( $statuspindahan == "P" )
        {
            $q = "SELECT IDMAKUL,NAMAMAKUL AS NAMA,makul.JENIS, \r\n          SEMESTERMAKUL AS SEMESTER ,BOBOT ,NILAI AS SIMBOL,nilaikonversisp.SKS\r\n          FROM nilaikonversisp,makul\r\n          WHERE\r\n          nilaikonversisp.IDMAKUL=makul.ID\r\n          AND IDMAHASISWA='{$d['ID']}'\r\n          AND SEMESTERMAKUL<={$semestermahasiswa}\r\n          ORDER BY SEMESTERMAKUL,IDMAKUL";
            $hn2 = mysqli_query($koneksi,$q);
            do
            {
                if ( !( 0 < sqlnumrows( $hn2 ) ) || !( $dn2 = sqlfetcharray( $hn2 ) ) )
                {
                    $arraydatatranskrip2["{$dn2['IDMAKUL']}"] = $dn2;
                }
            } while ( 1 );
        }
        $q = "\r\n\t\t\t\tSELECT pengambilanmksp.IDMAKUL, pengambilanmksp.BOBOT,pengambilanmksp.NILAI,pengambilanmksp.SIMBOL,\r\n\t\t\t\tpengambilanmksp.SKSMAKUL SKS,\r\n\t\t\t\tmakul.NAMA,makul.JENIS,\r\n\t\t\t\tpengambilanmksp.SEMESTERMAKUL\r\n\t\t\t\tFROM pengambilanmksp,makul \r\n\t\t\t\tWHERE \r\n\t\t\t\tpengambilanmksp.IDMAKUL=makul.ID\r\n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\tAND CONCAT(pengambilanmksp.TAHUN,pengambilanmksp.SEMESTER)<='{$tahun}{$semester}' \r\n\t\t\t\tORDER BY SEMESTERMAKUL,IDMAKUL,pengambilanmksp.TAHUN ,pengambilanmksp.SEMESTER \r\n\t\t\t";
        $hn = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $hn ) )
        {
            while ( $d2 = sqlfetcharray( $hn ) )
            {
                if ( $nilaidiambil != 1 )
                {
                    if ( $arraydatatranskrip2["{$d2['IDMAKUL']}"][BOBOT] <= $d2[BOBOT] )
                    {
                        $arraydatatranskrip2["{$d2['IDMAKUL']}"] = $d2;
                    }
                }
                else
                {
                    $arraydatatranskrip2["{$d2['IDMAKUL']}"] = $d2;
                }
            }
            if ( $sp == 1 )
            {
                $q = "\r\n    \t\t\t\tSELECT   pengambilanmksp.IDMAKUL, pengambilanmksp.BOBOT,pengambilanmksp.NILAI,pengambilanmksp.SIMBOL,\r\n\t\t\t\t  pengambilanmksp.SKSMAKUL SKS,\r\n    \t\t\t\tmakul.NAMA,makul.JENIS,\r\n    \t\t\t\tpengambilanmksp.SEMESTERMAKUL SEMESTER\r\n    \t\t\t\tFROM pengambilanmksp,makul \r\n    \t\t\t\tWHERE \r\n    \t\t\t\tpengambilanmksp.IDMAKUL=makul.ID\r\n    \t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n    \t\t\t\tORDER BY pengambilanmksp.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER \r\n    \t\t\t";
                $hn3 = mysqli_query($koneksi,$q);
                if ( !( 0 < sqlnumrows( $hn3 ) ) || !( $d3 = sqlfetcharray( $hn3 ) ) )
                {
                }
                else if ( $nilaidiambil != 1 )
                {
                    if ( $arraydatatranskrip2["{$d3['IDMAKUL']}"][BOBOT] <= $d3[BOBOT] )
                    {
                        $arraydatatranskrip2["{$d3['IDMAKUL']}"] = $d3;
                    }
                }
                else
                {
                    $arraydatatranskrip2["{$d3['IDMAKUL']}"] = $d3;
                }
            }
            unset( $arraydatatranskrip );
            $arraydatatranskrip = $arraydatatranskrip2;
            $i = 1;
            $semlama = "";
            unset( $totals );
            if ( is_array( $arraydatatranskrip ) )
            {
                foreach ( $arraydatatranskrip as $k => $d2 )
                {
                    unset( $kp );
                    if ( $konversisemua == 0 )
                    {
                        unset( $kon );
                    }
                    $kelas = kelas( $i );
                    unset( $d2[TAHUN] );
                    unset( $d2[KELAS] );
                    unset( $ddmk );
                    $simbolmax = "-";
                    $bobot = 0;
                    $nilai = "";
                    $nilai2 = 0;
                    $bobot = $d2[BOBOT];
                    $nilai = $d2[SIMBOL];
                    $nilai2 = 0;
                    $simbolmax = $nilai;
                    if ( $nilaikosong == 1 || $nilai != "MD" && $nilai != "T" && $nilai != "" && $nilaikosong == 0 )
                    {
                        $totals += $d2[SEMESTER];
                        $bobots += $d2[SEMESTER];
                        $bobotsemua += $d2[SKS];
                        $totalsemua += $bobot * $d2[SKS];
                    }
                    else
                    {
                        $bobot = "";
                    }
                    ++$i;
                }
            }
            $hasil[0] = $totalsemua / @$bobotsemua;
            $hasil[1] = $bobotsemua;
        }
    }
    return $hasil;
}

function getips( $idmahasiswa, $tahun, $semester, $nilaidiambil = 1, $nilaikosong = 1 )
{
    global $koneksi;
    $q = "SELECT ID,ANGKATAN,STPIDMSMHS  STATUS FROM mahasiswa,msmhs WHERE ID='{$idmahasiswa}' AND mahasiswa.ID=msmhs.NIMHSMSMHS ";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $statuspindahan = $d[STATUS];
        $semestermahasiswa = ( $tahun - 1 - $d[ANGKATAN] ) * 2 + $semester;
        $q = "\r\n\t\t\t\tSELECT \r\n        pengambilanmksp.BOBOT,\r\n        pengambilanmksp.SIMBOL,\r\n        pengambilanmksp.IDMAKUL,\r\n\t\t\t\tpengambilanmksp.TAHUN,\r\n\t\t\t\tmakul.NAMA,pengambilanmksp.SKSMAKUL AS SKS,\r\n\t\t\t\tpengambilanmksp.SEMESTER AS SEMESTERS,\r\n\t\t\t\tpengambilanmksp.SEMESTERMAKUL AS SEMESTER \r\n\t\t\t\tFROM pengambilanmksp,makul \r\n\t\t\t\tWHERE \r\n\t\t\t\tpengambilanmksp.IDMAKUL=makul.ID\r\n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'  \r\n\t\t\t\tORDER BY pengambilanmksp.SEMESTERMAKUL,\r\n\t\t\t\tIDMAKUL\r\n\t\t\t";
        $hn = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $hn ) )
        {
            if ( $semester != 3 )
            {
                $semesterhitung = ( $tahun - 1 - $d[ANGKATAN] ) * 2 + $semester;
            }
            else
            {
                $semesterhitung = ( $tahun - 1 - $d[ANGKATAN] ) * 2 + 0.5;
            }
            $i = 1;
            $semlama = $semlast = 0;
            while ( $d2 = sqlfetcharray( $hn ) )
            {
                unset( $kp );
                if ( $d2[SEMESTERS] != 3 )
                {
                    $semesterhitungx = ( $d2[TAHUN] - 1 - $d[ANGKATAN] ) * 2 + $d2[SEMESTERS];
                }
                else
                {
                    $semesterhitungx = ( $d2[TAHUN] - 1 - $d[ANGKATAN] ) * 2 + 0.5;
                }
                $kelas = kelas( $i );
                $semlama = $semesterhitungx;
                $kelas = kelas( $i );
                $nilai = "";
                $total = "";
                $bobot = "";
                $nilaiakhir = $nilaiakhirdicari = $totalmax = $totalmaxdicari = $bobotmax = $bobotmaxdicari = $simbolmax = $simbolmaxdicari = "-";
                $nilaiakhir = $nilaiakhirdicari;
                $totalmax = $totalmaxdicari;
                $bobotmax = $bobotmaxdicari;
                $simbolmax = $simbolmaxdicari;
                if ( $nilaikosong == 1 || $d2[SIMBOL] != "MD" && $d2[SIMBOL] != "" && $d2[SIMBOL] != "T" && $nilaikosong == 0 )
                {
                    $totalnilaiakhir += $nilaiakhir;
                    $nilai = $d2[SIMBOL];
                    $bobot = $d2[BOBOT];
                    $total = number_format_sikad( $d2[SKS] * $d2[BOBOT], 2, ".", "," );
                    $totals += $semesterhitungx;
                    $totalsemua += $totalmax;
                    $bobots += $semesterhitungx;
                    $bobotsemua += $d2[SKS];
                }
                $bobots2 += $semesterhitungx;
                if ( $semesterhitung == $semesterhitungx )
                {
                    $idmakul = $d2[IDMAKUL];
                    ++$i;
                }
            }
            if ( $semlama != "" && $semesterhitungx == $semlama )
            {
                $hasil[1] = $bobots2[$semesterhitung];
                $hasil[0] = $totals[$semesterhitung] / @$bobots[$semesterhitung];
            }
        }
    }
    return $hasil;
}

periksaroot( );
?>
