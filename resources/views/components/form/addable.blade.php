<div class="addable">
    <div class="items">
        {{$items ?? ''}}
    </div>
    <div class="new-item hidden">
        @component('components.form.addable-item')
            {{$slot}}
        @endcomponent
    </div>
    <span class="add">add</span>
</div>