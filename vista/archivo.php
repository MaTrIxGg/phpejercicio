<?php

include('pdf.php');

if(isset($_POST["hidden_html"]) && $_POST["hidden_html"] != ''){

    $file_name='google_chart.pdf';
    $html = '<link rel="stylesheet" href="css/bootstrap.min.css">';
    $html .= $_POST["hidden_html"];

    $pdf = new pdf();
    $pdf->load_html($html);
    $pdf->render();
    $pdf->stream($file_name, array("Attachment" => false));

}