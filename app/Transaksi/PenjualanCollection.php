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
}
