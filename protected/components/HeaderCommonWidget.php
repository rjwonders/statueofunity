<?php
class HeaderCommonWidget extends CWidget {

    public function run() {
		$Languages =  new Languages;
		$rsLanguages = $Languages->findAll('status=1');
		
		$this->render('HeaderCommonWidget', array('Languages' => $rsLanguages));
    }
}
?>