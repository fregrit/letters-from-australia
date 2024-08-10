<div data-letterdate="<?=$letter['date'];?>" class="col-12">
  <div class="card mb-4 h-100">
    <div class="row g-0 h-100">
      
      <div class="col-md-4">
        <a href="/<?= $language; ?>/<?= $letter['date']; ?>">
          <?php if (!empty($letter['images'])): ?>
            <img src="<?= $letter['images'][1]; ?>" class="img-fluid" alt="Letter Image">
          <?php else: ?>
            <img src="/path/to/placeholder/image.jpg" class="img-fluid" alt="No Image Available">
          <?php endif; ?>
        </a>
      </div>

      <div class="col-md-8 d-flex flex-column">
        <div class="card-body d-flex flex-column justify-content-between text-left h-100">
          <div>
            <a href="/<?= $language; ?>/<?= $letter['date']; ?>" class="text-decoration-none">
              <h5 class="label-printer card-title"><?= $letter['date']; ?></h5>
            </a>
            <p class="card-text"><?= mb_substr($letter['content'], 0, 150, 'UTF-8'); ?>...</p>
            
            <div class="mb-2">
              <?php 
                $currentKeywords = !empty($_GET['keywords']) ? $_GET['keywords'] : [];
                foreach ($letter['keywords'] as $keyword): 
                  $newKeywords = array_unique(array_merge($currentKeywords, [$keyword]));
              ?>
                <a href="/<?= $language; ?>/letters?<?= http_build_query(['keywords' => $newKeywords, 'people' => $_GET['people'] ?? []]); ?>" class="badge bg-secondary text-decoration-none"><?= htmlspecialchars($keyword); ?></a>
              <?php endforeach; ?>
            </div>
            <div class="mb-2">
              <?php 
                $currentPeople = !empty($_GET['people']) ? $_GET['people'] : [];
                foreach ($letter['people'] as $person): 
                  $newPeople = array_unique(array_merge($currentPeople, [$person]));
              ?>
                <a href="/<?= $language; ?>/letters?<?= http_build_query(['keywords' => $_GET['keywords'] ?? [], 'people' => $newPeople]); ?>" class="badge bg-dark text-decoration-none"><?= htmlspecialchars($person); ?></a>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="d-flex justify-content-end">
            <a href="/<?= $language; ?>/<?= $letter['date']; ?>" data-hasreadtext="<?= translate("Read this letter again"); ?>" class="btn btn-primary btn-sm"><?= translate("Read this letter"); ?></a>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
