<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Proforma;

class PdfController extends Controller
{
    public function ticket()
    {
        $doc = request('doc');
        $proforma = Proforma::where('documento', $doc)->first();
        // dd($proforma->client);
        $pdf = PDF::loadView('reports.ticket', compact('proforma'));
        return $pdf->stream();
        // return view('reports.ticket', compact('proforma'));

    }
}
