@php
use Facades\App\Transaksi\PenjualanCollection;
@endphp
<div class="col-12 col-lg-12">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs">
                @foreach(PenjualanCollection::content() as $key => $content)
                @php $active = ($draft->draftKey == $key)?'active':'' @endphp
                <li class="nav-item {{$active}}" role="presentation">
                    <a class="nav-link" id="profile-tab" href="{{route('penjualan.show',$key)}}" role="tab" aria-controls="profile">
                        {{trans('transaction.'.$content->type)}}-{{$key}}
                        <form action="{{route('penjualan.remove')}}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus Transaksi ini ?')">
                            {{csrf_field()}}
                            <input type="hidden" name="draft_key" value="{{ $key }}">
                            <button type="submit" class="btn-close" aria-label="Close"></button>
                        </form>
                    </a>
                </li>
                @endforeach
                <!-- <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home"
                        role="tab" aria-controls="home" aria-selected="true">Home</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile"
                        role="tab" aria-controls="profile" aria-selected="false">Profile</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact"
                        role="tab" aria-controls="contact" aria-selected="false">Contact</a>
                </li> -->
            </ul>
        </div>
    </div>
</div>