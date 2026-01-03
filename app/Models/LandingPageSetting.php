<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LandingPageSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'affiliate_id',
        'whatsapp_number',
        'greeting_message',
        'bio_description',
        'profile_image_path',
        'custom_colors',
        'visible_categories',
        'social_media_links',
        'is_active',
    ];

    protected $casts = [
        'custom_colors' => 'array',
        'visible_categories' => 'array',
        'social_media_links' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the affiliate user
     */
    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'affiliate_id');
    }

    /**
     * Get profile image URL
     */
    public function getProfileImageUrlAttribute(): string
    {
        return $this->profile_image_path
            ? asset('storage/' . $this->profile_image_path)
            : asset('images/default-avatar.png');
    }

    /**
     * Get WhatsApp link
     */
    public function getWhatsappLinkAttribute(): string
    {
        $number = preg_replace('/[^0-9]/', '', $this->whatsapp_number);
        return "https://wa.me/{$number}";
    }
}
