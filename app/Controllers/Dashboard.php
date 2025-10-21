<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Dashboard extends Controller
{
    public function index()
    {
        $db = \Config\Database::connect();
        $messages = $db->table('messages_status')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResult();

        return view('dashboard', ['messages' => $messages]);
    }
}
