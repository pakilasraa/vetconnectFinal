<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $fillable = [
        'name',
        'sku',
        'quantity',
        'unit',
        'expiry_date',
        'reorder_level',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'expiry_date' => 'date',
            'quantity' => 'integer',
            'reorder_level' => 'integer',
        ];
    }

    /**
     * @return array{key: string, label: string, class: string}
     */
    public function availabilityState(): array
    {
        $today = now()->startOfDay();

        if ($this->expiry_date && $this->expiry_date->lt($today)) {
            return ['key' => 'expired', 'label' => 'Expired', 'class' => 'bg-danger/10 text-danger'];
        }

        if ($this->quantity <= 0) {
            return ['key' => 'out', 'label' => 'Out of stock', 'class' => 'bg-secondary/10 text-secondary'];
        }

        if ($this->quantity <= $this->reorder_level) {
            return ['key' => 'low', 'label' => 'Low stock', 'class' => 'bg-warning/10 text-warning'];
        }

        return ['key' => 'ok', 'label' => 'Available', 'class' => 'bg-success/10 text-success'];
    }
}
