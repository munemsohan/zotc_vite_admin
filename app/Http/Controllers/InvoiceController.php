<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Language;
use App\Models\Order;
use Session;
use PDF;
use Config;
use Dompdf\Dompdf;
use Dompdf\Options;
use Milon\Barcode\DNS1D;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use niklasravnsborg\LaravelPdf\Facades\Pdf as FacadesPdf;
use Picqer\Barcode\BarcodeGeneratorPNG;

class InvoiceController extends Controller
{

    public function invoice_download($id)
    {
        try {
            // Get logo
            $logo = get_business_setting('header_logo_white') ?? get_business_setting('header_logo');

            // Get currency code from session or fallback to default
            $currency_code = Session::get('currency_code', function () {
                return Currency::findOrFail(get_setting('system_default_currency'))->code;
            });

            // Get language code from session or use default
            $language_code = Session::get('locale', Config::get('app.locale'));

            // Determine text direction and alignment based on language
            $language = Language::where('code', $language_code)->first();
            $direction = $language && $language->rtl == 1 ? 'rtl' : 'ltr';
            $text_align = $language && $language->rtl == 1 ? 'right' : 'left';
            $not_text_align = $language && $language->rtl == 1 ? 'left' : 'right';

            // Get font family based on currency and language
            $font_family = $this->getFontFamily($currency_code, $language_code);

            // Find the order or fail
            $order = Order::findOrFail($id);

            // Generate a tracking URL if not already present
            if (is_null($order->track_url)) {
                $order->track_url = makeTinyUrl(url('track?order_code=' . $order->code));
                $order->save();
            }

            // Generate barcode image data
            $generator = new BarcodeGeneratorPNG();
            $barcode = 'data:image/png;base64,' . base64_encode($generator->getBarcode($order->code, $generator::TYPE_CODE_128));

            // return view('backend.invoices.invoice', [
            //     'logo' => $logo,
            //     'order' => $order,
            //     'font_family' => $font_family,
            //     'direction' => $direction,
            //     'text_align' => $text_align,
            //     'not_text_align' => $not_text_align,
            //     'barcode' => $barcode
            // ]);

            // Pass data to the view
            $view = view('backend.invoices.invoice', [
                'logo' => $logo,
                'order' => $order,
                'font_family' => $font_family,
                'direction' => $direction,
                'text_align' => $text_align,
                'not_text_align' => $not_text_align,
                'barcode' => $barcode
            ])->render();


            // Load view and generate PDF
            $pdf = Pdf::loadHTML($view);

            // Return the PDF download response
            return $pdf->stream('order-' . $order->code . '.pdf');
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Invoice download error: ' . $e->getMessage());

            // Optionally, return an error response or redirect back with an error message
            return redirect()->back()->withErrors('Failed to generate the invoice. Please try again.');
        }
    }

    private function getFontFamily($currency_code, $language_code)
    {
        $font_mappings = [
            'BDT' => "hindsiliguri, sans-serif",
            'KHR' => "'Hanuman','sans-serif'",
            'AMD' => "'arnamu','sans-serif'",
            'AED' => "xbriyaz",
            'EGP' => "xbriyaz",
            'IQD' => "xbriyaz",
            'ROM' => "xbriyaz",
            'SDG' => "xbriyaz",
            'ILS' => "xbriyaz",
            'THB' => "'Kanit','sans-serif'",
            'CNY' => "'sun-exta','gb'",
            'MMK' => 'tharlon',
            'USD' => "'Roboto','sans-serif'"
        ];

        $language_mappings = [
            'bd' => "hindsiliguri, sans-serif",
            'kh' => "'Hanuman','sans-serif'",
            'sa' => "xbriyaz",
            'ir' => "xbriyaz",
            'om' => "xbriyaz",
            'jo' => "xbriyaz",
            'zh' => "'sun-exta','gb'",
            'mm' => 'tharlon',
            'th' => "'zawgyi-one','sans-serif'"
        ];

        return $font_mappings[$currency_code] ?? $language_mappings[$language_code] ?? "freeserif";
    }
}
