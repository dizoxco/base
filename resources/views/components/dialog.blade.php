<div class="mdc-dialog" id="{{$id ?? 'id'}}">
  <div class="mdc-dialog__container">
    <div class="mdc-dialog__surface">
      @isset($title)
        <h2 class="mdc-dialog__title" id="my-dialog-title">
          {{$title ?? 'عنوان'}}
        </h2>
      @endisset
      <div class="mdc-dialog__content" id="my-dialog-content">
        {{ $slot }}
      </div>
      <footer class="mdc-dialog__actions">
        <button type="button" class="mdc-button mdc-dialog__button" data-mdc-dialog-action="no">
          <span class="mdc-button__label">No</span>
        </button>
        <a class="mdc-button mdc-dialog__button" data-mdc-dialog-action="yes">
          <span class="mdc-button__label">Yes</span>
        </a>
      </footer>
    </div>
  </div>
  <div class="mdc-dialog__scrim"></div>
</div>