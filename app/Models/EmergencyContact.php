<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'whatsapp',
        'extension',
        'location',
        'operating_hours',
        'is_hotline',
        'sort_order',
    ];

    protected $casts = [
        'is_hotline' => 'boolean',
    ];

    /**
     * Get sanitized phone number suitable for tel: URI.
     */
    public function getCleanPhoneAttribute(): string
    {
        return preg_replace('/[^0-9+]/', '', (string) $this->phone);
    }

    /**
     * Get clean international WhatsApp number (62xxxxxxxxxx).
     */
    public function getWhatsappNumberAttribute(): string
    {
        $raw = !empty($this->whatsapp) ? (string) $this->whatsapp : (string) $this->phone;
        $digits = preg_replace('/[^0-9]/', '', $raw);

        if (empty($digits)) {
            return '';
        }

        // Format to Indonesian international format (62...)
        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        } elseif (str_starts_with($digits, '8')) {
            $digits = '62' . $digits;
        }

        return $digits;
    }

    /**
     * Get WhatsApp direct URL with pre-filled greeting message.
     */
    public function getWhatsappUrlAttribute(): string
    {
        $number = $this->whatsapp_number;
        if (empty($number)) {
            return '#';
        }

        $serviceName = $this->name ?? 'Tim Tanggap Darurat';
        $message = "Halo {$serviceName} Akebono Karawang, saya ingin menanyakan informasi / bantuan fasilitas.";
        $encoded = rawurlencode($message);

        return "https://wa.me/{$number}?text={$encoded}";
    }

    /**
     * Get tel: link.
     */
    public function getTelUrlAttribute(): string
    {
        $clean = $this->clean_phone;
        return !empty($clean) ? "tel:{$clean}" : '#';
    }
}
