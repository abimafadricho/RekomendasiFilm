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

    // Halaman Utama - Top 10 Film
    public function index(Request $request)
    {
        try {
            $response = Http::timeout(10)->get("{$this->apiUrl}/api/top-films");
            $data     = $response->json();
            $topFilms = $data['data'] ?? [];
        } catch (\Exception $e) {
            $topFilms = [];
            session()->flash('error', 'Gagal menghubungi server. Pastikan Flask API berjalan.');
        }

        return view('films.index', compact('topFilms'));
    }

    // Halaman Detail Film
    public function detail($id)
    {
        try {
            $response = Http::timeout(10)->get("{$this->apiUrl}/api/movies/{$id}");
            $data     = $response->json();

            if ($data['status'] !== 'ok') {
                abort(404, 'Film tidak ditemukan');
            }

            $film = $data['data'];

        } catch (\Exception $e) {
            abort(500, 'Gagal menghubungi server');
        }

        $userId = session('user_id', 1);
        return view('films.detail', compact('film', 'userId'));
    }
}