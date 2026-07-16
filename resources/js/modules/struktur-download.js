/**
 * Halaman "Struktur Komite SPKN" — tombol "Unduh sebagai Gambar" yang
 * meng-capture elemen bagan ([data-struktur-chart]) jadi file PNG lewat
 * html2canvas, lalu men-trigger download otomatis di browser.
 *
 * NOTE: butuh `npm install` dulu setelah nambah dependency "html2canvas" di
 * package.json (lihat catatan di PR/commit terkait).
 */
export function initStrukturDownload(root = document) {
  const tombol = root.querySelector("[data-struktur-download]");
  const chart = root.querySelector("[data-struktur-chart]");
  if (!tombol || !chart) return;

  tombol.addEventListener("click", async () => {
    const labelAsli = tombol.innerHTML;
    tombol.disabled = true;
    tombol.innerHTML = '<i class="bi bi-hourglass-split"></i> Menyiapkan gambar...';

    try {
      const { default: html2canvas } = await import("html2canvas");

      const canvas = await html2canvas(chart, {
        backgroundColor: "#ffffff",
        scale: 2, // biar hasil unduhan tajam (retina), bukan buram
        useCORS: true,
      });

      const link = document.createElement("a");
      link.download = `${tombol.dataset.strukturFilename || "struktur-komite"}.png`;
      link.href = canvas.toDataURL("image/png");
      link.click();
    } catch (err) {
      console.error("Gagal membuat gambar bagan struktur:", err);
      window.alert("Gagal mengunduh gambar bagan. Coba lagi beberapa saat.");
    } finally {
      tombol.disabled = false;
      tombol.innerHTML = labelAsli;
    }
  });
}