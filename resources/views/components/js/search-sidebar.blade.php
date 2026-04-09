<script>
function searchInput(elemen) {
    const query = elemen.value.toLowerCase().trim();
    const groups = elemen.closest('aside').querySelectorAll('.border.mb-2');

    groups.forEach(group => {
        const titleButton = group.querySelector('button');
        const titleText = titleButton.querySelector('span').textContent.toLowerCase();
        const menuItems = group.querySelectorAll('li');
        const contentContainer = group.querySelector('div[x-ref="container"]');
        
        let hasVisibleChild = false;

        // 1. Filter item menu
        menuItems.forEach(li => {
            const itemText = li.textContent.toLowerCase();
            if (itemText.includes(query)) {
                li.style.display = "block";
                hasVisibleChild = true;
            } else {
                li.style.display = "none";
            }
        });

        // 2. Logika Menampilkan Group & Sinkronisasi Alpine
        if (titleText.includes(query) || hasVisibleChild) {
            group.style.setProperty('display', 'block', 'important');
            
            if (query !== "") {
                // CEK APAKAH MENU SEDANG TERTUTUP (max-height = 0 atau hampir 0)
                // Kita cek SVG icon-nya. Biasanya Alpine memutar icon jika terbuka.
                const icon = titleButton.querySelector('svg');
                const isClosed = !icon.classList.contains('rotate-180');

                if (isClosed) {
                    // Paksa klik tombolnya agar variabel 'open' di Alpine jadi true
                    titleButton.click();
                }
            }
        } else {
            group.style.setProperty('display', 'none', 'important');
        }

        // 3. Jika query dihapus, kita tidak paksa apa-apa, biarkan user yang kelola
    });
}
</script>