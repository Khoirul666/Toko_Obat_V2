<?php

namespace App\Transaksi;

class TransaksiCollection
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

    public function content()
    {
        return $this->getContent();
    }

    protected function getContent()
    {
        $content = $this->session->has($this->instance) ? $this->session->get($this->instance) : collect([]);

        return $content;
    }
}
