<div class="pageheader">
	<h2><i class="fa fa-file-o"></i>Image Gallery</h2>
    <div class="breadcrumb-wrapper">
    	<span class="label">You are here:</span>
        <ol class="breadcrumb">
        	<li><a href="<?php echo $this->createUrl("webend/dashboard"); ?>">Dashboard</a></li>
            <li class="active"><a href="<?php echo $this->createUrl("webend/images"); ?>" title="">Image Gallery</a></li>
        </ol>
    </div>
</div>
<div class="contentpanel">
      
      <ul class="filemanager-options">
        <li style="padding:20px 15px">
          <div class="ckbox ckbox-default">
            <input type="checkbox" id="selectall" value="1" />
            <label for="selectall">Select All</label>
          </div>
        </li>
        
        <li style="padding:20px 15px">
          <a href="javascript:void(0)" id="DeleteAllImage" class="itemopt disabled"><i class="fa fa-trash-o"></i> Delete</a>
        </li>
        <li class="filter-type">
          <button class="btn btn-primary btn-block" id="UplaodImage">Upload Files</button>
        </li>
        
      </ul>
      <form action="<?php echo $this->createUrl("webend/galleryImagesUpload"); ?>" id="myresetform" method="post" enctype="multipart/form-data" style="display:none;">
      	<input type="file" id="uploadimagesfield" name="myfile[]" multiple="">
        <input type="submit" id="UploadImageNow" value="" />
      </form>
      <form method="post" action="<?php echo $this->createUrl("webend/galleryImagesDeleteAll"); ?>" id="projectImagesDeleteAll">
          <div class="row">
            <div class="col-sm-12">
              <div class="row filemanager">
                <?php 
                $rx = 0;
                foreach($rsGallery as $Images): ?>
                    <div class="col-xs-6 col-sm-4 col-md-3 document">
                  <div class="thmb">
                    <div class="ckbox ckbox-default">
                      <input type="checkbox" id="check<?php echo $Images->galleryid; ?>" value="<?php echo $Images->galleryid; ?>" name="checks[]" />
                      <label for="check<?php echo $Images->galleryid; ?>"></label>
                    </div>
                    <div class="btn-group fm-group">
                        <button type="button" class="btn btn-default dropdown-toggle fm-toggle" data-toggle="dropdown">
                          <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu fm-menu" role="menu">
                          <li><a href="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/gallery/<?php echo $Images->path; ?>" target="_blank"><i class="fa fa-download"></i> Download</a></li>
                          <li><a href="<?php echo $this->createUrl("webend/galleryImagesDelete/GalleryID/".$Images->galleryid); ?>"><i class="fa fa-trash-o"></i> Delete</a></li>
                        </ul>
                    </div><!-- btn-group -->
                    <div class="thmb-prev">
                        <?php Yii::import('ext.iwi.Iwi');
                        //echo YiiBase::getPathOfAlias('webroot')."/assets/projects/projectimage".$Images->projectid."/".$Images->images;
                        $picture = new Iwi(YiiBase::getPathOfAlias('webroot')."/assets/gallery/".$Images->path);
                        $picture->resize(0,393, Iwi::NONE);
                        ?>
                        <a href="<?php echo Yii::app()->request->baseUrl."/assets/gallery/".$Images->path; ?>" data-rel="prettyPhoto[]">
                        <img src="<?php echo $picture->cache(); ?>" class="img-responsive" alt="" />
                        </a>
                    </div>
                  </div><!-- thmb -->
                </div><!-- col-xs-6 -->
                <?php 
                $rx = $rx + 1;
                if($rx%4==0): ?>
                    <div style="clear:both"></div>
                <?php endif;
                ?>
                <?php endforeach; ?>
              </div><!-- row -->
            </div><!-- col-sm-9 -->
            <!-- col-sm-3 -->
          </div>
    	</a>
    </div>