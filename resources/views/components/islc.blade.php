@props(['lbl', 'nm' => null, 'req' => true,'fill' => '','full' => 'true',])
<div class="flex flex-col @if($full === 'true') flex-grow @endif gap-1 {{ $fill }}">
    <label class="text-sm text-gray-600 font-medium">{{ $lbl }} @if ($req)
            *
        @endif
    </label>
    <select name="{{ $nm }}" @if($req) required @endif
        class="h-10 border border-gray-300 rounded-md px-3 text-gray-700 focus:outline-none focus:ring-1 focus:ring-gray-400">
        {{ $slot }}
    </select>
</div>
