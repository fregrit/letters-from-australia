<?php if (!empty($_GET['keywords']) || !empty($_GET['people'])): ?>
  <div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
      <strong><?= translate("Current filter:"); ?></strong>
      <?php if (!empty($_GET['keywords'])): ?>
        <?php foreach ($_GET['keywords'] as $keyword): ?>
          <?php 
            // Build the link to remove this keyword
            $remainingKeywords = array_diff($_GET['keywords'], [$keyword]);
          ?>
          <a href="/<?= $language; ?>/letters?<?= http_build_query(['keywords' => $remainingKeywords, 'people' => $_GET['people'] ?? []]); ?>" class="badge bg-secondary text-decoration-none">
            <?= htmlspecialchars($keyword); ?> &times;
          </a>
        <?php endforeach; ?>
      <?php endif; ?>
      <?php if (!empty($_GET['people'])): ?>
        <?php foreach ($_GET['people'] as $person): ?>
          <?php 
            // Build the link to remove this person
            $remainingPeople = array_diff($_GET['people'], [$person]);
          ?>
          <a href="/<?= $language; ?>/letters?<?= http_build_query(['keywords' => $_GET['keywords'] ?? [], 'people' => $remainingPeople]); ?>" class="badge bg-dark text-decoration-none">
            <?= htmlspecialchars($person); ?> &times;
          </a>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
    <!-- Enhanced Reset Filter Button -->
    <a href="/<?= $language; ?>/letters" class="btn btn-danger btn-sm"><?= translate("Reset filter"); ?></a>
  </div>

  <!-- Show the number of letters -->
  <div class="mb-4">
    <strong><?= translate("Showing"); ?> <?= count($letters); ?> <?= translate("letters", "written messages"); ?></strong>
  </div>
<?php endif; ?>
