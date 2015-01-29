<div class="pageheader">
	<h2><i class="fa fa-file-o"></i>Video Gallery</h2>
    <div class="breadcrumb-wrapper">
    	<span class="label">You are here:</span>
        <ol class="breadcrumb">
        	<li><a href="<?php echo $this->createUrl("webend/dashboard"); ?>">Dashboard</a></li>
            <li class="active"><a href="<?php echo $this->createUrl("webend/videos"); ?>" title="">Video Gallery</a></li>
        </ol>
    </div>
</div>

<div class="contentpanel">
   	<div class="row">
        <div class="col-md-12">
                  
                  <form id="form2" class="form-horizontal form-bordered" action="<?php echo $this->createUrl("webend/galleryVideosUpload"); ?>" method="post">
                  
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <div class="panel-btns">
                          <a href="#" class="panel-close">&times;</a>
                          <a href="#" class="minimize">&minus;</a>
                        </div>
                        <h4 class="panel-title">Add New Video</h4>
                        <p>Add a youtube video url to add new video in the gallery.</p>
                      </div>
                      <div class="panel-body panel-body-nopadding">
                      
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Youtube Video URL:</label>
                          <div class="col-sm-8">
                            <input type="text" name="VideoURL" class="form-control" />
                            <span class="help-block">e.g. //www.youtube.com/embed/JDMOJZm7_AA or http://youtu.be/-tBWvbyIiVM or https://www.youtube.com/watch?v=-tBWvbyIiVM</span>
                          </div>
                        </div>
                      </div><!-- panel-body -->
                      <div class="panel-footer">
                        <button class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-default">Reset</button>
                      </div><!-- panel-footer -->
                    </div><!-- panel-default -->
                  </form>
                    
                </div>
    </div>   
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
        
      </ul>
      <form method="post" action="<?php echo $this->createUrl("webend/galleryVideosDeleteAll"); ?>" id="projectImagesDeleteAll">
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
                          <li><a href="<?php echo $this->createUrl("webend/galleryVideosDelete/GalleryID/".$Images->galleryid); ?>"><i class="fa fa-trash-o"></i> Delete</a></li>
                        </ul>
                    </div>
                    <!-- btn-group -->
                    <div class="thmb-prev">
                       <iframe width="250" height="180" src="//www.youtube.com/embed/<?php echo $Images->path; ?>" frameborder="0" allowfullscreen></iframe> 
                    </div>
                  </div><!-- thmb -->
                </div><!-- col-xs-6 -->
               
                <?php endforeach; ?>
              </div><!-- row -->
            </div><!-- col-sm-9 -->
            <!-- col-sm-3 -->
          </div>
    	</a>
    </div>