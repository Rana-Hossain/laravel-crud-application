<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Quantity',
            'Price',
            'Description',
            'Category',
            'Image URL'
        ];
    }
    /**
     * @param $product
     * @return array
     */
    public function map($product): array
    {
        return [
            $product->id,
            $product->name,
            $product->qty,
            $product->price,
            $product->description,
            $product->category,
            $product->image ? asset('images/' . $product->image_url) : 'No Image'
        ];
    }
}
