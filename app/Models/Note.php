<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Note extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
        'image',
        'text_color',
        'note_color',
        'line_color',
        'creator_id',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_notes');
    }
}
