<?php

namespace App\Controllers;

use App\Models\MessageModel;
use CodeIgniter\Controller;

class MessageController extends Controller
{
    public function index()
    {
        $model = new MessageModel();

        // Ambil jumlah pesan per status (group by)
        $counts = $model->select('status, COUNT(*) as total')
                        ->groupBy('status')
                        ->findAll();

        // Inisialisasi semua status default ke 0
        $data = [
            'sent'      => 0,
            'delivered' => 0,
            'read'      => 0,
            'pending'   => 0,
            'cancel'    => 0,
            'reject'    => 0,
            'received'  => 0,
        ];

        // Isi nilai sesuai hasil query
        foreach ($counts as $row) {
            $status = strtolower($row['status']);
            if (isset($data[$status])) {
                $data[$status] = $row['total'];
            }
        }

        // Ambil semua data pesan (tabel bawah)
        $data['messages'] = $model->orderBy('id', 'DESC')->findAll();

        return view('messages_view', $data);
    }
}
