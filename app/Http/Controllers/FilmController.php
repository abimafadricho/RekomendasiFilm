<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FilmController extends Controller
{
    private $apiUrl;

    public function __construct()
    {
        $this->apiUrl = env('FLASK_API_URL', 'http://localhost:5000');
    }

    public function index(Request $request)
    {
        $region = $request->query('region', 'global');
        if (!in_array($region, ['global', 'indonesia'])) {
            $region = 'global';
        }

        try {
            // Pakai endpoint realtime, bukan /api/top-films lagi
            $response = Http::timeout(60)->get("{$this->apiUrl}/api/top-films/realtime", [
                'region' => $region,
                'limit'  => 10,
            ]);
            $data     = $response->json();
            $topFilms = $data['data'] ?? [];
        } catch (\Exception $e) {
            $topFilms = [];
            session()->flash('error', 'Gagal menghubungi server. Pastikan Flask API berjalan.');
        }

        // Ambil evaluasi model: 4 kombinasi (global/indonesia x test/production)
        $metrics = [];
        $kombinasi = [
            'global_test'         => ['region' => 'global',    'source' => 'test'],
            'indonesia_test'      => ['region' => 'indonesia', 'source' => 'test'],
            'global_production'   => ['region' => 'global',    'source' => 'production'],
            'indonesia_production'=> ['region' => 'indonesia', 'source' => 'production'],
        ];

        foreach ($kombinasi as $key => $params) {
            try {
                $resp = Http::timeout(300)->get("{$this->apiUrl}/api/metrics", $params);
                $metrics[$key] = $resp->json()['data'] ?? null;
            } catch (\Exception $e) {
                $metrics[$key] = null;
            }
        }

        return view('films.index', compact('topFilms', 'region', 'metrics'));
    }

    // Halaman Detail Film
    public function detail($id)
    {
        try {
            $response = Http::timeout(300)->get("{$this->apiUrl}/api/movies/{$id}");
            $data     = $response->json();
        } catch (\Exception $e) {
            abort(500, 'Gagal menghubungi server');
        }

        if (!is_array($data) || ($data['status'] ?? null) !== 'ok') {
            abort(404, 'Film tidak ditemukan');
        }

        $film   = $data['data'];
        $userId = session('user_id');
        return view('films.detail', compact('film', 'userId'));
    }

    public function search(Request $request)
    {
        $query  = $request->query('q', '');
        $region = $request->query('region', 'global');

        if (strlen($query) < 2) {
            return view('films.search', [
                'films'  => [],
                'query'  => $query,
                'region' => $region,
                'error'  => 'Kata kunci minimal 2 karakter.',
            ]);
        }

        try {
            $response = Http::timeout(15)->get("{$this->apiUrl}/api/search", [
                'q'      => $query,
                'region' => $region,
                'limit'  => 20,
            ]);
            $data  = $response->json();
            $films = $data['data'] ?? [];
        } catch (\Exception $e) {
            $films = [];
        }

        return view('films.search', compact('films', 'query', 'region'));
    }
}