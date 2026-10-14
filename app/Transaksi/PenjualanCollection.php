<?php

namespace App\Transaksi;

use Illuminate\Support\Str;

class PenjualanCollection
{
    private $instance;
    private $session;

    public function __construct()
    {
        $this->session = session();
        $this->instance('drafts');
    }

    public function instance($instance = null)
    {
        $instance = $instance ?: 'drafts';

        $this->instance = sprintf('%s.%s', 'transactions', $instance);

        return $this;
    }

    public function add(TransaksiDraft $draft)
    {
        $content = $this->getContent();
        $draft->draftKey = Str::random(10);
        $content->put($draft->draftKey, $draft);

        $this->session->put($this->instance, $content);

        return $draft;
    }

    public function get($draftKey)
    {
        // dd($draftKey);
        $content = $this->getContent();
        if (isset($content[$draftKey])) {
            return $content[$draftKey];
        }
    }

    public function removeDraft($draftKey)
    {
        $content = $this->getContent();
        $content->pull($draftKey);
        $this->session->put($this->instance, $content);
    }

    public function content()
    {
        return $this->getContent();
    }

    protected function getContent()
    {
        $content = $this->session->has($this->instance) ? $this->session->get($this->instance) : collect([]);

        return $content;
    }

    public function count()
    {
        return $this->getContent()->count();
    }

    public function isEmpty()
    {
        return $this->count() == 0;
    }

    public function addItemToDraft($draftKey, Item $item)
    {
        $content = $this->getContent();
        $draft = $content[$draftKey];

        $item->sell = $item->product->sell;
        $item->subtotal = $item->product->sell * $item->qty;

        $foundItem = $draft->search($item->product);

        if (!is_null($foundItem)) {
            $itemKey = $draft->searchItemKeyFor($item->product);
            $content[$draftKey]->updateItem($itemKey, ['qty' => $foundItem->qty + $item->qty]);
        } else {
            $content[$draftKey]->addItem($item);
        }

        $this->session->put($this->instance, $content);

        return $item->product;
    }

    public function removeItemFromDraft($draftKey, $itemKey)
    {
        $content = $this->getContent();
        $content[$draftKey]->removeItem($itemKey);

        $this->session->put($this->instance, $content);
    }
    public function UpdateItemToDraft($draftKey, Item $item)
    {
        // dd($draftKey, $item);
        $content = $this->getContent();
        $draft = $content[$draftKey];
        $foundItem = $draft->search($item->product);
        if (!is_null($foundItem)) {
            $itemKey = $draft->searchItemKeyFor($item->product);
            $content[$draftKey]->updateItem($itemKey, ['qty' => $item->qty, 'item_discount' => $item->item_discount, 'subtotal' => $item->subtotal - $item->item_discount_subtotal]);
        }
        $this->session->put($this->instance, $content);

        return $item->product;
    }
    public function updateDraftAttributes($draftKey, $draftAttributes)
    {
        $content = $this->getContent();

        foreach ($draftAttributes as $attribute => $value) {
            $content[$draftKey]->{$attribute} = $value;
        }

        $this->session->put($this->instance, $content);

        return $content[$draftKey];
    }
}
