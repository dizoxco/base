@php
    $class = 'mdc-text-field mdc-text-field--outlined w-full';
    if(isset($shaped)) $class .= ' shaped';
    if(isset($icon)) $class .= isset($icon_front)? ' mdc-text-field--with-trailing-icon': ' mdc-text-field--with-leading-icon';
@endphp
@component('components.form.field', ['half' => $half ?? false])    
    <div class="{{$class}}"  data-mdc-auto-init="mdc-text-field">
        @isset($icon)
            <i class="material-icons mdc-text-field__icon" role="button" data-mdc-auto-init="mdc-text-field-icon">{{$icon}}</i>
        @endisset
        <input type="text" id="tf-outlined" class="mdc-text-field__input" name="{{$name ?? ''}}" value="{{$value ?? ''}}">
        <div class="mdc-notched-outline">
            <div class="mdc-notched-outline__leading"></div>
            <div class="mdc-notched-outline__notch">
                <label for="tf-outlined" class="mdc-floating-label">{{$label ?? ''}}</label>
            </div>
            <div class="mdc-notched-outline__trailing"></div>
        </div>
    </div>
    @if ( isset($name) && $errors->first($name) )
        <span class="helper-text" data-error="{{ $errors->first($name) }}" ></span>
    @else
        @isset($helper)
            <span class="helper-text" data-error="wrong" data-success="right">{{ $helper }}</span>
        @endisset
    @endif
@endcomponent
