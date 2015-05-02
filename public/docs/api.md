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

## Projects Collection [/api/project/user/{role}?token={token}]

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

## Project [/api/project/{id}?token={token}]

`/api/project/{id}?token={token}`

+ Parameters
    
    + id (string) ... id of the project
    + token (string) ... Token of the logged user

### ProjectShow [GET]

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

# Group Tasks
Tasks related resources of the **Sigma API**

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
