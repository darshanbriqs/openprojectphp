<?php

namespace OpenprojectAPI\Service;

class TypeService extends AbstractService
{
    /**
     * Returns all types
     */
    public function all( $options = array() ) {
        return $this->client->request( 'api/v3/types', 'get', $options );   
    }
    
    /**
    *  Returns all types by project  
    */
    public function allbyproject( $project_id, $options = array() ) {
        return $this->client->request( 'api/v3/projects/'.$project_id.'/types', 'get', $options );   
    }
    
    /**
    *  Returns one type  
    */
    public function one( $type_id, $options = array() ) {
        return $this->client->request( 'api/v3/types/'.$type_id, 'get', $options );   
    }
}