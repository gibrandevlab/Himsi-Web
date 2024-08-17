<?php
// main_system/app/Http/Controllers/QrCodeController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    private $payload;

    public function __construct()
    {
        $this->payload = 'https://example.com'; // Data to encode
    }

    public function showQrCode()
    {
        return view('components.qrcode', ['payload' => $this->payload]);
    }

    public function processScan(Request $request)
    {
        $decodedText = $request->input('decodedText');

        // Validasi input
        if (!$decodedText) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan.',
            ]);
        }

        if ($decodedText === $this->payload) {
            return response()->json([
                'status' => 'success',
                'message' => 'Pencocokan berhasil.',
                'redirect' => 'https://www.youtube.com' // URL untuk dialihkan
            ]);
        }
        else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak cocok.',
            ]);
        }
    }
}
