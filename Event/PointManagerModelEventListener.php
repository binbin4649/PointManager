<?php

class PointManagerModelEventListener extends BcModelEventListener {
    
    public $events = array(
        //'Blog.BlogPost.afterFind',
    );
    
    
/*
    public function blogBlogPostBeforeFind(CakeEvent $event) {
	    $BlogPost = $event->subject();
	    $BlogPost->bindModel(array('hasOne' => array(
		    'RnnBlogExp' => array(
			    'className' => 'Rnn.RnnBlogExp',
			    'foreignKey' => 'blog_post_id',
		    )
	    )), false);
    }
*/
    
    
    
}