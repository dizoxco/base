@forelse($businesses as $business)
    <h1> {{ $business->brand }} : {{ $product->tags->pluck('label') }} </h1>
@empty
    <h1> There is no business for this search panel</h1>
@endforelse