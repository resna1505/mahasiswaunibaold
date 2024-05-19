<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $jenisusers != 0 )
{
    exit( );
}
include( "fungsinilai.php" );
if ( $id != "" )
{
    $qfield .= " AND mahasiswa.ID = '{$id}'";
    $qjudul .= " NIM  '{$id}' <br>";
    $qinput .= " <input type=hidden name=id value='{$id}'>";
    $href .= "id={$id}&";
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
$q = "SELECT mahasiswa.*,prodi.SKSMIN , \r\n\tprodi.IDDEPARTEMEN, \tprodi.TINGKAT,\r\n\tdepartemen.IDFAKULTAS ,msmhs.SMAWLMSMHS\r\n\tFROM mahasiswa,prodi,departemen   ,msmhs\r\n\tWHERE 1=1 {$qprodidep5} AND\r\n\tmahasiswa.ID=msmhs.NIMHSMSMHS AND\r\n\tmahasiswa.IDPRODI=prodi.ID AND\r\n\tprodi.IDDEPARTEMEN=departemen.ID\r\n\t{$qfieldtambahan2}\r\n\t{$qfield}\r\n\t{$qfieldx1}\r\n\tORDER BY {$sort} {$qlimit}";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    if ( $aksi != "cetak" )
    {
        printmesg( "Edit Nilai Mahasiswa" );
        #echo "{$tpage} {$tpage2}";
    }
    $totalsemua = 0;
    $bobotsemua = 0;
    $totals = "";
    $bobots = "";
    #do
    #{
        while ( $d = sqlfetcharray( $h ) )
        {
            $tipemasuk = substr( $d[SMAWLMSMHS], 4, 1 );
            $semester = 1;
            $tahun = $d[ANGKATAN] + 1;
            $totalsemua = 0;
            $bobotsemua = 0;
            $totals = "";
            $bobots = "";
            $semesterhitung = $kurawal = $kurakhir = "";
            if ( $semester != 3 )
            {
                $semesterhitung = ( $tahun - 1 - $d[ANGKATAN] ) * 2 + $semester;
                $kurawal = "(";
                $kurakhir = ")";
            }
            if ( $aksi == "cetak" )
            {
                echo "<center>\r\n\t\t\t<h3>{$JUDULKHS} </h3>\r\n\t\t\tTahun Akademik ".( $tahun - 1 )."/{$tahun} ".$arraysemester[$semester]." <br><br>";
            }
            $idmahasiswa = $d[ID];
            $sem = $semester;
            $tahunlama = $tahun;
            /*echo " \r\n\t\t\t\r\n\t\t\t\t<center>\r\n\t\t\t<table   width=600  >\r\n\t\t\t\t<tr valign=top>\r\n\t\t\t\t<td width=50%>\r\n\t\t\t\t<table    >\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Nama</td>\r\n\t\t\t\t\t\t<td>: {$d['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left >\r\n\t\t\t\t\t\t<td class=judulform>NIM</td>\r\n\t\t\t\t\t\t<td>: {$d['ID']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Angkatan</td>\r\n\t\t\t\t\t\t<td>: {$d['ANGKATAN']} </td>\r\n\t\t\t\t\t</tr>\r\n \t\t\t\t</table>\r\n\t\t\t</td>\r\n\t\t\t<td  width=50%>\r\n\r\n\t\t\t\t<table    >\r\n \t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Fakultas</td>\r\n\t\t\t\t\t\t<td>: ".$arrayfakultas[$d[IDFAKULTAS]]."</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Jurusan</td>\r\n\t\t\t\t\t\t<td>: ".$arraydepartemen[$d[IDDEPARTEMEN]]."</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Program Studi</td>\r\n\t\t\t\t\t\t<td>: ".$arrayprodi[$d[IDPRODI]]." (".$arrayjenjang[$d[TINGKAT]].") </td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t</table>\t\t\t\t\r\n\t\t\t\t\r\n\t\t\t</td>\r\n\t\t</table>\r\n\t \r\n\t\t\t";
            */
			echo "	<div class='portlet-body form'>	
						<div class=\"table-scrollable\">
							<table class=\"table table-striped table-bordered table-hover\">"."
								<tr align=left>\r\n\t\t\t\t\t\t<td>Nama</td>\r\n\t\t\t\t\t\t<td>: {$d['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left >\r\n\t\t\t\t\t\t<td class=judulform>NIM</td>\r\n\t\t\t\t\t\t<td>: {$d['ID']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Angkatan</td>\r\n\t\t\t\t\t\t<td>: {$d['ANGKATAN']} </td>\r\n\t\t\t\t\t</tr><tr align=left>\r\n\t\t\t\t\t\t<td>Fakultas</td>\r\n\t\t\t\t\t\t<td>: ".$arrayfakultas[$d[IDFAKULTAS]]."</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Jurusan</td>\r\n\t\t\t\t\t\t<td>: ".$arraydepartemen[$d[IDDEPARTEMEN]]."</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Program Studi</td>\r\n\t\t\t\t\t\t<td>: ".$arrayprodi[$d[IDPRODI]]." (".$arrayjenjang[$d[TINGKAT]].") </td>\r\n\t\t\t\t\t</tr>
							</table>
						</div>
					</div>";	
			$angkatanmhs = $d[ANGKATAN];
            $idmahasiswa = $d[ID];
            if ( 0 < $semesterhitung )
            {
                $plus1 = 0;
                if ( $tipemasuk == 2 )
                {
                    $plus1 = 0 - 1;
                }
                include( "nilaimahasiswa.php" );
            }
            if ( $aksi != "cetak" )
            {
               # echo "<hr>";
            }
        }
   # } while ( 1 );
}else{
$errmesg = "Data mahasiswa tidak ada";
$aksi = "tambahawalm";
}
?>
