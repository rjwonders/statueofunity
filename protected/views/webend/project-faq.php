<div class="pageheader">
	<h2><i class="fa fa-file-o"></i>Project FAQs (<?php echo $rsData->projectname; ?>)</h2>
    <div class="breadcrumb-wrapper">
    	<span class="label">You are here:</span>
        <ol class="breadcrumb">
        	<li><a href="<?php echo $this->createUrl("webend/dashboard"); ?>">Dashboard</a></li>
            <li><a href="<?php echo $this->createUrl("webend/project"); ?>" title="">Projects</a></li>
            <li class="active"><a href="<?php echo $this->createUrl("webend/projectUpdates/ProjectID/".$rsData->projectid); ?>" title="">Project FAQs (<?php echo $rsData->projectname; ?>)</a></li>
        </ol>
    </div>
</div>

<div class="contentpanel">
	<div class="row">
        <div class="col-md-12">
                  
                  <form id="form2" class="form-horizontal form-bordered" action="<?php echo $this->createUrl("webend/projectAddFAQ"); ?>" method="post">
                  <input type="hidden" name="ProjectID" value="<?php echo $rsData->projectslug; ?>" />
                  <?php if($rsMyFAQ): ?>
                  	<input type="hidden" name="ProjectFAQID" value="<?php echo $rsMyFAQ->projectfaqid; ?>" />
                  <?php endif; ?>
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <div class="panel-btns">
                          <a href="#" class="panel-close">&times;</a>
                          <a href="#" class="minimize">&minus;</a>
                        </div>
                        <h4 class="panel-title"><?php if($rsMyFAQ): ?>Edit Project FAQ<?php else: ?>Add New Project FAQ<?php endif; ?></h4>
                        
                      </div>
                      <div class="panel-body panel-body-nopadding">
                      	<div class="form-group">
                          <div class="col-sm-12">
                          	<label>Question</label>
                            <input type="text" class="form-control" name="FAQ" value="<?php if($rsMyFAQ): ?><?php echo $rsMyFAQ->faq; ?><?php endif; ?>" />
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-sm-12">
                          	<label>Answer</label>
                            <textarea name="Answer" class="form-control" id="wysiwyg" rows="10"><?php if($rsMyFAQ): ?><?php echo $rsMyFAQ->answer; ?><?php endif; ?></textarea>
                          </div>
                        </div>
                      </div><!-- panel-body -->
                      <div class="panel-footer">
                        <button class="btn btn-primary"><?php if($rsMyFAQ): ?>Update FAQ<?php else: ?>Post FAQ<?php endif; ?></button>
                        <button type="reset" class="btn btn-default">Reset</button>
                      </div><!-- panel-footer -->
                    </div><!-- panel-default -->
                  </form>
                    
                </div>
    </div>
	<div class="panel panel-default">
    	<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-hidaction table-hover mb30" id="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Question</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($rsUpdate as $Update):?>
                        <tr>
                            <td><?php echo $Update->projectfaqid; ?></td>
                            <td><?php echo $Update->faq; ?></td>
                            <td class="table-action">
                            	<a href="<?php echo $this->createUrl("webend/projectFAQs/ProjectID/".$Update->projectslug."/ProjectFAQID/".$Update->projectfaqid); ?>"><i class="fa fa-pencil"></i></a>
                              	<a href="<?php echo $this->createUrl("webend/deleteProjectFAQ/ProjectFAQID/".$Update->projectfaqid); ?>" onclick="if(!confirm('Delete It?')){return false;}" class="delete-row"><i class="fa fa-trash-o"></i></a>
                           </td>
                            
                        </tr>
                      <?php endforeach; ?>
        			</tbody>
				</table>
			</div>
		</div>
	</div>
</div>