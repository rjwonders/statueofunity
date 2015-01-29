<div class="pageheader">
	<h2><i class="fa fa-file-o"></i>Image Manager (<?php echo $rsData->projectname; ?>)</h2>
    <div class="breadcrumb-wrapper">
    	<span class="label">You are here:</span>
        <ol class="breadcrumb">
        	<li><a href="<?php echo $this->createUrl("webend/dashboard"); ?>">Dashboard</a></li>
            <li><a href="<?php echo $this->createUrl("webend/project"); ?>" title="">Projects</a></li>
            <li class="active"><a href="<?php echo $this->createUrl("webend/projectImages/ProjectID/".$rsData->projectid); ?>" title="">Image Manager (<?php echo $rsData->projectname; ?>)</a></li>
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
      <form action="<?php echo $this->createUrl("webend/projectImagesUpload"); ?>" id="myresetform" method="post" enctype="multipart/form-data" style="display:none;">
      	<input type="hidden" name="ProjectID" value="<?php echo $rsData->projectslug; ?>" />
      	<input type="file" id="uploadimagesfield" name="myfile[]" multiple="">
        <input type="submit" id="UploadImageNow" value="" />
      </form>
      <form method="post" action="<?php echo $this->createUrl("webend/projectImagesDeleteAll"); ?>" id="projectImagesDeleteAll">
          <div class="row">
            <div class="col-sm-12">
              <div class="row filemanager">
                <?php 
                $rx = 0;
                foreach($rsImages as $Images): ?>
                    <div class="col-xs-6 col-sm-4 col-md-3 document">
                  <div class="thmb">
                    <div class="ckbox ckbox-default">
                      <input type="checkbox" id="check<?php echo $Images->projectimagesid; ?>" value="<?php echo $Images->projectimagesid; ?>" name="checks[]" />
                      <label for="check<?php echo $Images->projectimagesid; ?>"></label>
                    </div>
                    <div class="btn-group fm-group">
                        <button type="button" class="btn btn-default dropdown-toggle fm-toggle" data-toggle="dropdown">
                          <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu fm-menu" role="menu">
                          <li><a href="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/projects/<?php echo $Images->projectslug; ?>/<?php echo $Images->images; ?>" target="_blank"><i class="fa fa-download"></i> Download</a></li>
                          <li><a href="<?php echo $this->createUrl("webend/projectImagesDelete/ProjectImagesID/".$Images->projectimagesid); ?>"><i class="fa fa-trash-o"></i> Delete</a></li>
                        </ul>
                    </div><!-- btn-group -->
                    <div class="thmb-prev">
                        <?php Yii::import('ext.iwi.Iwi');
                        //echo YiiBase::getPathOfAlias('webroot')."/assets/projects/projectimage".$Images->projectid."/".$Images->images;
                        $picture = new Iwi(YiiBase::getPathOfAlias('webroot')."/assets/projects/".$Images->projectslug."/".$Images->images);
                        $picture->resize(0,393, Iwi::NONE);
                        ?>
                        <a href="<?php echo Yii::app()->request->baseUrl."/assets/projects/".$Images->projectslug."/".$Images->images; ?>" data-rel="prettyPhoto">
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