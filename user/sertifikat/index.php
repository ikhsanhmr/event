<?php include '../akses_user.php' ?>
<?php include '../../inc/koneksi.php'; ?>
<?php
$getEventId = $_GET['id'];
$email = $_SESSION['user'];

$sql = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email'");
$user = mysqli_fetch_assoc($sql);
$userId = $user['id'];

$userHasEvent = mysqli_query($koneksi, "SELECT *,user_event.id AS userEventId FROM user_event 
                                                            INNER JOIN users ON user_event.user_id = users.id
                                                            INNER JOIN events ON user_event.event_id = events.id
                                                            WHERE user_id='$userId' AND event_id='$getEventId'");


$fetchEvent = mysqli_fetch_object($userHasEvent);
?>

<?php if ($fetchEvent->status == 'acc' && date('Y-m-d') > $fetchEvent->tanggal_mulai) { ?>
<?php
    require('../../fpdf/fpdf.php');

    
    $bulan = array(
        '01' => ['Januari', 'I'],
        '02' => ['Februari', 'II'],
        '03' => ['Maret', 'III'],
        '04' => ['April', 'IV'],
        '05' => ['Mei', 'V'],
        '06' => ['Juni', 'VI'],
        '07' => ['Juli', 'VII'],
        '08' => ['Agustus', 'VIII'],
        '09' => ['September', 'IX'],
        '10' => ['Oktober', 'X'],
        '11' => ['November', 'XI'],
        '12' => ['Desember', 'XII'],
    );


    $tanggal = date('d', strtotime($fetchEvent->tanggal_mulai));
    $bulanAcara = $bulan[date('m', strtotime($fetchEvent->tanggal_mulai))][0];
    $tahun = date('Y', strtotime($fetchEvent->tanggal_mulai));

    $noSertifikat = strlen($fetchEvent->id);
    if ($noSertifikat == 1) {
        $generateNo = '000' . $fetchEvent->id;
    } elseif ($noSertifikat == 2) {
        $generateNo = '00' . $fetchEvent->id;
    } elseif ($noSertifikat == 3) {
        $generateNo = '0' . $fetchEvent->id;
    } elseif ($noSertifikat == 4) {
        $generateNo = $fetchEvent->id;
    }
    
    $singkatan = strtoupper($fetchEvent->singkatan);
    $bulanForNoSertifikat = $bulan[date('m', strtotime($fetchEvent->tanggal_mulai))][1];
    $no = "$generateNo/$singkatan/PST/LOKPRO/$bulanForNoSertifikat/$tahun";

    $name = $user['nama'];



    //$name = text to be added, $x= x cordinate, $y = y coordinate, 
    //$a = alignment , $f= Font Name, $t = Bold / Italic, $s = Font Size, $r = Red, $g = Green Font color, $b = Blue Font Color
    function AddText($pdf, $text, $x, $y, $a, $f, $t, $s, $r, $g, $b)
    {
        $pdf->SetFont($f, $t, $s);
        $pdf->SetXY($x, $y);
        $pdf->SetTextColor($r, $g, $b);
        $pdf->Cell(0, 10, $text, 0, 0, $a);
    }

    //Create A 4 Landscape page
    $pdf = new FPDF('L', 'mm', 'A4');
    $pdf->AddPage();
    $pdf->AddFont('Montserrat-ExtraBold', '', 'Montserrat-ExtraBold.php');
    $pdf->SetFont('Montserrat-ExtraBold', '', 16);
    $pdf->AddFont('Montserrat-SemiBold', '', 'Montserrat-SemiBold.php');
    $pdf->SetFont('Montserrat-SemiBold', '', 16);
    $pdf->AddFont('Montserrat-Medium', '', 'Montserrat-Medium.php');
    $pdf->SetFont('Montserrat-Medium', '', 16);
    $pdf->AddFont('Montserrat-Bold', '', 'Montserrat-Bold.php');
    $pdf->SetFont('Montserrat-Bold', '', 16);

    // Add background image for PDF
    $pdf->Image('../../assets/template_sertifikat/sertifikat.jpg', 0, 0, 300);

    //Add a Name to the certificate

    AddText($pdf, $no, 112, 72, 'J', 'Montserrat-Medium', '', 15, 255, 255, 255);
    AddText($pdf, $name, 30, 110, 'C', 'Montserrat-ExtraBold', '', 35, 0, 0, 103);


    $pdf->Ln(38);
    $pdf->SetFont('Montserrat-Bold', '', 14);
    $pdf->SetX(38);
    $title = "\"" . $fetchEvent->judul . "\"";
    // $titleLength = $pdf->GetStringWidth($title);
    $pdf->SetFont('Montserrat-SemiBold', '', 14);
    $body = "yang diadakan oleh Loker Programmer pada tanggal {$tanggal} {$bulanAcara} {$tahun}";
    // $bodyLength = $pdf->GetStringWidth($body);
    // $pdf->Cell($titleLength + 3,10,$title,1,0,"L",false);
    $pdf->SetTextColor(0, 51, 95);
    $pdf->MultiCell(225, 10, $title . ' ' . $body, 0, "C", false);




    $pdf->Output();
?>

<?php } else {
    header('Location: https://event.lokerprogrammer.com/user/');
} ?>