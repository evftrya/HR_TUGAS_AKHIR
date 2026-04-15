@php
    use App\Helpers\PhoneHelper;
    $active_sidebar = 'History SK Dan Amandemen';
@endphp

@extends('kelola_data.base-profile')

@section('title-the-page')
    {{ $active_sidebar }}
@endsection

@section('content-profile')
    <div class="relative mx-auto px-4 py-12 font-sans rounded-xl shadow-lg overflow-hidden" style="background: #6176CC;">

        <div class="pattern-batik-kawung-dark absolute inset-0 opacity-10 pointer-events-none"
            style="background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCI+PHBhdGggZD0iTTMwIDBjMTYuNTY5IDAgMzAgMTMuNDMxIDMwIDMwcy0xMy40MzEgMzAtMzAgMzBTMCA0Ni41NjkgMCAzMCAxMy40MzEgMCAzMCAwek0wIDMwYzAgMTEuMDU2IDguOTQ0IDIwIDIwIDIwczIwLTguOTQ0IDIwLTIwUzMxLjA1NiAxMCAyMCAxMCAwIDE4Ljk0NCAwIDMwek0zMCA2MGMxMS4wNTYgMCAyMC04Ljk0NCAyMC0yMHMtOC45NDQtMjAtMjAtMjBTMTAgMjguOTQ0IDEwIDQwczguOTQ0IDIwIDIwIDIwek0zMCAwQzE4Ljk0NCAwIDEwIDguOTQ0IDEwIDIwczguOTQ0IDIwIDIwIDIwIDIwLTguOTQ0IDIwLTIwUzQxLjA1NiAwIDMwIDB6IiBmaWxsPSIjMDAwIiBmaWxsLW9wYWNpdHk9Ii4xIi8+PC9zdmc+');">
        </div>

        <div class="relative z-10">
            <div class="mb-12 text-center">
                <h3 class="text-2xl font-bold text-white">Riwayat Nomor Induk Kepegawaian (NIP)</h3>
                <p class="mt-2 text-sm text-blue-100">Kronologi NIP</p>
            </div>

            <div class="relative mt-4">
                <div class="absolute bottom-0 left-8 top-0 w-1 -translate-x-1/2 rounded bg-blue-400/30 md:left-1/2"></div>



                <div class="space-y-8">
                    @forelse ($nips as $nip)
                        <div
                            class="relative w-full md:flex {{ $loop->iteration % 2 == 1 ? 'md:justify-end' : 'md:justify-start' }}">
                            <div
                                class="absolute left-8 top-6 z-10 h-5 w-5 -translate-x-1/2 rounded-full border-4 border-orange-500 bg-white md:left-1/2">
                            </div>
                            <div class="ml-16 w-[calc(100%-4rem)] md:ml-0 md:w-5/12">
                                <div
                                    class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-100 transition-transform duration-300 hover:-translate-y-1 hover:shadow-md">
                                    <span class="mb-3 block text-sm font-semibold text-gray-400">{{ $nip->tmt_mulai }}</span>
                                    <div>
                                        <span
                                            class="inline-block rounded border-l-4 border-orange-500 bg-orange-50 px-2.5 py-1 text-xs font-bold uppercase tracking-wider text-orange-600">
                                            {{ $nip->statusPegawai->status_pegawai }}
                                        </span>
                                    </div>
                                    <div class="mb-3 mt-3 text-sm font-medium text-gray-500">NIP: {{ $nip->nip }}</div>
                                    {{-- <p class="mb-5 text-sm leading-relaxed text-gray-600">{{ $sk->keterangan }}</p> --}}
                                    <div class="text-right">
                                        <a href="{{ route('manage.sk.view', ['id_sk_or_sk_number' => $nip->sk_ypt_or_amandemen]) }}"
                                            class="inline-block rounded bg-blue-600 px-4 py-2 text-xs font-medium text-white hover:bg-blue-700">View
                                            Document SK</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>

            </div>
        </div>
    </div>
@endsection
