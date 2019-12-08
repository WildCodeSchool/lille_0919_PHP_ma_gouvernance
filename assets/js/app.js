/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../scss/app.scss');

const advisors = document.getElementById('allCardsContainer');
const buttonBoards = document.getElementById('buttonBoards');
const buttonAdvisors = document.getElementById('buttonAdvisors');
const boards = document.getElementById('Boards');
// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// const $ = require('jquery');
let boardShowed = true;
buttonBoards.addEventListener('click', () => {
    if (boardShowed === false) {
        advisors.classList.toggle('hidden');
        boards.classList.toggle('hidden');
        boardShowed = true;
    }
});

buttonAdvisors.addEventListener('click', () => {
    if (boardShowed === true) {
        advisors.classList.toggle('hidden');
        boards.classList.toggle('hidden');
        boardShowed = false;
    }
});

const myInput = document.getElementById('myInput');
myInput.addEventListener('keyup', () => {
    const filter = myInput.value.toUpperCase();
    const cardAdvisors = document.getElementsByClassName('cardAdvisors');
    for (let i = 0; i < cardAdvisors.length; i += 1) {
        const h4 = cardAdvisors[i].getElementsByTagName('h4')[0];
        const txtValue = h4.textContent || h4.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            cardAdvisors[i].style.display = '';
        } else {
            cardAdvisors[i].style.display = 'none';
        }
    }
});
