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