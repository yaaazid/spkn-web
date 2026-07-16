/**
 * Kalender SPKN di sidebar section "Berita SPKN" (beranda).
 * Render awal (bulan berjalan, tanggal hari ini) dikerjakan server-side lewat
 * Carbon di berita-spkn.blade.php. Modul ini cuma nanganin navigasi
 * bulan sebelumnya/berikutnya di sisi client, tanpa reload halaman.
 */
const NAMA_BULAN = [
  "Januari", "Februari", "Maret", "April", "Mei", "Juni",
  "Juli", "Agustus", "September", "Oktober", "November", "Desember",
];

function jumlahHariDalamBulan(tahun, bulanIndex0) {
  // Trik: tanggal 0 di bulan berikutnya = hari terakhir bulan ini.
  return new Date(tahun, bulanIndex0 + 1, 0).getDate();
}

function offsetAwalMinggu(tahun, bulanIndex0) {
  // JS: Minggu = 0 ... Sabtu = 6. Grid kita mulai dari Senin, jadi digeser.
  const dow = new Date(tahun, bulanIndex0, 1).getDay();
  return dow === 0 ? 6 : dow - 1;
}

function renderGrid(container, tahun, bulanIndex0, hariIniInfo) {
  // Bersihkan sel tanggal lama, sisakan 7 label hari (S S R K J S M) yang statis.
  container.querySelectorAll(".spkn-berita__calendar-day").forEach((el) => el.remove());

  const offset = offsetAwalMinggu(tahun, bulanIndex0);
  const totalHari = jumlahHariDalamBulan(tahun, bulanIndex0);

  const isBulanIni =
    hariIniInfo.tahun === tahun && hariIniInfo.bulanIndex0 === bulanIndex0;

  const frag = document.createDocumentFragment();

  for (let i = 0; i < offset; i++) {
    const span = document.createElement("span");
    span.className = "spkn-berita__calendar-day is-empty";
    frag.appendChild(span);
  }

  for (let tgl = 1; tgl <= totalHari; tgl++) {
    const span = document.createElement("span");
    span.className = "spkn-berita__calendar-day";
    if (isBulanIni && tgl === hariIniInfo.tanggal) {
      span.classList.add("is-today");
    }
    span.textContent = String(tgl);
    frag.appendChild(span);
  }

  container.appendChild(frag);
}

export function initKalenderSpkn(root = document) {
  const wrap = root.querySelector("[data-kalender-spkn]");
  if (!wrap) return;

  const grid = wrap.querySelector("[data-kalender-grid]");
  const label = wrap.querySelector("[data-kalender-label]");
  const btnPrev = wrap.querySelector("[data-kalender-prev]");
  const btnNext = wrap.querySelector("[data-kalender-next]");
  if (!grid || !label) return;

  const hariIniInfo = {
    tanggal: Number(wrap.dataset.hariIni),
    tahun: Number(wrap.dataset.tahun),
    bulanIndex0: Number(wrap.dataset.bulan) - 1,
  };

  // State bulan yang sedang ditampilkan (mulai dari bulan berjalan).
  let tahunAktif = hariIniInfo.tahun;
  let bulanAktif = hariIniInfo.bulanIndex0;

  const update = () => {
    label.textContent = `${NAMA_BULAN[bulanAktif].toUpperCase()} ${tahunAktif}`;
    renderGrid(grid, tahunAktif, bulanAktif, hariIniInfo);
  };

  btnPrev?.addEventListener("click", () => {
    bulanAktif -= 1;
    if (bulanAktif < 0) {
      bulanAktif = 11;
      tahunAktif -= 1;
    }
    update();
  });

  btnNext?.addEventListener("click", () => {
    bulanAktif += 1;
    if (bulanAktif > 11) {
      bulanAktif = 0;
      tahunAktif += 1;
    }
    update();
  });
}