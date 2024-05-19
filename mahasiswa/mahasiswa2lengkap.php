<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
set_time_limit(0);
$q = "SELECT * FROM msmhs WHERE NIMHSMSMHS='{$idupdate}'";
$h = doquery( $q, $koneksi );
if ( sqlnumrows( $h ) <= 0 )
{
    $q = "INSERT INTO msmhs (NIMHSMSMHS) VALUES ('{$idupdate}') ";
    doquery( $q, $koneksi );
    $q = "SELECT * FROM msmhs WHERE NIMHSMSMHS='{$idupdate}'";
    $h = doquery( $q, $koneksi );
}
$d2 = sqlfetcharray( $h );
$tmp = $d2[SMAWLMSMHS];
$tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
$semester = $tmp[4];
$tmp = $d2[BTSTUMSMHS];
$tahun2 = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
$semester2 = $tmp[4];
#echo "\r\n<tr>\r\n  <td  colspan=2><hr></td>\r\n</tr>\r\n<tr>\r\n  <td >Semester Awal Terdaftar Sebagai Mahasiswa</td>\r\n  <td>".$arraysemester[$semester]." {$tahun}  </td>\r\n</tr>\r\n<tr>\r\n  <td>Batas Studi</td>\r\n  <td>".$arraysemester[$semester2]." {$tahun2}  </td>\r\n</tr>\r\n<tr>\r\n  <td>Kode Propinsi Asal Pendidikan Terakhir</td>\r\n  <td>{$d2['ASSMAMSMHS']}\r\n  </td>\r\n</tr>\r\n<tr>\r\n  <td >Status Awal Mahasiswa Baru</td>\r\n  <td >\r\n  ".$arraystatusmhsbaru[$d2[STPIDMSMHS]]."\r\n  </td>\r\n</tr> \r\n<tr>\r\n  <td>Jumlah SKS Diakui u/ Mhs Baru/Pindahan</td>\r\n  <td>{$d2['SKSDIMSMHS']}</td>\r\n</tr>\r\n<tr>\r\n  <td>NIM Asal dari PT Sebelumnya (Pindahan)</td>\r\n  <td>{$d2['ASNIMMSMHS']}</td>\r\n</tr>\r\n<tr>\r\n  <td>Kode PT Sebelumnya (Pindahan)</td>\r\n  <td>{$d2['ASPTIMSMHS']}\r\n  </td>\r\n</tr>\r\n<tr>\r\n  <td>Jenjang PT Sebelumnya (Pindahan)</td>\r\n  <td>".$arrayjenjang[$d2[ASJENMSMHS]]."</td>\r\n</tr>\r\n<tr>\r\n  <td>Kode Program Studi Sebelumnya (Pindahan)</td>\r\n  <td>{$d2['ASPSTMSMHS']}  </td>\r\n</tr>\r\n\r\n<tr>\r\n  <td  colspan=2><hr></td>\r\n</tr>\r\n<tr>\r\n  <td  colspan=2><b> {$JUDULKHUSUSS3}</td>\r\n</tr>\r\n\r\n<tr>\r\n  <td>Kode Biaya Studi</td>\r\n  <td>{$d2['BISTUMSMHS']} (".$arraybiayastudi[$d2[BISTUMSMHS]].")</td>\r\n</tr>\r\n<tr>\r\n  <td>Kode Pekerjaan</td>\r\n  <td>{$d2['PEKSBMSMHS']} (".$arraykodepekerjaan[$d2[PEKSBMSMHS]].")</td>\r\n</tr>\r\n\r\n<tr>\r\n  <td>Nama Tempat Bekerja, bila bukan Dosen</td>\r\n  <td>{$d2['NMPEKMSMHS']}</td>\r\n</tr>\r\n\r\n<tr>\r\n  <td>Kode PT Tempat Bekerja, bila Dosen</td>\r\n  <td>{$d2['PTPEKMSMHS']}</td>\r\n</tr>\r\n<tr>\r\n  <td>Kode PS Tempat Bekerja, bila Dosen</td>\r\n  <td>{$d2['PSPEKMSMHS']}</td>\r\n</tr>\r\n\r\n\r\n<tr>\r\n  <td>NIDN Promotor</td>\r\n  <td>{$d2['NOPRMMSMHS']}</td>\r\n</tr>\r\n<tr>\r\n  <td>NIDN Ko-Promotor #1</td>\r\n  <td>{$d2['NOKP1MSMHS']}</td>\r\n</tr>\r\n<tr>\r\n  <td>NIDN Ko-Promotor #2</td>\r\n  <td>{$d2['NOKP2MSMHS']}</td>\r\n</tr>\r\n<tr>\r\n  <td>NIDN Ko-Promotor #3</td>\r\n  <td>{$d2['NOKP3MSMHS']}</td>\r\n</tr>\r\n<tr>\r\n  <td>NIDN Ko-Promotor #4</td>\r\n  <td>{$d2['NOKP4MSMHS']}</td>\r\n</tr>\r\n<tr>\r\n  <td  colspan=2><hr></td>\r\n</tr>\r\n\r\n";
/*echo "<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped2 table-bordered table-hover\">
								<tr> 
									<td  colspan=2><hr></td>
								</tr>";*/
echo "
								<tr>
									<td>Semester Awal Terdaftar Sebagai Mahasiswa</td>
									<td colspan=2>".$arraysemester[$semester]." {$tahun}  </td>
								</tr>
								<tr>
									<td>Batas Studi</td>
									<td colspan=2>".$arraysemester[$semester2]." {$tahun2}  </td>
								</tr>
								<tr>
									<td>Kode Propinsi Asal Pendidikan Terakhir</td>
									<td colspan=2>{$d2['ASSMAMSMHS']}</td>
								</tr>
								<tr>
									<td>Status Awal Mahasiswa Baru</td>
									<td colspan=2>".$arraystatusmhsbaru[$d2[STPIDMSMHS]]."</td>
								</tr>
								<tr>
									<td>Jumlah SKS Diakui u/ Mhs Baru/Pindahan</td>
									<td colspan=2>{$d2['SKSDIMSMHS']}</td>
								</tr>
								<tr>
									<td>NIM Asal dari PT Sebelumnya (Pindahan)</td>
									<td colspan=2>{$d2['ASNIMMSMHS']}</td>
								</tr>
								<tr>
									<td>Kode PT Sebelumnya (Pindahan)</td>
									<td colspan=2>{$d2['ASPTIMSMHS']}</td>
								</tr>
								<tr>
									<td>Jenjang PT Sebelumnya (Pindahan)</td>
									<td colspan=2>".$arrayjenjang[$d2[ASJENMSMHS]]."</td>
								</tr>
								<tr>
									<td>Kode Program Studi Sebelumnya (Pindahan)</td>
									<td colspan=2>{$d2['ASPSTMSMHS']}  </td>
								</tr>
								<tr>
									<td  colspan=3><hr></td>
								</tr>
								<tr>
									<td  colspan=3><b> {$JUDULKHUSUSS3}</td>
								</tr>
								<tr>
									<td>Kode Biaya Studi</td>
									<td colspan=2>{$d2['BISTUMSMHS']} (".$arraybiayastudi[$d2[BISTUMSMHS]].")</td>
								</tr>
								<tr>
									<td>Kode Pekerjaan</td>
									<td colspan=2>{$d2['PEKSBMSMHS']} (".$arraykodepekerjaan[$d2[PEKSBMSMHS]].")</td>
								</tr>
								<tr>
									<td>Nama Tempat Bekerja, bila bukan Dosen</td>
									<td colspan=2>{$d2['NMPEKMSMHS']}</td>
								</tr>
								<tr>
									<td>Kode PT Tempat Bekerja, bila Dosen</td>
									<td colspan=2>{$d2['PTPEKMSMHS']}</td>
								</tr>
								<tr>
									<td>Kode PS Tempat Bekerja, bila Dosen</td>
									<td colspan=2>{$d2['PSPEKMSMHS']}</td>
								</tr>
								<tr>
									<td>NIDN Promotor</td>
									<td colspan=2>{$d2['NOPRMMSMHS']}</td>
								</tr>
								<tr>
									<td>NIDN Ko-Promotor #1</td>
									<td colspan=2>{$d2['NOKP1MSMHS']}</td>
								</tr>
								<tr>
									<td>NIDN Ko-Promotor #2</td>
									<td colspan=2>{$d2['NOKP2MSMHS']}</td>
								</tr>
								<tr>
									<td>NIDN Ko-Promotor #3</td>
									<td colspan=2>{$d2['NOKP3MSMHS']}</td>
								</tr>
								<tr>
									<td>NIDN Ko-Promotor #4</td>
									<td colspan=2>{$d2['NOKP4MSMHS']}</td>
								</tr>
								<tr>
									<td  colspan=3><hr></td>
								</tr>
							";
							
?>
