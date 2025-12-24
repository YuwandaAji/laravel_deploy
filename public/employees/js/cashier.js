/*toggle profil strat */

const submenu = document.getElementById('submenu');

function subMenu(){
  submenu.classList.toggle('open-menu');
}

/*toggle profil end */

/*drag down strat */

const cards = document.querySelectorAll('.card')
const columns = document.querySelectorAll('.column')

cards.forEach(card => {
  card.addEventListener('dragstart', () => {
    card.classList.add('dragging')
  })

  card.addEventListener('dragend', () => {
    card.classList.remove('dragging')
  })
});

columns.forEach(column => {
  column.addEventListener('dragover', e => {
    e.preventDefault()
    const afterElement = getDragAfterElement(column, e.clientY)
    const card = document.querySelector('.dragging')
    if (afterElement == null) {
      column.appendChild(card)
    } else {
      column.insertBefore(card, afterElement)
    }
  })
})

function getDragAfterElement(column, y){
  const draggableElement = [...column.querySelectorAll('.card:not(.dragging)')]

  return draggableElement.reduce((closest, child) => {
    const box = child.getBoundingClientRect()
    const offset = y - box.top - box.height / 2
    console.log(offset)
    if (offset < 0 && offset > closest.offset){
      return {offset : offset, element : child}
    } else {
      return closest
    }
  }, {offset: Number.NEGATIVE_INFINITY}).element
}

/*drag down end */

//  LOGOUT TOOGLE

function subMenu() {
    const submenu = document.getElementById("submenu");
    submenu.classList.toggle("open-menu");
}

