<?php

/**
 *  Corresponding Class to test OpenProject class
 *
 *  @author darshan
 */
class OpenProjectTest extends PHPUnit_Framework_TestCase
{

    /**
     *  openoproject object
     */
    public function testIsThereAnySyntaxError()
    {
        $var = new OpenprojectAPI\OpenProject(array('apiKey' => 'apikey:a6e9bd6020f65c89af2191861daeff2bbf5a1d6e'));
        $this->assertTrue(is_object($var));
        unset($var);
    }

    /**
     * list projects
     *
     */
    public function testListProjectApiCall()
    {
        $var = new OpenprojectAPI\OpenProject(
            array(
                'apiKey' => 'apikey:a6e9bd6020f65c89af2191861daeff2bbf5a1d6e',
                //'apiKey'=>'apikey:3fed729f01124d971c98674e96a7921b30821c10ef4dcac2bf0b18b4d3d315d0',
                'baseUrl' => 'https://briqsdata.openproject.com',
                //'baseUrl'=>'http://127.0.0.1:5000'
            ));

        $this->assertTrue(is_object($var->projects()->all()));
        unset($var);
    }

    /**
     * create project
     *
     */
//  public function testCreateProjectApiCall(){
    //    $var = new OpenprojectAPI\OpenProject(
    //                array(
    //                    'apiKey'=>'apikey:a6e9bd6020f65c89af2191861daeff2bbf5a1d6e',
    //                    'baseUrl'=>'https://briqsdata.openproject.com'
    //                ));
    //        $params['project']['name'] = 'testproject';
    //        $params['project']['identifier'] = 'testproject';
    //        $params['project']['is_public'] = 0;
    //        print_r($var->projects()->create($params));exit;
    //        $this->assertTrue($var->projects()->create($params)->count == 1);
    //    unset($var);
    //  }

    /**
     * create task
     *
     */
    public function testCreateTaskApiCall()
    {
        $var = new OpenprojectAPI\OpenProject(
            array(
                'apiKey' => 'apikey:a6e9bd6020f65c89af2191861daeff2bbf5a1d6e',
                //'apiKey'=>'apikey:3fed729f01124d971c98674e96a7921b30821c10ef4dcac2bf0b18b4d3d315d0',
                'baseUrl' => 'https://briqsdata.openproject.com',
                //'baseUrl'=>'http://127.0.0.1:5000'
            ));
        $project_id = 2;
        $data['name'] = 'New Task';
        $data['description'] = 'A *simple* paragraph with\n test';

        $this->assertTrue(is_object($var->tasks()->create($project_id, $data)));
        unset($var);
    }

    /**
     * update task
     *
     */
    public function testUpdateTaskApiCall()
    {
        $var = new OpenprojectAPI\OpenProject(
            array(
                'apiKey' => 'apikey:a6e9bd6020f65c89af2191861daeff2bbf5a1d6e',
                //'apiKey'=>'apikey:3fed729f01124d971c98674e96a7921b30821c10ef4dcac2bf0b18b4d3d315d0',
                'baseUrl' => 'https://briqsdata.openproject.com',
                //'baseUrl'=>'http://127.0.0.1:5000'
            ));
        $task_id = 2;
        $data['description'] = 'Update Task Description A *simple* paragraph with
                                    test';
        $this->assertTrue(is_object($var->tasks()->update($task_id, $data)));
        unset($var);
    }

    /**
     * list tasks
     *
     */
    public function testListTaskApiCall()
    {
        $var = new OpenprojectAPI\OpenProject(
            array(
                'apiKey' => 'apikey:a6e9bd6020f65c89af2191861daeff2bbf5a1d6e',
                //'apiKey'=>'apikey:3fed729f01124d971c98674e96a7921b30821c10ef4dcac2bf0b18b4d3d315d0',
                'baseUrl' => 'https://briqsdata.openproject.com',
                //'baseUrl'=>'http://127.0.0.1:5000'
            ));
        $project_id = 2;
        $this->assertTrue(is_object($var->tasks()->all($project_id)));
        unset($var);
    }

    /**
     * Add attachment
     *
     */
    public function testAddAttachment()
    {
        $var = new OpenprojectAPI\OpenProject(
            array(
                'apiKey' => 'apikey:fcaf248a8b882fd7c9926d20847b475fbae87cf7',
                //'apiKey'=>'apikey:3fed729f01124d971c98674e96a7921b30821c10ef4dcac2bf0b18b4d3d315d0',
                'baseUrl' => 'https://project.wsuite.com/52137/',
                //'baseUrl'=>'http://127.0.0.1:5000'
            ));
        $task_id = 21;
        $json_data = json_encode(["fileName" => "cute-cat.png", "description" => ["raw" => "this is test"]]);
        $data = [
            "multipart" => [
                [
                    'name' => 'metadata',
                    'contents' => $json_data,
                    'headers' => ['Content-Type' => 'application/json'],
                ],
                [
                    "name" => "file",
                    'headers' => ['Content-Type' => 'image/png'],
                    "contents" => file_get_contents("https://s3.amazonaws.com/static.wtrack.wsuite.com/staging/public/5a2/fa1/567/5a2fa1567b7a0316622667.png"),
                    "filename" => "attachment",
                ],
            ],
        ];
        try {
            $response = $var->tasks()->addAttachment($task_id, $data);
            print_r($response);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        // $this->assertTrue(is_object($var->tasks()->addAttachment($task_id, $data)));
        // unset($var);
    }

}
