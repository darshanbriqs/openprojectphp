# openprojectphp
openprojectphp is a library to help us access <a href="http://docs.openproject.org/apiv3-doc/" target="_blank">OpenProject API</a> in PHP.

## Installation
1. Add respository in composer.json
```sh
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/darshanbriqs/openprojectphp"
    }
]
```

2. Add as dependency in require block
```sh
"require": {
    "darshanbriqs/openprojectphp": "dev-master"
}
```

## How to Use?
```sh
(URL of your openproject application)
$baseUrl = 'https://briqsdata.openproject.com';
```

```sh
(Generate apiKey from openproject application account)
$apiKey = 'apikey:3fed729f01124d971c98674e96a7921b30821c10ef4dcac2bf0b18b4d3d315d0';
```

// Example of List all projects
```sh
$opObj = new OpenprojectAPI\OpenProject(['baseUrl' => $baseUrl, 'apiKey' => $apiKey]);
$opObj->projects()->all();
```
// Example of Create task
```sh
$opObj = new OpenprojectAPI\OpenProject(['baseUrl' => $baseUrl, 'apiKey' => $apiKey]);
$data['name'] = 'Task Name';
$data['description'] = 'Task Description';
$opObj->tasks()->create($project_id, $data);
```
## Use below methods to perform various operations:
all - list all resources
one - list one resource
create - create resource
update - update resource
