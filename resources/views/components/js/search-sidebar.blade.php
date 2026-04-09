<script>
function searchInput(elemen) {
    const query = elemen.value.toLowerCase().trim();
    
    // Ambil semua wrapper group (div terluar di sidebar-group)
    const groups = elemen.closest('aside').querySelectorAll('.border.mb-2');

    groups.forEach(group => {
        // 1. Cari elemen-elemen penting di dalam group
        const titleText = group.querySelector('button span').textContent.toLowerCase();
        const menuItems = group.querySelectorAll('li');
        const contentContainer = group.querySelector('div[x-ref="container"]');
        
        let hasVisibleChild = false;

        // 2. Filter item menu (li) di dalam group
        menuItems.forEach(li => {
            const itemText = li.textContent.toLowerCase();
            if (itemText.includes(query)) {
                li.style.display = "block";
                hasVisibleChild = true;
            } else {
                li.style.display = "none";
            }
        });

        // 3. Logika Menampilkan/Menyembunyikan Group
        // Group tampil jika Judul cocok ATAU ada isi yang cocok
        if (titleText.includes(query) || hasVisibleChild) {
            group.style.setProperty('display', 'block', 'important');
            
            // Jika sedang mencari (query tidak kosong), paksa buka menu
            if (query !== "") {
                contentContainer.style.maxHeight = contentContainer.scrollHeight + "px";
                // Kita tambahkan inline style untuk meng-override Alpine sementara
                contentContainer.style.opacity = "1";
            } else {
                // Jika query kosong, kembalikan ke kontrol Alpine (hapus style manual)
                contentContainer.style.maxHeight = "";
            }
        } else {
            group.style.setProperty('display', 'none', 'important');
        }
    });
}
</script>