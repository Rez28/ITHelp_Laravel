<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestHelp extends Model
{
    protected $fillable = ['ip_address', 'ip_mapping_id', 'issue_type', 'note', 'status', 'resolution_note'];
    public function mapping()
    {
        return $this->belongsTo(IpMapping::class, 'ip_mapping_id');
    }
}
