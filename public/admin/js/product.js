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

// POP UP EDIT

var buttonEdit = document.getElementById("btnEdit");
var buttonCancel = document.getElementById("btn-cancel");
var buttonSave = document.getElementById("btn-save");
var addPopup = document.getElementById("form-new");

buttonEdit.addEventListener("click", () => {
    addPopup.classList.add("open");
})

buttonCancel.addEventListener("click", () => {
    addPopup.classList.remove ("open");
})

// PREVIEW IMAGE UPLOAD

const imgView = document.getElementById("img-view");
const inputFile = document.getElementById("input-file");

document.querySelector(".img-container").addEventListener("click", () => {
    inputFile.click()
});

inputFile.addEventListener("change", function() {
    const file = this.files[0];
    if (file) {
        imgView.src = URL.createObjectURL(file);
        imgView.style.opacity = "1"; 
    }
})

// INPUT NAME

const nameInput = document.getElementById("name-input");

nameInput.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
        e.preventDefault();
        nameInput.blur();
    }
});

// INPUT HARGA

const inputPrice = document.getElementById("prcInput");

inputPrice.addEventListener("input", function () {
    let value = this.value.replace(/\D/g, ""); 

    if (value) {
        this.value = new Intl.NumberFormat("id-ID").format(value);
    } else {
        this.value = "";
    }
});


inputPrice.addEventListener("keydown", (e) => {
    if (e.key === "Enter") inputPrice.blur()
})

// INPUT SIZE 


const inputSize = document.getElementById("sizeInput");


inputSize.addEventListener("keydown", (e) => {
    if (e.key === "Enter") inputSize.blur()
})

//INPUT STOCK

const inputStock = document.getElementById("stockInput");

inputStock.addEventListener("keydown", (e) => {
    if (e.key === "Enter") inputStock.blur()
})


// INPUT DESKRIPSI

const inputDesc = document.getElementById("deskripsiInput");


inputDesc.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
        e.preventDefault();
        inputDesc.blur();
    };
})

//INPUT CATEGORY
const input = document.querySelector('.input-cat');
const optionsBox = document.querySelector('.select-options');
const options = optionsBox.querySelectorAll('li');
const hiddenInput = document.getElementById('catId');

input.addEventListener('focus', () => {
  optionsBox.style.display = 'block';
});

input.addEventListener('input', () => {
  const search = input.value.toLowerCase();

  options.forEach(option => {
    const text = option.textContent.toLowerCase();
    option.style.display = text.includes(search) ? 'block' : 'none';
  });
});

options.forEach(option => {
  option.addEventListener('click', () => {
    input.value = option.textContent;
    hiddenInput.value = option.dataset.value;
    optionsBox.style.display = 'none';
  });
});

document.addEventListener('click', e => {
  if (!e.target.closest('.select-box')) {
    optionsBox.style.display = 'none';
  }
});


//-----POP UP DELETE----------
var buttonDlt = document.getElementById("btnDelete");
var buttonCancelDlt = document.getElementById("btn-cancel-dlt");
var buttonSaveDlt = document.getElementById("btn-save-dlt");
var addPopupDlt = document.getElementById("popDlt");

buttonDlt.addEventListener("click", () => {
    addPopupDlt.classList.add("open");
})

buttonCancelDlt.addEventListener("click", () => {
    addPopupDlt.classList.remove ("open");
})

// --------------CHARTS-----------



