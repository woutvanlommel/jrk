document.addEventListener("DOMContentLoaded", function () {
  if (typeof groepenData === "undefined" || !Array.isArray(groepenData.groepen)) {
    console.error("❌ groepenData niet gevonden of ongeldig");
    return;
  }

  const container = document.getElementById("groepenContainer");
  if (!container) {
    console.warn("⚠️ Geen container gevonden met ID 'groepenContainer'");
    return;
  }

  groepenData.groepen.forEach(groep => {
    const groepDiv = document.createElement("div");
    groepDiv.classList.add("groep");
    groepDiv.style.backgroundColor = groep.kleur || "#ccc";

    if (groep.afbeelding) {
      groepDiv.style.backgroundImage = `url(${groep.afbeelding})`;
      groepDiv.style.backgroundSize = "cover";
      groepDiv.style.backgroundPosition = "center";
    }

    const overlay = document.createElement("div");
    overlay.className = "groep-overlay";
    overlay.innerHTML = `<h3>${groep.naam}</h3><p>${groep.leiding.length} leiding(en)</p>`;
    groepDiv.appendChild(overlay);

    groepDiv.addEventListener("click", () => {
      openModal(groep);
    });

    container.appendChild(groepDiv);
  });

  function openModal(groep) {
    const modal = document.getElementById("groepModal");
    const title = modal.querySelector("h2");
    const content = modal.querySelector(".modal-content-body");

    title.textContent = groep.naam;
    content.innerHTML = "";

    const sortedLeiding = groep.leiding.sort((a, b) => {
      const naamA = `${a.naam} ${a.achternaam}`.toLowerCase();
      const naamB = `${b.naam} ${b.achternaam}`.toLowerCase();
      return naamA.localeCompare(naamB);
    });

    sortedLeiding.forEach(p => {
      const pDiv = document.createElement("div");
      pDiv.className = "leidingkaart";
      pDiv.innerHTML = `
        <img src="${p.foto}" alt="${p.naam}">
        <div class="leidinginfo">
            <h4>${p.naam} ${p.achternaam}</h4>
            ${p.telefoon ? `<a href="tel:${p.telefoon}">📞 ${p.telefoon}</a>` : ""}
            ${p.email ? `<a href="mailto:${p.email}">✉️ ${p.email}</a>` : ""}
            ${p.favorieteAct ? `<p>❤ ${p.favorieteAct}</p>` : ""}
            ${p.verjaardag ? `<p>🎂 ${p.verjaardag}</p>` : ""}
        </div>
      `;
      content.appendChild(pDiv);
    });

    modal.style.display = "block";
  }

  document.querySelector(".close-modal").addEventListener("click", () => {
    document.getElementById("groepModal").style.display = "none";
  });

  window.addEventListener("click", function (e) {
    const modal = document.getElementById("groepModal");
    if (e.target === modal) {
      modal.style.display = "none";
    }
  });

  document.addEventListener("keydown", function (e) {
    const modal = document.getElementById("groepModal");
    if (modal.style.display === "block" && (e.key === "Escape" || e.key === "Enter")) {
      modal.style.display = "none";
    }
  });
});