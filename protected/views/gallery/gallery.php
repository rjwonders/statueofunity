<?php Yii::import('ext.iwi.Iwi'); ?>

<section class="contentpart">
	<div class="wrapper">
    	<div class="gallerypart">
          <?php if($rsVideoGallery): ?>
              <div class="video-gallery">
                  <h2><?php echo Yii::app()->vars->myLang['Video Gallery']; ?></h2>
                  <div class="img-gal popup-gallery-video">
                      <?php foreach($rsVideoGallery as $gallery): ?>
                      <a href="http://www.youtube.com/watch?v=<?php echo $gallery->path; ?>"><img src="http://img.youtube.com/vi/<?php echo $gallery->path; ?>/hqdefault.jpg" alt=""></a>
                      <?php endforeach; ?>
                      <div class="cl"></div>
                  </div>
              </div>
          <?php endif; ?>
          <?php if($rsImageGallery): ?>
              <div class="photos-gallery">
                  <h2><?php echo Yii::app()->vars->myLang['Photos Gallery']; ?></h2>
                  <div class="img-gal popup-gallery-photos">
                      <?php foreach($rsImageGallery as $gallery): 
                          $MainPicture = Yii::app()->iwi->load(YiiBase::getPathOfAlias('webroot')."/assets/gallery/".$gallery->path)->adaptive(224,168)->cache();
                          $MainPicture2 = Yii::app()->iwi->load(YiiBase::getPathOfAlias('webroot')."/assets/gallery/".$gallery->path)->cache();?>
                          <a href="<?php echo $MainPicture2; ?>"><img src="<?php echo $MainPicture; ?>" alt=""></a>
                      <?php endforeach; ?>
                      <div class="cl"></div>
                  </div>
              </div>
          <?php endif; ?>
      </div>   
  </div>
</section>