<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DocumentVersion;

class Document extends Model
{
    protected $fillable = [
        'owner_id',
        'title',
        'content',
        'share_token',
        'is_public'
    ];

    public function owner()
    {
        return $this->belongsTo(
            User::class,
            'owner_id'
        );
    }

    public function collaborators()
{
    return $this->belongsToMany(
        User::class
    );
}

    public function versions()
    {
        return $this->hasMany(
            DocumentVersion::class
        );
    }
}