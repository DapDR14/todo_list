<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tasks;

class TasksController extends Controller
{
    // Function for getting all tasks
    public function getAll () {
        // Get all tasks in ascending order by position
        $tasks = Tasks::orderBy('position', 'ASC')->get();

        return response()->json(
            [
                'status' => 200,
                'tasks' => $tasks
            ]);
    }

    // Function for adding new task
    public function addTask (Request $request) {

        $input = $request->all();

        $taskOrder = Tasks::max('position') + 1; // Get the last positiom and add 1

        // Check for any missing gaps in the positiom sequence
        $existingTaskOrders = Tasks::pluck('position')->toArray();
        $missingTaskOrder = array_diff(range(1, count($existingTaskOrders) + 1), $existingTaskOrders);

        if (!empty($missingTaskOrder)) {
            $taskOrder = reset($missingTaskOrder); // Get the first missing positiom value
        }

        // Create the new task with the determined positiom
        $input = Tasks::create([
                'title' => $input['title'],
                'description' => $input['description'],
                'position' => $taskOrder,
                'status' => $input['status']
        ]);

        // Check if task has been created on the db
        if ($input->save()) {
            return response()->json(
            [
                'status' => 200,
                'tasks' => $input,
                'message' => 'Tasks successfully added!'
            ]);
        } else {
            return response()->json(
            [
                'status' => 500,
                'message' => 'Tasks has not been added!'
            ]);
        }

        return response()->json(
            [
                'status' => 500,
                'tasks' => $input,
                'message' => 'Tasks has not been added!'
            ]);
    }

    // Function for editing the details of a task
    public function editTask (Request $request, $id) {
        // Get title and description post data
        $title = $request->input('title');
        $desc = $request->input('description');
        $status = $request->input('status');

        // Check if task id exists
        $task = Tasks::find($id);

        // If task id exists
        if ($task) {
            // Then update the data
            $task->update([
                'title' => $title,
                'description' => $desc,
                'status' => $status
            ]);

            return response()->json([
                'status' => 200,
                'task' => $task,
                'message' => 'Task successfully updated!'
            ]);
        } else {
            // Else return an error
            return response()->json([
                'status' => 404,
                'message' => 'Task does not exist!'
            ]);
        }
    }

    // Function for updating positions of tasks/reordering tasks
    public function reorderTasks(Request $request)
    {
        // Get post data parameter tasks
        $input = $request->input('tasks');

        // Sort the inputted tasks by position and then by id
        usort($input, function ($a, $b) {
            if ($a['position'] === $b['position']) {
                return $a['id'] - $b['id'];
            }
            return $a['position'] - $b['position'];
        });

        $existingTaskOrders = Tasks::pluck('position')->toArray();
        $totalTasks = count($input);

        // Update the position for each task
        foreach ($input as $index => $taskData) {
            $taskId = $taskData['id'];
            $currentTaskOrder = $index + 1;

            // Check if the position already exists
            if (in_array($currentTaskOrder, $existingTaskOrders)) {
                // Switch position with other task if it has the same position
                $otherTask = Tasks::where('position', $currentTaskOrder)
                    ->where('id', '<>', $taskId)
                    ->first();

                if ($otherTask) {
                    Tasks::where('id', $taskId)->update(['position' => $otherTask->position]);
                    Tasks::where('id', $otherTask->id)->update(['position' => $currentTaskOrder]);
                }
            }

            Tasks::where('id', $taskId)->update(['position' => $currentTaskOrder]);
        }

        // Fill the missing position numbers
        if ($totalTasks < $existingTaskOrders[count($existingTaskOrders) - 1]) {
            for ($i = $totalTasks + 1; $i <= count($existingTaskOrders); $i++) {
                $taskToUpdate = Tasks::where('position', $i)->first();
                if ($taskToUpdate) {
                    Tasks::where('position', '>=', $i)
                        ->where('id', '<>', $taskToUpdate->id)
                        ->orderBy('position', 'desc')
                        ->update(['position' => \DB::raw('position + 1')]);

                    Tasks::where('id', $taskToUpdate->id)->update(['position' => $i]);
                }
            }
        }



        $tasks = Tasks::orderBy('position', 'ASC')->get();

        // Return success
        return response()->json([
            'status' => 200,
            'tasks' => $tasks,
            'message' => 'Tasks reordered successfully'
        ]);
    }

    // Function for deleting a task
    public function deleteTask (Request $request, $id) {
        // Check if id exists in the db
        $task = Tasks::findOrFail($id);

        if (!$task) {
            return response()->json([
                'status' => 404,
                'message' => 'Task does not exist',
            ]);
        }

        // Delete the task
        $task->delete();

        // Reorder the positiom for the remaining tasks to fill any gaps
        $remainingTasks = Tasks::orderBy('position')->get();

        $taskOrderCounter = 1;

        foreach ($remainingTasks as $remainingTask) {
            // Update the positiom only if it's not in the correct sequence
            if ($remainingTask->positiom != $taskOrderCounter) {
                $remainingTask->update(['position' => $taskOrderCounter]);
            }
            $taskOrderCounter++;
        }

        return response()->json([
            'message' => 'Task deleted successfully',
            'tasks' => $remainingTask
        ]);
    }
}
