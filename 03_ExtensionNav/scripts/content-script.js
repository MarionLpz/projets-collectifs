
chrome.runtime.sendMessage({ type: 'getData' },  response => {
  const data = response.data
  console.log(data);
  let listeNoms = [];
  for (let politicien of data) {
    listeNoms.push(politicien["nom"]);
  }

  let text = document.createElement('div');
  text.style.position = 'absolute';
  text.style.background = 'black';
  text.style.padding = '10px';
  text.style.borderRadius = '15px';
  text.style.display = 'none';
  document.body.appendChild(text);
  text.style.color= "white";

  setTimeout(() => {
    trouverMot(listeNoms);
    let poli = document.querySelectorAll('.politicien');
    
    poli.forEach(nom => {
      nom.addEventListener("mouseenter", (e) => {
        let mot = e.target.textContent;
        text.innerText = trouveFonction(mot, data);
        text.style.display = 'block';
      });
      nom.addEventListener("mousemove", (e) => {
        positionnerTexte(text, e.clientX + window.scrollX, e.clientY + window.scrollY);
      });
      nom.addEventListener("mouseleave", (e) => {
        text.style.display = 'none';
      });
    })
  }, 2000);
});

function positionnerTexte(element, x, y) {
  element.style.left = x + 10 + 'px';
  element.style.top = y + 10 + 'px';
}

// Parcourir les éléments de la page HTML
function trouverMot(listeMots, parent = document.body) {
  if (parent.tagName === 'A') {
    return;
  }

  const enfants = parent.childNodes;
  for (const enfant of enfants) {
    if (enfant.nodeType === Node.TEXT_NODE) {
      surlignage(listeMots, enfant, parent)
    } else if (enfant.nodeType === Node.ELEMENT_NODE) {
      if (enfant.tagName !== 'A') {
        trouverMot(listeMots, enfant);
      }
    }
  }
}


// Surligner le mot recherché
function surlignage(listeMots, enfant, parent) {
  const contenuElementLower = enfant.textContent.toLowerCase();
  const contenuElement = enfant.textContent;
  let nouveauContenu = contenuElement;
  for (const mot of listeMots) {
    if (contenuElementLower.includes(mot.toLowerCase())) {
      nouveauContenu = nouveauContenu.replace(
        new RegExp(`(${mot})`, 'gi'),
        '<span style="background-color: rgb(204 255 255); color:black;" class="politicien">$1</span>'
      );
    }
  }
  if (contenuElementLower !== nouveauContenu.toLowerCase()) {
    const nouvelEnfant = document.createElement('span');
    nouvelEnfant.innerHTML = nouveauContenu;
    parent.replaceChild(nouvelEnfant, enfant);
  }
}

function trouveFonction(nom, data) {
  const detail = data.find( donnée => donnée.nom === nom)
  return detail["fonction"]
}