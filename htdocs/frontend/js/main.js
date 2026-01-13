
document.addEventListener('DOMContentLoaded', () => {
  console.log('Omeng Script Initialized');

  // 1. Burger Menu Toggle
  const toggle = document.querySelector('.nav-toggle');
  const nav = document.querySelector('.nav-secondary');

  if (toggle && nav) {
    toggle.addEventListener('click', (e) => {
      e.stopPropagation();
      nav.classList.toggle('is-open');
      console.log('Menu toggled');
    });

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
      if (nav.classList.contains('is-open') && !nav.contains(e.target) && !toggle.contains(e.target)) {
        nav.classList.remove('is-open');
      }
    });
  }

  // 2. Global Event Delegation for Project Preview
  const modal = document.getElementById("projectModal");
  const modalImg = document.getElementById("imgPreview");
  const captionText = document.getElementById("modalCaption");

  document.addEventListener('click', (e) => {
    // Find the closest project-card anchor
    const card = e.target.closest('.preview-trigger');
    if (card) {
      // Get data from the card
      const img = card.querySelector('img');
      const titleElement = card.querySelector('h3');
      const title = titleElement ? titleElement.innerText : 'Omeng Creation';

      if (modal && modalImg && img) {
        modalImg.src = img.src;
        captionText.innerHTML = title;
        modal.style.display = "block";
        document.body.style.overflow = "hidden";
        console.log('Previewing:', title);
      } else {
        console.warn('Modal elements or image source missing');
      }
    }
  });

  // 3. Modal Close Logic
  if (modal) {
    const closeBtn = modal.querySelector('.close-modal');
    if (closeBtn) {
      closeBtn.onclick = () => {
        modal.style.display = "none";
        document.body.style.overflow = "auto";
      };
    }

    modal.onclick = (e) => {
      if (e.target === modal) {
        modal.style.display = "none";
        document.body.style.overflow = "auto";
      }
    };

    // Escape key to close
    document.addEventListener('keydown', (e) => {
      if (e.key === "Escape" && modal.style.display === "block") {
        modal.style.display = "none";
        document.body.style.overflow = "auto";
      }
    });
  }

  // 4. Sticky Navbar
  const navbar = document.querySelector('.main-nav');
  if (navbar) {
    const handleScroll = () => {
      if (window.scrollY > 60) {
        navbar.classList.add('is-sticky');
        document.body.classList.add('nav-is-sticky');
      } else {
        navbar.classList.remove('is-sticky');
        document.body.classList.remove('nav-is-sticky');
      }
    };
    window.addEventListener('scroll', handleScroll);
    handleScroll(); // Initial check
  }
});