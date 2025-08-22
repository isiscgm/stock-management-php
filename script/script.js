
function toggleSidebar() {
    var sidebar = document.getElementById("mySidebar");
    var overlay = document.getElementById("myOverlay");
    var isVisible = window.getComputedStyle(sidebar).display === "block";
    if (isVisible) {
        w3_close();
    } else {
        w3_open();
    }
}

function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("myOverlay").style.display = "block";
}

function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("myOverlay").style.display = "none";
}

function toggleForm() {
    const form = document.getElementById('addProductForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

function toggleSidebar() {
    const sidebar = document.getElementById('mySidebar');
    const overlay = document.getElementById('myOverlay');
    if (sidebar.style.display === 'block') {
        sidebar.style.display = 'none';
        overlay.style.display = 'none';
    } else {
        sidebar.style.display = 'block';
        overlay.style.display = 'block';
    }
}

function w3_close() {
    const sidebar = document.getElementById('mySidebar');
    const overlay = document.getElementById('myOverlay');
    sidebar.style.display = 'none';
    overlay.style.display = 'none';
}