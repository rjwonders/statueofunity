<div class="pageheader">
	<h2><i class="fa fa-home"></i>Projects<span><?php if($data): ?>Edit Project<?php else: ?>Add New Project<?php endif; ?></span></h2>
    <div class="breadcrumb-wrapper">
    	<span class="label">You are here:</span>
        <ol class="breadcrumb">
        	<li><a href="<?php echo $this->createUrl("webend/dashboard"); ?>">Dashboard</a></li>
            <li><a href="<?php echo $this->createUrl("webend/project"); ?>" title="">Projects</a></li>
            <?php if($data): ?>
                <li class="active"><a href="<?php echo $this->createUrl("webend/projects/ProjectID/". $data->projectid); ?>" title="">Edit Project</a></li>
            <?php else: ?>
                <li class="active"><a href="<?php echo $this->createUrl("webend/projects"); ?>" title="">Add New Project</a></li>
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
            <h4 class="panel-title">Edit Project</h4>
          <?php else: ?>
            <h4 class="panel-title">Add New Project</h4>
          <?php endif; ?>
      </div>
      <div class="panel-body panel-body-nopadding">
        <div id="basicWizard" class="basic-wizard">
            <ul class="nav nav-pills nav-justified">
                <li><a href="#tab1" data-toggle="tab"><span>Project Detail</span></a></li>
                <li><a href="#tab2" data-toggle="tab"><span>Rewards</span></a></li>
            </ul>
            <form class="form-horizontal form-bordered" method="post" action="<?php echo $this->createUrl("webend/addProject"); ?>" enctype="multipart/form-data">
            	<div class="tab-content">
                	<div class="tab-pane" id="tab1">
                  
                      <div class="panel-body panel-body-nopadding">
                          <?php if($data): ?>
                              <input type="hidden" name="ProjectID" value="<?php echo $data[$rsLangu->languageid]['projectslug']; ?>" />
                          <?php endif; ?>
                          <?php foreach($rsLangs as $Lang): ?>
                          <div class="form-group">
                              <label class="col-sm-3 control-label">Project Name (<?php echo $Lang->language; ?>)</label>
                              <div class="col-sm-6">
                                  <input type="text" name="ProjectName[<?php echo $Lang->languageid; ?>]" class="form-control" value="<?php if($data): echo $data[$Lang->languageid]['projectname']; endif; ?>" />
                              </div>
                          </div>
                          
                          <div class="form-group">
                              <label class="col-sm-3 control-label">Project Description (<?php echo $Lang->language; ?>)</label>
                              <div class="col-sm-9">
                                <div class="panel-body">
                                  <textarea name="ProjectDescription[<?php echo $Lang->languageid; ?>]" placeholder="Enter text here..." class="form-control ckeditor" rows="10"><?php if($data): echo $data[$Lang->languageid]['projectdescription']; endif; ?></textarea>
                                </div>
                                  
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-3 control-label">Story (<?php echo $Lang->language; ?>)</label>
                              <div class="col-sm-9">
                                <div class="panel-body">
                                  <textarea name="ProjectStory[<?php echo $Lang->languageid; ?>]" placeholder="Enter text here..." class="form-control ckeditor" rows="10"><?php if($data): echo $data[$Lang->languageid]['projectstory']; endif; ?></textarea>
                                </div>
                                  
                              </div>
                          </div>
                          <?php endforeach; ?>
                          <div class="form-group">
                              <label class="col-sm-3 control-label">Editor Name:</label>
                              <div class="col-sm-5">
                                  <select class="form-control chosen-select" name="AdminID" data-placeholder="Choose a Editor...">
                                    <option value="">Select Editor</option>
                                    <?php 
                                    if(count($rsAdmin)>0):
                                        foreach($rsAdmin as $rsAdmins): ?>
                                          <option value="<?php echo $rsAdmins->adminid; ?>" <?php if($data): if($data[$rsLangu->languageid]['adminid']==$rsAdmins->adminid): ?> selected="selected" <?php endif; endif; ?>><?php echo $rsAdmins->firstname." ".$rsAdmins->lastname; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                  </select>
                              </div>
                          </div>
                          
                          <div class="form-group">
                              <label class="col-sm-3 control-label">Campaigner Name:</label>
                              <div class="col-sm-5">
                                  <select class="form-control chosen-select" name="PublisherID" data-placeholder="Choose a Campaigner...">
                                    <option value="">Select Campaigner</option>
                                    <?php 
                                    if(count($rsPublishers)>0):
                                        foreach($rsPublishers as $rsPublisher): ?>
                                          <option value="<?php echo $rsPublisher->publisherid; ?>" <?php if($data): if($data[$rsLangu->languageid]['publisherid']==$rsPublisher->publisherid): ?> selected="selected" <?php endif; endif; ?>><?php echo $rsPublisher->firstname." ".$rsPublisher->lastname; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                  </select>
                              </div>
                          </div>
                          
                          
                          <div class="form-group">
                              <label class="col-sm-3 control-label">Campaign Category:</label>
                              <div class="col-sm-5">
                                  <select class="form-control chosen-select" name="CategoryID[]" data-placeholder="Choose a Campaign Category..." multiple="multiple">
                                    <option value="">Select Campaign Category</option>
                                    <?php 
                                    if(count($rsAdmin)>0):
                                        foreach($rsCategory as $rsCategorys): ?>
                                          <option value="<?php echo $rsCategorys->categoryslug; ?>" <?php if($rsProjectCategory): if(in_array($rsCategorys->categoryslug,$rsProjectCategory)): ?> selected="selected" <?php endif; endif; ?>><?php echo $rsCategorys->category; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                  </select>
                              </div>
                          </div>
                          
                          
                          <div class="form-group">
                              <label class="col-sm-3 control-label">Goal Amount</label>
                              <div class="col-sm-2">
                                <div class="input-group">
                                  <span class="input-group-addon">&#8377;</span>
                                  <input type="text" name="GoalAmount" class="form-control" value="<?php if($data): echo $data[$rsLangu->languageid]['goalamount']; endif; ?>" />
                                  <span class="input-group-addon">.00</span>
                                </div>
                              </div>
                          </div>
                          
                          <div class="form-group">
                              <label class="col-sm-3 control-label">Project Main Image: </label>
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
                              <label class="col-sm-3 control-label">Project End Date</label>
                              <div class="col-sm-2">
                                <div class="input-group">
                                    <input type="text" name="ProjectEndDate" class="form-control hasDatepicker" placeholder="mm/dd/yyyy" id="datepicker-multiple" value="<?php if($data): echo date("m/d/Y",strtotime($data[$rsLangu->languageid]['projectenddate'])); endif; ?>">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                                  
                              </div>
                          </div>
                          
                          
                          
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Tags</label>
                                <div class="col-sm-6">
                                    <input name="Tags" id="tags" class="form-control" value="<?php if($data): echo $data[$rsLangu->languageid]['tags']; endif; ?>" />
                                </div>
                            </div>
                          
                          <div class="form-group">
                              <label class="col-sm-3 control-label">Status:</label>
                              <div class="col-sm-5">
                                  <select class="form-control chosen-select" name="Status" data-placeholder="Choose a Status...">
                                      <option value="1">Active</option>
                                      <option value="0" <?php if($data): if($data[$rsLangu->languageid]['status']==0): ?> selected="selected" <?php endif; endif; ?>>Inactive</option>
                                  </select>
                              </div>
                          </div>
                      </div><!-- panel-body -->
                      <!-- panel-footer -->
                  
                    </div>
                    <div class="tab-pane" id="tab2">
                    	
                    	<div id="myrewards">
                        	<?php 
							$p = 0;
							foreach($rsProjectReward as $ProjectReward): ?>
                            	<div class="row" id="rw<?php echo $p; ?>">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="control-label">Amount to back</label>
                                            <input type="text" name="BackAmount[]" class="form-control" value="<?php echo $ProjectReward->amounttoback; ?>">
                                        </div>
                                    </div><!-- col-sm-6 -->
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="control-label">Reward Points</label>
                                            <input type="text" name="RewardPoint[]" class="form-control" value="<?php echo $ProjectReward->reward; ?>">
                                        </div>
                                    </div><!-- col-sm-6 -->
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="control-label">&nbsp;</label><br/>
                                            <button class="btn btn-primary deletecrow" type="button" value="<?php echo $p; ?>">Delete</button>
                                        </div>
                                    </div><!-- col-sm-6 -->
                                </div>
                            <?php 
							$p = $p + 1;
							endforeach; ?>
                            <input type="hidden" id="crow" value="<?php echo $p; ?>" />
                        </div>
                    	
                        <div class="panel-footer">
                          <div class="row">
                              <div class="col-sm-6 col-sm-offset-5">
                                  <button class="btn btn-primary" type="button" id="addreward">Add New Reward</button>
                              </div>
                          </div>
                      </div>
                    </div>
                    <div class="panel-footer">
                          <div class="row">
                              <div class="col-sm-6 col-sm-offset-3">
                                  <button class="btn btn-primary" type="submit">Submit</button>&nbsp;
                                  <button class="btn btn-default" onclick="document.location.href='<?php echo $this->createUrl("webend/project"); ?>'">Cancel</button>
                              </div>
                          </div>
                      </div>
            	</div>
  			</form>
    </div>
</div>