@props(['footer' => true, 'id', 'title' => 'Modal Title', 'head' => true, 'target' => null])

<!-- Modal -->
<div class="modal fade backdrop-blur-sm overflow-y-hidden" id="{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered flex items-center justify-center modal-dialog-scrollable">
        <div class="modal-content bg-white/95 backdrop-blur-md rounded-md shadow-2xl border transition-all transform scale-100 opacity-100"
            style="max-width: 75%;">

            <!-- Header -->
            @if ($head)
                <div
                    class="flex items-center justify-between px-5 py-3 bg-gradient-to-r from-[#1C2762] to-[#2E3D8F] rounded-t-2xl">
                    <h5 class="text-lg font-semibold text-white tracking-wide">{{ $title }}</h5>
                    <button type="button" class="text-white/70 hover:text-white transition" data-bs-dismiss="modal"
                        aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            <!-- Body -->
            <div class="p-6 text-gray-700 leading-relaxed overflow-y-auto" style="max-height: 55%;">
                {{ $slot }}
            </div>

            <!-- Footer -->
            @if ($footer)
                <div class="flex justify-end gap-3 border-t border-gray-100 px-6 py-4 bg-gray-50 rounded-b-2xl">
                    <button type="button"
                        class="px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-100 transition"
                        data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                        Save changes
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Bootstrap JS (wajib untuk fungsi modal) -->

<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
