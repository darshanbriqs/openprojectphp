<?php

namespace OpenprojectAPI\Service;

class CategoryService extends AbstractService
{
    /**
    *  Returns all categories by project  
    */
    public function allbyproject( $project_id, $options = array() ) {
        return $this->client->request( 'api/v3/projects/'.$project_id.'/categories', 'get', $options );   
    }
    
    /**
    *  Returns one category  
    */
    public function one( $category_id, $options = array() ) {
        return $this->client->request( 'api/v3/categories/'.$category_id, 'get', $options );   
    }
}