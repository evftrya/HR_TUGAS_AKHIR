<script>
document.addEventListener('DOMContentLoaded', () => {
    /**
     * 1. LOGIKA AWAL MASUK (INITIAL LOAD)
     */
    const aside = document.querySelector('aside');
    if (!aside) return;

    // Ganti pencarian selector ke class spesifik yang baru ditambahkan
    const groups = aside.querySelectorAll('.sidebar-group-item');
    let groupToOpen = null;

    const currentUrl = window.location.href;

    groups.forEach(group => {
        const links = group.querySelectorAll('a');
        links.forEach(link => {
            if (link.href === currentUrl || link.classList.contains('active')) {
                groupToOpen = group;
            }
        });
    });

    if (!groupToOpen && groups.length > 0) {
        groupToOpen = groups[0];
    }

    if (groupToOpen) {
        openAlpineGroup(groupToOpen);
    }
});

/**
 * Fungsi pembantu untuk membuka Alpine Group secara aman
 */
function openAlpineGroup(group) {
    const titleButton = group.querySelector('button');
    if (!titleButton) return;

    const icon = titleButton.querySelector('svg');
    if (!icon) return;

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
    // Ganti pencarian selector ke class spesifik yang baru ditambahkan
    const groups = aside.querySelectorAll('.sidebar-group-item');

    groups.forEach(group => {
        const titleButton = group.querySelector('button');
        if (!titleButton) return;

        const titleSpan = titleButton.querySelector('span');
        const titleText = titleSpan ? titleSpan.textContent.toLowerCase() : '';
        const menuItems = group.querySelectorAll('li');

        let hasVisibleChild = false;
        const matchGroup = titleText.includes(query);

        if (query === "") {
            // Reset state
            group.style.display = "";
            menuItems.forEach(li => li.style.display = "");
            return;
        }

        menuItems.forEach(li => {
            const itemText = li.textContent.toLowerCase();
            if (itemText.includes(query) || matchGroup) {
                li.style.display = ""; // Reset ke display default
                hasVisibleChild = true;
            } else {
                li.style.display = "none";
            }
        });

        if (matchGroup || hasVisibleChild) {
            group.style.setProperty('display', 'block', 'important');
            openAlpineGroup(group);
        } else {
            group.style.setProperty('display', 'none', 'important');
        }
    });
}
</script>
