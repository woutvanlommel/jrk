document.addEventListener("DOMContentLoaded", function () {
  const basePath = (typeof jrkData !== "undefined" && jrkData.themeUrl) ? jrkData.themeUrl : ".";
  console.log("📁 Base path ingesteld op:", basePath);

  Promise.all([
    fetch(`${basePath}/groepen.json`).then(res => {
      if (!res.ok) throw new Error("groepen.json niet gevonden");
      return res.json();
    }),
    fetch(`${basePath}/leiding.json`).then(res => {
      if (!res.ok) throw new Error("leiding.json niet gevonden");
      return res.json();
    })
  ])
    .then(([groepen, leiding]) => {
      console.log("✅ Groepen geladen:", groepen);
      console.log("✅ Leiding geladen:", leiding);

      const container = document.getElementById("groepenContainer");
      if (!container) {
        console.warn("⚠️ Geen container gevonden met ID 'groepenContainer'");
        return;
      }

      groepen.forEach(groep => {
        const groepsLeiding = leiding.filter(p => p.groepen.toLowerCase() === groep.naam.toLowerCase());
        console.log(`👥 Leiding gevonden voor groep ${groep.naam}:`, groepsLeiding);

        const groepDiv = document.createElement("div");
        groepDiv.classList.add("groep");
        groepDiv.style.backgroundColor = groep.kleur || "#ccc";
        if (groep.afbeelding) {
          groepDiv.style.backgroundImage = `url(${basePath}/${groep.afbeelding})`;
          groepDiv.style.backgroundSize = "cover";
          groepDiv.style.backgroundPosition = "center";
        }

        const overlay = document.createElement("div");
        overlay.className = "groep-overlay";
        overlay.innerHTML = `<h3>${groep.naam}</h3>`;
        groepDiv.appendChild(overlay);

        groepDiv.addEventListener("click", () => {
          console.log(`📦 Modal openen voor groep: ${groep.naam}`);
          openModal(groep.naam, groepsLeiding);
        });

        container.appendChild(groepDiv);
      });
    })
    .catch(error => {
      console.error("❌ Fout bij ophalen data voor groepenpagina:", error);
    });

  function openModal(groepNaam, leidingLeden) {
    const modal = document.getElementById("groepModal");
    const title = modal.querySelector("h2");
    const content = modal.querySelector(".modal-content-body");

    title.textContent = groepNaam;
    content.innerHTML = "";

    leidingLeden.sort((a, b) => {
      const naamA = `${a.naam} ${a.achternaam}`.toLowerCase();
      const naamB = `${b.naam} ${b.achternaam}`.toLowerCase();
      return naamA.localeCompare(naamB);
    });

    console.log(`📄 Modal inhoud opbouwen voor groep: ${groepNaam}`, leidingLeden);

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

  document.querySelector(".close-modal").addEventListener("click", () => {
    console.log("❌ Modal gesloten via knop");
    document.getElementById("groepModal").style.display = "none";
  });

  window.addEventListener("click", function (e) {
    const modal = document.getElementById("groepModal");
    if (e.target === modal) {
      console.log("❌ Modal gesloten via buiten klik");
      modal.style.display = "none";
    }
  });

  document.addEventListener("keydown", function (e) {
    const modal = document.getElementById("groepModal");
    if (modal.style.display === "block" && (e.key === "Escape" || e.key === "Enter")) {
      console.log(`❌ Modal gesloten via toets: ${e.key}`);
      modal.style.display = "none";
    }
  });
});