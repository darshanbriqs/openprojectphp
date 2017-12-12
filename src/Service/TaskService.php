<?php

namespace OpenprojectAPI\Service;

class TaskService extends AbstractService
{
    /**
     * Returns all tasks
     */
    public function all($project_id, $data = array())
    {
        $options = array();
        $options['type_id']['operator'] = '=';
        $options['type_id']['values'] = 1;
        return $this->client->request('api/v3/projects/' . $project_id . '/work_packages', 'get', $options);
    }

    /**
     *  Returns one task
     */
    public function one($task_id, $options = array())
    {
        return $this->client->request('api/v3/work_packages/' . $task_id . '', 'get', $options);
    }

    /**
     *  Create task
     */
    public function create($project_id, $type, $data = array())
    {
        $options = array();
        $options['subject'] = $data['name'];
        $options['description'] = array('format' => 'textile', 'raw' => $data['description']);
        $options['_links'] = array(
            "type" => array("href" => "/api/v3/types/" . $type),
        );
        return $this->client->request('api/v3/projects/' . $project_id . '/work_packages', 'post', $options);
    }

    /**
     *  Update task
     */
    public function update($task_id, $data = array())
    {
        $taskInfo = $this->one($task_id);
        $options['lockVersion'] = $taskInfo->lockVersion;

        if (isset($data['name'])) {
            $options['subject'] = $data['name'];
        }

        if (isset($data['description'])) {
            $options['description'] = array('format' => 'textile', 'raw' => $data['description']);
        }

        return $this->client->request('api/v3/work_packages/' . $task_id . '', 'patch', $options);
    }

    public function addAttachment($task_id, $data = array())
    {
        return $this->client->requestMultipart('api/v3/work_packages/' . $task_id . '/attachments', $data);
    }
}
