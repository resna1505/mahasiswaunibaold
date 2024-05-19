<?php
error_reporting(E_ALL    & ~E_NOTICE);

function periksaroot( )
{
    global $root;
    if ( !( $root == "../" ) )
    {
        $root = "./";
    }
}

function session_is_registered_sikad( $var )
{
    return isset( $_SESSION[$var] );
}

unset( $arraysort );
$arraysort[0] = "jadwalkuliah.IDMAKUL";
$arraysort[1] = "jadwalkuliah.KELAS";
$arraysort[2] = "jadwalkuliah.IDRUANGAN";
$arraysort[3] = "jadwalkuliah.HARI";
$arraysort[4] = "jadwalkuliah.MULAI";
$arraysort[5] = "jadwalkuliah.SELESAI";
$arraysort[6] = "jadwalkuliah.RENCANA";
$arraysort[7] = "jadwalkuliah.TIM";
$arraysort[8] = "jadwalkuliah.IDPRODI";

if ( $_GET['root'] != "" )
{
    $root = "";
}
if ( $_POST['root'] != "" )
{
    $root = "";
}
unset( $_GET['root'] );
unset( $_POST['root'] );
unset( $_GET['root'] );
unset( $_POST['root'] );

include "../db.php";
$koneksi = mysqli_connect($hostsql, $loginsql, $passwordsql, $basisdatasql,$portsql );
if ( !$koneksi )
{
    echo "Error koneksi ke basis data. Periksa apakah server basis data telah dihidupkan.  Hubungi Administrator Anda";
    exit();
}
#mysqli_select_db( $basisdatasql, $koneksi );

function getnamafromtabel( $id, $tabel )
{
    global $koneksi;
    $q = "SELECT NAMA FROM {$tabel} WHERE ID='{$id}'";
    $h = mysqli_query($koneksi,$q);
    $nama = "";
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $nama = $d[NAMA];
    }
    return $nama;
}
function getfield( $field, $tabel, $syarat )
{
    global $koneksi;
    $q = "SELECT {$field} FROM {$tabel} {$syarat}";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
    }
    return $d[$field];
}
mysqli_query( $koneksi,"SET time_zone='{$offset}';" );

include "../arrayakademik.php";
#include "array.php";
#include "../arraydikti.php";
#include "../arraylog.php";

include "init.php";

//Get Parameter
$tahun=$_GET["tahun"];
$semester=$_GET["semester"];
$iddepartemen=$_GET["iddepartemen"];
$makul=$_GET["makul"];
$kelasjadwal=$_GET["kelasjadwal"];
$hari=$_GET["hari"];
#echo $tahun;exit();

if ( $semester != "" && $semester != 'undefined' )
{
    $qfield .= " AND jadwalkuliah.SEMESTER='{$semester}'";
    $qjudul .= " Semester  ".$arraysemester[$semester]."";
    $qinput .= " <input type=hidden name=semester value='{$semester}'>";
    $href .= "semester={$semester}&";
}
if ( $tahun != "" && $tahun != 'undefined')
{
	$thntrnlm=($tahun-1).$semester;
    $qfield .= " AND jadwalkuliah.TAHUN='{$tahun}' AND trnlm.THSMSTRNLM='{$thntrnlm}'";
    #$qfield .= " AND jadwalkuliah.TAHUN='{$tahun}' AND trnlm.THSMSTRNLM='{$tahun-1}'";
    $qjudul .= " Tahun Akademik  ".( $tahun - 1 )."/{$tahun}";
    $qinput .= " <input type=hidden name=tahun value='{$tahun}'>";
    $href .= "tahun={$tahun}&";
}
if ( $iddepartemen != "" && $iddepartemen != 'undefined')
{
    $qfield .= " AND jadwalkuliah.IDPRODI='{$iddepartemen}'";
    $qjudul .= " Jurusan/Program Studi '".$arrayprodidep[$iddepartemen]."'";
    $qinput .= " <input type=hidden name=iddepartemen value='{$iddepartemen}'>";
    $href .= "iddepartemen={$iddepartemen}&";
}
if ( $makul != "" && $makul != 'undefined')
{
    $qfield .= " AND IDMAKUL = '{$makul}'";
    $qjudul .= " ID MAKUL = {$makul} (".getnamafromtabel( $makul, "makul" ).") ";
    $qinput .= " <input type=hidden name=makul value='{$makul}'>";
    $href .= "makul={$makul}&";
}
if ( $kelasjadwal != "" && $kelasjadwal != 'undefined')
{
    $qfield .= " AND KELAS = '{$kelasjadwal}'";
    $qjudul .= " Kelas = '".$arraylabelkelas[$kelasjadwal]."'";
    $qinput .= " <input type=hidden name=kelasjadwal value='{$kelasjadwal}'>";
    $href .= "kelasjadwal={$kelasjadwal}&";
}
if ( $hari != "" && $hari != 'undefined')
{
    $qfield .= " AND HARI='{$hari}'";
    $qjudul .= " Hari '".$arrayhari[$hari]."'";
    $qinput .= " <input type=hidden name=hari value='{$hari}'>";
    $href .= "hari={$hari}&";
}

if ( $arraysort[$sort] == "" )
{
    $sort = 0;
}
/*if ( $tahunmasuk != "" )
{
    $qfield .= " TAHUN='{$tahunmasuk}'";
    $qjudul .= " Tahun Masuk '{$tahunmasuk}' <br>";
    $qinput .= " <input type=hidden name=tahunmasuk value='{$tahunmasuk}'>";
    $href .= "tahunmasuk={$tahunmasuk}&";
}*/

//Loading Excel Library 
/*$excel = new PHPExcel();
ob_start();
$excel->setActiveSheetIndex(0);
$excel->getActiveSheet()->setTitle('Jadwal Kuliah');

//Setting display
//for title
$styleArray = array(
    'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            
        )
                    
);

$styleArray2 = array(
	    'borders' => array(
		'allborders' => array(
		    'style' => PHPExcel_Style_Border::BORDER_THIN
		)
	    ),
	    'alignment' => array(
		'vertical' 	 => PHPExcel_Style_Alignment::VERTICAL_TOP
	    )	
	);

//Get Data
//Title
$excel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($styleArray);
$excel->getActiveSheet()->setCellValue('A1', 'Data Jadwal Kuliah');
$excel->getActiveSheet()->mergeCells('A1:L1');
$excel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);
$excel->getActiveSheet()->getStyle("A1:L1")->getFont()->setSize(16);

$excel->getActiveSheet()->setCellValue('A2', $qjudul);
$excel->getActiveSheet()->mergeCells('A2:L2');
$excel->getActiveSheet()->getStyle('A2:L2')->getFont()->setBold(true);
$excel->getActiveSheet()->getStyle("A2:L2")->getFont()->setSize(12);

foreach(range('A','X') as $columnID) {
    $excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}

//Attribut
$excel->getActiveSheet()->getStyle('A5:L5')->applyFromArray($styleArray2);
$excel->getActiveSheet()->setCellValue('A5', 'No');
$excel->getActiveSheet()->setCellValue('B5', 'Prodi');
$excel->getActiveSheet()->setCellValue('C5', 'Kode MK');
$excel->getActiveSheet()->setCellValue('D5', 'Mata Kuliah');
$excel->getActiveSheet()->setCellValue('E5', 'Kelas');
$excel->getActiveSheet()->setCellValue('F5', 'Ruangan');
#$excel->getActiveSheet()->setCellValue('G5', 'Hari');
$excel->getActiveSheet()->setCellValue('G5', 'Tanggal');
$excel->getActiveSheet()->setCellValue('H5', 'Jam Mulai');
$excel->getActiveSheet()->setCellValue('I5', 'Jam Selesai');
$excel->getActiveSheet()->setCellValue('J5', 'Rencana Tatap Muka');
#$excel->getActiveSheet()->setCellValue('K5', 'Jumlah Mahasiswa');
#$excel->getActiveSheet()->setCellValue('L5', 'Tim Pengajar');
$excel->getActiveSheet()->setCellValue('K5', 'Tim Pengajar');*/
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Data Jadwal Kuliah');
$sheet->mergeCells('A1:L1');
$sheet->setCellValue('A2', $qjudul);
$sheet->mergeCells('A2:L2');
foreach (range('A','X') as $col) {
   $sheet->getColumnDimension($col)->setAutoSize(true);
}

$sheet->setCellValue('A3', 'Nama');
$sheet->setCellValue('A5', 'No');
$sheet->setCellValue('B5', 'Prodi');
$sheet->setCellValue('C5', 'Kode MK');
$sheet->setCellValue('D5', 'Mata Kuliah');
$sheet->setCellValue('E5', 'Kelas');
$sheet->setCellValue('F5', 'Ruangan');
#$sheet->setCellValue('G5', 'Hari');
$sheet->setCellValue('G5', 'Tanggal');
$sheet->setCellValue('H5', 'Jam Mulai');
$sheet->setCellValue('I5', 'Jam Selesai');
$sheet->setCellValue('J5', 'Rencana Tatap Muka');
$sheet->setCellValue('K5', 'Tim Pengajar');
/*
$p =$_REQUEST["hal"];
$limit =$_REQUEST["limit"];

$p=(!$p)?0:$p-1;
$limit=(!$limit)?10:$limit;

//Content
#$q = "SELECT jadwalkuliah.* \n   FROM jadwalkuliah \n\t WHERE 1=1  \n\t {$qfield}\n\tORDER BY ".$arraysort[$sort]." LIMIT ".$p.",".$limit;
$q = "SELECT jadwalkuliah.*,COUNT( trnlm.NIMHSTRNLM) AS PESERTA FROM jadwalkuliah 
JOIN trnlm ON jadwalkuliah.IDMAKUL=trnlm.KDKMKTRNLM WHERE 1=1 {$qfield} GROUP BY IDPRODI,IDMAKUL,MULAI ORDER BY ".$arraysort[$sort]." LIMIT ".$p.",".$limit;
#echo $q;exit();
$r = mysqli_query($koneksi,$q) or die("Error : ".mysqli_error($koneksi));
if(mysqli_num_rows($r) > 0 ) {
    $y = 6;$no=1;
    while($data = mysqli_fetch_array($r)) {
		#$kelas = kelas($no);
		$tmp = explode( "\n", $data['TIM'] );
        $timpengajar = "";
        foreach ( $tmp as $k => $v )
        {
            $timpengajar .= "{$v} / ".getfield( "NAMA", "dosen", "WHERE ID='".trim( $v )."'" )."\n";
        }
	
		$tanggalajar=explode( "-", $data['TANGGAL'] );
		$tanggalajar=$tanggalajar[2]."-".$tanggalajar[1]."-".$tanggalajar[0];
        
        #$excel->getActiveSheet()->getStyle('A'.$y.':L'.$y)->applyFromArray($styleArray2);
        $sheet->setCellValue('A'.$y, $no);
        $sheet->setCellValue('B'.$y, $arrayprodidep[$data[IDPRODI]]);
        $sheet->setCellValue('C'.$y, $data["IDMAKUL"]);
        $sheet->setCellValue('D'.$y, getnamafromtabel( $data[IDMAKUL], "makul" ));
        $sheet->setCellValue('E'.$y, $arraylabelkelas[$data[KELAS]]);
        $sheet->setCellValue('F'.$y, $arrayruangan[$data[IDRUANGAN]]);
        #$excel->getActiveSheet()->setCellValue('G'.$y, $arrayhari[$data[HARI]]);
		$sheet->setCellValue('G'.$y, $tanggalajar);
		$sheet->setCellValue('H'.$y, $data['MULAI']);
		$sheet->setCellValue('I'.$y, $data['SELESAI']);
		$sheet->setCellValue('J'.$y, $data['RENCANA']);
		#$excel->getActiveSheet()->setCellValue('K'.$y, $data['PESERTA']);
		$sheet->setCellValue('K'.$y, $timpengajar);
	    $y++;
        $no++;
    }
}    */
 $writer = new Xlsx($spreadsheet);
$filename='jadwal-'.date('dmY').'.xlsx';
$writer->save($filename);
       
/*ob_end_clean(); 
$filename='jadwal-'.date('dmY').'.xls'; //save our workbook as this file name
header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache
             
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format q
$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');  
//force user to download the Excel file without writing it to server's HD
$objWriter->save("php://output");
$excel->disconnectWorksheets();
exit(); */       
?>