<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show dashboard
     */
    public function index()
    {
        // Get user role from session
        $role = session('role', 'guest');

        // Get statistics based on role
        $stats = $this->getStatistics($role);

        // Return appropriate view
        return view('dashboard', [
            'role' => $role,
            'stats' => $stats,
            'username' => session('username', 'User'),
        ]);
    }

    /**
     * Get statistics based on user role
     */
    private function getStatistics($role)
    {
        // Mock data for demonstration
        switch ($role) {
            case 'admin':
                return [
                    [
                        'title' => 'Total Pelanggan',
                        'value' => '1,234',
                        'icon' => 'people',
                        'color' => 'primary',
                    ],
                    [
                        'title' => 'Total Tagihan',
                        'value' => 'Rp 50.5M',
                        'icon' => 'file-earmark-text',
                        'color' => 'success',
                    ],
                    [
                        'title' => 'Pembayaran Hari Ini',
                        'value' => 'Rp 2.3M',
                        'icon' => 'cash-coin',
                        'color' => 'info',
                    ],
                    [
                        'title' => 'Tiket Aktif',
                        'value' => '45',
                        'icon' => 'ticket',
                        'color' => 'warning',
                    ],
                ];

            case 'staff':
                return [
                    [
                        'title' => 'Tiket Ditugaskan',
                        'value' => '12',
                        'icon' => 'ticket',
                        'color' => 'primary',
                    ],
                    [
                        'title' => 'Tiket Selesai',
                        'value' => '89',
                        'icon' => 'check-circle',
                        'color' => 'success',
                    ],
                    [
                        'title' => 'Pelanggan Aktif',
                        'value' => '234',
                        'icon' => 'people',
                        'color' => 'info',
                    ],
                ];

            case 'finance':
                return [
                    [
                        'title' => 'Pendapatan Bulan Ini',
                        'value' => 'Rp 125.5M',
                        'icon' => 'cash-coin',
                        'color' => 'success',
                    ],
                    [
                        'title' => 'Tagihan Belum Lunas',
                        'value' => 'Rp 25.3M',
                        'icon' => 'exclamation-circle',
                        'color' => 'warning',
                    ],
                    [
                        'title' => 'Transaksi Hari Ini',
                        'value' => '156',
                        'icon' => 'arrow-left-right',
                        'color' => 'info',
                    ],
                ];

            case 'customer':
                return [
                    [
                        'title' => 'Tagihan Saya',
                        'value' => 'Rp 450K',
                        'icon' => 'file-earmark-text',
                        'color' => 'primary',
                    ],
                    [
                        'title' => 'Status Pembayaran',
                        'value' => 'Lunas',
                        'icon' => 'check-circle',
                        'color' => 'success',
                    ],
                    [
                        'title' => 'Tiket Support',
                        'value' => '2',
                        'icon' => 'ticket',
                        'color' => 'warning',
                    ],
                ];

            default:
                return [
                    [
                        'title' => 'Welcome',
                        'value' => 'Guest',
                        'icon' => 'person',
                        'color' => 'primary',
                    ],
                ];
        }
    }
}
