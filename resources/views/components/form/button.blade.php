
@php
    $class = 'mdc-button';
    if(isset($outlined)) $class .= ' mdc-button--outlined';
    if(isset($raised)) $class .= ' mdc-button--raised';
@endphp
<button class="{{$class}}" @isset($disabled) disabled @endisset>
    @isset($icon)
        <i class="material-icons mdc-button__icon" aria-hidden="true">{{$icon}}</i>
    @endisset
    <span class="mdc-button__label">مورد علاقه</span>
</button>