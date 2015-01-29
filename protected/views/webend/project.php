<div class="pageheader">
	<h2><i class="fa fa-tags"></i> Projects</h2>
    <div class="breadcrumb-wrapper">
    	<span class="label">You are here:</span>
        <ol class="breadcrumb">
        	<li><a href="<?php echo $this->createUrl("webend/dashboard"); ?>">Dashboard</a></li>
            <li class="active"><a href="<?php echo $this->createUrl("webend/project"); ?>" title="">Projects</a></li>
        </ol>
	</div>
</div>
<?php if(Yii::app()->session['UserTypeID']==1): ?>
<div class="contentpanel" style="padding-bottom:0px;">
<input type="button" value="Add New Project" class="btn btn-info" style="float:right" onclick="document.location.href='<?php echo $this->createUrl("webend/projects"); ?>'">  
</div>
<?php endif; ?>
<input type="hidden" id="AJAXURL" value="<?php echo $this->createUrl("webend/defaultBannerProject"); ?>" />
<input type="hidden" id="HighlightURL" value="<?php echo $this->createUrl("webend/defaultFocusProject"); ?>" />
<div class="contentpanel">
	<div class="panel panel-default">
    	<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-hidaction table-hover mb30" id="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Project Name</th>
                            <th>Goal</th>
                            <th>Project End Date</th>
                            <th>Is Banner Project</th>
                            <th>Highlight Project</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($data as $Publisher):?>
                        <tr>
                            <td><?php echo $Publisher->projectid; ?></td>
                            <td><?php echo $Publisher->projectname; ?></td>
                            <td>&#8377; <?php echo number_format($Publisher->goalamount,2); ?></td>
                            <td><?php if($Publisher->projectenddate!="0000-00-00 00:00:00"): echo date("d M,Y",strtotime($Publisher->projectenddate)); endif; ?></td>
                            <td>
                            	<input type="radio" name="IsDefault" class="IsBanner" value="<?php echo $Publisher->projectslug; ?>" <?php if($Publisher->isbannerproject==1): ?>checked="checked" <?php endif; ?> />
                            </td>
                            <td>
                            	<input type="radio" name="IsHighlight" class="IsHighlight" value="<?php echo $Publisher->projectslug; ?>" <?php if($Publisher->isfocusproject==1): ?>checked="checked" <?php endif; ?> />
                            </td>
                            <td><?php if($Publisher->status==1): echo "Active"; else: echo "Inactive"; endif; ?></td>
                            <td class="table-action">
                              	<a href="<?php echo $this->createUrl("webend/projects/ProjectID/".$Publisher->projectslug); ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                                <a href="<?php echo $this->createUrl("webend/projectImages/ProjectID/".$Publisher->projectslug); ?>" title="Images"><i class="fa fa-camera"></i></a>
                                <a href="<?php echo $this->createUrl("webend/projectVideos/ProjectID/".$Publisher->projectslug); ?>" title="Videos"><i class="fa fa-video-camera"></i></a>
                                <a href="<?php echo $this->createUrl("webend/projectUpdates/ProjectID/".$Publisher->projectslug); ?>" title="Updates"><i class="fa fa-comments"></i></a>
                                <a href="<?php echo $this->createUrl("webend/projectFAQs/ProjectID/".$Publisher->projectslug); ?>" title="FAQ"><i class="fa fa-info"></i></a>
                                <a href="<?php echo $this->createUrl("webend/deleteProject/ProjectID/".$Publisher->projectslug); ?>" onclick="if(!confirm('Delete It?')){return false;}" class="delete-row" title="Delete"><i class="fa fa-trash-o"></i></a>
                           </td>
                            
                        </tr>
                      <?php endforeach; ?>
        			</tbody>
				</table>
			</div>
		</div>
	</div>
</div>