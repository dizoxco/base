@php
    $class = 'mdc-text-field mdc-text-field--textarea';
@endphp
@component('components.form.field', ['half' => $half ?? false])    
    <div class="{{$class}}"  data-mdc-auto-init="mdc-text-field">
        <textarea id="textarea" class="mdc-text-field__input" rows="8" name="{{$name ?? ''}}" >{{$value ?? ''}}</textarea>
        <div class="mdc-notched-outline">
            <div class="mdc-notched-outline__leading"></div>
            <div class="mdc-notched-outline__notch">
                <label for="textarea" class="mdc-floating-label">{{$label ?? ''}}</label>
            </div>
            <div class="mdc-notched-outline__trailing"></div>
        </div>
    </div>
@endcomponent