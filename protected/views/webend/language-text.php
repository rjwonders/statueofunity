<div class="pageheader">
	<h2><i class="fa fa-file-o"></i>Change Language Text (<?php echo $rsData->language; ?>)</h2>
    <div class="breadcrumb-wrapper">
    	<span class="label">You are here:</span>
        <ol class="breadcrumb">
        	<li><a href="<?php echo $this->createUrl("webend/dashboard"); ?>">Dashboard</a></li>
            <li><a href="<?php echo $this->createUrl("webend/language"); ?>" title="">Languages</a></li>
            <li class="active"><a href="<?php echo $this->createUrl("webend/languageText/LanguageID/".$rsData->languageid); ?>" title="">Change Language Text (<?php echo $rsData->language; ?>)</a></li>
        </ol>
    </div>
</div>

<div class="contentpanel">
	<div class="row">
        <div class="col-md-12">
                  
                  <form id="form2" class="form-horizontal form-bordered" action="<?php echo $this->createUrl("webend/editLanguageText"); ?>" method="post">
                  <input type="hidden" name="LanguageID" value="<?php echo $rsData->languageid; ?>" />
                  
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <div class="panel-btns">
                          <a href="#" class="panel-close">&times;</a>
                          <a href="#" class="minimize">&minus;</a>
                        </div>
                        <h4 class="panel-title">Edit Language Text</h4>
                        
                      </div>
                      <div class="panel-body panel-body-nopadding">
                      	<?php foreach($rsLine as $Lines): ?>
                        <div class="form-group">
                          <label class="col-sm-4 control-label"><?php echo $Lines; ?>:</label>
                          <div class="col-sm-8">
                            <input type="text" name="Language[<?php echo $Lines; ?>]" value="<?php if(isset($rsMyLiner[$Lines])): echo $rsMyLiner[$Lines]; endif; ?>" class="form-control" />
                          </div>
                        </div>
                        <?php endforeach; ?>
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