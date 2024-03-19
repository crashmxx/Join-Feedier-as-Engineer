<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Necessary to set because the noun feedback is uncountable.
     * The plural form of feedback is also feedback but we want to keep the Laravel table name convention which is
     * "DB tables should be in lower case, with underscores to separate words (snake_case), and should be in plural form."
     */
    protected $table = 'feedbacks';

    protected $fillable = ['description', 'email', 'type'];

    protected $dates = [
        'created_at',
        'deleted_at',
    ];
    protected $appends = ['created_at_fr', 'deleted_at_fr'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getEmailAttribute($value): string|null
    {
        return optional($this->user)->email ?? $value;
    }

    public function getCreatedAtFrAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->isoFormat('DD/MM/YYYY');
    }

    public function getDeletedAtFrAttribute()
    {
        if ($this->attributes['deleted_at']) {
            return Carbon::parse($this->attributes['deleted_at'])->isoFormat('DD/MM/YYYY');
        }
        return null;
    }
}
