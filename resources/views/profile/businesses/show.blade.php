@extends('profile.businesses.layout', ['title' => $business->brand])
@section('profile-content')
    <div class="mb-3">
        <span class="text-grey-dark font-bold pl-4 my-2 ">برند : </span>
        {{ $business->brand }}
    </div>
    <div class="mb-3">
        <span class="text-grey-dark font-bold pl-4 my-2 ">شهر : </span>
        {{ $business->city->name }}
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
    <div class="mb-3">
        <span class="text-grey-dark font-bold pl-4 my-2 ">تاریخ ایجاد : </span>

        {{ $business->created_at->diffForHumans() }}
    </div>
    <div class="mb-3">
        <span class="text-grey-dark font-bold pl-4 my-2 ">آخرین به روزرسانی :</span>
        {{ $business->updated_at->diffForHumans() }}
    </div>
@endsection