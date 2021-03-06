<?php
/**
 * @var $users \App\User []
 */
?>


@extends('layouts.admin')

@section('content')

    <div class="card card-default">
        <div class="card-header">
            Пользователи
        </div>
        <div class="card-body">
            @if($users->count())
                <table class="table user-list-table">
                    <thead>
                    <tr>
                        <th>Аватар</th>
                        <th>Имя</th>
                        <th>Фамилия</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td><img src="{{ Gravatar::src($user->email) }}" alt="" width="40" style="border-radius: 50%"></td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->surname }}</td>
                            <td>{{ $user->email }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $users->links() }}
            @else
                <h6 class="text-center">Пользователи не найдены</h6>
            @endif
        </div>
    </div>

@endsection
