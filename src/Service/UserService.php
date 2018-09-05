<?php

namespace OpenprojectAPI\Service;

class UserService extends AbstractService
{
    /**
     * Returns all user
     */
    public function all( $options = array() ) {
        return $this->client->request( 'api/v3/users', 'get', $options );   
    }
    
    /**
    *  Returns one user  
    */
    public function one( $user_id, $options = array() ) {
        return $this->client->request( 'api/v3/users/'.$user_id.'', 'get', $options );   
    }
    
    /**
    *  Create User  
    */
    public function create( $options = array() ) {
        return $this->client->request( 'api/v3/users', 'post', $options );
    }
    
    /**
    *  Delete User  
    */
    public function delete( $user_id, $options = array() ) {
        return $this->client->request( 'api/v3/users/'.$user_id.'', 'delete', $options );
    }

    /**
     *  Update User
     */
    public function update($user_id, $options = array())
    {
        return $this->client->request('api/v3/users/' . $user_id, 'patch', $options);
    }
   
}