<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'user_id',
    'mediable_id',
    'mediable_type',
    'name',
    'type',
    'mime_type',
    'size',
    'extension',
    'path',
    'is_primary',
])]
class Media extends Model
{
    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Display label for a property listing image (name column).
     */
    public static function propertyImageLabel(string $propertyName, int $sequence): string
    {
        return $sequence <= 1 ? $propertyName : "{$propertyName} ({$sequence})";
    }

    /**
     * Display label for user verification uploads (name column).
     */
    public static function verificationDocumentLabel(string $type): string
    {
        return match ($type) {
            'govt_id' => 'Government ID',
            'address_proof' => 'Proof of address',
            'facial' => 'Facial verification',
            default => ucfirst(str_replace('_', ' ', $type)),
        };
    }

    /**
     * Storage path on the public disk (path column, with legacy fallback).
     */
    public function resolveStoragePath(): ?string
    {
        if (filled($this->path)) {
            return $this->path;
        }

        if (filled($this->name) && str_contains($this->name, '/')) {
            return $this->name;
        }

        return null;
    }

    public function deleteStoredFile(): void
    {
        $path = $this->resolveStoragePath();

        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    protected function url(): Attribute
    {
        return Attribute::make(get: function (): ?string {
            $path = $this->resolveStoragePath();

            if (! $path) {
                return null;
            }

            return Storage::disk('public')->url($path);
        });
    }
}
