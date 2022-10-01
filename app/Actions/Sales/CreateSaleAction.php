<?php

namespace App\Actions\Sales;

use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class CreateSaleAction
{
    public function execute(array $params): Sale
    {
        return DB::transaction(static function () use ($params) {
            /** @var Sale $sale */
            $sale = Sale::query()
                ->create([
                    'customer_id' => $params['customer_id'],
                ]);

            foreach ($params['products'] as $product) {
                $sale->products()->attach([
                    $product['id'] => ['quantity' => $product['quantity']],
                ]);
            }

            return $sale;
        });
    }
}
