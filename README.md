<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
    </a>
</p>

# <p align="center">ToDo List</p>
<p align="center">
    Engineering Test by Law Advisor Adventure
</p>

## Instruction
Setup a project with your programming language of choice and create an API for managing a TODO list with the following specification:

1. The user should be able to list all tasks in the TODO list
2. The user should be able to add a task to the TODO list
3. The user should be able to update the details of a task in the TODO list
4. The user should be able to remove a task from the TODO list
5. The user should be able to reorder the tasks in the TODO list
6. A task in the TODO list should be able to handle being moved more than 50 times
7. A task in the TODO list should be able to handle being moved to more than one task away from its current position

Note: You can think of this as an API endpoint that will be used to handle the drag and drop feature of a TODO list application

All endpoints should return JSON responses.

## Prerequisites
- Laravel
- MySQL

## Setup
To run this project:

1. Clone the repository
```bash
 $ git clone https://github.com/DapDR14/todo_list.git
 ```

2. CD into your project
```bash
 $ cd todo_app
 ```

3. Install Composer Dependencies
```bash
 $ composer install
 ```

4. Generate an app encryption key
```bash
 $ php artisan key:generate
 ```

5. Run database migration
```bash
 $ php artisan migrate
 ```

6. Run seeder for database
```bash
 $ php artisan db:seed
 ```

7. Start the server
```bash
 $ php artisan serve
```

The API will now be accessible at http://127.0.0.1:8000.

## API Endpoints

## Endpoint to get all the todo tasks
 ```bash
 $ GET /api/tasks
 ```

 This endpoint returns a JSON with the list of tasks.

## Endpoint to add new task
```bash
 $ POST /tasks/new
 ```

## Body Parameters in JSON
 ```bash
 $ {
    "title": "Exercise",
    "description": "Do 10 situps"
    }
 ```

 This endpoint allows you to add new tasks that has the title and its description.

## Endpoint to update the title and description of an existing task
```bash
 $ POST /tasks/details/{id}
 ```

## Body Parameters in JSON
 ```bash
 $ {
    "title": "Exercise",
    "description": "Do 10 situps"
    }
 ```

 This endpoint allows you to update a specific task's title and description.

## Endpoint to delete a task
```bash
 $ DELETE /tasks/{id}
 ```

This endpoint allows you to delete a specific task.

## Endpoint to reorder the tasks
```bash
 $ PUT /tasks/reorder
 ```

## Body Parameters in JSON
 ```bash
 $ {
    "tasks": [
        {
        "id": 1,
        "position": 3
        },
        {
        "id": 2,
        "position": 2
        },
        {
        "id": 3,
        "position": 1
        }
    ]
    }
 ```

 This endpoint allows you to reorder or update the positioning of your tasks in todo list.
