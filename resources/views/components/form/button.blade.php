
@php
    $class = 'mdc-button';
    if(isset($type)){
        switch ($type) {
            case 'text': $class .= ''; break;            
            case 'outlined': $class .= ' mdc-button--outlined'; break;            
            case 'raised': $class .= ' mdc-button--raised'; break;            
        }
    }else{
        $class .= ' mdc-button--raised';
    }
    if(isset($dense)) $class .= ' mdc-button--dense';
@endphp
<button class="{{$class}}" @isset($disabled) disabled @endisset data-mdc-auto-init="mdc-ripple">
    @isset($icon)
        <i class="material-icons mdc-button__icon" aria-hidden="true">{{$icon}}</i>
    @endisset
<span class="mdc-button__label">{{$label}}</span>
</button>