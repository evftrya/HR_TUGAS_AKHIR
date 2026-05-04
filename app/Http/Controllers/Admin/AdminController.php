<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PelaporanPekerjaan;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        $totalUsers = User::count();
        $adminUsers = User::where('is_admin', true)->count();
        $regularUsers = User::where('is_admin', false)->count();
        $recentUsers = User::latest()->take(5)->get();

        // --- Achievement Badges Logic (Fitur 2A5) ---
        $userId = auth()->id();
        $lastTenReports = PelaporanPekerjaan::where('user_id', $userId)
            ->latest()
            ->take(10)
            ->get();

        $badges = [
            'reliable' => false,
            'speedy'   => false
        ];

        if ($lastTenReports->count() >= 10) {
            $badges['reliable'] = $lastTenReports->every(fn($rep) => $rep->status === 'approved' || $rep->status === 'completed');
        }

        $lastFiveReports = $lastTenReports->take(5);
        if ($lastFiveReports->count() >= 5) {
            $avgHour = $lastFiveReports->avg(fn($rep) => $rep->created_at->hour);
            $badges['speedy'] = $avgHour < 17;
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'adminUsers',
            'regularUsers',
            'recentUsers',
            'badges'
        ));
    }

    /**
     * Show all users.
     */
    public function users()
    {
        $users = User::paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show user details.
     */
    public function showUser(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Edit user.
     */
    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user.
     */
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'is_admin' => 'boolean'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'is_admin' => $request->has('is_admin')
        ]);

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User updated successfully.');
    }

    /**
     * Delete user.
     */
    public function deleteUser(User $user)
    {
        // Prevent deleting the last admin
        if ($user->is_admin && User::where('is_admin', true)->count() <= 1) {
            return ($this->handleRedirectBack())
                ->with('error', 'Cannot delete the last admin user.');
        }

        $user->delete();

        return redirect()->route('admin.users')
            ->with('success', 'User deleted successfully.');
    }
}
