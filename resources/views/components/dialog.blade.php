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
        @foreach ($buttons ?? [] as $button => $label)
          <button type="button" class="mdc-button mdc-dialog__button" data-mdc-dialog-action="{{$button}}">
            <span class="mdc-button__label">{{$label}}</span>
          </button>
        @endforeach
        @isset($cancel)
          <a class="mdc-button mdc-dialog__button" data-mdc-dialog-action="cancel">
            <span class="mdc-button__label">{{$cancel}}</span>
          </a>
        @endisset
      </footer>
    </div>
  </div>
  <div class="mdc-dialog__scrim"></div>
</div>