<html>
<head>
    <meta charset="utf8">
</head>
@forelse($businesses as $business)
    <h1> {{ $business->brand }} </h1>
    @forelse($business->tags->pluck('label') as $label)
        <h3> {{ $label }}</h3>
    @empty
        <h3>-</h3>
    @endforelse
    <hr>
@empty
    <h1> There is no business for this search panel</h1>
@endforelse
</html>