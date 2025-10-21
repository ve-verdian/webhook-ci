<?php

namespace App\Controllers;
date_default_timezone_set('Asia/Jakarta');

use CodeIgniter\RESTful\ResourceController;

class Webhook extends ResourceController
{
    protected $modelName = 'App\Models\MessageModel';
    protected $format    = 'json';

    private $wablasUrl   = 'https://sby.wablas.com/api/send-message';
    private $wablasToken = '0ZtHBJvBpZZhyKtdlhkeUmYFSw9i4RSrvVJU0srZxOS2wO210Ycehau';

    // ========== 1. PESAN MASUK ==========
    public function incoming()
    {
        $raw = $this->request->getBody();
        file_put_contents(WRITEPATH . 'logs/webhook_incoming_' . date('Y-m-d') . '.log',
            date('c') . " RAW: " . $raw . "\n", FILE_APPEND);

        $data = json_decode($raw, true);
        if (json_last_error() !== JSON_ERROR_NONE || !$data) {
            return $this->fail('Invalid JSON', 400);
        }

        $from = $data['from'] ?? $data['phone'] ?? $data['data']['from'] ?? null;
        $message = $data['message'] ?? $data['data']['message'] ?? null;

        if (empty($from) || empty($message)) {
            return $this->respond([
                'status' => false,
                'error'  => 'Missing "from" or "message"'
            ], 400);
        }

        // Simpan pesan masuk
        $this->model->insert([
            'sender'       => $from,
            'message'      => $message,
            'message_type' => $data['messageType'] ?? 'text',
            'raw_payload'  => $raw,
            'status'       => 'received',
            'created_at'   => date('Y-m-d H:i:s'),
        ]);

        // Auto reply sederhana
        $msgLower = strtolower(trim($message));
        if ($msgLower === 'halo') {
            $this->sendReply($from, "Halo 👋 Selamat datang di sistem kami!");
        } elseif ($msgLower === 'info') {
            $this->sendReply($from, "Ini adalah bot auto-reply CodeIgniter 😄");
        }

        return $this->respond(['status' => true, 'message' => 'Incoming processed'], 200);
    }

// ========== 2. STATUS PESAN ==========
public function status()
{
    date_default_timezone_set('Asia/Jakarta');
    $today = date('Y-m-d');

    $raw = file_get_contents('php://input');
    if (empty($raw)) $raw = json_encode($this->request->getRawInput());
    if (empty($raw) && !empty($_POST)) $raw = json_encode($_POST);

    if (empty($raw) || $raw === '[]') {
        return $this->respond(['status' => false, 'message' => 'Empty body received'], 200);
    }

    $data = json_decode($raw, true);
    if (json_last_error() !== JSON_ERROR_NONE || !$data) {
        return $this->fail('Invalid JSON: ' . json_last_error_msg(), 400);
    }

    $items = isset($data['data']) ? $data['data'] : (isset($data[0]) ? $data : [$data]);
    $db = \Config\Database::connect();

    foreach ($items as $item) {
        $messageId = $item['id'] ?? null;
        $status    = strtolower($item['status'] ?? 'unknown');
        $note      = $item['note'] ?? '';
        $phone     = $item['phone'] ?? '';
        $device    = $item['deviceId'] ?? '';

        if (!$messageId) continue;

        $existing = $db->table('messages')->where('message_id', $messageId)->get()->getRow();

        $payload = [
            'message_id' => $messageId,
            'status'     => $status,
            'note'       => $note,
            'raw_payload'=> json_encode($item),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if ($existing) {
            // update existing row
            $db->table('messages')
               ->where('message_id', $messageId)
               ->update($payload);
        } else {
            // ambil last daily_id hari ini
            $last = $db->table('messages')
                        ->selectMax('daily_id')
                        ->where('log_date', $today)
                        ->get()
                        ->getRow();
            $nextId = ($last && $last->daily_id) ? $last->daily_id + 1 : 1;

            $payload['daily_id'] = $nextId;
            $payload['log_date'] = $today;
            $payload['sender'] = $phone;
            $payload['message'] = '';
            $payload['message_type'] = 'status';
            $payload['created_at'] = date('Y-m-d H:i:s');

            $db->table('messages')->insert($payload);
        }

        // log ke file
        file_put_contents(
            WRITEPATH . 'logs/webhook_status_update_' . date('Y-m-d') . '.log',
            date('c') . " ID: $messageId | Status: $status | Phone: $phone | Device: $device | Note: $note\n",
            FILE_APPEND
        );
    }

    return $this->respond(['status' => true, 'message' => 'Status updated'], 200);
}


    // ========== 3. STATUS PERANGKAT ==========
    public function deviceStatus()
    {
        $raw = file_get_contents('php://input');
        file_put_contents(WRITEPATH . 'logs/webhook_device_' . date('Y-m-d') . '.log',
            date('c') . " RAW: " . $raw . "\n", FILE_APPEND);

        $data = json_decode($raw, true);
        if (json_last_error() !== JSON_ERROR_NONE || !$data) {
            return $this->fail('Invalid JSON', 400);
        }

        return $this->respond(['status' => true, 'device' => $data], 200);
    }

    // ========== 4. KIRIM BALASAN ==========
    private function sendReply($to, $text)
    {
        $payload = [
            'phone'   => $to,
            'message' => $text,
        ];

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $this->wablasUrl,
            CURLOPT_HTTPHEADER => [
                "Authorization: {$this->wablasToken}",
                "Content-Type: application/json"
            ],
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_RETURNTRANSFER => true
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);
        $messageId = $result['data']['id'] ?? null;

        $this->model->insert([
            'sender' => 'system',
            'message' => $text,
            'message_type' => 'outgoing',
            'message_id' => $messageId,
            'status' => $result['status'] ? 'sent' : 'failed',
            'raw_payload' => $response,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        file_put_contents(WRITEPATH . 'logs/wablas_reply_' . date('Y-m-d') . '.log',
            date('c') . " Reply to $to: $text\nResponse: $response\n\n", FILE_APPEND);
    }

    public function index()
    {
        return $this->respond(['message' => 'Webhook endpoint active'], 200);
    }

    
}
