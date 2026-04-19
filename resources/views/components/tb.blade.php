@props(['id' => null, 'cls' => null, 'search_status' => true])
@aware(['table_header', 'table_column', 'put_something'])

<style>
    /* Elevasi Apple: Memberi kontras di atas background putih */
    .apple-wrapper {
        background: #ffffff;
        border-radius: 20px;
        /* Shadow lebih dalam agar terpisah dari bg putih */
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
        border: 1px solid #f2f2f7;
        padding: 4px;
        /* Space kecil antara border luar dan isi */
    }

    .search-input-wrapper {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #e5e5ea !important;
        background-color: #f5f5f7;
        /* Sedikit abu agar kontras dengan input */
    }

    .search-input-wrapper:focus-within {
        background-color: #ffffff;
        border-color: #007AFF !important;
        box-shadow: 0 0 0 4px rgba(0, 122, 255, 0.1);
    }

    /* Bootstrap Table Customization */
    .bootstrap-table .fixed-table-container {
        border: none !important;
        background: transparent !important;
    }

    .th-inner {
        color: #1d1d1f !important;
        font-weight: 700 !important;
        font-size: 13px;
    }

    /* Styling Header: Sedikit lebih gelap dari bg putih utama */
    thead.apple-header {
        background-color: #fbfbfd;
        border-bottom: 1.5px solid #f2f2f7;
    }

    .fixed-table-loading {
        display: none !important;
    }

    .bootstrap-table .fixed-table-toolbar {
        display: none;
    }
</style>

@if ($search_status == true)
    <div id="cekser" class="flex flex-row justify-center items-center gap-3 mb-5 px-1">
        <div class="search-input-wrapper flex items-center gap-3 px-4 py-2.5 rounded-2xl flex-grow">
            <i class="fa-solid fa-magnifying-glass text-[#86868b] text-sm"></i>
            <input id="customSearchInput" type="text" placeholder="Cari data..."
                class="bg-transparent border-none outline-none w-full text-[15px] text-[#1d1d1f] placeholder-[#86868b] focus:ring-0">
        </div>
        @if (isset($put_something))
            <div class="flex-shrink-0 flex gap-2 flex-row">
                {{ $put_something }}
            </div>
        @endif
    </div>
@endif

<div class="w-full">
    <div class="apple-wrapper overflow-hidden bg-white">
        <div class="overflow-x-auto">
            <table id="{{ $id }}" data-toggle="table" data-search="true" data-filter-control="true"
                data-show-loading="false" data-visible-search="false"
                @if (request()->has('sort') && request()->has('order')) data-sort-name="{{ request('sort') }}"
    data-sort-order="{{ request('order') }}" @endif
                class="min-w-full align-middle {{ $cls }}">

                <thead class="apple-header">
                    <tr>
                        <th data-formatter="indexFormatter" data-align="center" class="py-4 text-[#86868b]"
                            width="65px">No</th>
                        {{ $table_header }}
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f2f2f7]">
                    {{ $table_column }}
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('script-under-base')
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script>
        window.indexFormatter = function(value, row, index) {
            const tableId = "{{ $id }}";
            const $table = $('#' + tableId);
            if ($table.data('bootstrap.table')) {
                const opts = $table.bootstrapTable('getOptions');
                return ((opts.pageNumber - 1) * opts.pageSize) + index + 1;
            }
            return index + 1;
        };

        $(function() {
            const tableId = "{{ $id }}";
            const $table = $('#' + tableId);
            const $searchInput = $('#customSearchInput');

            $searchInput.on('input', function() {
                $table.bootstrapTable('resetSearch', $(this).val());
            });

            $table.on('sort.bs.table', function(e, name, order) {
                const $thead = $table.closest('.bootstrap-table').find('thead');
                $thead.find('i.sort-icon').removeClass('bi-sort-up bi-sort-down text-[#007AFF]').addClass(
                    'bi-filter text-[#aeaeb2]');

                const $activeTh = $thead.find(`th[data-field="${name}"]`);
                const $icon = $activeTh.find('i.sort-icon');

                if ($icon.length) {
                    $icon.removeClass('bi-filter text-[#aeaeb2]');
                    $icon.addClass(order === 'asc' ? 'bi-sort-up text-[#007AFF]' :
                        'bi-sort-down text-[#007AFF]');
                }
            });
        });
    </script>
@endpush
