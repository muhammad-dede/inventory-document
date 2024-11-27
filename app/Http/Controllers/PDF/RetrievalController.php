<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use App\Models\Retrieval;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RetrievalController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function generate(Request $request, $id)
    {
        $retrieval = Retrieval::with('retrievalItems')->findOrFail($id);
        $data = [
            'date' => Carbon::parse($retrieval->retrieval_date)->format('d-m-Y'),
            'section' => '(' . $retrieval?->section?->code . ') ' . $retrieval?->section?->name,
            'items' => $retrieval->retrievalItems,
        ];
        $pdf = Pdf::loadView('pdf.retrieval', $data)->setPaper('A4', 'potrait')->setWarnings(false);
        return $pdf->stream('Pengambilan-Barang-' .  $retrieval?->section?->code . '-' . $retrieval->retrieval_date . '.pdf', array("Attachment" => false));
    }
}
