<div class="pageheader">
	<h2><i class="fa fa-home"></i> CMS</h2>
    <div class="breadcrumb-wrapper">
    	<span class="label">You are here:</span>
        <ol class="breadcrumb">
        	<li><a href="<?php echo $this->createUrl("webend/dashboard"); ?>">Dashboard</a></li>
            <li class="active"><a href="<?php echo $this->createUrl("webend/cms"); ?>" title="">CMS</a></li>
        </ol>
	</div>
</div>
<div class="contentpanel">
	<div class="panel panel-default">
    	<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-hidaction table-hover mb30" id="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Page Name</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php for($i=0;$i<count($rsCMS);$i++):?>
                        <tr>
                            <td><?php echo $rsCMS[$i]['cmsid']; ?></td>
                            <td><?php echo $rsCMS[$i]['pagename']; ?></td>
                             <td><?php if($rsCMS[$i]['status']==1): echo "Active"; else: echo "Inactive"; endif; ?></td>
                            <td class="table-action">
                            	<a href="<?php echo $this->createUrl("webend/cmss/CmsID/".$rsCMS[$i]['pageslug']); ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                                
                           </td>
                            
                        </tr>
                      <?php endfor; ?>
        			</tbody>
				</table>
			</div>
		</div>
	</div>
</div>