<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnualReport extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'year',
        'file_path',
        'thumbnail'
    ];

    /**
     * Get the URL for the report's PDF file.
     *
     * @return string
     */
    public function getFileUrlAttribute()
    {
        return asset($this->file_path);
    }

    /**
     * Get the URL for the report's thumbnail.
     *
     * @return string|null
     */
    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail ? asset($this->thumbnail) : null;
    }

    /**
     * Get formatted file size.
     *
     * @return string
     */
    public function getFormattedFileSizeAttribute()
    {
        if (!file_exists(storage_path('app/public/' . $this->file_path))) {
            return '0 KB';
        }
        
        $size = filesize(storage_path('app/public/' . $this->file_path));
        $units = ['B', 'KB', 'MB', 'GB'];
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}

/**
     * Get the user that uploaded the report.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

}
