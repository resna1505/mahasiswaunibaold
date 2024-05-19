<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
unset( $arraysort );
$arraysort[0] = "mahasiswa.IDPRODI";
$arraysort[1] = "mahasiswa.ANGKATAN";
$arraysort[2] = "mahasiswa.ID";
$arraysort[3] = "mahasiswa.NAMA";
$arraysort[4] = "mahasiswa.STATUS";
$arraysort[5] = "mahasiswa.IDDOSEN";
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $idprodi != "" )
{
    $qfield .= " AND mahasiswa.IDPRODI='{$idprodi}'";
    $qjudul .= " Jurusan/Program Studi '".$arrayprodi[$idprodi]."' <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
}
if ( $iddosen != "" )
{
    $qfield .= " AND mahasiswa.IDDOSEN='{$iddosen}'";
    $qjudul .= " Dosen Wali '".$arraydosen[$iddosen]."' <br>";
    $qinput .= " <input type=hidden name=iddosen value='{$iddosen}'>";
    $href .= "iddosen={$iddosen}&";
}
if ( $angkatan != "" )
{
    $qfield .= " AND mahasiswa.ANGKATAN='{$angkatan}'";
    $qjudul .= " Angkatan '{$angkatan}' <br>";
    $qinput .= " <input type=hidden name=angkatan value='{$angkatan}'>";
    $href .= "angkatan={$angkatan}&";
}
if ( $id != "" )
{
    $qfield .= " AND mahasiswa.ID LIKE '%{$id}%'";
    $qjudul .= " NIM mengandung kata  '{$id}' <br>";
    $qinput .= " <input type=hidden name=id value='{$id}'>";
    $href .= "id={$id}&";
}
if ( $nama != "" )
{
    $qfield .= " AND mahasiswa.NAMA LIKE '%{$nama}%'";
    $qjudul .= " Nama mengandung kata '{$nama}' <br>";
    $qinput .= " <input type=hidden name=nama value='{$nama}'>";
    $href .= "nama={$nama}&";
}
if ( $statusawal != "" )
{
    $qjudul .= " Status Awal '".$arraystatusmhsbaru["{$statusawal}"]."' <br>";
    $qinput .= " <input type=hidden name=statusawal value='{$statusawal}'>";
    $href .= "statusawal={$statusawal}&";
    $qfield .= " AND msmhs.STPIDMSMHS='{$statusawal}'";
}
if ( $status != "" )
{
    $qjudul .= " Status Mahasiswa '".$arraystatusmahasiswa["{$status}"]."' <br>";
    $qinput .= " <input type=hidden name=status value='{$status}'>";
    $href .= "status={$status}&";
    if ( $iftahunakademik == 1 )
    {
        $qtabel = ", trlsm ";
        $qtabel2 = " trlsm, ";
        $qfield .= "\r\n        AND mahasiswa.ID=trlsm.NIMHSTRLSM\r\n        AND trlsm.THSMSTRLSM='{$tahun2}{$semester2}' AND trlsm.STMHSTRLSM='{$status}'\r\n      ";
        $qjudul .= " Periode Tahun Akademik : {$tahun2}/".( $tahun2 + 1 )." ".$arraysemester[$semester2]." <br>";
        $qinput .= " \r\n      <input type=hidden name=iftahunakademik value='{$iftahunakademik}'>\r\n      <input type=hidden name=tahun2 value='{$tahun2}'>\r\n      <input type=hidden name=semester2 value='{$semester2}'>\r\n      ";
    }
    else
    {
        $qfield .= " AND mahasiswa.STATUS='{$status}'";
    }
}
if ( $jeniskelas != "" )
{
    $qfield .= " AND mahasiswa.JENISKELAS='{$jeniskelas}'";
    $qjudul .= " Jenis Kelas '".$arraykelasstei["{$jeniskelas}"]."' <br>";
    $qinput .= " <input type=hidden name=jeniskelas value='{$jeniskelas}'>";
    $href .= "jeniskelas={$jeniskelas}&";
}
if ( $tahuna != "" && $semestera != "" )
{
    $qfield .= " AND msmhs.SMAWLMSMHS='".$tahuna."{$semestera}'";
    $qjudul .= " Semester Awal '".$arraysemester["{$semestera}"]."  {$tahuna}' <br>";
    $qinput .= " <input type=hidden name=tahuna value='{$tahuna}'>";
    $qinput .= " <input type=hidden name=semestera value='{$semestera}'>";
    $href .= "semestera={$semestera}&tahuna={$tahuna}&";
}
include( "prosescari2.php" );
if ( $arraysort[$sort] == "" )
{
    $sort = 2;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(*) AS JML \r\n FROM msmhs {$qtabel} ,mahasiswa LEFT JOIN mahasiswa2 ON mahasiswa.ID=mahasiswa2.ID\r\n\tWHERE \r\n   mahasiswa.ID=msmhs.NIMHSMSMHS\r\n  \r\n   {$qprodidep2}\r\n\t{$qfield}\r\n\t";
$h = doquery($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
include( "../paginating.php" );
#$q = "SELECT mahasiswa.*,DATE_FORMAT(mahasiswa.TANGGAL,'%d-%m-%Y') TANGGAL \r\n  FROM msmhs {$qtabel} ,mahasiswa LEFT JOIN mahasiswa2 ON mahasiswa.ID=mahasiswa2.ID  \r\n\tWHERE \r\n  mahasiswa.ID=msmhs.NIMHSMSMHS\r\n   {$qprodidep2}\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
$q = "SELECT DATE_FORMAT(mahasiswa.TANGGALMASUK,'%d-%m-%Y') AS TANGGALMASUK,mahasiswa.ID,mahasiswa.IDCALONMAHASISWA,mahasiswa.KTP,mahasiswa.NAMA,mahasiswa.TEMPAT,mahasiswa.TANGGAL,mahasiswa.NAMAIBU,mahasiswa.NAMAAYAH,mahasiswa.KELAMIN,mahasiswa.AGAMA,mahasiswa.KTP,mahasiswa.HP,mahasiswa.PROVINSI,mahasiswa.ASAL,mahasiswa.TAHUNLULUS,mahasiswa.STATUS,DATE_FORMAT(mahasiswa.TANGGAL,'%d-%m-%Y') TANGGAL \r\n  FROM msmhs {$qtabel} ,mahasiswa LEFT JOIN mahasiswa2 ON mahasiswa.ID=mahasiswa2.ID  \r\n\tWHERE \r\n  mahasiswa.ID=msmhs.NIMHSMSMHS\r\n   {$qprodidep2}\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";

#echo $q;
$h = doquery($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    if ( $aksi != "cetak" )
    {
        printjudulmenu( "Data Mahasiswa" );
        printmesg( $qjudul );
    }
    else
    {
        printjudulmenucetak( "Data Mahasiswa" );
        printmesgcetak( $qjudul );
    }
    #echo "\r\n \t\t\t<table {$border} class=data{$aksi}>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n \t\t\t\t<td>NIM</td>\r\n\t\t\t\t<td>Nama</td>\r\n\t\t\t\t<td>Prodi</td>\r\n\t\t\t\t<td>Angkatan</td>\r\n\t\t\t\t<td>Alamat</td>\r\n\t\t\t\t<td>TTL</td>\r\n\t\t\t\t<td>Kelamin</td>\r\n\t\t\t\t<td>Agama</td>\r\n\t\t\t\t<td>Telepon</td>\r\n\t\t\t\t<td>HP</td>\r\n\t\t\t\t<td>Email</td>\r\n\t\t\t\t<td>Asal Sekolah</td>\r\n\t\t\t\t<td>Tahun Lulus</td>\r\n\t\t\t\t<td>Status</td>\r\n\t\t\t\t<td>Dosen Wali</td>";
    echo "\r\n \t\t\t<table {$border} class=data{$aksi}>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n \t\t\t\t<td>Nama</td>\r\n\t\t\t\t<td>NIM</td>\r\n\t\t\t\t<td>Tempat Lahir</td>\r\n\t\t\t\t<td>Tanggal Lahir</td>\r\n\t\t\t\t<td>Nama Ibu</td><td>Nama Ayah</td>\r\n\t\t\t\t<td>Jenis Kelamin</td>\r\n\t\t\t\t<td>Agama</td>\r\n\t\t\t\t<td>NIK</td>\r\n\t\t\t\t<td>Kelurahan</td>\r\n\t\t\t\t<td>Kecamatan</td><td>HP</td><td>SKS</td><td>Provinsi</td><td>Asal Sekolah</td>\r\n\t\t\t\t<td>Tahun Lulus</td><td>Ukuran Jas Almamater</td><td>Status</td><td>Tanggal Masuk</td>";
    
    if ( $tingkataksesusers[$kodemenu] == "T" )
    {
        echo "\r\n\t\t\t\t\t\t\t<td nowrap colspan=2 width=20%>Aksi</td>\r\n\t\t\t\t\t\t\t";
    }
    echo "\r\n\t\t\t</tr>\r\n\t\t";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
		$sql_tabel_calon="SELECT KELURAHAN,KECAMATAN,JASALMAMATER,KTP FROM calonmahasiswa WHERE ID='{$d['IDCALONMAHASISWA']}'";
		#echo $sql_tabel_calon;
		$h_tabel_calon = mysqli_query($koneksi,$sql_tabel_calon);
		$d_tabel_calon = sqlfetcharray( $h_tabel_calon );

		if(!empty($d_tabel_calon['KTP'])){
			$ktpnya=$d_tabel_calon['KTP'];
		}else{
			$ktpnya=$d['KTP'];
		}
		
		//get SKS TOTAL from trakm
		$sql_sks_total="SELECT SKSTTTRAKM AS SKSTOTAL FROM trakm WHERE NIMHSTRAKM='{$d['ID']}' AND NLIPKTRAKM!=0 order by THSMSTRAKM DESC LIMIT 1";
		#echo $sql_sks_total;
		$h_sks_total = mysqli_query($koneksi,$sql_sks_total);
		$d_sks_total = sqlfetcharray( $h_sks_total );
	
        $kelas = kelas( $i );
        #echo "\r\n\t\t\t\t<tr valign=top align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n  \t\t\t\t\t<td align=left><a class='{$cetak}' href='index.php?pilihan=lengkap&id={$d['ID']}'>{$d['ID']}</td>\r\n \t\t\t\t\t<td nowrap align=left>{$d['NAMA']}</td>\r\n\t\t\t\t\t<td nowrap align=left>".$arrayprodi[$d[IDPRODI]]."</td>\r\n \t\t\t\t\t<td  >{$d['ANGKATAN']}</td>\r\n\t \t\t\t\t<td align=left>".nl2br( $d[ALAMAT]."\n".$d[KOTA].",".$d[PROVINSI] )."</td>\r\n\t\t\t\t\t<td align=left nowrap> {$d['TEMPAT']},{$d['TANGGAL']}</td>\r\n\t\t\t\t\t<td>{$d['KELAMIN']}</td>\r\n\t\t\t\t\t<td>".$arrayagama[$d[AGAMA]]."</td>\r\n\t\t\t\t\t<td align=left>{$d['TELEPON']}</td>\r\n\t\t\t\t\t<td align=left>{$d['HP']}</td>\r\n\t\t\t\t\t<td align=left>{$d['EMAIL']}</td>\r\n\t\t\t\t\t<td align=left>{$d['ASAL']}</td>\r\n\t\t\t\t\t<td>{$d['TAHUNLULUS']}</td>\r\n\t\t\t\t\t<td align=left>".$arraystatusmahasiswa[$d[STATUS]]."</td>\r\n \t\t\t\t\t<td align=left>".$arraydosen[$d[IDDOSEN]]."</td>";
        echo "\r\n\t\t\t\t<tr valign=top align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td><td nowrap align=left>{$d['NAMA']}</td><td align=left><a class='{$cetak}' href='index.php?pilihan=lengkap&id={$d['ID']}'>{$d['ID']}</td><td align=left nowrap> {$d['TEMPAT']}</td><td align=left nowrap> {$d['TANGGAL']}</td><td align=left nowrap> {$d['NAMAIBU']}</td><td align=left nowrap> {$d['NAMAAYAH']}</td><td>{$d['KELAMIN']}</td><td>".$arrayagama[$d[AGAMA]]."</td><td>{$ktpnya}</td><td>{$d_tabel_calon['KELURAHAN']}</td><td>".$arraykecamatan{$d_tabel_calon['KECAMATAN']}."</td><td>{$d['HP']}</td><td>{$d_sks_total['SKSTOTAL']}</td><td align=left>{$d['PROVINSI']}</td><td align=left>{$d['ASAL']}</td><td>{$d['TAHUNLULUS']}</td><td>".$arraybaju[$d_tabel_calon['JASALMAMATER']]."</td><td align=left>".$arraystatusmahasiswa[$d[STATUS]]."</td><td align=left>{$d['TANGGALMASUK']}</td>";
        
	if ( $tingkataksesusers[$kodemenu] == "T" )
        {
            echo "\r\n\t\t\t\t\t\t\t\t<td   align=center><a href='index.php?pilihan={$pilihan}&aksi=formupdate&idupdate={$d['ID']}'>Update</td>\r\n\t\t\t\t\t\t\t\t<td   align=center ><a \r\n\t\t\t\t\t\t\t\tonclick=\"return confirm('Hapus Data Mahasiswa Dengan NIM = {$d['ID']} ? Seluruh data mata kuliah yang diambil dan nilainya juga akan dihapus');\"\r\n\t\t\t\t\t\t\t\thref='{$href}&aksi=hapus&idhapus={$d['ID']}'>Hapus</td>\r\n\t\t\t\t\t\t\t\t";
        }
        echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
    echo "</table>";
    if ( !( $tahuna != "" && $semestera != "" ) )
    {
        include( "prosestampillengkap2.php" );
    }
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Mahasiswa Tidak Ada";
    $aksi = "";
}
?>
