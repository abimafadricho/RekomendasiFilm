<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RatingController extends Controller
{
    private $apiUrl;

    public function __construct()
    {
        $this->apiUrl = env('FLASK_API_URL', 'http://localhost:5000');
    }

    // Simpan rating baru
    public function simpan(Request $request)
    {
        $request->validate([
            'user_id'  => 'required|integer',
            'movie_id' => 'required',
            'rating'   => 'required|numeric|min:0.5|max:5',
        ]);

        try {
            $response = Http::timeout(10)->post("{$this->apiUrl}/api/ratings", [
                'user_id'  => $request->user_id,
                'movie_id' => $request->movie_id,
                'rating'   => $request->rating,
            ]);

            $data = $response->json();

            if ($data['status'] === 'ok') {
                return back()->with('success', '⭐ Rating berhasil disimpan!');
            } else {
                return back()->with('error', 'Gagal menyimpan rating: ' . $data['message']);
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghubungi server.');
        }
    }

    // Riwayat rating user
    public function riwayat($userId)
    {
        try {
            $response = Http::timeout(10)->get("{$this->apiUrl}/api/ratings/{$userId}");
            $data     = $response->json();
            $ratings  = $data['data'] ?? [];
        } catch (\Exception $e) {
            $ratings = [];
        }

        return view('rating.riwayat', compact('ratings', 'userId'));
    }
}