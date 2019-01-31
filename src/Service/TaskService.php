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
        
        if(isset($data['author'])){
            $options['_links']['author'] = array("href" => "/api/v3/users/" . $data['author']);
        }
        if(isset($data['responsible'])){
            $options['_links']['responsible'] = array("href" => "/api/v3/users/" . $data['responsible']);
        }
        if(isset($data['assignee'])){
            $options['_links']['assignee'] = array("href" => "/api/v3/users/" . $data['assignee']);
        }
        if(isset($data['estimatedTime'])){
            $options['estimatedTime'] = $data['estimatedTime'];
        }
        if(isset($data['dueDate'])){
            $options['dueDate'] = $data['dueDate'];
        }
        if(isset($data['startDate'])){
            $options['startDate'] = $data['startDate'];
        }
        if(isset($data['priority'])){
            $options['_links']['priority'] = array("href" => "/api/v3/priorities/" . $data['priority']);
        }
        if(isset($data['status'])){
            $options['_links']['status'] = array("href" => "/api/v3/statuses/" . $data['status']);
        }
        if(isset($data['parent'])){
            $options['_links']['parent'] = array("href" => "/api/v3/work_packages/" . $data['parent']);
        }

        if(isset($data['category'])){
            $options['_links']['category'] = array("href" => "/api/v3/categories/" . $data['category']);
        }

        if(isset($data['type'])){
            $options['_links']['customField2'] = array("href" => "/api/v3/custom_options/" . $data['type']);
        }

        $options['_links']['type'] = array("href" => "/api/v3/types/" . $type);

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

        if(isset($data['author'])){
            $options['_links']['author'] = array("href" => "/api/v3/users/" . $data['author']);
        }

        if(isset($data['responsible'])){
            $options['_links']['responsible'] = array("href" => "/api/v3/users/" . $data['responsible']);
        }

        if(isset($data['assignee'])){
            $options['_links']['assignee'] = array("href" => "/api/v3/users/" . $data['assignee']);
        }

        if(isset($data['estimatedTime'])){
            $options['estimatedTime'] = $data['estimatedTime'];
        }

        if(isset($data['dueDate'])){
            $options['dueDate'] = $data['dueDate'];
        }

        if(isset($data['startDate'])){
            $options['startDate'] = $data['startDate'];
        }

        if(isset($data['priority'])){
            $options['_links']['priority'] = array("href" => "/api/v3/priorities/" . $data['priority']);
        }

        if(isset($data['status'])){
            $options['_links']['status'] = array("href" => "/api/v3/statuses/" . $data['status']);
        }

        if(isset($data['parent'])){
            $options['_links']['parent'] = array("href" => "/api/v3/work_packages/" . $data['parent']);
        }

        if(isset($data['category'])){
            $options['_links']['category'] = array("href" => "/api/v3/categories/" . $data['category']);
        }

        if(isset($data['type'])){
            $options['_links']['customField2'] = array("href" => "/api/v3/custom_options/" . $data['type']);
        }

        return $this->client->request('api/v3/work_packages/' . $task_id . '', 'patch', $options);
    }

    public function addAttachment($task_id, $data = array())
    {
        return $this->client->requestMultipart('api/v3/work_packages/' . $task_id . '/attachments', $data);
    }

    public function addComment($task_id, $data = array())
    {
        $options = array();
        $options['comment'] = $data['comment'];
        
        if(isset($data['user'])){
            $options['_links']['user'] = array("href" => "/api/v3/users/" . $data['user']);
        }

        return $this->client->request('api/v3/work_packages/' . $task_id . '/activities?notify=true', 'post', $options);
    }

    public function getStatus($name = null)
    {
        if ($name) {
            $status = $this->client->request('api/v3/statuses', 'get');
            if (isset($status->_embedded->elements)) {
                foreach ($status->_embedded->elements as $elemnt) {
                    if($elemnt->name == $name){
                        return $elemnt;
                    }
                }
                return false;
            }
            return false;
        } else {
            return $this->client->request('api/v3/statuses', 'get');
        }

    }

    /**
     *  Returns all comments of task
     */
    public function getComments($wp_id, $options = array())
    {
        return $this->client->request('api/v3/work_packages/' . $wp_id . '/activities', 'get', $options);
    }

    /**
    *  Delete Attachment  
    */
    public function deleteAttachment($attachment_id, $options = array()) {
        return $this->client->request('api/v3/attachments/'.$attachment_id.'', 'delete', $options);
    }
}
