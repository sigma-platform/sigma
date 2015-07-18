FORMAT: 1A

# Sigma
Project Management Platform

# Group Authentication
Authentication related resources of the **Sigma API**

## Sign In [/api/auth/login]

`/api/auth/login`

### Login [POST]

You may connect a user using this action.

#### Required Parameters

| Name     | Type   |
|----------|--------|
| email    | String |
| password | String |

+ Request (application/json)

        { "email": "john@doe.com", "password": "john" }

+ Response 200 (application/json)

        { "success" : true, "payload" : { "user_id": 1, "token": "efc45ab4-c310-40be-bd11-8638308ab804" }, "message" : "Authentication successfull." }

+ Response 400 (application/json)

        { "success" : false, "payload" : {}, "error" : "The credentials do not match any user." }

## Sign Out [/api/auth/logout?token={token}]

`/api/auth/logout?token={token}`

### Logout [GET]

You may disconnect a user using this action.

+ Parameters
    
    + token (string) ... Token of the logged user

+ Response 200 (application/json)

        { "success" : true, "payload" : {}, "message" : "You are now logged out." }
        
+ Response 401 (application/json)

        { "success" : false, "payload" : {}, "error" : "Please authenticate yourself." }

# Group Projects
Projects related resources of the **Sigma API**

## Projects Collection For User [/api/project/user/{role}?token={token}]

`/api/project/user/{role?}?token={token}`

+ Parameters
    
    + role (string) ... Role filter (optional)
    + token (string) ... Token of the logged user

### UserProjectList [GET]

+ Response 200 (application/json)

        {
            "success": true,
            "payload": [
                {
                    "id": 1,
                    "name": "Sigma",
                    "description": "sigma",
                    "slug": "sigma",
                    "status": 1,
                    "project_group_id": 1,
                    "created_at": "2015-04-04 17:03:13",
                    "updated_at": "2015-04-04 17:03:13",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 1,
                        "project_id": 1
                    }
                },
                {
                    "id": 3,
                    "name": "Sigma Client",
                    "description": "sigma client",
                    "slug": "sigma-client",
                    "status": 1,
                    "project_group_id": 2,
                    "created_at": "2015-04-04 17:04:00",
                    "updated_at": "2015-04-04 17:04:00",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 1,
                        "project_id": 3
                    }
                }
            ]
        }
        
## Projects Collection [/api/project?token={token}]

`/api/project?token={token}`
        
### Store [POST]

+ Response 200 (application/json)

        {
          "success": true,
          "message": "Project succesfuly created.",
          "payload": {
            "name": "Sigma 27",
            "description": "27",
            "project_group_id": "2",
            "slug": "zouley",
            "status": 0,
            "updated_at": "2015-07-18 14:24:02",
            "created_at": "2015-07-18 14:24:02",
            "id": 4
          }
        }

## Project [/api/project/{id}?token={token}]

`/api/project/{id}?token={token}`

+ Parameters
    
    + id (string) ... id of the project
    + token (string) ... Token of the logged user

### Show [GET]

+ Response 200 (application/json)

        {
            "success": true,
            "payload": {
                    "id": 1,
                    "name": "Sigma",
                    "description": "sigma",
                    "slug": "sigma",
                    "status": 1,
                    "project_group_id": 1,
                    "created_at": "2015-04-04 17:03:13",
                    "updated_at": "2015-04-04 17:03:13",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 1,
                        "project_id": 1
                    }
            }
        }
        
### Update [PUT]

+ Response 200 (application/json)

        {
          "success": true,
          "message": "Project successfully modified.",
          "payload": {
            "id": 3,
            "name": "Sigma zouley",
            "description": "sigma client",
            "slug": "sigma-client",
            "status": 1,
            "project_group_id": 2,
            "created_at": "2015-04-04 17:04:00",
            "updated_at": "2015-07-18 14:19:00",
            "deleted_at": null
          }
        }
        
### Destroy [DELETE]

+ Response 200 (application/json)

        {
          "success": true,
          "message": "Project successfully deleted.",
          "payload": []
        }
        
# Group Versions
Versions related resources of the **Sigma API**

## Versions Collection [/api/version?token={token}]

`/api/version?token={token}`

+ Parameters
    
    + token (string) ... Token of the logged user
    
### Store [POST]

| Name          | Type                                                             |
|---------------|------------------------------------------------------------------|
| label         | String                                                           |
| date_start    | Date (yyyy-mm-dd)                                                |
| date_end      | Date (yyyy-mm-dd)                                                |
| project_id    | Integer                                                          |

+ Response 200 (application/json)

        {
          "success": true,
          "message": "Version successfully added.",
          "payload": {
            "label": "0.5",
            "project_id": "1",
            "date_start": "2015-05-01",
            "date_end": "2015-07-01",
            "updated_at": "2015-07-16 21:23:42",
            "created_at": "2015-07-16 21:23:42",
            "id": 3
          }
        }

## Version [/api/version/{id}?token={token}]

`/api/version/{id}?token={token}`

+ Parameters
    
    + id (string) ... id of the version
    + token (string) ... Token of the logged user
    
### Show [GET]

+ Response 200 (application/json)

        {
          "success": true,
          "payload": {
            "id": 3,
            "label": "0.5",
            "description": null,
            "date_start": "2015-05-01",
            "date_end": "2015-07-01",
            "project_id": 1,
            "created_at": "2015-07-16 21:23:42",
            "updated_at": "2015-07-16 21:23:42"
          }
        }
        
+ Response 404 (application/json)

        { "success": false, "payload": [], "error": "The selected version doesn't exist." }

### Update [PUT]

+ Response 200 (application/json)

        {
          "success": true,
          "message": "Version successfully updated.",
          "payload": {
            "id": 3,
            "label": "0.5",
            "description": null,
            "date_start": "2015-05-06",
            "date_end": "2015-07-01",
            "project_id": 1,
            "created_at": "2015-07-16 21:23:42",
            "updated_at": "2015-07-16 21:26:44"
          }
        }
        
+ Response 404 (application/json)

        { "success": false, "payload": [], "error": "The selected version doesn't exist." }

### Destroy [DELETE]

+ Response 200 (application/json)

        {
          "success": true,
          "message": "The version has been successfully deleted.",
          "payload": []
        }
        
+ Response 404 (application/json)

        { "success": false, "payload": [], "error": "The selected version doesn't exist." }

# Group Users
Users related resources of the **Sigma API**

## Users Collection For Project [/api/project/{id}/user?token={token}]

`/api/project/{id}/user?token={token}`

+ Parameters
    
    + id (string) ... id of the project
    + token (string) ... Token of the logged user
    
### ProjectUserList [GET]

+ Response 200 (application/json)

        {
          "success": true,
          "payload": [
            {
              "id": 1,
              "firstname": "Super",
              "lastname": "Admin",
              "email": "admin@sigma.com",
              "status": 0,
              "avatar": null,
              "role_id": 1,
              "created_at": "2015-04-04 16:53:43",
              "updated_at": "2015-07-16 11:49:18",
              "deleted_at": null,
              "pivot": {
                "project_id": 1,
                "user_id": 1,
                "role_id": 3
              }
            }
          ]
        }
        
+ Response 403 (application/json)

        { "success": false, "payload": [], "error": "You do not have access to this project." }
        
### ProjectUserAccess [PUT]

#### Required Parameters

| Name          | Type                                                                      |
|---------------|---------------------------------------------------------------------------|
| users         | JSON - exemple : [{"user_id":3, "role_id":4}, {"user_id":8, "role_id":5}] |

+ Response 200 (application/json)

        {
          "success": true,
          "payload": [
            {
              "id": 3,
              "firstname": "Super",
              "lastname": "Admin2",
              "email": "admin2@sigma.com",
              "status": 0,
              "avatar": null,
              "role_id": 2,
              "created_at": "2015-04-04 16:53:43",
              "updated_at": "2015-04-26 17:01:02",
              "deleted_at": null,
              "pivot": {
                "project_id": 1,
                "user_id": 3,
                "role_id": 4
              }
            },
            {
              "id": 8,
              "firstname": "Sigma",
              "lastname": "Admin3",
              "email": "admin3@sigma.com",
              "status": 1,
              "avatar": null,
              "role_id": 2,
              "created_at": "2015-07-16 21:43:52",
              "updated_at": "2015-07-16 21:43:52",
              "deleted_at": null,
              "pivot": {
                "project_id": 1,
                "user_id": 8,
                "role_id": 5
              }
            }
          ],
          "message": "Users successfully synced to the project"
        }
        
+ Response 404 (application/json)

        { "success": false, "payload": [], "error": "Some of the selected users doesn't exists." }
        
## Users Collection [/api/user?token={token}]

`/api/user?token={token}`

+ Parameters
    
    + token (string) ... Token of the logged user

### Store [POST]

#### Required Parameters

| Name          | Type                                                             |
|---------------|------------------------------------------------------------------|
| email         | String                                                           |
| firstname     | String                                                           |
| lastname      | String                                                           |
| role_id       | Integer                                                          |

+ Response 200 (application/json)

        {
          "success": true,
          "message": "User successfully added.",
          "payload": {
            "email": "admin4@sigma.com",
            "role_id": "1",
            "firstname": "admin2",
            "lastname": "sigma",
            "status": 0,
            "updated_at": "2015-07-16 20:56:05",
            "created_at": "2015-07-16 20:56:05",
            "id": 7
          }
        }
        
## User [/api/user/{id}?token={token}]

`/api/user?token={token}`

+ Parameters
    
    + id (string) ... id of the user
    + token (string) ... Token of the logged user

### Show [GET]

+ Response 200 (application/json)

        {
          "success": true,
          "payload": {
            "id": 7,
            "firstname": "admin2",
            "lastname": "sigma",
            "email": "admin4@sigma.com",
            "status": 0,
            "avatar": null,
            "role_id": 1,
            "created_at": "2015-07-16 20:56:05",
            "updated_at": "2015-07-16 20:56:05",
            "deleted_at": null
          }
        }
        
+ Response 404 (application/json)

        { "success": false, "payload": [], "error": "The selected user doesn't exist." }

### Update [PUT]

+ Response 200 (application/json)

        {
          "success": true,
          "message": "User successfully updated.",
          "payload": {
            "id": 7,
            "firstname": "admin2",
            "lastname": "sigma edit",
            "email": "admin4@sigma.com",
            "status": 0,
            "avatar": null,
            "role_id": 1,
            "created_at": "2015-07-16 20:56:05",
            "updated_at": "2015-07-16 21:00:11",
            "deleted_at": null
          }
        }
        
+ Response 404 (application/json)

        { "success": false, "payload": [], "error": "The selected user doesn't exist." }

### Destroy [DELETE]

+ Response 200 (application/json)

        {
          "success": true,
          "message": "The user has been successfully deleted.",
          "payload": []
        }
        
+ Response 404 (application/json)

        { "success": false, "payload": [], "error": "The selected user doesn't exist." }

# Group Tasks
Tasks related resources of the **Sigma API**

## Tasks Collection [/api/task?token={token}]

`/api/task?token={token}`

+ Parameters
    
    + token (string) ... Token of the logged user

### Store [POST]

#### Required Parameters

| Name          | Type                                                             |
|---------------|------------------------------------------------------------------|
| label         | String                                                           |
| status        | String ('Etude','Validation','Réalisation','Recette','Acceptée') |
| date_start    | Date (yyyy-mm-dd)                                                |
| date_end      | Date (yyyy-mm-dd)                                                |
| progress      | Integer (0-100)                                                  |
| estimated_time| Float                                                            |
| user_id       | Integer                                                          |
| version_id    | Integer                                                          |

#### Optional Parameters

| Name        | Type   |
|-------------|--------|
| description | String |

+ Response 200 (application/json)

        {
            "success": true,
            "message": "Task successfully added.",
            "payload": {
                "description": "Description tâche 1",
                "status": "Réalisation",
                "date_start": "2015-04-30",
                "date_end": "2015-05-05",
                "estimated_time": "8.0",
                "user_id": "1",
                "version_id": "1",
                "label": "Tâche 1",
                "progress": "0",
                "updated_at": "2015-06-14 17:48:35",
                "created_at": "2015-06-14 17:48:35",
                "id": 19
            }
        }

        
+ Response 400 (application/json)

        { "success": false, "payload": [], "error": "Incorrect parameters."}

## Tasks Collection For Project [/api/task/project/{projectId}?token={token}]

`/api/task/project/{projectId}?token={token}`

+ Parameters
    
    + projectId (string) ... Id of the project
    + token (string) ... Token of the logged user

### ProjectTaskList [GET]

+ Response 200 (application/json)

        {
            "success": true,
            "payload": [
                {
                    "id": 1,
                    "label": "Gestion des utilisateurs",
                    "description": "Gestion des utilisateurs",
                    "status": "Réalisation",
                    "date_start": "2015-04-30",
                    "date_end": "2015-05-05",
                    "estimated_time": "8.0",
                    "progress": 0,
                    "user_id": 1,
                    "version_id": 1,
                    "created_at": "2015-04-04 16:53:43",
                    "updated_at": "2015-04-04 16:53:43",
                    "version": {
                        "id": 1,
                        "label": "0.1",
                        "description": "Version 0.1",
                        "date_start": "2015-04-30",
                        "date_end": "2015-06-30",
                        "project_id": 1,
                        "created_at": "2015-04-04 16:53:43",
                        "updated_at": "2015-04-04 16:53:43"
                    }
                },
                {
                    "id": 2,
                    "label": "Gestion des projets",
                    "description": "Gestion des projets",
                    "status": "Etude",
                    "date_start": "2015-04-30",
                    "date_end": "2015-05-05",
                    "estimated_time": "8.0",
                    "progress": 0,
                    "user_id": 1,
                    "version_id": 2,
                    "created_at": "2015-04-04 16:53:43",
                    "updated_at": "2015-04-04 16:53:43",
                    "version": {
                        "id": 2,
                        "label": "0.2",
                        "description": "Version 0.2",
                        "date_start": "2015-06-30",
                        "date_end": "2015-08-30",
                        "project_id": 1,
                        "created_at": "2015-04-04 16:53:43",
                        "updated_at": "2015-04-04 16:53:43"
                    }
                }
            ]
        }
        
+ Response 403 (application/json)

        { "success": false, "payload": [], "error": "You do not have access to this project." }

## Tasks Collection For Version [/api/version/{versionId}/task?token={token}]

`/api/version/{versionId}/task?token={token}`

+ Parameters
    
    + versionId (string) ... Id of the project
    + token (string) ... Token of the logged user

### VersionTaskList [GET]

+ Response 200 (application/json)

        {
            "success": true,
            "payload": [
                {
                    "id": 1,
                    "label": "Gestion des utilisateurs",
                    "description": "Gestion des utilisateurs",
                    "status": "Réalisation",
                    "date_start": "2015-04-30",
                    "date_end": "2015-05-05",
                    "estimated_time": "8.0",
                    "progress": 0,
                    "user_id": 1,
                    "version_id": 1,
                    "created_at": "2015-04-04 16:53:43",
                    "updated_at": "2015-04-04 16:53:43",
                    "version": {
                        "id": 1,
                        "label": "0.1",
                        "description": "Version 0.1",
                        "date_start": "2015-04-30",
                        "date_end": "2015-06-30",
                        "project_id": 1,
                        "created_at": "2015-04-04 16:53:43",
                        "updated_at": "2015-04-04 16:53:43"
                    }
                },
                {
                    "id": 2,
                    "label": "Gestion des projets",
                    "description": "Gestion des projets",
                    "status": "Etude",
                    "date_start": "2015-04-30",
                    "date_end": "2015-05-05",
                    "estimated_time": "8.0",
                    "progress": 0,
                    "user_id": 1,
                    "version_id": 2,
                    "created_at": "2015-04-04 16:53:43",
                    "updated_at": "2015-04-04 16:53:43",
                    "version": {
                        "id": 2,
                        "label": "0.2",
                        "description": "Version 0.2",
                        "date_start": "2015-06-30",
                        "date_end": "2015-08-30",
                        "project_id": 1,
                        "created_at": "2015-04-04 16:53:43",
                        "updated_at": "2015-04-04 16:53:43"
                    }
                }
            ]
        }
        
+ Response 403 (application/json)

        { "success": false, "payload": [], "error": "You do not have access to the project related with this version." }
        
## Task [/api/task/{id}?token={token}]

`/api/task/{id}?token={token}`

+ Parameters
    
    + id (string) ... Id of the task
    + token (string) ... Token of the logged user

### Show [GET]

+ Response 200 (application/json)

        {
            "success": true,
            "payload": {
                "id": 19,
                "label": "Tâche 1",
                "description": "Description tâche 1",
                "status": "Réalisation",
                "date_start": "2015-04-30",
                "date_end": "2015-05-05",
                "estimated_time": "8.0",
                "progress": 0,
                "user_id": 1,
                "version_id": 1,
                "created_at": "2015-06-14 17:48:35",
                "updated_at": "2015-06-14 17:48:35"
            }
        }

        
+ Response 404 (application/json)

        { "success": false, "payload": [], "error": "The selected task doesn't exist."}
        
### Update [PUT]

+ Response 200 (application/json)

        {
            "success": true,
            "message": "Version successfully updated.",
            "payload": {
                "id": 19,
                "label": "Tâche 1",
                "description": "Description tâche 1",
                "status": "Réalisation",
                "date_start": "2015-04-30",
                "date_end": "2015-05-05",
                "estimated_time": "8.0",
                "progress": 0,
                "user_id": 1,
                "version_id": 1,
                "created_at": "2015-06-14 17:48:35",
                "updated_at": "2015-06-14 17:48:35"
            }
        }

        
+ Response 404 (application/json)

        { "success": false, "payload": [], "error": "The selected task doesn't exist."}
        
### Destroy [DELETE]

+ Response 200 (application/json)

        {
            "success": true,
            "message": "The task has been successfully deleted.",
            "payload": []
        }

        
+ Response 404 (application/json)

        { "success": false, "payload": [], "error": "The selected task doesn't exist."}

# Group Comments
Comments related resources of the **Sigma API**

## Comments Collection For Task [/api/task/{taskId}/comment?token={token}]

`/api/task/{taskId}/comment?token={token}`

+ Parameters
    
    + taskId (string) ... Id of the task
    + token (string) ... Token of the logged user

### TaskCommentList [GET]

+ Response 200 (application/json)

        {
          "success": true,
          "payload": [
            {
              "id": 1,
              "content": "First comment edit",
              "created_at": "2015-07-14 22:12:45",
              "updated_at": "2015-07-14 22:20:53",
              "task_id": 1,
              "user_id": 1,
              "user": {
                "id": 1,
                "firstname": "Super",
                "lastname": "Admin"
              }
            },
            {
              "id": 2,
              "content": "gribouiboui",
              "created_at": "2015-07-17 15:49:12",
              "updated_at": "2015-07-17 15:49:12",
              "task_id": 1,
              "user_id": 1,
              "user": {
                "id": 1,
                "firstname": "Super",
                "lastname": "Admin"
              }
            }
          ]
        }
    
## Comments Collection [/api/comment?token={token}]

`/api/comment?token={token}`

+ Parameters
    
    + token (string) ... Token of the logged user

### Store [POST]

#### Required Parameters

| Name          | Type                                                             |
|---------------|------------------------------------------------------------------|
| content       | String                                                           |
| task_id       | Integer                                                          |
| user_id       | Integer                                                          |

+ Response 200 (application/json)

        {
            "success": true,
            "payload": {
                "content": "First comment",
                "task_id": "1",
                "user_id": "1",
                "updated_at": "2015-07-14 22:12:45",
                "created_at": "2015-07-14 22:12:45",
                "id": 1
            }
        }

        
+ Response 400 (application/json)

        { "success": false, "payload": [], "error": "Incorrect parameters."}

## Comment [/api/comment/{id}?token={token}]

`/api/comment/{id}?token={token}`

### Show [GET]

+ Response 200 (application/json)

        {
            "success": true,
            "payload": {
                "id": 1,
                "content": "First comment",
                "created_at": "2015-07-14 22:12:45",
                "updated_at": "2015-07-14 22:12:45",
                "task_id": 1
                "user_id": 1
            }
        }

        
+ Response 404 (application/json)

        { "success": false, "payload": [], "error": "The selected comment doesn't exist."}

### Update [PUT]

+ Response 200 (application/json)

        {
          "success": true,
          "payload": {
            "id": 1,
            "content": "First comment edit",
            "created_at": "2015-07-14 22:12:45",
            "updated_at": "2015-07-14 22:20:53",
            "task_id": 1
            "user_id": 1
          },
          "message": "Comment successfully updated."
        }

        
+ Response 404 (application/json)

        { "success": false, "payload": [], "error": "The selected comment doesn't exist."}

### Destroy [DELETE]

+ Response 200 (application/json)

        {
          "success": true,
          "message": "The comment has been successfully deleted.",
          "payload": []
        }

        
+ Response 404 (application/json)

        { "success": false, "payload": [], "error": "The selected comment doesn't exist."}
        
# Group Todos
Todos related resources of the **Sigma API**

## Todos Collection For Task [/api/task/{taskId}/todo?token={token}]

`/api/task/{taskId}/todo?token={token}`

+ Parameters
    
    + taskId (string) ... Id of the task
    + token (string) ... Token of the logged user

### TaskTodoList [GET]

+ Response 200 (application/json)

        {
          "success": true,
          "payload": [
            {
              "id": 1,
              "label": "First todo",
              "done": 0,
              "task_id": 1
            },
            {
              "id": 2,
              "label": "Second todo",
              "done": 0,
              "task_id": 1
            }
          ]
        }
    
## Todos Collection [/api/todo?token={token}]

`/api/todo?token={token}`

+ Parameters
    
    + token (string) ... Token of the logged user

### Store [POST]

#### Required Parameters

| Name          | Type                                                             |
|---------------|------------------------------------------------------------------|
| label         | String                                                           |
| done          | Boolean                                                          |
| task_id       | Integer                                                          |

+ Response 200 (application/json)

        {
          "success": true,
          "payload": {
            "label": "First todo",
            "task_id": "1",
            "done": "0",
            "id": 1
          }
        }

        
+ Response 400 (application/json)

        { "success": false, "payload": [], "error": "Incorrect parameters."}

## Todo [/api/todo/{id}?token={token}]

`/api/todo/{id}?token={token}`

### Show [GET]

+ Response 200 (application/json)

        {
          "success": true,
          "payload": {
            "id": 1,
            "label": "First todo",
            "done": 0,
            "task_id": 1
          }
        }

        
+ Response 404 (application/json)

        { "success": false, "payload": [], "error": "The selected todo doesn't exist."}

### Update [PUT]

+ Response 200 (application/json)

        {
            "success": true,
            "payload": {
                "id": 1,
                "label": "First todo",
                "done": 1,
                "task_id": 1
            },
            "message": "Todo successfully updated."
        }

        
+ Response 404 (application/json)

        { "success": false, "payload": [], "error": "The selected todo doesn't exist."}

### Destroy [DELETE]

+ Response 200 (application/json)

        {
          "success": true,
          "message": "The todo has been successfully deleted.",
          "payload": []
        }

        
+ Response 404 (application/json)

        { "success": false, "payload": [], "error": "The selected comment doesn't exist."}
        
# Group Times
Times related resources of the **Sigma API**

## Times Collection [/api/time?token={token}]

`/api/time?token={token}`

+ Parameters
    
    + token (string) ... Token of the logged user
    
### UserTimeList [GET]

+ Response 200 (application/json)

        {
          "success": true,
          "payload": [
            {
              "id": 4,
              "time": "2.0",
              "date": "2015-05-30",
              "created_at": "2015-06-27 17:41:47",
              "updated_at": "2015-06-27 17:41:47",
              "pivot": {
                "user_id": 1,
                "time_id": 4
              },
              "task": {
                "id": 3,
                "label": "Gestion des taches",
                "description": "Gestion des taches",
                "status": "Réalisation",
                "date_start": "2015-04-30",
                "date_end": "2015-05-05",
                "estimated_time": "4.0",
                "progress": 20,
                "user_id": 1,
                "version_id": 2,
                "created_at": "2015-04-26 18:30:47",
                "updated_at": "2015-04-26 19:14:48"
              }
            },
            {
              "id": 5,
              "time": "2.0",
              "date": "2015-05-30",
              "created_at": "2015-06-27 17:45:42",
              "updated_at": "2015-06-27 17:45:42",
              "pivot": {
                "user_id": 1,
                "time_id": 5
              },
              "task": {
                "id": 3,
                "label": "Gestion des taches",
                "description": "Gestion des taches",
                "status": "Réalisation",
                "date_start": "2015-04-30",
                "date_end": "2015-05-05",
                "estimated_time": "4.0",
                "progress": 20,
                "user_id": 1,
                "version_id": 2,
                "created_at": "2015-04-26 18:30:47",
                "updated_at": "2015-04-26 19:14:48"
              }
            }
          ]
        }
        
### Store [POST]

#### Required Parameters

| Name          | Type                                                             |
|---------------|------------------------------------------------------------------|
| time          | Float (ex : 2.5)                                                 |
| date          | Date (yyyy-mm-dd)                                                |
| task_id       | Integer                                                          |
| user_id       | Integer                                                          |

+ Response 200 (application/json)
        
        {
          "success": true,
          "payload": {
            "time": "2",
            "date": "2015-05-24",
            "updated_at": "2015-07-15 20:17:32",
            "created_at": "2015-07-15 20:17:32",
            "id": 6
          },
          "message": "Time spent successfully added."
        }

## Time [/api/time/{id}?token={token}]

`/api/time/{id}?token={token}`

+ Parameters
    
    + id (string) ... Id of the time
    + token (string) ... Token of the logged user

### Show [GET]

+ Response 200 (application/json)

        {
          "success": true,
          "payload": {
            "id": 6,
            "time": "2.0",
            "date": "2015-05-24",
            "created_at": "2015-07-15 20:17:32",
            "updated_at": "2015-07-15 20:17:32"
          }
        }

        
+ Response 404 (application/json)

        { "success": false, "payload": [], "error": "The selected time doesn't exist."}

### Update [PUT]

+ Response 200 (application/json)

        {
          "success": true,
          "payload": {
            "id": 6,
            "time": "4.0",
            "date": "2015-05-24",
            "created_at": "2015-07-15 20:17:32",
            "updated_at": "2015-07-15 20:19:47"
          },
          "message": "Time spent on the task successfully updated."
        }

        
+ Response 404 (application/json)

        { "success": false, "payload": [], "error": "The selected time doesn't exist."}

### Destroy [DELETE]

+ Response 200 (application/json)

        {
          "success": true,
          "message": "The time spent has been successfully deleted.",
          "payload": []
        }

        
+ Response 404 (application/json)

        { "success": false, "payload": [], "error": "The selected time doesn't exist."}