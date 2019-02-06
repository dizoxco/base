@extends('layout')
@section('content')
    <div class="flex flex-wrap">
        <div class="mb-10">
            {{-- @php print_r($post) @endphp --}}
            <article class="mb-10">
                <img class="mb-4" src="{{$post->banner[0]->getUrl('banner')}}" alt="">
                <div class="caption"><time>{{ jdate($post->published_at)->format('Y F d')}}</time></div>
                <h1 class="headline">{{$post->title}}</h1>
                <div class="body-2">
                    {{$post->body}}
                </div>
            </article>
            <div class="related-post py-4">
                <h3 class="title-2">مطالب مرتبط</h3>
                <div class="flex flex-row flex-wrap" column="2">
                    @foreach (range(1,4) as $id)
                    <div class="w-full md:w-1/2 p-2">
                        @component('components.post.card-horizontal', ['post' => $recent[$id]]) @endcomponent
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="comments py-4">
                @component('components.comment',['post' => $post]) @endcomponent
            </div>
            <div class="comment-form flex flex-wrap py-4">
                <div class="w-1/5"></div>
                <div class="w-3/5 flex flex-wrap">
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
                <div class="w-1/5"></div>

            </div>
        </div>
    </div>    
@endsection