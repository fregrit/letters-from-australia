<!-- templates/partials/header.php -->
<?php
$title = translate("Letters from Australia");

$urls = Url::getInstance()->getLanguageUrls($_SERVER['REQUEST_URI']);
if (isset($letter)) {
  $title = $letter['date'] . ' - ' . $title;
}
?>
<!DOCTYPE html>
<html lang="<?=$language;?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?=$title;?></title>
  
  <!-- Hreflang Tags -->
  <?php foreach ($urls as $langCode => $url): ?>
    <link rel="alternate" hreflang="<?=$langCode;?>" href="<?=$url;?>" />
  <?php endforeach; ?>
  
  <!-- Open Graph Meta Tags -->
  <meta property="og:title" content="<?=$title;?>" />
  <meta property="og:description" content="<?=translate("A collection of letters sent from Australia to Sweden in the early 1970s.");?>" />
  <meta property="og:image" content="<?=PolaroidPics::getByFilename("4.jpeg");?>" />
  <meta property="og:url" content="http://yourwebsite.com" />
  <meta property="og:type" content="website" />

  <!-- Twitter Card Meta Tags -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="<?=$title;?>" />
  <meta name="twitter:description" content="<?=translate("A collection of letters sent from Australia to Sweden in the early 1970s.");?>" />
  <meta name="twitter:image" content="<?=PolaroidPics::getByFilename("4.jpeg");?>" />

  <link rel="stylesheet" href="/css/bootstrap.min.css">
  <link rel="stylesheet" href="/css/styles.css">
  <?php if (isset($allLetterDates) && is_array($allLetterDates)): ?>
    <script>
      var language = '<?=$language;?>';
      var isStartPage = <?=isset($isStartPage) ? 'true' : 'false';?>;
      var isOnLetterPage = <?=isset($letter) ? 'true' : 'false';?>;
      var isOnLetterListPage = <?=isset($letters) ? 'true' : 'false';?>;
      var allLetterDates = <?=json_encode($allLetterDates);?>;
      function isLocalStorageAvailable() {
        try {
          const test = '__storage_test__';
          localStorage.setItem(test, test);
          localStorage.removeItem(test);
          return true;
        } catch (e) {
          return false;
        }
      }
    </script>
  <?php endif; ?>
</head>
<body>
  <header class="sticky-header">
    <div class="container">
      <nav>
        <!-- Hamburger Menu for Small Screens -->
        <div class="hamburger-menu">
          <button id="hamburger-button" aria-expanded="false">
            <span class="hamburger-icon">☰</span>
          </button>
          <div id="hamburger-dropdown" class="dropdown-content">
            <a href="/<?=$language;?>" class="nav-link label-printer"><?=translate("Home");?></a>
            <a href="/<?=$language;?>/letters" class="nav-link label-printer"><?=translate("All letters", "All written messages");?></a>
            <!-- Language style Toggle Switch -->
            <?php if ($language === 'sv' && isset($letter) && !empty($letter['content_sv_modern'])): ?>
              <div class="language-switcher-wrapper label-printer">
                <label for="languageToggle1" class="mr-2"><?=translate("Modern Swedish");?>:</label>
                <div class="toggle-button-cover">
                  <div class="button-cover">
                    <div class="button language-switcher">
                      <input type="checkbox" class="checkbox languageToggle" id="languageToggle1"/>
                      <div class="knobs"></div>
                      <div class="layer"></div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endif; ?>
            <?php foreach ($urls as $langCode => $url): ?>
              <?php if ($langCode !== $language): ?>
                <a class="label-printer" href="<?=$url;?>"><?=$GLOBALS['supported_languages'][$langCode];?></a>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>
        <!-- Regular Menu for Large Screens -->
        <div class="regular-menu">
          <div class="page-links">
            <a href="/<?=$language;?>" class="nav-link label-printer"><?=translate("Home");?></a>
            <a href="/<?=$language;?>/letters" class="nav-link label-printer"><?=translate("All letters", "All written messages");?></a>
          </div>
          <div class="language-controls">
          <!-- Language style Toggle Switch -->
          <?php if ($language === 'sv' && isset($letter) && !empty($letter['content_sv_modern'])): ?>
            <div class="language-switcher-wrapper label-printer">
              <label for="languageToggle2" class="mr-2"><?=translate("Modern Swedish");?>:</label>
              <div class="toggle-button-cover">
                <div class="button-cover">
                  <div class="button language-switcher">
                    <input type="checkbox" class="checkbox languageToggle" id="languageToggle2"/>
                    <div class="knobs"></div>
                    <div class="layer"></div>
                  </div>
                </div>
              </div>
            </div>
          <?php endif; ?>
          <?php foreach ($urls as $langCode => $url): ?>
            <?php if ($langCode !== $language): ?>
              <a class="label-printer" href="<?=$url;?>"><?=$GLOBALS['supported_languages'][$langCode];?></a>
            <?php endif; ?>
          <?php endforeach; ?>
          </div>
        </div>
      </nav>
    </div>
  </header>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <main>
