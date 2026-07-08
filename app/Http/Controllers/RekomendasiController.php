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

    public function index()
    {
         return $this->show(request());
    }

    public function show(Request $request, $user_id = null)
    {
        $region = $request->query('region', 'global');
        if (!in_array($region, ['global', 'indonesia'])) {
            $region = 'global';
        }

        try {
            // Ambil film mulai posisi 11 (offset=10)
            $response = Http::timeout(30)->get("{$this->apiUrl}/api/top-films/realtime", [
                'region' => $region,
                'offset' => 10,  // skip 10 film teratas
                'limit'  => 20,  // ambil 10 film berikutnya
            ]);

            $data  = $response->json();
            $films = $data['data'] ?? [];

            // Renumber rank mulai dari 11
            foreach ($films as $i => &$film) {
                $film['rank'] = $i + 11;
            }
            unset($film);

        } catch (\Exception $e) {
            $films = [];
        }

        return view('rekomendasi.show', compact('films', 'region'));
    }
}