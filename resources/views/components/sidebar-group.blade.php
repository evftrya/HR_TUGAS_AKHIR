@props(['title' => null,'hide'=>null])

<p class="px-2 py-2 text-sm text-black sm-hide">{{$title}}</p>
<hr class="sm-show mx-2 hidden mb-4">

<ul class="space-y-1 mb-4">
    {{ $slot }}
</ul>