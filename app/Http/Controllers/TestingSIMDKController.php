<?php

namespace App\Http\Controllers;

use App\Models\TestingSIMDK;
use Illuminate\Http\Request;

class TestingSIMDKController extends Controller
{
    public function submit_review(Request $request, $kode, $nama_fitur = null)
    {
        try {
            $userId = session('account')['id'];

            // ambil atau buat data user
            $model = TestingSIMDK::firstOrCreate(
                ['users_id' => $userId],
                ['test_statuses' => []]
            );

            // ambil data lama
            $data = $model->test_statuses ?? [];

            // ambil data berdasarkan kode
            $current = $data[$kode] ?? [];

            // cek apakah sudah done
            if (
                ($current['name'] ?? null) === $nama_fitur &&
                ($current['status'] ?? null) === 'done'
            ) {
                return response()->json([
                    'success' => true,
                    'data' => 'sudah mengisi review'
                ], 200);
            }

            // update / tambah data
            $data[$kode] = [
                'name' => $nama_fitur,
                'status' => 'done',
                'updated_at' => now()->toDateTimeString()
            ];

            // simpan
            $model->update([
                'test_statuses' => $data
            ]);

            return response()->json([
                'success' => true,
                'data' => $model
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}