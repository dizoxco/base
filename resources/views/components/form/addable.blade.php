<div class="addable">
    <div class="items">
        {{$items ?? ''}}
        @if ($new ?? false)
            @component('components.form.addable-item')
                {{$slot}}
            @endcomponent
        @endif
    </div>
    <div class="new-item hidden">
        @component('components.form.addable-item')
            {{$slot}}
        @endcomponent
    </div>
    <span class="add">افزودن</span>
</div>