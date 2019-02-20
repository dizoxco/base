<div class="mdc-select demo-width-class mdc-select--outlined w-full">
  <input type="hidden" name="enhanced-select">
  <i class="mdc-select__dropdown-icon"></i>
  <div class="mdc-select__selected-text"></div>
  <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
    <ul class="mdc-list">
      @if ($nullable ?? false)
        <li class="mdc-list-item mdc-list-item--selected" data-value="" aria-selected="true"></li>
      @endif
      @foreach ($options ?? [] as $option_key => $option_label)
        <li class="mdc-list-item" data-value="{{$option_key}}">
          {{$option_label}}
        </li>
      @endforeach
    </ul>
  </div>
  <div class="mdc-notched-outline">
    <div class="mdc-notched-outline__leading"></div>
    <div class="mdc-notched-outline__notch">
      <label class="mdc-floating-label">{{$label ?? 'select'}}</label>
    </div>
    <div class="mdc-notched-outline__trailing"></div>
  </div>
</div>