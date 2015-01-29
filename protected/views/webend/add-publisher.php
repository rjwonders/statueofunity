<div class="pageheader">
	<h2><i class="fa fa-home"></i>Campaigner <span><?php if($data): ?>Edit Campaigner<?php else: ?>Add New Campaigner<?php endif; ?></span></h2>
    <div class="breadcrumb-wrapper">
    	<span class="label">You are here:</span>
        <ol class="breadcrumb">
        	<li><a href="<?php echo $this->createUrl("webend/dashboard"); ?>">Dashboard</a></li>
            <li><a href="<?php echo $this->createUrl("webend/creator"); ?>" title="">Campaigners</a></li>
            <?php if($data): ?>
                <li class="active"><a href="<?php echo $this->createUrl("webend/creators/PublisherID/". $data->publisherid); ?>" title="">Edit Campaigner</a></li>
            <?php else: ?>
                <li class="active"><a href="<?php echo $this->createUrl("webend/creators"); ?>" title="">Add New Campaigner</a></li>
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
            <h4 class="panel-title">Edit Campaigner</h4>
          <?php else: ?>
            <h4 class="panel-title">Add New Campaigner</h4>
          <?php endif; ?>
      </div>
      <form class="form-horizontal form-bordered" method="post" action="<?php echo $this->createUrl("webend/addPublisers"); ?>" enctype="multipart/form-data">
          <div class="panel-body panel-body-nopadding">
              <?php if($data): ?>
                  <input type="hidden" name="PublisherID" value="<?php echo $data->publisherid; ?>" />
              <?php endif; ?>
              <div class="form-group">
                  <label class="col-sm-3 control-label">Name</label>
                  <div class="col-sm-2">
                      <input type="text" name="FirstName" placeholder="First Name" class="form-control" value="<?php if($data): echo $data->firstname; endif; ?>" />
                  </div>
                  <div class="col-sm-2">
                      <input type="text" name="LastName" placeholder="Last Name" class="form-control" value="<?php if($data): echo $data->lastname; endif; ?>" />
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-sm-3 control-label">Email</label>
                  <div class="col-sm-6">
                      <input type="text" name="Email" class="form-control" value="<?php if($data): echo $data->email; endif; ?>" <?php if($data): ?> readonly="readonly" <?php endif; ?>/>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-sm-3 control-label">Password:</label>
                  <div class="col-sm-6"><input type="password" name="Password" class="form-control" value="" /></div>
              </div>
              
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
                          <option value="0" <?php if($data): if($data->status==0): ?> selected="selected" <?php endif; endif; ?>>Inactive</option>
                      </select>
                  </div>
              </div>
          </div><!-- panel-body -->
          <div class="panel-footer">
              <div class="row">
                  <div class="col-sm-6 col-sm-offset-3">
                      <button class="btn btn-primary" type="submit">Submit</button>&nbsp;
                      <button class="btn btn-default" onclick="document.location.href='<?php echo $this->createUrl("webend/creator"); ?>'">Cancel</button>
                  </div>
              </div>
          </div><!-- panel-footer -->
      </form>
  </div>
</div>