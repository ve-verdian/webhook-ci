<?php

namespace App\Models;

use CodeIgniter\Model;

class MessageModel extends Model
{
    protected $table      = 'messages';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'sender',
        'message',
        'message_type',
        'raw_payload',
        'message_id',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
