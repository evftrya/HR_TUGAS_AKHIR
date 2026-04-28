<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Logika: Aktifkan grup pertama jika tidak ada yang terbuka saat load
    const firstGroup = document.querySelector('aside .border.mb-2');
    if (firstGroup) {
        const titleButton = firstGroup.querySelector('button');
        const icon = titleButton.querySelector('svg');

        // Cek jika saat ini masih tertutup (berdasarkan class rotasi icon)
        if (!icon.classList.contains('rotate-180')) {
            titleButton.click();
        }
    }
});

function searchInput(elemen) {
    const query = elemen.value.toLowerCase().trim();
    const groups = elemen.closest('aside').querySelectorAll('.border.mb-2');

    groups.forEach(group => {
        const titleButton = group.querySelector('button');
        const titleText = titleButton.querySelector('span').textContent.toLowerCase();
        const menuItems = group.querySelectorAll('li');

        let hasVisibleChild = false;
        const matchGroup = titleText.includes(query);

        // 2. Filter item menu (Anak)
        menuItems.forEach(li => {
            const itemText = li.textContent.toLowerCase();
            // Anak tampil jika: query match dengan teks anak ATAU query match dengan nama grupnya
            if (itemText.includes(query) || (matchGroup && query !== "")) {
                li.style.display = "block";
                hasVisibleChild = true;
            } else {
                li.style.display = "none";
            }
        });

        // 3. Logika Menampilkan Group & Sinkronisasi Alpine
        if (query === "") {
            // Jika search dikosongkan, kembalikan semua grup ke display asal
            group.style.display = "block";
            // Kita tidak memaksa tutup/buka agar user experience tetap terjaga
        } else {
            if (matchGroup || hasVisibleChild) {
                group.style.setProperty('display', 'block', 'important');

                // Cek status Alpine via icon class
                const icon = titleButton.querySelector('svg');
                const isClosed = !icon.classList.contains('rotate-180');

                // Jika match dan masih tertutup, kita buka
                if (isClosed) {
                    titleButton.click();
                }
            } else {
                group.style.setProperty('display', 'none', 'important');
            }
        }
    });
}
</script>
