<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    private $apiUrl;

    public function __construct()
    {
        $this->apiUrl = env('FLASK_API_URL', 'http://localhost:5000');
    }

    // Dashboard Admin
    public function index()
    {
        try {
            $totalFilm    = DB::table('movies')->count();
            $totalUser    = DB::table('users')->count();
            $totalRating  = DB::table('ratings')->count();

            // Status API
            $apiResponse  = Http::timeout(5)->get("{$this->apiUrl}/api/status");
            $apiStatus    = $apiResponse->json();
        } catch (\Exception $e) {
            $totalFilm   = 0;
            $totalUser   = 0;
            $totalRating = 0;
            $apiStatus   = ['status' => 'error'];
        }

        return view('admin.index', compact(
            'totalFilm', 'totalUser', 'totalRating', 'apiStatus'
        ));
    }

    // Kelola Film
    public function films()
    {
        try {
            $films = DB::table('movies')
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        } catch (\Exception $e) {
            $films = collect([]);
        }

        return view('admin.films', compact('films'));
    }

    // Tambah Film
    public function tambahFilm(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'required|string',
            'year'  => 'required|integer|min:1888|max:2030',
        ]);

        DB::table('movies')->insert([
            'title'       => $request->title,
            'genre'       => $request->genre,
            'year'        => $request->year,
            'description' => $request->description ?? '',
            'poster'      => $request->poster ?? '',
            'sumber'      => 'manual',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return back()->with('success', '✅ Film berhasil ditambahkan!');
    }

    // Hapus Film
    public function hapusFilm($id)
    {
        DB::table('movies')->where('id', $id)->delete();
        return back()->with('success', '🗑️ Film berhasil dihapus!');
    }
}