<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PdfController extends Controller
{
    //
    public function exportpdf()
    {

        $data = DB::table('classement_global')->where('rang_equipe', 1)->get();
        $d = DB::select('select sum(longeur) as distance from etape');
        $distance = $d[0]->distance;
        $dateActuelle = date('Y-m-d H:i:s');
        $pdf = \PDF::setPaper('A4', 'landscape')->loadView('classement.pdf', ['equipe' => $data, 'distance' => $distance]);
        return $pdf->stream($dateActuelle.'invoice.pdf');
//        $this->loadPDF($data,$distance);
//        return redirect()->back();
//        return view('classement.pdf', ['equipe' => $data, 'distance' => $distance]);
    }

//    private function loadPDF($equipe, $distance)
//    {
//        $dompdf = new Dompdf();
//        $dompdf->loadHtml(view('classement.pdf', ['equipe' => $equipe, 'distance' => $distance]));
//        $dompdf->setPaper('a4', 'landscape');
//        $dompdf->render();
//        $daty = Carbon::now('Indian/Antananarivo')->format('Y-m-d H:i:s');
//        return $dompdf->stream($daty. ''.'winner.pdf');
//    }

private function loadPDF($equipe,$distance){
    $dateActuelle = date('Y-m-d H:i:s');
    $pdf = \PDF::setPaper('A4', 'landscape')->loadView('classement.pdf', ['equipe' => $equipe, 'distance' => $distance]);
    return $pdf->stream($dateActuelle.'invoice.pdf');

}

}
