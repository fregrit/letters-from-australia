<!-- startPage.php -->
<!-- centered content -->
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="text-center">
        <h1><?=translate("Letters from Australia");?></h1>
        <p><?=translate("
        Here we have collected a series of heartfelt letters written by Margareta to her mom in Sweden during the early 1970s.
        These letters detail the experiences and adventures of Margareta, her husband Stig, and their son Per as they settled into their new life in Australia. 
        Offering a unique glimpse into everyday life and the world as it was back then, these letters were preserved and published by Margareta's sons after her passing in 2017 to keep her story alive.
        Enjoy exploring this special piece of history!
        ");?></p>
        <!-- read the letters button -->
        <a href="/<?=$language;?>/<?=$allLetterDates[0];?>" data-continueredingtext="<?=translate("Continue reading");?>" class="btn btn-primary"><?=translate("Start reading");?></a>

        <img src="<?=PolaroidPics::getRandom();?>" class="img-fluid mt-2">
      </div>
    </div>
  </div>
</div>
