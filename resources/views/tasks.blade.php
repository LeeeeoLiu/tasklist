@extends('layouts.app')

@section('content')
        <!-- Create Task Form... -->
<script src="http://cdn.static.runoob.com/libs/angular.js/1.4.6/angular.min.js"></script>

<!-- Bootstrap Boilerplate... -->

<div class="panel-body">
    <!-- Display Validation Errors -->
    @include('common.errors')

            <!-- New Task Form -->
    <form action="/task" method="POST" class="form-horizontal">
        {{ csrf_field() }}

                <!-- Task Name -->
        <div class="form-group">
            <label for="task" class="col-sm-3 control-label">Task</label>

            <div class="col-sm-6">
                <input type="text" name="name" id="task-name" class="form-control">
            </div>
        </div>

        <!-- Add Task Button -->
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-plus"></i> Add Task
                </button>
            </div>
        </div>
    </form>
</div>


<!-- Current Tasks -->
@if (count($tasks) > 0)
    <div class="panel panel-default" ng-app="myTask" ng-controller="taskCtrl">
        <br>

        <div class="panel-body">
            <table class="table table-striped task-table">

                <!-- Table Headings -->
                <thead>
                <th>Todo list</th>
                <th>&nbsp;</th>
                </thead>

                <!-- Table Body -->
                <tbody>
                @foreach ($tasks as $task)
                    @if($task->done==0)
                    <tr>
                        <!-- Task Name -->
                        <td class="table-text">
                            <div>{{ $task->name }}</div>
                        </td>
                        <!--Edit Button-->
                        <td>
                            <button ng-click="toggle()">Edit Task</button>
                        </td>
                        <td>
                            <!-- New Task Form -->
                            <form action="/task/{{ $task->id }}/edit" method="POST" class="form-horizontal" ng-show="myVar">
                                {{ csrf_field() }}
                                        <!-- Task Name -->
                                <div class="form-group">

                                    <div class="col-sm-6">
                                        <input type="text" name="name" id="task-name" class="form-control">
                                    </div>
                                </div>
                                <!-- Add Task Button -->
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-6">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fa fa-plus"></i> Submit your change
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </td>
                        <!-- Delete Button -->
                        <td>
                            <form action="/task/{{ $task->id }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <button type="submit">Delete Task</button>
                            </form>
                        </td>
                        <!--Finist Button-->
                        <td>
                            <form action="/task/{{ $task->id }}/check" method="POST">
                                {{ csrf_field() }}
                                <button type="submit">Finish Task</button>
                            </form>
                        </td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
            <br>
            <table class="table table-striped task-table">

                <!-- Table Headings -->
                <thead>
                <th>Done list</th>
                <th>&nbsp;</th>
                </thead>

                <!-- Table Body -->
                <tbody>
                @foreach ($tasks as $task)
                    @if($task->done)
                        <tr>
                            <!-- Task Name -->
                            <td class="table-text">
                                <div>{{ $task->name }}</div>
                            </td>
                            <!--Edit Button-->
                            <td>
                                <button ng-click="toggle()">Edit Task</button>
                            </td>
                            <td>
                                <!-- New Task Form -->
                                <form action="/task/{{ $task->id }}/edit" method="POST" class="form-horizontal" ng-show="myVar">
                                    {{ csrf_field() }}

                                            <!-- Task Name -->
                                    <div class="form-group">

                                        <div class="col-sm-6">
                                            <input type="text" name="name" id="task-name" class="form-control">
                                        </div>
                                    </div>

                                    <!-- edit Task Button -->
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-6">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fa fa-plus"></i> Submit your change
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                            <!-- Delete Button -->
                            <td>
                                <form action="/task/{{ $task->id }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <button>Delete Task</button>
                                </form>
                            </td>

                            <!--Undo Button-->
                            <td>
                                <form action="/task/{{ $task->id }}/reset" method="POST">
                                    {{ csrf_field() }}
                                    <button type="submit">Make Task undo</button>
                                </form>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
    <script>
        var app = angular.module('myTask', []);
        app.controller('taskCtrl', function($scope) {
            $scope.myVar = false;
            $scope.toggle = function() {
                $scope.myVar = !$scope.myVar;
            };
        });
    </script>

@endif
@endsection