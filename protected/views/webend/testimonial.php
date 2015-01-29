<div class="pageheader">
	<h2><i class="fa fa-home"></i> Testimonials</h2>
    <div class="breadcrumb-wrapper">
    	<span class="label">You are here:</span>
        <ol class="breadcrumb">
        	<li><a href="<?php echo $this->createUrl("webend/dashboard"); ?>">Dashboard</a></li>
            <li class="active"><a href="<?php echo $this->createUrl("webend/testimonial"); ?>" title="">Testimonials</a></li>
        </ol>
	</div>
</div>
<div class="contentpanel" style="padding-bottom:0px;">
<input type="button" value="Add New Testimonial" class="btn btn-info" style="float:right" onclick="document.location.href='<?php echo $this->createUrl("webend/testimonials"); ?>'">  
</div>
<div class="contentpanel">
	<div class="panel panel-default">
    	<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-hidaction table-hover mb30" id="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User's Name</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach($rsTestimonials as $Testi):?>
                        <tr>
                            <td><?php echo $Testi->testimonialid; ?></td>
                            <td><?php echo $Testi->username; ?></td>
                             <td><?php if($Testi->status==1): echo "Active"; else: echo "Inactive"; endif; ?></td>
                            <td class="table-action">
                            	<a href="<?php echo $this->createUrl("webend/testimonials/TestimonialID/".$Testi->testimonialslug); ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                                <a href="<?php echo $this->createUrl("webend/deleteTestimonial/TestimonialID/".$Testi->testimonialslug); ?>" title="Delete" class="delete-row"><i class="fa fa-trash-o"></i></a>
                           </td>
                            
                        </tr>
                      <?php endforeach; ?>
        			</tbody>
				</table>
			</div>
		</div>
	</div>
</div>