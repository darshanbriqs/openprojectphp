<?php

namespace OpenprojectAPI\Service;

use OpenprojectAPI\OpenProject;

abstract class AbstractService {
    
    /**
     * @var GetEloqua
     */
    protected $client;
    
    public function __construct( OpenProject $client ) {
            $this->client = $client;
    }
}