<?php

class TagCloud extends CPortlet {
    
    public $title = 'Tag Cloud';
    
    protected function renderContent() {
        $tags = Tag::model()->findAll();
        
        $this->render('tagCloud', array('tags'=>$tags));
    }
}