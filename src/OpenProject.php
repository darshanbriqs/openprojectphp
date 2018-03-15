<?php

namespace OpenprojectAPI;

/**
 *  OpenProject API
 *
 *  @author darshan
 */
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class OpenProject
{

    protected $baseUrl;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * @var array
     */
    protected $apis = array();

    public function __construct($config = array())
    {
        if (isset($config['apiKey'])) {
            $this->apiKey = $config['apiKey'];
        }

        if (isset($config['baseUrl'])) {
            $this->baseUrl = $config['baseUrl'];
        }
    }

    /**
     * @return string
     */
    public function get_apiKey()
    {
        return $this->apiKey;
    }

    /**
     * @return string
     */
    public function get_baseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function get_httpClient()
    {
        if (!$this->httpClient) {
            $this->httpClient = new Client(array(
                'base_uri' => $this->get_baseUrl(),
                'headers' => array(
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode($this->get_apiKey()),
                ),
            ));
        }
        return $this->httpClient;
    }

    public function get_api($class)
    {
        $fq_class = '\\OpenprojectAPI\\Service\\' . $class;
        if (!class_exists($fq_class)) {
            throw new ServiceNotFoundException('Service: ' . $class . ' could not be found');
        }
        if (!array_key_exists($fq_class, $this->apis)) {
            $this->apis[$fq_class] = new $fq_class($this);
        }
        return $this->apis[$fq_class];
    }

    public function request($path = '', $method = 'get', $data = array())
    {
        $options = array();
        switch ($method) {
            case 'get':
                if (!empty($data)) {
                    $query = array();
                    foreach ($data as $key => $value) {
                        $query[$key] = $value;
                    }
                    $options['filters'] = $query;
                }
                break;
            case 'post':
            case 'put':
            case 'patch':
                if (!empty($data)) {
                    $json = array();
                    foreach ($data as $key => $value) {
                        $json[$key] = $value;
                    }
                    $options['json'] = $json;
                }
                break;
        }
        try {
            /** @var \GuzzleHttp\Psr7\Response $response * */
            $response = $this->get_httpClient()->{$method}($path, $options);
            return json_decode($response->getBody());
        } catch (RequestException $e) {
            if ($e->hasResponse() && $e->getResponse()->getStatusCode() === 422) {
                $body = $e->getResponse()->getBody()->getContents();
                $handler = new ValidationExceptionHandler($body);
                $handler->handle();
            } else if ($e->hasResponse() && $e->getResponse()->getStatusCode() === 401) {

            } else if ($e->hasResponse() && $e->getResponse()->getStatusCode() === 409) {
                return 'uniqueValidationError';
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return false;
    }

    public function requestMultipart($path = "", $data = array())
    {
        $httpClient = new Client(array(
            'base_uri' => $this->get_baseUrl(),
            'headers' => array(
                'Authorization' => 'Basic ' . base64_encode($this->get_apiKey()),
            ),
        ));
        try {
            $response = $httpClient->request("POST", $path, $data);
            return json_decode($response->getBody());
        } catch (\Exception $e) {
            $error['error'] = true;
            $error['message'] = $e->getMessage();
            return json_decode(json_encode($error));
        }

    }

    /**
     * @return ProjectService
     */
    public function projects()
    {
        return $this->get_api('ProjectService');
    }

    /**
     * @return TaskService
     */
    public function tasks()
    {
        return $this->get_api('TaskService');
    }
    
    /**
    * @return UserService
    */
    public function users() {
        return $this->get_api('UserService');
    }
}