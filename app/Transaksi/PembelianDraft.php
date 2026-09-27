<?php

namespace App\Transaksi;

/**
 * Cash Draft.
 */
class PembelianDraft extends TransaksiDraft
{
    public $draftKey;
    public $type = 'pembelian';
    public $type_id = 1;
}
