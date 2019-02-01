<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Barryvdh\DomPDF\Facade as PDF;

class PdfController extends Controller
{
    public function ticket()
    {
        try {
            $pdf = PDF::loadView('reports.ticket');
            return $pdf->stream();
        } catch (DecryptException $e) {
            abort(404);
        }

    }
}
