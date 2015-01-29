<div class="pageheader">
	<h2><i class="fa fa-home"></i>Testimonials <span><?php if($data): ?>Edit Testimonials<?php else: ?>Add New Testimonials<?php endif; ?></span></h2>
    <div class="breadcrumb-wrapper">
    	<span class="label">You are here:</span>
        <ol class="breadcrumb">
        	<li><a href="<?php echo $this->createUrl("webend/dashboard"); ?>">Dashboard</a></li>
            <li><a href="<?php echo $this->createUrl("webend/testimonial"); ?>" title="">Testimonials</a></li>
            <?php if($data): ?>
                <li class="active"><a href="<?php echo $this->createUrl("webend/testimonials/TestimonialID/". $data->testimonialid); ?>" title="">Edit Testimonials</a></li>
            <?php else: ?>
                <li class="active"><a href="<?php echo $this->createUrl("webend/testimonials"); ?>" title="">Add New Testimonials</a></li>
            <?php endif; ?>
        </ol>
	</div>
</div>
<div class="contentpanel">
  <?php if(isset(Yii::app()->session['AdminError'])): ?>
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong>Error!</strong> <?php echo Yii::app()->session['AdminError']; ?></a>.
        </div>
    <?php 
    unset(Yii::app()->session['AdminError']);
    endif; ?>
    <?php if(isset(Yii::app()->session['AdminSuccess'])): ?>
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong>Congratulations!</strong> <?php echo Yii::app()->session['AdminSuccess']; ?></a>.
        </div>
    <?php 
    unset(Yii::app()->session['AdminSuccess']);
    endif; ?>
  <div class="panel panel-default">
  	  <div class="panel-heading">
          <div class="panel-btns">
              <a href="#" class="minimize">&minus;</a>
          </div>
          <?php if($data): ?>
            <h4 class="panel-title">Edit Testimonial</h4>
          <?php else: ?>
            <h4 class="panel-title">Add New Testimonial</h4>
          <?php endif; ?>
      </div>
      <form class="form-horizontal form-bordered" method="post" action="<?php echo $this->createUrl("webend/addTestimonial"); ?>" enctype="multipart/form-data">
          <div class="panel-body panel-body-nopadding">
              <?php if($data): ?>
                  <input type="hidden" name="TestimonialID" value="<?php echo $data[$rsDefaultLang->languageid]['testimonialslug']; ?>" />
              <?php endif; ?>
              <?php foreach($rsLangs as $Langs): ?>
                  <div class="form-group">
                      <label class="col-sm-3 control-label">User's Name (<?php echo $Langs->language; ?>)</label>
                      <div class="col-sm-6">
                          <input type="text" name="UserName[<?php echo $Langs->languageid; ?>]" class="form-control" value="<?php if($data): echo $data[$Langs->languageid]['username']; endif; ?>" />
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-3 control-label">Designation (<?php echo $Langs->language; ?>)</label>
                      <div class="col-sm-6">
                          <input type="text" name="Designation[<?php echo $Langs->languageid; ?>]" class="form-control" value="<?php if($data): echo $data[$Langs->languageid]['designation']; endif; ?>" />
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-3 control-label">Testimonial (<?php echo $Langs->language; ?>)</label>
                      <div class="col-sm-9">
                        <div class="panel-body">
                          <textarea name="Testimonial[<?php echo $Langs->languageid; ?>]" placeholder="Enter testimonial here..." class="form-control ckeditor" rows="10"><?php if($data): echo stripslashes($data[$Langs->languageid]['testimonial']); endif; ?></textarea>
                        </div>
                          
                      </div>
                  </div>
                  
              <?php endforeach; ?>
              <div class="form-group">
                  <label class="col-sm-3 control-label">Image: </label>
                  <div class="col-sm-6">
                      <div class="fileupload fileupload-new" data-provides="fileupload">
                          <div class="input-append">
                              <div class="uneditable-input">
                                  <i class="glyphicon glyphicon-file fileupload-exists"></i>
                                  <span class="fileupload-preview"></span>
                              </div>
                              <span class="btn btn-default btn-file">
                                  <span class="fileupload-new">Select file</span>
                                  <span class="fileupload-exists">Change</span>
                                  <input type="file" class="styled" size="24" name="FilePath">
                              </span>
                              <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-sm-3 control-label">Status:</label>
                  <div class="col-sm-5">
                      <select class="form-control chosen-select" name="Status" data-placeholder="Choose a Status...">
                          <option value="1">Active</option>
                          <option value="0" <?php if($data): if($data[$rsDefaultLang->languageid]['status']==0): ?> selected="selected" <?php endif; endif; ?>>Inactive</option>
                      </select>
                  </div>
              </div>
          </div><!-- panel-body -->
          <div class="panel-footer">
              <div class="row">
                  <div class="col-sm-6 col-sm-offset-3">
                      <button class="btn btn-primary" type="submit">Submit</button>&nbsp;
                      <button class="btn btn-default" onclick="document.location.href='<?php echo $this->createUrl("webend/cms"); ?>'">Cancel</button>
                  </div>
              </div>
          </div><!-- panel-footer -->
      </form>
  </div>
</div>