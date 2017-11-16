<?php

namespace OpenprojectAPI\Service;

class ProjectService extends AbstractService
{
    /**
     * Returns all projects
     *
     * @param int $page
     *
     * @return \stdClass
     */
    public function all( $options = array() ) {
        return $this->client->request( '/api/v3/projects', 'get', $options );   
    }
    /**
    *  Create Project  
    */
    public function create( $options = array() ) {
        return $this->client->request( '/api/v3/projects', 'post', $options );
    }
    
    public function projectInList($project_id, $list_id) {
        $lists = $this->client->request( '/api/v3/project/'.$project_id.'', 'get');
        foreach($lists as $list){
            if($list->id == trim("".$list_id)){
                return true;
            }
        }
        return false;
    }
}