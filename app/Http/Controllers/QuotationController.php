<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quotation;
use App\Mail\QuotationClient;
use PDF;
use Mail;

class QuotationController extends Controller
{
    public function index()
    {
        $quotations =  Quotation::with(['product', 'user'])->get();
        return response()->json($quotations);
    }

    public function store(Request $request)
    {
        $total = $request->price * $request->productAmount;
        $quotation = Quotation::create([
            'product_id' => $request->productId,
            'user_id' => $request->clientId,
            'product_amount'=> $request->productAmount,
            'discount' => $request->discount,
            'price' => $total,
            'file' => $request->productId.'-'.date('Y-m-d')
        ]);

        return response()->json($quotation);
    }

    public function downloadQuotation($id) {
        $data = Quotation::with(['product', 'user'])->where('id', $id)->get();
  
        view()->share('quotation',$data);
        $pdf = PDF::loadView('pdf_quotation', $data);
  
        return $pdf->download('pdf_file.pdf');
    }

    public function sendEmail($id)
    {
        $data = Quotation::with(['product', 'user'])->where('id', $id)->get();
  
        view()->share('quotation',$data);
        $pdf = PDF::loadView('pdf_quotation', $data);

        Mail::send('mails.mail', $data, function($message)use($data,$pdf) {
            $message->to('tavo@gmail.com', $data->user['email'])
            ->attachData($pdf->output(), "filePdf.pdf");
        });
    }
}
