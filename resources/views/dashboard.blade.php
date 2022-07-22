@extends('template')
@section('title', 'Dashboard Page')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>Login Button</h1>
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Имя </th>
                    <th scope="col">Фамилия</th>
                    <th scope="col">Дата рождения</th>
                    <th scope="col">Рост</th>
                    <th scope="col">Вердикт</th>
                    <th scope="col">Дата регистрации</th>
                </tr>
                </thead>
                <tbody>
                @foreach($scan_histories as $scan_history)
                    <tr>
                        <th scope="row">{{ $scan_history['ID'] }}</th>
                        <td>{{ $scan_history['identity']['FirstName'] ? $scan_history['identity']['FirstName'] : 'Unknown' }}</td>
                        <td>{{ $scan_history['identity']['LastName'] ? $scan_history['identity']['LastName'] : 'Unknown' }}</td>
                        <td>{{ $scan_history['identity']['Birthday'] ? $scan_history['identity']['Birthday'] : 'Undefined' }}</td>
                        <td>{{ $scan_history['identity']['Height'] ? $scan_history['identity']['Height'] : 'Unknown' }}</td>
                        <td class="{{ Str::lower($scan_history["VerdictName"]) }}">{{ $scan_history['VerdictValue'] ? $scan_history['VerdictValue']: 'Unknown' }}</td>
                        <td>{{ $scan_history['identity']['CreatedAt'] ? $scan_history['identity']['CreatedAt'] : 'Undefined' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <style>
        .fake {
            color:red;
            background-color: #ffcdcd;
        }
        .valid {
            color:green;
            background-color: #d0f9d7;
        }
        .thead-dark th {
            color: #fff;
            background-color: #212529;
            border-color: #32383e;
        }
    </style>
@endsection