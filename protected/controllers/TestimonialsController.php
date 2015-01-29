<?php

class TestimonialsController extends Controller
{
	public function filters(){
		return array(
			array(
				'COutputCache',
				'duration'=>100,
				'varyByParam'=>array('id'),
			),
		);
	}
	public function actionIndex(){
		$Testimonials =  new Testimonials;
		$rsTestimonial = $Testimonials->getData();
		$this->render('testimonial', array("rsTestimonial" => $rsTestimonial));	
	}
	
}
