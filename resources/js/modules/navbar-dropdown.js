/**
 * Navbar dropdown + flyout controller.
 * Dipanggil sekali dari resources/js/app.js -> initNavbarDropdown()
 *
 * Kenapa pakai JS untuk hover, bukan CSS :hover biasa?
 * Karena ada jarak (gap) antara tombol trigger dan panel dropdown/flyout
 * (buat estetika, lihat "top: calc(100% + 12px)" di CSS). Saat kursor
 * melintasi celah itu, CSS :hover langsung lepas sebelum sampai ke panel.
 * Di sini dipasang jeda tutup (CLOSE_DELAY) yang di-cancel kalau kursor
 * berhasil masuk ke trigger ATAU panel dalam waktu itu, jadi ada waktu
 * buat "menyeberang" celahnya tanpa panel keburu hilang.
 *
 * Markup yang diharapkan (lihat partials/navbar/navbar.blade.php):
 *   <li class="spkn-nav-item" data-dropdown>
 *     <button data-dropdown-trigger>...</button>
 *     <div class="spkn-dropdown" data-dropdown-panel>
 *       <li class="spkn-dropdown__item" data-flyout>
 *         <a data-flyout-trigger>...</a>
 *         <div class="spkn-flyout" data-flyout-panel>...</div>
 *       </li>
 *     </div>
 *   </li>
 */
const CLOSE_DELAY = 250; // ms — cukup buat gerakan mouse wajar, tidak kelamaan juga

export function initNavbarDropdown(root = document) {
  const dropdownItems = root.querySelectorAll("[data-dropdown]");
  let closeDropdownTimer = null;

  const closeAllDropdowns = (except = null) => {
    dropdownItems.forEach((item) => {
      if (item !== except) {
        item.classList.remove("is-open");
        const trigger = item.querySelector("[data-dropdown-trigger]");
        trigger?.classList.remove("is-open");
        trigger?.setAttribute("aria-expanded", "false");
      }
    });
  };

  const openDropdown = (item, trigger) => {
    clearTimeout(closeDropdownTimer);
    closeAllDropdowns(item);
    item.classList.add("is-open");
    trigger?.classList.add("is-open");
    trigger?.setAttribute("aria-expanded", "true");
  };

  const scheduleCloseDropdown = () => {
    clearTimeout(closeDropdownTimer);
    closeDropdownTimer = setTimeout(() => closeAllDropdowns(), CLOSE_DELAY);
  };

  dropdownItems.forEach((item) => {
    const trigger = item.querySelector("[data-dropdown-trigger]");
    const panel = item.querySelector("[data-dropdown-panel]");
    if (!trigger) return;

    // Klik tetap didukung (mobile & keyboard, tanpa hover).
    trigger.addEventListener("click", (event) => {
      event.stopPropagation();
      if (item.classList.contains("is-open")) {
        closeAllDropdowns();
      } else {
        openDropdown(item, trigger);
      }
    });

    // Hover dengan jeda tutup — dipasang di trigger DAN di panel,
    // supaya "menyeberang" celah di antara keduanya tidak langsung menutup.
    [item, panel].forEach((el) => {
      el?.addEventListener("mouseenter", () => openDropdown(item, trigger));
      el?.addEventListener("mouseleave", scheduleCloseDropdown);
    });

    // --- Flyout tingkat dua (mis. "Struktur Tim Teknis") ---
    const flyoutItems = item.querySelectorAll("[data-flyout]");
    let closeFlyoutTimer = null;

    const openFlyout = (flyoutItem) => {
      clearTimeout(closeFlyoutTimer);
      flyoutItems.forEach((f) => f.classList.remove("is-flyout-open"));
      flyoutItem.classList.add("is-flyout-open");
    };

    const scheduleCloseFlyout = () => {
      clearTimeout(closeFlyoutTimer);
      closeFlyoutTimer = setTimeout(() => {
        flyoutItems.forEach((f) => f.classList.remove("is-flyout-open"));
      }, CLOSE_DELAY);
    };

    flyoutItems.forEach((flyoutItem) => {
      const flyoutPanel = flyoutItem.querySelector("[data-flyout-panel]");
      const flyoutTrigger = flyoutItem.querySelector("[data-flyout-trigger]");

      [flyoutItem, flyoutPanel].forEach((el) => {
        el?.addEventListener("mouseenter", () => openFlyout(flyoutItem));
        el?.addEventListener("mouseleave", scheduleCloseFlyout);
      });

      flyoutTrigger?.addEventListener("click", (event) => {
        if (flyoutPanel) {
          event.preventDefault();
          openFlyout(flyoutItem);
        }
      });
    });
  });

  document.addEventListener("click", () => closeAllDropdowns());
  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") closeAllDropdowns();
  });
}