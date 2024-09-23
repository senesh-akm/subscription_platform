<x-mail::message>
@component('mail::message')
# New Post Published: {{ $post->title }}

{{ $post->description }}

Visit the website for more details.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
</x-mail::message>
