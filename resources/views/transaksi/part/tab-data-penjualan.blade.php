@php
use Facades\App\Transaksi\PenjualanCollection;
@endphp
<div class="col-12 col-lg-12">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs">
                @foreach(PenjualanCollection::content() as $key => $content)
                @php $active = ($draft->draftKey == $key)?'active':'' @endphp
                @php $slctd = ($draft->draftKey == $key)?'true':'' @endphp
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{$active}}" id="{{$key}}-tab" href="{{ route('penjualan.show', $key) }}" role="tab" aria-controls="{{$key}}" aria-selected="{{$slctd}}">
                        <div class="d-flex">
                            <h6 class="mb-1">{{trans('transaction.'.$content->type)}}-{{$key}}</h6>
                        </div>
                    </a>
                </li>
                @endforeach
            </ul>
            @if (Request::get('action') !== 'confirm')
            <hr>
            <div class="tab-content">
                <!-- @php var_dump($draft->draftKey,PenjualanCollection::get($draft->draftKey)) @endphp -->
                @foreach(PenjualanCollection::content() as $key => $content)
                @php $active = ($draft->draftKey == $key)?'show active':'' @endphp
                <div class="tab-pane fade {{$active}}" id="id-{{$key}}" role="tabpanel" aria-labelledby="{{$key}}-tab">
                    <!-- {{trans('transaction.'.$content->type)}}-{{$key}} -->
                    <div class="card">
                        <div class="page-title">
                            <div class="card-title">
                                <div class="row">
                                    <div class="col-12 col-md-6 order-md-1 order-last">
                                        <h3 class="card-title">Transaksi Penjualan</h3>
                                    </div>
                                    <div class="col-12 col-md-6 order-md-2 order-first">
                                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                            <form action="{{route('penjualan.remove')}}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus Transaksi-{{$key}} ini ?')">
                                                {{csrf_field()}}
                                                <input type="hidden" name="draft_key" value="{{ $key }}">
                                                <button type="submit" class="btn btn-danger" aria-label="Close">Hapus Transaksi-{{$key}}</button>
                                            </form>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-1">
                                        <form method="get" action="{{ route('penjualan.show', $draft->draftKey) }}">
                                            <div class="input-group input-group-sm mb-3">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">{{ trans('cart.product_search') }}</span>
                                                <input type="text" id="query" name="query" value="{{ request('query') }}" placeholder="{{ trans('cart.min_search_query') }}" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                                <button class="btn btn-outline-secondary" type="submit" id="button-addon2" value="{{ trans('cart.product_search') }}">Cari Produk</button>
                                            </div>
                                        </form>
                                    </div>
                                    @if ($queryPenjualan)
                                    <div class=" col-md-6 mb-1">
                                        <div class="input-group input-group-sm mb-3">
                                            {{ link_to_route('penjualan.show', trans('cart.search_box_cleanup'), [$draft->draftKey], ['class' => 'btn btn-outline-secondary']) }}
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @includeWhen($queryPenjualan,'transaksi.part.search-result-penjualan',[
                            'draftType' => $draft->type,
                            'draftKey' => $draft->draftKey
                            ])
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>