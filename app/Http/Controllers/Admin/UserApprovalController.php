<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SellerApprovedNotification;

class UserApprovalController extends Controller
{
    public function index()
    {
        
    // Cari penjual yang belum disetujui (is_approved = 0)
    $pendingUsers = User::where('role', 'penjual')
                        ->where('is_approved', 0)
                        ->get();

    return view('admin.approval.index', compact('pendingUsers'));
    }

   public function approve($id)
{
    $user = User::findOrFail($id);

    // Update status approval
    $user->is_approved = 1;
    $user->save();

    // Kirim notifikasi email ke penjual
    $user->notify(new \App\Notifications\SellerApprovedNotification());

    return redirect()->back()->with('success', 'Penjual berhasil disetujui dan email notifikasi telah dikirim.');
}


    
    
}

