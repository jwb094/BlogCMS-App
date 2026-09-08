    const sidebar = document.getElementById('adminSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarClose = document.getElementById('sidebarClose');

    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.add('show');
    });

    sidebarClose.addEventListener('click', () => {
        sidebar.classList.remove('show');
    });