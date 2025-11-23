@props(['id' => null, 'cls' => null, 'idTargetModal' => null, 'topping' => null])

<tr class="x-tb-cl {{ $cls }}"
    @if($id!=null) id="{{ $id }}" @endif
    
    @if($idTargetModal) data-bs-toggle="modal" data-bs-target="#{{ $idTargetModal }}" @endif
    {!! $topping !!}>
    <x-tb-cl-fill cls="numbering"></x-tb-cl-fill>
    {{ $slot }}
</tr>
