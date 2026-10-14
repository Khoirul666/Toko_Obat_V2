<?php

namespace App\Transaksi;

use App\Produk;

/**
 * Draft Item class.
 */
class Item
{
    public $id;
    public $product;
    public $name;
    public $unit;
    public $price;
    public $sell;
    public $qty;
    public $item_discount = 0;
    public $item_discount_subtotal = 0;
    public $subtotal;

    public function __construct(Produk $product, $qty)
    {
        $this->id = $product->id;
        $this->name = $product->name;
        $this->unit = $product->unit_id ? $product->unit->name : null;
        $this->product = $product;
        $this->qty = $qty;
        $this->price = $product->price;
        $this->sell = $product->sell;
        $this->subtotal = $product->price * $qty;
    }

    public function updateAttribute(array $newItemData)
    {
        if (isset($newItemData['qty'])) {
            $this->qty = $newItemData['qty'];
            $this->subtotal = $this->sell * $this->qty;
        }

        if (isset($newItemData['item_discount'])) {
            $this->setItemDiscount($newItemData['item_discount']);
        }

        return $this;
    }

    public function setItemDiscount(int $discount)
    {
        $this->item_discount = $discount;
        $this->item_discount_subtotal = $discount * $this->qty;
    }
}
