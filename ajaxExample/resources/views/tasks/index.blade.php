@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-12">
        <h1>Lista de tareas</h1>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <input type="text" name="description" id='description'>
        <input type="button" value="crear" onclick="createTask()">
    </div>
</div>

<div class="row">
    <div class="col-12">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Descripción</th>
                    <th>¿Pendiente?</th>
                    <th>¿Terminado?</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                <tr>
                    <td>
                        {{$task->id}}
                    </td>
                    <td>
                        {{$task->description}}
                    </td>
                    <th>
                        {{$task->is_done ? 'No' : 'Si'}}
                    </th>
                    <th>
                        <input type="button" value="Listo" onclick="updateTask({{$task -> id}})">
                    </th>
                    <td>
                        <input type="button" value="eliminar" onclick="deleteTask({{$task -> id}})">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('layout_end_body')
<script>
    function createTask(){
        let theDescription = $('#description').val();
        $.ajax({
            url: '{{ route('tasks.store') }}',
            method: 'POST',
            headers: {
                'Accept' : 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                description: theDescription
            }
        })
        .done(function(response){
            $('#description').val('');
            $('.table tbody').append('<tr><td>' + response.id + '</td><td> ' + response.description + '</td><td>Sí</td><th><input type="button" value="Listo" onclick="updateTask('+ response.id +')"></th><td><input type="button" value="eliminar" onclick="deleteTask('+ response.id+')"></td>');
            console.log(response.id);
            console.log(response.description);
        })
        .fail(function(jqXHR, response){
            console.log('Failure',response);
        });
    }
    function updateTask(task){
        let durl = '{{ route('tasks.update', 0) }}' + task;
        $.ajax({
            url: durl,
            method: 'PUT',
            headers: {
                'Accept' : 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .done(function(response){
            $('#description').val('');
            $('.table tbody').append()
            console.log(response.id);
            console.log(response.description);
        });
    }
    function deleteTask(task){
        let theDescription = $('#description').val();
        let durl = '{{ route('tasks.destroy', 0) }}' + task;
        $.ajax({
            url: durl,
            method: 'DELETE',
            headers: {
                'Accept' : 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                description: theDescription
            }
        })
        .done(function(response){
            $('#description').val('');
            $('.table tbody').remove('<tr><td>' + response.id + '</td><td> ' + response.description + '</td><td>Sí</td><th><input type="button" value="Listo" onclick="updateTask({{$task -> id}})"></th><td><input type="button" value="eliminar" onclick="deleteTask({{$task -> id}})"></td>');

            console.log(response.id);
            console.log(response.description);
        });
    }
</script>
@endpush