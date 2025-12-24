document.addEventListener("DOMContentLoaded", () => {
    const buttons = document.querySelectorAll("#btn-bar .btn-custom");
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    buttons.forEach((btn) => {
        btn.addEventListener("click", () => {
            const newStatus = btn.dataset.status;
            const salesId = btn.dataset.id;


            fetch(`/employees/sales/update-status/${salesId}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {

                    if (newStatus === "Prepared") {
                        window.print();
                    }
                    
 
                    location.reload();
                }
            })
            .catch(error => console.error("Error:", error));
        });
    });
});

//  LOGOUT TOOGLE

function subMenu() {
    const submenu = document.getElementById("submenu");
    submenu.classList.toggle("open-menu");
}
