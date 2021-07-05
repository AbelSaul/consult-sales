<?php

namespace App\Http\Controllers;

use App\Empresa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Proforma;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;
use Mpdf\HTMLParserMode;


class PdfController extends Controller
{
    public function ticket()
    {
        $doc = request('doc');
        $proforma = Proforma::where('documento', $doc)->first();
        $empresa = Empresa::first();
        $pdf = PDF::loadView('reports.report', compact('proforma', 'empresa'));
        return $pdf->stream();
    }

    // public function ticket()
    // {
    //     $pdf = new Mpdf();
    //     $html =  view('reports.report')->render();
    //     $pdf->WriteHTML($html, HTMLParserMode::HTML_BODY);
    //     Storage::disk('public')->put("documento.pdf", $pdf->output('', 'S'));
    // }
}
