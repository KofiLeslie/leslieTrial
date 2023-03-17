<?php

namespace App\Models;

use App\Events\MediaFileDeleted;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    protected $dispatchesEvents = [
        'deleted' => MediaFileDeleted::class,
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
