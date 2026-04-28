<script>
document.addEventListener('DOMContentLoaded', () => {
    /**
     * 1. Logika Auto-Open Saat Load
     * Prioritas:
     * - Cari grup yang punya anak 'active'
     * - Jika tidak ada, buka grup pertama
     */
    const aside = document.querySelector('aside');
    if (!aside) return;

    const groups = aside.querySelectorAll('.border.mb-2');
    let groupToOpen = null;

    // Cari grup yang mengandung elemen aktif (misal class 'active' atau link yang sedang dibuka)
    // Sesuaikan selector '.active' atau '.bg-blue-500' sesuai class aktif di template Anda
    groups.forEach(group => {
        const hasActiveChild = group.querySelector('li.active, a.active, .bg-primary'); // Ganti selector jika perlu
        if (hasActiveChild) {
            groupToOpen = group;
        }
    });

    // Jika tidak ada yang aktif, pilih grup pertama
    if (!groupToOpen && groups.length > 0) {
        groupToOpen = groups[0];
    }

    // Eksekusi buka group
    if (groupToOpen) {
        const titleButton = groupToOpen.querySelector('button');
        const icon = titleButton.querySelector('svg');

        // Cek Alpine state via icon: jika belum berotasi (tertutup), klik!
        if (icon && !icon.classList.contains('rotate-180')) {
            titleButton.click();
        }
    }
});

function searchInput(elemen) {
    const query = elemen.value.toLowerCase().trim();
    const aside = elemen.closest('aside');
    const groups = aside.querySelectorAll('.border.mb-2');

    groups.forEach(group => {
        const titleButton = group.querySelector('button');
        const titleText = titleButton.querySelector('span').textContent.toLowerCase();
        const menuItems = group.querySelectorAll('li');

        let hasVisibleChild = false;
        const matchGroup = titleText.includes(query);

        /**
         * 2. Logika Filter Anak
         */
        menuItems.forEach(li => {
            const itemText = li.textContent.toLowerCase();

            if (query === "") {
                // Jika search kosong, kembalikan tampilan default (tampilkan semua)
                li.style.display = "block";
            } else {
                // Anak tampil jika teksnya cocok ATAU nama grupnya cocok
                if (itemText.includes(query) || matchGroup) {
                    li.style.display = "block";
                    hasVisibleChild = true;
                } else {
                    li.style.display = "none";
                }
            }
        });

        /**
         * 3. Logika Menampilkan Group & Auto-Expand
         */
        if (query === "") {
            // Reset ke tampilan normal
            group.style.display = "block";
        } else {
            if (matchGroup || hasVisibleChild) {
                // Tampilkan grup jika match nama grup atau ada anak yang match
                group.style.setProperty('display', 'block', 'important');

                // AUTO-OPEN: Buka group jika match (agar anak terlihat)
                const icon = titleButton.querySelector('svg');
                const isClosed = icon && !icon.classList.contains('rotate-180');

                if (isClosed) {
                    titleButton.click(); // Trigger Alpine.js toggle
                }
            } else {
                // Sembunyikan grup jika tidak ada satupun yang match
                group.style.setProperty('display', 'none', 'important');
            }
        }
    });
}
</script>
