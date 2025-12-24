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

// POP UP NEW

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

buttonSave.addEventListener("click", () => {

    const formData = collectEditFormData(); 
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


    fetch(`/employees/${EMPLOYEE_ID}`, {
        method: 'PATCH', 
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Data Karyawan berhasil diperbarui!');
            addPopup.classList.remove ("open");
            window.location.reload(); 
        } else {
            alert('Gagal menyimpan data. Cek error di console.');
        }
    })
    .catch(error => {
        console.error('Error saat menyimpan:', error);
        alert('Terjadi kesalahan koneksi.');
    });
});

function collectEditFormData() {

    

    const name = document.getElementById('name-input').value; 

    const gender = document.querySelector('input[name="Gender"]:checked').value; 
    
    const roleId = document.getElementById('roleId').value; 
    const inputEmail = document.getElementById("emailInput").value;
    const inputPhone = document.getElementById("phoneInput").value;
    const inputAddres = document.getElementById("addressInput").value;
    const inputSalary = document.getElementById("salaryInput").value;
    const inputDay = document.getElementById("inputDay").value;
    const inputShift = document.getElementById("inputShift").value;
    

    return {
        employee_name: name,
        employee_gender: gender === 'Male' ? 1 : 0, 
        employee_role: roleId,
        employee_email: inputEmail,
        employee_phone: inputPhone,
        employee_address: inputAddres,
        employee_salary: inputSalary,
        employee_day: inputDay,
        employee_shift: inputShift

    };
}

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

// INPUT EMAIL

const inputEmail = document.getElementById("emailInput");


inputEmail.addEventListener("keydown", (e) => {
    if (e.key === "Enter") inputEmail.blur()
})

// INPUT PASSWORD

const inputPassword = document.getElementById("passwordInput");


inputPassword.addEventListener("keydown", (e) => {
    if (e.key === "Enter") inputPassword.blur()
})

// INPUT NO

const inputPhone = document.getElementById("phoneInput");


inputPhone.addEventListener("keydown", (e) => {
    if (e.key === "Enter") inputPhone.blur()
})

// INPUT ADDRESS

const inputAddres = document.getElementById("addressInput");


inputAddres.addEventListener("keydown", (e) => {
    if (e.key === "Enter") inputAddres.blur()
})


// INPUT ROLE

const input = document.querySelector('.input-role');
const optionsBox = document.querySelector('.select-options');
const options = optionsBox.querySelectorAll('li');
const hiddenInput = document.getElementById('roleId');

input.addEventListener('focus', () => {
  optionsBox.style.display = 'block';
});

//INPUT STATUS PRESENCE

const Inputstatus = document.querySelector('.input-status');
const optionsBoxStatus = document.querySelector('.select-options');
const optionsstatus = optionsBoxStatus.querySelectorAll('li');
const hiddenInputstatus = document.getElementById('statusId');

Inputstatus.addEventListener('focus', () => {
  optionsBoxStatus.style.display = 'block';
});


// INPUT SALARY

const inputSalary = document.getElementById("salaryInput");

inputSalary.addEventListener("input", function () {
    let value = this.value.replace(/\D/g, ""); 

    if (value) {
        this.value = new Intl.NumberFormat("id-ID").format(value);
    } else {
        this.value = "";
    }
});

// INPUT DAY

/*const inputDay = document.getElementById("inputDay");


inputDay.addEventListener("keydown", (e) => {
    if (e.key === "Enter") inputDay.blur()
})

// INPUT SHIFT

const inputShift = document.getElementById("inputShift");


inputShift.addEventListener("keydown", (e) => {
    if (e.key === "Enter") inputShift.blur()
})*/


// --- MANAJEMEN TABEL SCHEDULE ---

function addScheduleRow(dayValue = '', shiftValue = '0') {
    const tbody = document.getElementById('schedule-body');

    const row = `
    <tr>
        <td>
            <div class="select-box">
                <input type="text" class="input-day" value="${dayValue}" placeholder="Pilih Hari" readonly>
                <input type="hidden" name="days[]" value="${dayValue}">
                <ul class="select-options">
                    <li data-value="Monday">Monday</li>
                    <li data-value="Tuesday">Tuesday</li>
                    <li data-value="Wednesday">Wednesday</li>
                    <li data-value="Thursday">Thursday</li>
                    <li data-value="Friday">Friday</li>
                    <li data-value="Saturday">Saturday</li>
                    <li data-value="Sunday">Sunday</li>
                </ul>
            </div>
        </td>
        <td>
            <div class="select-box">
                <input type="text" class="input-shift" value="${shiftValue == 1 ? 'Evening' : 'Morning'}" readonly>
                <input type="hidden" name="shifts[]" value="${shiftValue}">
                <ul class="select-options">
                    <li data-value="0">Morning</li>
                    <li data-value="1">Evening</li>
                </ul>
            </div>
        </td>
        <td style="text-align: end;">
            <span class="material-symbols-outlined delete-btn" onclick="this.closest('tr').remove()">delete</span>
        </td>
    </tr>
    `;

    tbody.insertAdjacentHTML('beforeend', row);
    
    // PENTING: Panggil ulang fungsi inisialisasi dropdown Anda di sini 
    // agar dropdown yang baru ditambah bisa diklik.
    initDropdowns(); 
}

function closeAllSelectOptions() {
  document.querySelectorAll('.select-options').forEach(opt => {
    opt.style.display = 'none';
  });
}

document.addEventListener('click', function (e) {

  if (
    e.target.classList.contains('input-role') ||
    e.target.classList.contains('input-day') ||
    e.target.classList.contains('input-shift') ||
    e.target.classList.contains('input-status')
  ) {
    closeAllSelectOptions();

    const box = e.target.closest('.select-box');
    box.querySelector('.select-options').style.display = 'block';
    return;
  }

  // PILIH OPTION
  if (e.target.closest('.select-options li')) {
    const li = e.target;
    const box = li.closest('.select-box');

    const input = box.querySelector('input[type="text"]');
    const hidden = box.querySelector('input[type="hidden"]');

    input.value = li.textContent.trim();
    hidden.value = li.dataset.value;

    closeAllSelectOptions();
    return;
  }

  // KLIK DI LUAR
  closeAllSelectOptions();
});


document.addEventListener('input', function (e) {
  if (
    e.target.classList.contains('input-role') ||
    e.target.classList.contains('input-day') ||
    e.target.classList.contains('input-shift') ||
    e.target.classList.contains('input-status')
  ) {
    const search = e.target.value.toLowerCase();
    const box = e.target.closest('.select-box');

    box.querySelectorAll('.select-options li').forEach(li => {
      li.style.display = li.textContent.toLowerCase().includes(search)
        ? 'block'
        : 'none';
    });
  }
});


//--------POP UP PRESENSI---------
var buttonPsc = document.getElementById("btnPsc");
var buttonCancelPsc = document.getElementById("btn-cancel-psc");
var buttonSavePsc = document.getElementById("btn-save-psc");
var addPopupPsc = document.getElementById("popupPsc");

buttonPsc.addEventListener("click", () => {
    addPopupPsc.classList.add("open");
})

buttonCancelPsc.addEventListener("click", () => {
    addPopupPsc.classList.remove ("open");
})







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

buttonSaveDlt.addEventListener("click", () => {

    
});

// --------------CHARTS-----------


