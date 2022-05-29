<?php

namespace App\Http\Controllers;

use App\Subscription;
use Illuminate\Http\Request;
use PDF;

class MiscController extends Controller
{
    public function download(){
        $subs = Subscription::all();
        // $sub = '12345266jdjdhhhhhhhhhhhffsfffffffwh';
        $data = array(
            'subs' => $subs,
        );

        $pdf = PDF::loadView('pdf.subscription',$data);
        // $pdf = PDF::loadView('pdf.subscription', $sub);
        ob_end_clean();
        // $pdf->setOption('javascript-delay', 3000);
        // $pdf->setOption('no-stop-slow-scripts', true);
        return $pdf->download('subscription.pdf');
    }
}
