@forelse($products as $product)
    <h1> {{ $product->title }} : {{ $product->tags->pluck('label') }} </h1>
@empty
    <h1> There is no product for this search panel</h1>
@endforelse