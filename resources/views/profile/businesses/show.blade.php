@extends('profile.businesses.layout', ['title' => $business->brand])
@section('profile-content')
    <a href="{{ route('profile.businesses.edit', $business->slug) }}">
        Edit
    </a>
    @if($business->hasLogo())
        <img src="{{ $business->logo->getUrl() }}" alt="logo">
    @endif
    <div>
        برند : {{ $business->brand }}
    </div>
    <div>
        شهر : {{ $business->city->name }}
    </div>
    @forelse($business->contact as $key => $contact)
        @php $length = max(count($contact['title']), count($contact['value'])) - 1; @endphp
            @for($i = 0; $i <= $length; $i++)
                @component('components.form.text',[
                    'name' => "contact[$key][title][$i]",
                    'value' => $contact['title'][$i],
                ])
                @endcomponent
                @component('components.form.text',[
                    'name' => "contact[$key][title][$i]",
                    'value' => $contact['value'][$i],
                ])
                @endcomponent
            @endfor
    @empty
    @endforelse
    <div>
        تاریخ ایجاد : {{ $business->created_at->diffForHumans() }}
    </div>
    <div>
        آخرین به روزرسانی : {{ $business->updated_at->diffForHumans() }}
    </div>
    <div>
        <div>
            <a href="{{ route('profile.businesses.chats.index', $business->slug) }}">chats</a>
        </div>
        <div>
            <a href="{{ route('profile.businesses.orders.index', $business->slug) }}">orders</a>
        </div>
    </div>
@endsection