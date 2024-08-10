<!-- letterPage.php -->
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-8">

      <!-- Letter Header -->
      <div class="letter-header text-center">
        <h1><?= htmlspecialchars($letter['date']); ?></h1>
      </div>

      <!-- Previous and Next Navigation -->
      <?php
        $currentIndex = array_search($letter['date'], $allLetterDates);
        $prevIndex = $currentIndex > 0 ? $currentIndex - 1 : null;
        $nextIndex = $currentIndex < count($allLetterDates) - 1 ? $currentIndex + 1 : null;
      ?>
      <div class="d-flex justify-content-between mb-3">
        <?php if ($prevIndex !== null): ?>
          <a href="/<?= $language; ?>/<?= $allLetterDates[$prevIndex]; ?>" class="btn btn-outline-primary">
            &larr; <?= translate('Previous'); ?>
          </a>
        <?php else: ?>
          <div></div>
        <?php endif; ?>
        <?php if ($nextIndex !== null): ?>
          <a href="/<?= $language; ?>/<?= $allLetterDates[$nextIndex]; ?>" class="btn btn-outline-primary">
            <?= translate('Next'); ?> &rarr;
          </a>
        <?php else: ?>
          <div></div>
        <?php endif; ?>
      </div>

      <!-- Original Letter Content -->
      <div class="letter-content">
        <p><?= nl2br(htmlspecialchars($letter['content'])); ?></p>
      </div>

      <!-- Modernized Letter Content (Hidden by Default) -->
      <?php if ($language === 'sv' && !empty($letter['content_sv_modern'])): ?>
        <div class="letter-content-modern" style="display: none;">
          <p><?= nl2br(htmlspecialchars($letter['content_sv_modern'])); ?></p>
        </div>
      <?php endif; ?>

      <div class="d-flex justify-content-between mt-3">
        <?php if ($prevIndex !== null): ?>
          <a href="/<?= $language; ?>/<?= $allLetterDates[$prevIndex]; ?>" class="btn btn-outline-primary">
            &larr; <?= translate('Previous'); ?>
          </a>
        <?php else: ?>
          <div></div>
        <?php endif; ?>
        <?php if ($nextIndex !== null): ?>
          <a href="/<?= $language; ?>/<?= $allLetterDates[$nextIndex]; ?>" class="btn btn-outline-primary">
            <?= translate('Next'); ?> &rarr;
          </a>
        <?php else: ?>
          <div></div>
        <?php endif; ?>
      </div>

      <!-- Thumbnail Images Row -->
      <div class="image-grid mb-4">
        <?php foreach ($letter['images'] as $image): ?>
          <?php if (strpos($image, '_thumbnail.webp') !== false && strpos($image, 'Kuvert') === false): ?>
            <?php 
              $fullSizeImage = str_replace('_thumbnail', '', $image); 
            ?>
            <div class="image-cell">
              <a href="<?= htmlspecialchars($fullSizeImage); ?>" target="fullImageTab">
                <img src="<?= htmlspecialchars($image); ?>" class="img-fluid" alt="Letter Thumbnail">
              </a>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>

    </div>
  </div>
</div>
