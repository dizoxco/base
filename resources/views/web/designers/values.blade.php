<div class="values" panel={{$level}}>
    @foreach ($values as $value_index => $value)
        <div class="sq value" 
            key={{$value['key']}} 
            @isset($value['value']) value={{$value['value']}} @endisset 
            @isset($value['fabric']) fabric={{$value['fabric']}} @endisset
            @isset($value['flag']) flag={{$value['flag']}} @endisset
            @isset($value['flagup']) flagup={{$value['flagup']}} @endisset
            @isset($value['flagdown']) flagdown={{$value['flagdown']}} @endisset >
            <h2 class="m-4">
                {{$value['label']}}
            </h2>
        </div>
    @endforeach
</div>
