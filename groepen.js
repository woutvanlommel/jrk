// groepen.js
Promise.all([
    fetch('groepen.json').then(res => res.json()),
    fetch('leiding.json').then(res => res.json())
]).then(([groepen, leiding]) => {
    const container = document.getElementById("groepenContainer");

    groepen.forEach(groep => {
        const groepsLeiding = leiding.filter(p => p.groepen.toLowerCase() === groep.naam.toLowerCase());

        const groepDiv = document.createElement("div");
        groepDiv.classList.add("groep");
        groepDiv.style.backgroundColor = groep.kleur;
        groepDiv.style.backgroundImage = `url(${groep.afbeelding})`;
        groepDiv.style.backgroundSize = "cover";
        groepDiv.style.backgroundPosition = "center";

        const overlay = document.createElement("div");
        overlay.className = "groep-overlay";
        overlay.innerHTML = `<h3>${groep.naam}</h3><p>${groepsLeiding.length} leiding(en)</p>`;
        groepDiv.appendChild(overlay);

        groepDiv.addEventListener("click", () => {
            openModal(groep.naam, groepsLeiding);
        });

        container.appendChild(groepDiv);
    });
}).catch(error => {
    console.error("Fout bij ophalen data:", error);
});


function openModal(groepNaam, leidingLeden) {
    const modal = document.getElementById("groepModal");
    const title = modal.querySelector("h2");
    const content = modal.querySelector(".modal-content-body");

    title.textContent = groepNaam;
    content.innerHTML = ""; // reset

    leidingLeden.forEach(p => {
        const pDiv = document.createElement("div");
        pDiv.className = "leidingkaart";
        pDiv.innerHTML = `
            <img src="${p.foto}" alt="${p.naam}">
            <div class="leidinginfo">
                <h4>${p.naam} ${p.achternaam}</h4>
                ${p.telefoon ? `<a href="tel:${p.telefoon}">📞 ${p.telefoon}</a>` : ""}
                ${p.email ? `<a href="mailto:${p.email}">✉️ ${p.email}</a>` : ""}
                ${p.favorieteAct ? `<p>❤ ${p.favorieteAct}</p>` : ""}
                ${p.Verjaardag ? `<p>🎂 ${p.Verjaardag}</p>` : ""}
            </div>
        `;
        content.appendChild(pDiv);
    });

    modal.style.display = "block";
}


// sluiten van de modal
document.querySelector(".close-modal").addEventListener("click", () => {
    document.getElementById("groepModal").style.display = "none";
});