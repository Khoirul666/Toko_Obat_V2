<?php

namespace App\Transaksi;

use App\Produk;
use App\Transaksi;

/**
 * Transaction Draft Interface.
 */
abstract class TransaksiDraft
{
    public $items = [];

    public $customer = ['name' => null, 'phone' => null];
    public $notes;
    public $payment;

    public function toArray()
    {
        return [
            'invoice_no' => 2,
            'date'       => 1,
            'items'      => $this->items(),
            'total'      => 0,
            'payment'    => 0,
            'customer'   => 0,
            'status_id'  => 0,
            'creator_id' => 0,
            'remark'     => '',
        ];
    }

    public function items()
    {
        return collect($this->items)->sortBy('name');
    }

    public function addItem(Item $item)
    {
        $this->items[] = $item;

        return $item->product;
    }

    public function removeItem($itemKey)
    {
        unset($this->items[$itemKey]);
    }

    public function empty()
    {
        $this->items = [];
    }

    public function getSubtotal()
    {
        return $this->items()->sum('subtotal');
    }

    public function getTotal()
    {
        return $this->items()->sum('subtotal') - $this->getDiscountTotal();
    }

    public function getItemsCount()
    {
        return $this->items()->count();
    }

    public function getTotalQty()
    {
        return $this->items()->sum('qty');
    }

    public function getDiscountTotal()
    {
        return $this->items()->sum('item_discount_subtotal');
    }

    public function updateItem($itemKey, $newItemData, $posisi)
    {
        if (!isset($this->items[$itemKey])) {
            return;
        }

        $item = $this->items[$itemKey];

        $this->items[$itemKey] = $item->updateAttribute($newItemData, $posisi);

        return $item;
    }

    public function search(Produk $product)
    {
        $productItem = $this->items()->where('id', $product->id)->first();

        return $productItem;
    }

    public function searchItemKeyFor(Produk $product)
    {
        return $this->items()->search(function ($item, $key) use ($product) {
            return $item->product->id == $product->id;
        });
    }

    public function getExchange()
    {
        return $this->payment - $this->getTotal();
    }

    public function store()
    {
        $transaction = new Transaksi();
        $transaction->invoice_no = $this->getNewInvoiceNo();
        $transaction->items = $this->getItemsArray();
        $transaction->customer = $this->customer;
        $transaction->payment = $this->payment;
        $transaction->total = $this->getTotal();
        $transaction->notes = $this->notes;
        $transaction->user_id = auth()->id() ?: 1;

        $transaction->save();

        // Update stok produk
        // dd($transaction);
        foreach ($this->items as $item) {
            $product = $item->product;

            $produkId = $item->product->id ?? null;
            $produk = $produkId ? Produk::find($produkId) : null;
            $stok = $produk ? $produk->stok : 0;
            $product->stok = $stok;

            $product->stok -= $item->qty;
            $product->save();
        }

        return $transaction;
    }

    public function getNewInvoiceNo()
    {
        $prefix = date('ym');

        $lastTransaction = Transaksi::orderBy('invoice_no', 'desc')->first();

        if (!is_null($lastTransaction)) {
            $lastInvoiceNo = $lastTransaction->invoice_no;
            if (substr($lastInvoiceNo, 0, 4) == $prefix) {
                return ++$lastInvoiceNo;
            }
        }

        return $prefix . '0001';
    }

    protected function getItemsArray()
    {
        $items = [];
        foreach ($this->items as $item) {
            $items[] = [
                'id'                     => $item->product->id,
                'name'                   => $item->name,
                'unit'                   => $item->unit,
                'price'                  => $item->price,
                'qty'                    => $item->qty,
                'item_discount'          => $item->item_discount,
                'item_discount_subtotal' => $item->item_discount_subtotal,
                'subtotal'               => $item->subtotal,
            ];
        }

        return $items;
    }

    public function destroy()
    {
        $cart = app(PenjualanCollection::class);

        return $cart->removeDraft($this->draftKey);
    }
}
