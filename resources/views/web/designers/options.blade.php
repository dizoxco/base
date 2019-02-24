@php
    $level = $level ?? '';
    $options_list = [];
    $values_list = [];
@endphp
<div class="options" panel="{{$level}}">
    @if ($level != '')
        <h2 class="back m-4">برگشت</h2>
    @endif
    @foreach ($options as $option_index => $option)
        @php $scope_level = $level.'o'.$option_index; @endphp
        <div class="option sq" option="{{$scope_level}}" camera={{$option['camera']}}>
            <h2 class="m-4">{{$option['label']}}</h2>
        </div>
        @isset($option['options'])
            @php $options_list[$scope_level] = $option['options'] @endphp
        @endisset
        @isset($option['values'])
            @php $values_list[$scope_level] = $option['values'] @endphp
        @endisset
    @endforeach
</div>
@foreach ($options_list as $option_index => $options)
    @component('web.designers.options', ['options' => $options, 'level' => $option_index])@endcomponent
@endforeach
@foreach ($values_list as $value_index => $values)
    @component('web.designers.values', ['values' => $values, 'level' => $value_index])@endcomponent
@endforeach