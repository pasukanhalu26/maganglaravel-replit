<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait Trackable {
    public static function bootTrackable() {
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->create_by = Auth::user()->name;
            }
            if (!isset($model->status)) {
                $model->status = 1;
            }
        });

        static::created(function ($model) {
            // Jika ini model User
            if ($model instanceof \App\Models\User && (!$model->username || !str_starts_with($model->username, 'SIP-'))) {
                $hex = strtoupper(base_convert($model->id, 10, 36));
                $kodeId = 'SIP-' . str_pad($hex, 6, '0', STR_PAD_LEFT);
                $model->update(['username' => $kodeId]);
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->update_by = Auth::user()->name;
            }
        });
    }
}