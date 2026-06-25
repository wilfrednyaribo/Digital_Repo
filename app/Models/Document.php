<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\User;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'author_creator',
        'description',
        'document_type',
        'file_path',
        'file_type',
        'file_size',
        'cover_image',
        'rating',
        'is_public',
        'published_at',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'rating' => 'decimal:1',
        'published_at' => 'datetime',
    ];

    /**
     * Format file size (KB, MB, GB)
     */
    public function getFormattedFileSizeAttribute()
    {
        $bytes = $this->file_size;

        if ($bytes >= 1073741824) {
            return round($bytes / 1073741824, 2) . ' GB';
        }

        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 2) . ' MB';
        }

        if ($bytes >= 1024) {
            return round($bytes / 1024, 2) . ' KB';
        }

        return $bytes . ' B';
    }

    /**
     * Get the human-readable type label
     */
    public function getTypeLabelAttribute()
    {
        $labels = [
            'book' => 'Book',
            'file' => 'File',
            'record' => 'Record',
            'thesis' => 'Thesis',
        ];

        return $labels[$this->document_type] ?? ucfirst($this->document_type ?? 'Document');
    }

    /**
     * Check if this document has a displayable cover
     */
    public function getHasCoverAttribute()
    {
        return !empty($this->cover_image);
    }

    /**
     * Relationships
     */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}