 @props(['route', 'method' => 'POST', 'id' => null, 'class' => null, 'cancelRoute' => null,'base_route'=>null])
 <form action="{{ $route }}" @if($base_route!=null) base-route="{{ $base_route }}" @endif id="{{ $id }}"
     class="{{ $class }} flex flex-col gap-11 w-full max-w-100 mx-auto" method="{{ $method }}"
     enctype="multipart/form-data">
     @csrf

     @if ($errors->any())
         <div class="mb-4 rounded-md border border-red-300 bg-red-50 p-3 text-red-800">
             <div class="font-semibold mb-2">
                 Terdapat {{ $errors->count() }} kesalahan pada input:
             </div>
             <ul class="list-disc list-inside space-y-0.5 text-sm">
                 @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                 @endforeach
             </ul>
         </div>
     @endif

     {{ $slot }}


     <div class="flex justify-end gap-3 mt-6">
         @if ($cancelRoute)
             <a href="{{ $cancelRoute }}"
                 class="px-6 py-2 bg-gray-300 text-gray-700 rounded-md font-medium hover:bg-gray-400 transition">
                 Batal
             </a>
         @endif
         <button type="submit"
             class="px-6 py-2 bg-black text-white rounded-md font-medium hover:bg-gray-800 transition">
             Simpan Data
         </button>
     </div>
 </form>
