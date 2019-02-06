
@php
    $class = 'mdc-button';
    if(isset($outlined)) $class .= ' mdc-button--outlined';
    if(isset($raised)) $class .= ' mdc-button--raised';
    if(isset($custom_class)) $class .= $custom_class;
@endphp
<button class="{{$class}}" @isset($disabled) disabled @endisset>
    @isset($icon)
        <i class="material-icons mdc-button__icon" aria-hidden="true">{{$icon}}</i>
    @endisset
<span class="mdc-button__label">{{$label}}</span>
</button>