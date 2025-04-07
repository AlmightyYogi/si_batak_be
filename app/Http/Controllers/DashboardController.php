<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function getData(Request $request)
    {
        $user = Auth::user(); // Ambil data user yang sedang login

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data dashboard berhasil diambil',
            'user' => $user,
            'additionalData' => [
                'total_users' => User::count(),
                'random_fact' => "Aksara Batak adalah salah satu aksara tradisional Indonesia."
            ]
        ]);
    }
}
