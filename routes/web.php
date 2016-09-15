<?php

    use App\Task;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    $tasks = Task::orderBy('created_at', 'asc')->get();
 
    return view('tasks', [
        'tasks' => $tasks
    ]);
});

Route::post('/task', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
    ]);
 
    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }

    $task = new Task;
    $task->name = $request->name;
    $task->done =false;
    $task->save();

    return redirect('/');
 
    // Create The Task...
});

Route::post('/task/{id}/edit', function (Request $request,$id) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
    ]);

    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }
    $task = Task::find($id);
    $task->name = $request->name;
    $task->save();

    return redirect('/');

    // Create The Task...
});

Route::post('/task/{id}/check', function ($id) {
    $task = Task::find($id);
    $task->done = True;
    $task->save();
    if ($task->done)
        echo $task->done;

    return redirect('/');

});


Route::post('/task/{id}/reset', function ($id) {
    $task = Task::find($id);
    $task->done = False;
    $task->save();
    if ($task->done)
        echo $task->done;

    return redirect('/');

});

Route::delete('/task/{id}', function ($id) {
    Task::findOrFail($id)->delete();
 
    return redirect('/');
});

//Route::get('/task/{id}',);
//Route::edit('/task/{id}/edit',function($id){
//    Task::findOrFail($id)->edit();
//
//
//
//    return redirect('/');
//});