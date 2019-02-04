@forelse($infos as $info)
    <label >{{ $info['label'] }}</label>
    <p> {{ $info['value'] }}</p>
@empty
    There is no contact information
@endempty