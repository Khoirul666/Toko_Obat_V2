<?php

namespace App\Transaksi;

/**
 * Cash Draft.
 */
class PenjualanDraft extends TransaksiDraft
{
    public $draftKey;
    public $type = 'penjualan';
    public $type_id = 1;
}
