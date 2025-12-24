// SIDEBAR TOOGLE

var sidebarOpen = false;
var sidebar = document.getElementById("sidebar");

function openSidebar() {
    if (!sidebarOpen) {
        sidebar.classList.add("sidebar-responsive");
        sidebarOpen = true;
    }
}

function closeSidebar() {
    if (sidebarOpen) {
        sidebar.classList.remove("sidebar-responsive");
        sidebarOpen = false;
    }
}

//  LOGOUT TOOGLE

function subMenu() {
    const submenu = document.getElementById("submenu");
    submenu.classList.toggle("open-menu");
}

// SIDEBAR ITEM ACTIVE

var currentPage = window.location.pathname;
console.log("Current page:", currentPage);

document.querySelectorAll(".sidebar-list-item a").forEach(link => {
        if (currentPage.endsWith(link.getAttribute("href"))) {
            link.parentElement.classList.add("active");
}
    }
)

document.addEventListener("DOMContentLoaded", function() {
    // Tombol Aktif
    const btnAkf = document.getElementById("btnAktif");
    const popAkf = document.getElementById("popAkf");
    const cancelAkf = document.getElementById("btn-cancel-akf");

    if (btnAkf) {
        btnAkf.addEventListener("click", () => popAkf.classList.add("open"));
    }
    if (cancelAkf) {
        cancelAkf.addEventListener("click", () => popAkf.classList.remove("open"));
    }

    // Tombol Non-Aktif
    const btnNkf = document.getElementById("btnNonAktif");
    const popNkf = document.getElementById("popNkf");
    const cancelNkf = document.getElementById("btn-cancel-nkf");

    if (btnNkf) {
        btnNkf.addEventListener("click", () => popNkf.classList.add("open"));
    }
    if (cancelNkf) {
        cancelNkf.addEventListener("click", () => popNkf.classList.remove("open"));
    }
});

// --------------CHARTS-----------

