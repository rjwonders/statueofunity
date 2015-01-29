<div class="pageheader">
	<h2><i class="fa fa-home"></i>Project Category <span><?php if($data): ?>Edit Project Category<?php else: ?>Add New Project Category<?php endif; ?></span></h2>
    <div class="breadcrumb-wrapper">
    	<span class="label">You are here:</span>
        <ol class="breadcrumb">
        	<li><a href="<?php echo $this->createUrl("webend/dashboard"); ?>">Dashboard</a></li>
            <li><a href="<?php echo $this->createUrl("webend/category"); ?>" title="">Project Category</a></li>
            <?php if($data): ?>
                <li class="active"><a href="<?php echo $this->createUrl("webend/categorys/CategoryID/". $data->categoryid); ?>" title="">Edit Project Category</a></li>
            <?php else: ?>
                <li class="active"><a href="<?php echo $this->createUrl("webend/categorys"); ?>" title="">Add New Project Category</a></li>
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
            <h4 class="panel-title">Edit Project Category</h4>
          <?php else: ?>
            <h4 class="panel-title">Add New Project Category</h4>
          <?php endif; ?>
      </div>
      <form class="form-horizontal form-bordered" method="post" action="<?php echo $this->createUrl("webend/addCategory"); ?>" enctype="multipart/form-data">
          <div class="panel-body panel-body-nopadding">
              <?php if($data): ?>
                  <input type="hidden" name="CategoryID" value="<?php echo $data[$rsDefaultLang->languageid]['categoryslug']; ?>" />
              <?php endif; ?>
              <?php foreach($rsLanguages as $Langs): ?>
                  <div class="form-group">
                      <label class="col-sm-3 control-label">Category Name(<?php echo $Langs->language; ?>)</label>
                      <div class="col-sm-6">
                          <input type="text" name="Category[<?php echo $Langs->languageid; ?>]" class="form-control" value="<?php if($data): echo $data[$Langs->languageid]['category']; endif; ?>" />
                      </div>
                  </div>
              <?php endforeach; ?>
              <div class="form-group">
                  <label class="col-sm-3 control-label">Parent Category:</label>
                  <div class="col-sm-5">
                      <select class="form-control chosen-select" name="ParentCategoryID" data-placeholder="Choose a Parent Category...">
                      	<option value="">Select Parent Category</option>
                      	<?php 
						if(count($rsCategory)>0):
							foreach($rsCategory as $rsCats): ?>
							  <option value="<?php echo $rsCats->categoryslug; ?>" <?php if($data): if($data[$rsDefaultLang->languageid]['parentcategoryid']==$rsCats->categoryslug): ?> selected="selected" <?php endif; endif; ?>><?php echo $rsCats->category; ?></option>
							<?php endforeach; ?>
                        <?php endif; ?>
                      </select>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-sm-3 control-label">Category Color</label>
                   <div class="col-sm-5">
                  	<input type="text" name="CategoryColor" class="form-control colorpicker-input" id="colorpicker" value="<?php if($data): echo $data[$rsDefaultLang->languageid]['categorycolor']; endif; ?>"  />
                      <span id="colorSelector" class="colorselector">
                        <span <?php if($data): ?>style="background-color:<?php echo $data[$rsDefaultLang->languageid]['categorycolor'][$rsDefaultLang->languageid]; ?>"<?php endif; ?>></span>
                      </span>
              		</div>
              </div>
              <div class="form-group">
                  <label class="col-sm-3 control-label">Category Image: </label>
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
                      <button class="btn btn-default" onclick="document.location.href='<?php echo $this->createUrl("webend/category"); ?>'">Cancel</button>
                  </div>
              </div>
          </div><!-- panel-footer -->
      </form>
  </div>
</div>