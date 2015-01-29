<div class="pageheader">
	<h2><i class="fa fa-home"></i>CMS <span><?php if($data): ?>Edit CMS<?php else: ?>Add New CMS<?php endif; ?></span></h2>
    <div class="breadcrumb-wrapper">
    	<span class="label">You are here:</span>
        <ol class="breadcrumb">
        	<li><a href="<?php echo $this->createUrl("webend/dashboard"); ?>">Dashboard</a></li>
            <li><a href="<?php echo $this->createUrl("webend/cms"); ?>" title="">CMS</a></li>
            <?php if($data): ?>
                <li class="active"><a href="<?php echo $this->createUrl("webend/cmss/CmsID/". $data->cmsid); ?>" title="">Edit CMS</a></li>
            <?php else: ?>
                <li class="active"><a href="<?php echo $this->createUrl("webend/cmss"); ?>" title="">Add New CMS</a></li>
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
            <h4 class="panel-title">Edit CMS</h4>
          <?php else: ?>
            <h4 class="panel-title">Add New CMS</h4>
          <?php endif; ?>
      </div>
      <form class="form-horizontal form-bordered" method="post" action="<?php echo $this->createUrl("webend/addCms"); ?>">
          <div class="panel-body panel-body-nopadding">
              <?php if($data): ?>
                  <input type="hidden" name="CmsID" value="<?php echo $data[$rsDefaultLang->languageid]['pageslug']; ?>" />
              <?php endif; ?>
              <?php foreach($rsLangs as $Langs): ?>
                  <div class="form-group">
                      <label class="col-sm-3 control-label">Page Name (<?php echo $Langs->language; ?>)</label>
                      <div class="col-sm-6">
                          <input type="text" name="Page[<?php echo $Langs->languageid; ?>]" class="form-control" value="<?php if($data): echo $data[$Langs->languageid]['pagename']; endif; ?>" />
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-3 control-label">Content (<?php echo $Langs->language; ?>)</label>
                      <div class="col-sm-9">
                        <div class="panel-body">
                          <textarea name="Content[<?php echo $Langs->languageid; ?>]" placeholder="Enter text here..." class="form-control ckeditor" rows="10"><?php if($data): echo stripslashes($data[$Langs->languageid]['pagecontent']); endif; ?></textarea>
                        </div>
                          
                      </div>
                  </div>
                  
              <?php endforeach; ?>
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