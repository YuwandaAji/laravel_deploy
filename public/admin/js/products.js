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

// FILTER MENU

var btnFilter = document.getElementById("btnFilter");
var Filter = document.getElementById("filter");

btnFilter.addEventListener("click", () => {
    Filter.classList.toggle("open")
})

// SIDEBAR ITEM ACTIVE

var currentPage = window.location.pathname;
console.log("Current page:", currentPage);

document.querySelectorAll(".sidebar-list-item a").forEach(link => {
        if (currentPage.endsWith(link.getAttribute("href"))) {
            link.parentElement.classList.add("active");
}
    }
)

// POP UP NEW

var buttonNew = document.getElementById("button-new");
var buttonCancel = document.getElementById("btn-cancel");
var buttonSave = document.getElementById("btn-save");
var addPopup = document.getElementById("form-new");

buttonNew.addEventListener("click", () => {
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

//INPUT CATEGORY

/*const inputCat = document.getElementById("catInput");

inputCat.addEventListener("keydown", (e) => {
    if (e.key === "Enter") inputCat.blur()
})*/


// INPUT DESKRIPSI

const inputDesc = document.getElementById("deskripsiInput");


inputDesc.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
        e.preventDefault();
        inputDesc.blur();
    };
})

// POP UP DISCOUNT

var buttonDsc = document.getElementById("button-disc");
var buttonCancelDsc = document.getElementById("btn-cancel-dsc");
var buttonSaveDsc = document.getElementById("btn-save-dsc");
var addPopupDsc = document.getElementById("popDsc");

buttonDsc.addEventListener("click", () => {
    addPopupDsc.classList.add("open");
})

buttonCancelDsc.addEventListener("click", () => {
    addPopupDsc.classList.remove ("open");
})

//INPUT TABEL
function addRow() {
    const tbody = document.getElementById("schedule-body");

    // HTML Template (Perhatikan class 'clean-input')
    const rowTemplate = `
        <tr class="row-item">
            <td>
                <div class="select-table">
                    <input type="text" class="input-item" placeholder="" autocomplete="off">
                    <input type="hidden" name="itemId" id="itemId">
                    <ul class="select-options">
                        <li data-value="1">Hot Americano</li>
                        <li data-value="2">Hot Espresso</li>
                        <li data-value="3">Hot Matcha</li>
                    </ul>
                </div>
            </td>
            
            <td style="text-align: end; vertical-align: middle;">
                <span class="material-symbols-outlined delete-btn" onclick="deleteRow(this)">
                    delete
                </span>
            </td>
        </tr>
    `;

    // Masukkan ke tabel
    tbody.insertAdjacentHTML('beforeend', rowTemplate);
}

// 2. Fungsi Hapus Baris
function deleteRow(btn) {
    const row = btn.closest('tr');
    row.remove();
}

// 3. AUTO RUN: Pasang 1 baris kosong saat halaman dibuka
document.addEventListener("DOMContentLoaded", function() {
    // Cek jika tabel kosong, isi 1 baris
    const tbody = document.getElementById("schedule-body");
    if (tbody && tbody.children.length === 0) {
        addRow();
    }
});

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

// Klik di luar → tutup
document.addEventListener('click', e => {
  if (!e.target.closest('.select-box')) {
    optionsBox.style.display = 'none';
  }
});


const hiddenInputItem = document.getElementById('itemId');

document.addEventListener('click', function (e) {

  if (e.target.classList.contains('input-item')) {
    const box = e.target.closest('.select-table');
    box.querySelector('.select-options').style.display = 'block';
  }

  if (e.target.closest('.select-table .select-options li')) {
    const li = e.target;
    const box = li.closest('.select-table');

    box.querySelector('.input-item').value = li.textContent.trim();
    box.querySelector('#itemId').value = li.dataset.value;
    box.querySelector('.select-options').style.display = 'none';
  }
});

inputItem.addEventListener('focus', () => {
  optionsBox.style.display = 'block';
});

inputItem.addEventListener('input', () => {
  const search = inputItem.value.toLowerCase();

  options.forEach(option => {
    const text = option.textContent.toLowerCase();
    option.style.display = text.includes(search) ? 'block' : 'none';
  });
});

options.forEach(option => {
  option.addEventListener('click', () => {
    inputItem.value = option.textContent;
    hiddenInputItem.value = option.dataset.value;
    optionsBox.style.display = 'none';
  });
});

document.addEventListener('click', e => {
  if (!e.target.closest('.select-table')) {
    optionsBox.style.display = 'none';
  }
});