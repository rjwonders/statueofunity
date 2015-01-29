<div class="pageheader">
	<h2><i class="fa fa-file-o"></i>Settings</h2>
    <div class="breadcrumb-wrapper">
    	<span class="label">You are here:</span>
        <ol class="breadcrumb">
        	<li><a href="<?php echo $this->createUrl("webend/dashboard"); ?>">Dashboard</a></li>
            <li  class="active"><a href="<?php echo $this->createUrl("webend/settings"); ?>" title="">Settings</a></li>
        </ol>
    </div>
</div>

<div class="contentpanel">
	<div class="row">
        <div class="col-md-12">
                  
                  <form id="form2" class="form-horizontal form-bordered" action="<?php echo $this->createUrl("webend/saveSettings"); ?>" method="post">
                  
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <div class="panel-btns">
                          <a href="#" class="panel-close">&times;</a>
                          <a href="#" class="minimize">&minus;</a>
                        </div>
                        <h4 class="panel-title">Edit General Settings</h4>
                        
                      </div>
                      <div class="panel-body panel-body-nopadding">
                      	<div id="basicWizard" class="basic-wizard">
                        	<ul class="nav nav-pills nav-justified">
                            	<?php foreach($rsLanguages as $Languages): ?>
                          			<li><a href="#tab<?php echo $Languages->languageid; ?>" data-toggle="tab"><span><?php echo $Languages->language; ?></span><?php if($Languages->isdefault==1): ?> (Default)<?php endif; ?></a></li>
                                <?php endforeach; ?>
                          	</ul>
                        	<div class="tab-content">
                            	<?php foreach($rsLanguages as $Languages): ?>
                                    <div class="tab-pane" id="tab<?php echo $Languages->languageid; ?>">
                                        <?php foreach($rsData as $Data): 
											$FieldName = "lang".$Languages->languageid;?>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label"><?php echo $Data->settingname; ?>:</label>
                                                <div class="col-sm-8">
                                                    <textarea name="Settings[<?php echo $Languages->languageid; ?>][<?php echo $Data->settingid; ?>]" class="form-control" rows="6"><?php if(trim($Data->$FieldName)!=""): echo $Data->$FieldName; endif; ?></textarea>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endforeach; ?>
                        	</div>
                        </div>
                      </div><!-- panel-body -->
                      <div class="panel-footer">
                        <button class="btn btn-primary">Update</button>
                        <button type="reset" class="btn btn-default">Reset</button>
                      </div><!-- panel-footer -->
                    </div><!-- panel-default -->
                  </form>
                    
                </div>
    </div>
	
</div>