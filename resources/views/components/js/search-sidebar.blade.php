<script>
document.addEventListener('DOMContentLoaded', () => {
    /**
     * 1. LOGIKA AWAL MASUK (INITIAL LOAD)
     */
    const aside = document.querySelector('aside');
    if (!aside) return;

    const groups = aside.querySelectorAll('.border.mb-2');
    let groupToOpen = null;

    // Cari grup yang memiliki menu aktif berdasarkan URL saat ini
    // Kita cek apakah ada link (<a>) yang href-nya cocok dengan URL sekarang
    const currentUrl = window.location.href;

    groups.forEach(group => {
        const links = group.querySelectorAll('a');
        links.forEach(link => {
            if (link.href === currentUrl || link.classList.contains('active')) {
                groupToOpen = group;
            }
        });
    });

    // Jika tidak ada yang match active route, pilih grup paling atas
    if (!groupToOpen && groups.length > 0) {
        groupToOpen = groups[0];
    }

    // Buka group yang ditentukan
    if (groupToOpen) {
        openAlpineGroup(groupToOpen);
    }
});

/**
 * Fungsi pembantu untuk membuka Alpine Group secara aman
 */
function openAlpineGroup(group) {
    const titleButton = group.querySelector('button');
    const icon = titleButton.querySelector('svg');
    // Cek apakah sedang tertutup (biasanya icon tidak berotasi 180 derajat)
    const isClosed = !icon.classList.contains('rotate-180');

    if (isClosed) {
        titleButton.click();
    }
}

/**
 * 2. LOGIKA SEARCH
 */
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

        if (query === "") {
            // Jika search dihapus: Tampilkan semua grup & anak
            group.style.display = "block";
            menuItems.forEach(li => li.style.display = "block");
            return;
        }

        // Cek kecocokan anak
        menuItems.forEach(li => {
            const itemText = li.textContent.toLowerCase();
            // Anak tampil jika: namanya match ATAU nama grupnya match
            if (itemText.includes(query) || matchGroup) {
                li.style.display = "block";
                hasVisibleChild = true;
            } else {
                li.style.display = "none";
            }
        });

        // Tampilkan/Sembunyikan Grup
        if (matchGroup || hasVisibleChild) {
            group.style.setProperty('display', 'block', 'important');

            // JIKA MATCH (baik group atau anak), PAKSA BUKA (OPEN MODE)
            openAlpineGroup(group);
        } else {
            group.style.setProperty('display', 'none', 'important');
        }
    });
}
</script>
