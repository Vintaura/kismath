    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Simplified Mobile sidebar toggle logic
    const toggle = document.getElementById('sidebarToggle');
    const close = document.getElementById('sidebarClose');
    const sidebar = document.getElementById('adminSidebar');
    const overlay = document.getElementById('sidebarOverlay');

    if(toggle) {
        toggle.addEventListener('click', () => {
             sidebar.classList.add('active');
             overlay.classList.add('active');
        });
    }
    
    if(close) {
        close.addEventListener('click', () => {
             sidebar.classList.remove('active');
             overlay.classList.remove('active');
        });
    }

    if(overlay) {
        overlay.addEventListener('click', () => {
             sidebar.classList.remove('active');
             overlay.classList.remove('active');
        });
    }
</script>
</body>
</html>
