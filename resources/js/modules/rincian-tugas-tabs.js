/**
 * Tab switcher section "Rincian Tugas" (halaman Tugas).
 * Dipanggil dari resources/js/app.js -> initRincianTugasTabs()
 *
 * Markup yang diharapkan (lihat partials/committee/rincian-tugas.blade.php):
 * - Container tombol tab: [data-rincian-tugas]
 * - Tiap tombol tab     : [data-rincian-tugas-tab] dengan data-target="<key>"
 * - Tiap panel isi      : [data-rincian-tugas-panel="<key>"]
 *
 * Simpel: klik tab -> toggle class "is-active" + attribute "hidden" di
 * panel yang cocok, sisanya disembunyikan. Tidak pakai animasi geser,
 * cuma fade halus lewat CSS (.spkn-rincian-tugas__panel).
 */
export function initRincianTugasTabs(root = document) {
  const wrapper = root.querySelector("[data-rincian-tugas]");
  if (!wrapper) return;

  const tabs = wrapper.querySelectorAll("[data-rincian-tugas-tab]");
  const panels = root.querySelectorAll("[data-rincian-tugas-panel]");

  tabs.forEach((tab) => {
    tab.addEventListener("click", () => {
      const target = tab.dataset.target;

      tabs.forEach((t) => {
        const isActive = t === tab;
        t.classList.toggle("is-active", isActive);
        t.setAttribute("aria-selected", isActive ? "true" : "false");
      });

      panels.forEach((panel) => {
        const isMatch = panel.dataset.rincianTugasPanel === target;
        panel.hidden = !isMatch;
        panel.classList.toggle("is-active", isMatch);
      });
    });
  });
}
