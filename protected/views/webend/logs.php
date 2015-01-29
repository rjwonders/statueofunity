<div class="pageheader">
	<h2><i class="fa fa-file-o"></i>Logs</h2>
    <div class="breadcrumb-wrapper">
    	<span class="label">You are here:</span>
        <ol class="breadcrumb">
        	<li><a href="<?php echo $this->createUrl("webend/dashboard"); ?>">Dashboard</a></li>
            <li class="active"><a href="<?php echo $this->createUrl("webend/logs"); ?>" title="">Logs</a></li>
        </ol>
    </div>
</div>
<div class="contentpanel">
	<div class="row">
        <div class="col-md-12">
        	<div class="panel panel-default">
                      <div class="panel-heading">
                        <div class="panel-btns">
                          <a href="#" class="panel-close">&times;</a>
                          <a href="#" class="minimize">&minus;</a>
                        </div>
                        <h4 class="panel-title">View website logs</h4>
                        
                      </div>
                      <div class="panel-body">
                      
                          	<textarea class="form-control" rows="30" readonly="readonly" style="background:none; border:none; resize:none; line-height:30px;"><?php echo $rsLog; ?></textarea>
                         
                      </div><!-- panel-body -->
                      <!-- panel-footer -->
                    </div>
        </div>
    </div>
</div>