document.addEventListener('DOMContentLoaded', function() {
  if (isLocalStorageAvailable()) {
    // Reading tracking logic
    if (isOnLetterPage) {
      const originalContent = document.querySelector('.letter-content');
      const modernContent = document.querySelector('.letter-content-modern');
      const languageToggles = document.querySelectorAll('.languageToggle'); // Select all toggles

      // Function to sync toggles and content display
      function syncToggles(isChecked) {
        languageToggles.forEach(toggle => toggle.checked = isChecked);
        if (originalContent && modernContent) { // Ensure elements exist before trying to manipulate them
          if (isChecked) {
            modernContent.style.display = 'none';
            originalContent.style.display = 'block';
            localStorage.setItem('preferredLanguageVersion', 'original');
          } else {
            originalContent.style.display = 'none';
            modernContent.style.display = 'block';
            localStorage.setItem('preferredLanguageVersion', 'modern');
          }
        }
      }

      // Set initial state based on localStorage
      const preferredVersion = localStorage.getItem('preferredLanguageVersion');
      if (preferredVersion === 'modern' && modernContent) {
        syncToggles(false); // Uncheck toggles, show modern content
      } else {
        syncToggles(true); // Check toggles, show original content
      }

      // Add event listeners to language toggles
      languageToggles.forEach(toggle => {
        toggle.addEventListener('change', function() {
          syncToggles(this.checked);
        });
      });

      // Reading status tracking
      if (originalContent) {
        const text = originalContent.innerText;
        const wordCount = text.split(/\s+/).length;
        const readingSpeed = 380; // words per minute
        const readingTime = (wordCount / readingSpeed) * 60 * 1000; // time in milliseconds

        let readStatus = JSON.parse(localStorage.getItem('readStatus')) || {};
        const letterDate = allLetterDates.find(date => window.location.href.includes(date));

        // Save currently reading letter in localStorage
        localStorage.setItem('isCurrentlyReading', letterDate);

        if (!readStatus[letterDate]) {
          setTimeout(() => {
            readStatus[letterDate] = 'read';
            localStorage.setItem('readStatus', JSON.stringify(readStatus));
          }, readingTime);
        }
      }
    }

    // Hamburger menu functionality
    const hamburgerButton = document.getElementById('hamburger-button');
    const hamburgerDropdown = document.getElementById('hamburger-dropdown');

    if (hamburgerButton) {
      hamburgerButton.addEventListener('click', function() {
        const isExpanded = this.getAttribute('aria-expanded') === 'true';
        this.setAttribute('aria-expanded', !isExpanded);
      });
    }

    // Adding checkmarks and updating read button text for read letters on the letter list page
    if (isOnLetterListPage) {
      let readStatus = JSON.parse(localStorage.getItem('readStatus')) || {};

      document.querySelectorAll('[data-letterdate]').forEach(card => {
        const letterDate = card.getAttribute('data-letterdate');

        if (readStatus[letterDate] === 'read') {
          const cardTitle = card.querySelector('.card-title');
          if (cardTitle) {
            const checkmarkSpan = document.createElement('span');
            checkmarkSpan.innerHTML = ' ✔️'; // Add a checkmark symbol
            cardTitle.appendChild(checkmarkSpan);
          }

          // Update the read button text
          const readButton = card.querySelector('a[data-hasreadtext]');
          if (readButton) {
            readButton.innerText = readButton.getAttribute('data-hasreadtext');
          }
        }
      });
    }

    // Update the start reading link if on the start page
    if (isStartPage) {
      const continueReadingDate = localStorage.getItem('isCurrentlyReading');
      if (continueReadingDate) {
        const startReadingLink = document.querySelector('[data-continueredingtext]');
        if (startReadingLink) {
          startReadingLink.href = `/${language}/${continueReadingDate}`;
          startReadingLink.innerText = `${startReadingLink.getAttribute('data-continueredingtext')} ${continueReadingDate}`;
        }
      }
    }
  }
});
