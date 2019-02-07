<div class="flex flex-wrap">
    <div class="w-1/2 my-4">
        @component('components.form.text', [
            'label' => 'نام',
                'icon' => 'edit'
        ])@endcomponent
    </div>
    <div class="w-1/2 my-4">
        @component('components.form.text', [
            'label' => 'ایمیل',
            'icon' => 'edit'
        ])@endcomponent
    </div>
    <div class="w-full my-4">
        @component('components.form.textarea', ['label' => 'پیام شما'])@endcomponent    
    </div>
    <div class="w-full my-4">
        @component('components.form.button', [
            'label' => 'ارسال دیدگاه',
            'raised' => true,
        ])@endcomponent
    </div>
</div>