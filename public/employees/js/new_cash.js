const items = document.querySelectorAll(".item");
const totalItem = document.getElementById("totalItem");
const totalAll = document.getElementById("totalAll");
const orderList = document.getElementById("orderList");
const hapusPesanan = document.getElementById("hapusPesanan");

let subtotal = 0;
let pesanan = [];


function updateDisplay() {
  orderList.innerHTML = "";
  pesanan.forEach((item, index) => {
    const li = document.createElement("li");
    li.innerHTML = `
      <div>
        ${item.name}
      </div>
      <div>
        Rp ${item.price.toLocaleString("id-ID")}
        <span class="remove" data-index="${index}">❌</span>
      </div>
    `;
    orderList.appendChild(li);
  });

  totalItem.textContent = `Rp ${subtotal.toLocaleString("id-ID")}`;
  totalAll.textContent = `Rp ${subtotal.toLocaleString("id-ID")}`;


  const removeBtns = document.querySelectorAll(".remove");
  removeBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      const index = parseInt(btn.getAttribute("data-index"));
      subtotal -= pesanan[index].price;
      pesanan.splice(index, 1);
      updateDisplay();
    });
  });
}

items.forEach((item) => {
  item.addEventListener("click", () => {
    const name = item.getAttribute("data-name");
    const price = parseInt(item.getAttribute("data-price"));
    pesanan.push({ name, price });
    subtotal += price;
    updateDisplay();
  });
});


document.getElementById("printNota").addEventListener("click", () => {
  const nama = document.getElementById("namaCust").value || "Pelanggan";
  const total = totalAll.textContent;
  const itemList = pesanan
    .map((p) => `- ${p.name} (${p.price.toLocaleString("id-ID")})`)
    .join("\n");
  alert(
    `Nota untuk ${nama}\n\nPesanan:\n${itemList}\n\nTotal Pembayaran: ${total}\nTerima kasih!`
  );
});


hapusPesanan.addEventListener("click", () => {
  if (confirm("Yakin ingin menghapus semua pesanan?")) {
    pesanan = [];
    subtotal = 0;
    updateDisplay();
  }
});
