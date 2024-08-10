<div class="container text-center my-5">
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <div class="error-container">
        <h1 class="display-1 text-danger"><?= htmlspecialchars($error_code); ?></h1>
        <h2 class="mb-4"><?= htmlspecialchars($error_message); ?></h2>
        <p class="lead"><?= translate('Sorry, something went wrong.'); ?></p>
        <p class="mb-4">
          <?= translate('Please try refreshing the page, or go back to the'); ?>
          <a href="<?= isset($language) ? '/' . $language : '/'; ?>">
            <?= translate('homepage'); ?>
          </a>.
        </p>
        <a href="<?= isset($language) ? '/' . $language : '/'; ?>" class="btn btn-primary">
          <?= translate('Go to Homepage'); ?>
        </a>
      </div>
    </div>
  </div>
</div>
