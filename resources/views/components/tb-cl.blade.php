@props(['id' => null, 'cls' => null, 'idTargetModal' => null, 'topping' => null])

<tr class="x-tb-cl group transition-colors hover:bg-[#fbfbfb] {{ $cls }}"
    @if($id!=null) id="{{ $id }}" @endif
    @if($idTargetModal) data-bs-toggle="modal" data-bs-target="#{{ $idTargetModal }}" @endif
    {!! $topping !!}>
    <td class="py-4 text-gray-400 font-medium text-sm"></td>
    {{ $slot }}
</tr>