// global variables
let credit = 0;
let drink = {
    Cola: { price: 2.0, stock: 0, color: "#351212" },
    Fanta: { price: 2.0, stock: 0, color: "#FFAD29" },
    Sprite: { price: 2.0, stock: 0, color: "#11B121" },
    Mineral: { price: 1.5, stock: 0, color: "#A8FBFF" }
};

// action display
function updateText(selector, text, animate = true) {
    const el = document.querySelector(selector);
    el.innerText = text;
    if (animate) {
        el.classList.add('hover');
        setTimeout(() => el.classList.remove('hover'), 300);
    }
}

// initialize grid
window.onload = initGrid;

function initGrid() {
    const grid = document.getElementById('grid');
    grid.innerHTML = '';

    const rows = 10;
    const cols = 4;
    const totalCells = rows * cols;

    // create cells
    for (let i = 0; i < totalCells; i++) {
        const cell = document.createElement('div');
        cell.classList.add('cell');
        cell.addEventListener('click', () => handleFieldClick(i));
        grid.appendChild(cell);
    }

    // randomize initial stock (1-10)
    Object.values(drink).forEach(d => d.stock = Math.floor(Math.random() * 10) + 1);

    // display initial credit and grid
    updateText('#credit', credit.toFixed(2), false);
    updateGrid();
    console.log("Machine initialized:", drink);
}

// --- update grid display ---
function updateGrid() {
    const cells = document.querySelectorAll('#grid div');
    cells.forEach(cell => (cell.style.background = '#ccc'));

    const drinkNames = Object.keys(drink);
    const rows = 10;
    const cols = 4;

    // fill bottom → top in each column
    drinkNames.forEach((name, colIndex) => {
        const d = drink[name];
        for (let i = 0; i < d.stock; i++) {
            const rowFromBottom = rows - 1 - i;
            const cellIndex = rowFromBottom * cols + colIndex;
            const cell = cells[cellIndex];
            if (cell) cell.style.background = d.color;
        }
    });
}

// --- handle refill by clicking grid ---
function handleFieldClick(index) {
    const rows = 10;
    const cols = 4;
    const col = index % cols; // 0 = Cola, 1 = Fanta, etc.
    const drinkNames = Object.keys(drink);
    const selectedDrink = drinkNames[col];
    const d = drink[selectedDrink];

    const rowFromBottom = rows - 1 - Math.floor(index / cols);
    const newStock = rowFromBottom + 1;

    if (d.stock < newStock) {
        d.stock = Math.min(newStock, 10);
        updateText('#output', `${selectedDrink} refilled to ${d.stock}.`);
        updateGrid();
    } else {
        updateText('#output', `${selectedDrink} already has ${d.stock}.`);
    }
}

// --- money functions ---
function insertMoney(amount) {
    credit += amount;
    updateText('#credit', credit.toFixed(2), false);
    updateText('#output', `You inserted +${amount.toFixed(2)} €`);
}

function returnMoney() {
    if (credit > 0) {
        updateText('#output', `Payback: ${credit.toFixed(2)} €`);
        credit = 0;
    } else {
        updateText('#output', "No money for pay back");
    }
    updateText('#credit', credit.toFixed(2), false);
}

// --- drink selection ---
function selectDrink(type) {
    const d = drink[type];
    if (!d) return;

    if (d.stock <= 0) return updateText('#output', `${type} is empty!`);
    if (credit < d.price) return updateText('#output', `Not enough credit for ${type}.`);

    credit -= d.price;
    d.stock--;

    updateText('#credit', credit.toFixed(2), false);
    updateText('#output', `You get a ${type}.`);
    console.log(`${type} dispensed. New stock: ${d.stock}`);

    updateGrid();
}
