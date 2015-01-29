<div class="pageheader">
	<h2><i class="fa fa-tags"></i> Campaigners</h2>
    <div class="breadcrumb-wrapper">
    	<span class="label">You are here:</span>
        <ol class="breadcrumb">
        	<li><a href="<?php echo $this->createUrl("webend/dashboard"); ?>">Dashboard</a></li>
            <li class="active"><a href="<?php echo $this->createUrl("webend/creator"); ?>" title="">Campaigners</a></li>
        </ol>
	</div>
</div>
<div class="contentpanel" style="padding-bottom:0px;">
<input type="button" value="Add New Campaigner" class="btn btn-info" style="float:right" onclick="document.location.href='<?php echo $this->createUrl("webend/creators"); ?>'">  
</div>
<div class="contentpanel">
	<div class="panel panel-default">
    	<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-hidaction table-hover mb30" id="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Registration Date</th>
                            <th>Last Login Date</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($data as $Publisher):?>
                        <tr>
                            <td><?php echo $Publisher->publisherid; ?></td>
                            <td><?php echo $Publisher->firstname." ".$Publisher->lastname; ?></td>
                            <td><?php echo $Publisher->email; ?></td>
                            <td><?php echo date("d M,Y h:i A",strtotime($Publisher->registartiondate)); ?></td>
                            <td><?php if($Publisher->lastlogindate!="0000-00-00 00:00:00"): echo date("d M, Y h:i A",strtotime($Publisher->lastlogindate)); endif; ?></td>
                            <td><?php 
								if(trim($Publisher->profilepicture)!='' && file_exists(YiiBase::getPathOfAlias('webroot')."/assets/users/creator/".$Publisher->profilepicture)):
									Yii::import('ext.iwi.Iwi');
									$picture = new Iwi(YiiBase::getPathOfAlias('webroot')."/assets/users/creator/".$Publisher->profilepicture);
									$picture->resize(40,0, Iwi::NONE);
								?>
									<img src="<?php echo $picture->cache(); ?>" alt="" />
								<?php else: ?>
								  <img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/photos/loggeduser.png" class="media-object" height="40">
								<?php endif; ?>
                			</td>
                            <td><?php if($Publisher->status==1): echo "Active"; else: echo "Inactive"; endif; ?></td>
                            <td class="table-action">
                              	<a href="<?php echo $this->createUrl("webend/creators/PublisherID/".$Publisher->publisherid); ?>"><i class="fa fa-pencil"></i></a>
                                <a href="<?php echo $this->createUrl("webend/deleteCreator/PublisherID/".$Publisher->publisherid); ?>" onclick="if(!confirm('Delete It?')){return false;}" class="delete-row"><i class="fa fa-trash-o"></i></a>
                           </td>
                            
                        </tr>
                      <?php endforeach; ?>
        			</tbody>
				</table>
			</div>
		</div>
	</div>
</div>