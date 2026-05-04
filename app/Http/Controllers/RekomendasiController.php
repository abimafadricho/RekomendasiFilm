<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RekomendasiController extends Controller
{
    private $apiUrl;

    public function __construct()
    {
        $this->apiUrl = env('FLASK_API_URL', 'http://localhost:5000');
    }

    // Halaman form input user_id
    public function index()
    {
        return view('rekomendasi.index');
    }

    // Halaman hasil rekomendasi
    public function show(Request $request, $userId)
    {
        $k     = $request->get('k',     20);
        $topN  = $request->get('top_n', 10);

        try {
            $response = Http::timeout(60)->get("{$this->apiUrl}/api/recommend/{$userId}", [
                'k'     => $k,
                'top_n' => $topN,
            ]);

            $data          = $response->json();
            $rekomendasi   = $data['data']    ?? [];
            $status        = $data['status']  ?? 'error';
            $pesan         = $data['message'] ?? '';

        } catch (\Exception $e) {
            $rekomendasi = [];
            $status      = 'error';
            $pesan       = 'Gagal menghubungi server. Pastikan Flask API berjalan.';
        }

        return view('rekomendasi.show', compact(
            'rekomendasi', 'userId', 'k', 'topN', 'status', 'pesan'
        ));
    }
}