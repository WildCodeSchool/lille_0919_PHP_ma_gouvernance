/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../scss/app.scss');


const buttonDemand = document.getElementById('button-newdemand');
const demandeFormulaire = document.getElementById('demandeFormulaire');
const filterContainer = document.getElementById('filterContainer');
const selectFormulaireDemande = document.getElementsByClassName('selectFormulaireDemande');
const tagsContainer = document.getElementById('tags');
const cardsDemande = document.getElementsByClassName('cardHorizontal');
const modalDescription = document.getElementsByClassName('modalDescription');
const cardClient = document.getElementsByClassName('cardClient');
const deletes = document.querySelectorAll('a.delete');
const clientName = document.querySelectorAll('p.clientName');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// const $ = require('jquery');

buttonDemand.addEventListener('click', () => {
    demandeFormulaire.classList.toggle('hidden');
    filterContainer.classList.toggle('hidden');
    buttonDemand.classList.toggle('hidden');
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
});

selectFormulaireDemande.forEach(item => item.addEventListener('change', () => {
    const div = document.createElement('div');
    div.innerHTML = item.value;
    div.classList.add('tags');
    div.addEventListener('click', () => {
        tagsContainer.removeChild(div);
    });
    tagsContainer.appendChild(div);
}));

cardsDemande.forEach(item => item.addEventListener('click', () => {
    filterContainer.classList.toggle('hidden');
}));

for (let i = 0; i < cardsDemande.length; i += 1) {
    cardsDemande[i].addEventListener('click', () => {
        modalDescription[i].classList.remove('hidden');
        buttonDemand.classList.add('hidden');
        cardClient.forEach(item => item.classList.add('hidden'));
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    });
}

document.addEventListener('click', (e) => {
    if (e.target.id === 'filterContainer') {
        for (let i = 0; i < cardsDemande.length; i += 1) {
            modalDescription[i].classList.add('hidden');
            filterContainer.classList.add('hidden');
            buttonDemand.classList.remove('hidden');
            cardClient.forEach(item => item.classList.remove('hidden'));
        }
        demandeFormulaire.classList.add('hidden');
    }
});

const myInput = document.getElementById('myInput');
myInput.addEventListener('keyup', () => {
    const filter = myInput.value.toUpperCase();
    const cardHorizontal = document.getElementsByClassName('cardHorizontal');
    for (let i = 0; i < cardHorizontal.length; i += 1) {
        const cardTitle = cardHorizontal[i].getElementsByClassName('cardTitle')[0];
        const txtValue = cardTitle.textContent || cardTitle.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            cardHorizontal[i].style.display = '';
        } else {
            cardHorizontal[i].style.display = 'none';
        }
    }
});

for (let i = 0; i < deletes.length; i += 1) {
    const name = clientName[i].innerHTML;

    deletes[i].addEventListener('click', (e) => {
        if (window.confirm(`Etes-vous sur de vouloir supprimer la demande de ${name}`)) {
            // do stuff
        } else {
            e.preventDefault();
        }
    });
}
