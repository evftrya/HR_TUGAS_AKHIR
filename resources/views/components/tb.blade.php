@props(['id' => null, 'cls' => null, 'search_status' => true])
{{-- @aware(['table_header', 'table_column', 'put_something', 'search_status']) --}}
@aware(['table_header', 'table_column', 'put_something'])

<style>
    .search-input {
        border: rgba(0, 0, 0, 0.097) 0.5px solid !important;
        border-radius: 4px !important;
        font-size: 10px !important;
    }

    th.sortable {
        cursor: pointer;
        user-select: none;
        transition: color 0.3s ease;
    }

    th.sortable:hover {
        color: #2563eb;
    }

    .sort-icon {
        font-size: 10px;
        margin-left: 5px;
        color: #9ca3af;
    }

    .fixed-table-loading {
        display: none !important;
    }

    .bootstrap-table .fixed-table-toolbar .search {
        display: none !important;
    }

    /* Menghilangkan margin toolbar jika kosong agar tidak ada gap aneh */
    .bootstrap-table .fixed-table-toolbar {
        display: none;
    }
</style>
{{-- {{ dd($id,$search_status==true) }} --}}

@if ($search_status == true)
    {{-- {{ dd($search_status,'masuk') }} --}}
    <div id="cekser"
        class="h-auto max-h-fit bg-yellow-200 w-full min-w-full flex flex-row justify-center items-center gap-2.5 rounded-[6px] mb-1">
        <div
            class="flex min-w-full w-full items-center gap-[6px] self-stretch bg-white px-[12px] py-[8px] rounded-lg border border-[#d0d5dd] flex-grow">
            <i class="fa-solid fa-magnifying-glass text-sm text-gray-500"></i>
            <!-- ⚡ Bootstrap Table akan otomatis deteksi input ini -->
            <input id="customSearchInput" type="text" placeholder="Search"
                class="font-medium border-none outline-none p-1 focus:ring-0 w-full text-sm leading-[14.6px] text-[#344054]">
        </div>
        {{ $put_something }}
    </div>
@endif

<div class="overflow-hidden pb-2 pt-0 w-full">
    <div class="overflow-x-auto border border-gray-200 rounded-lg">
        <div class="inline-block w-full align-middle">
            <div>
                <table id="{{ $id }}" data-toggle="table" data-search="true" data-filter-control="true"
                    data-show-loading="false" data-visible-search="false" {{-- Sembunyikan search bawaan yang jelek --}}
                    class="min-w-full table-auto border border-gray-200 rounded-lg text-sm text-blue-900 border-collapse {{ $cls }}">

                    <thead class="bg-[#f4f4f5] rounded-lg text-center align-middle">
                        <th data-formatter="indexFormatter" data-align="center" width="5%">No</th>
                        {{ $table_header }}
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-center align-middle">
                        {{ $table_column }}
                    </tbody>
                </table>
            </div>


            {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> //sudah ada di app --}}

        </div>
    </div>
</div>

@push('script-under-base')
    <script>
        // Taruh di luar document ready agar tersedia secara global sebelum table init
        window.indexFormatter = function(value, row, index) {
            // Ambil ID table dari PHP blade
            const tableId = "{{ $id }}";
            const $table = $('#' + tableId);

            // Cek jika bootstrapTable sudah terinisialisasi
            if ($table.data('bootstrap.table')) {
                const opts = $table.bootstrapTable('getOptions');
                const offset = (opts.pageNumber - 1) * opts.pageSize;
                return offset + index + 1;
            }

            // Default jika data belum siap
            return index + 1;
        };

        $(function() {
            const tableId = "{{ $id }}";
            const $table = $('#' + tableId);
            const $searchInput = $('#customSearchInput');

            // Hubungkan input custom ke fitur search Bootstrap Table
            $searchInput.on('input', function() {
                $table.bootstrapTable('resetSearch', $(this).val());
            });

            // Event listener untuk update icon sort
            $table.on('sort.bs.table', function(e, name, order) {
                updateSortIcons(tableId, name, order);
            });

            function updateSortIcons(tableId, columnName, order) {
                const $thead = $(`#${tableId}`).closest('.bootstrap-table').find('thead');

                // Reset semua icon
                $thead.find('i.sort-icon')
                    .removeClass('bi-sort-up bi-sort-down text-blue-500')
                    .addClass('bi-filter text-gray-400');

                // Set icon aktif
                const $activeTh = $thead.find(`th[data-field="${columnName}"]`);
                const $icon = $activeTh.find('i.sort-icon');

                if ($icon.length) {
                    $icon.removeClass('bi-filter text-gray-400');
                    if (order === 'asc') $icon.addClass('bi-sort-up text-blue-500');
                    else if (order === 'desc') $icon.addClass('bi-sort-down text-blue-500');
                }
            }
        });
    </script>
@endpush
