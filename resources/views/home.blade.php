@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">List of Users</div>

                <div class="panel-body">
                    <div class="controls">
                        <div class="row">
                            <div class="col-md-4">
                                <a href="{{ route('createProfile') }}" class="btn btn-default">Create User</a>
                            </div>
                            <div class="col-md-8">
                                <form action="{{ route('home') }}" method="get">
                                    <div class="input-daterange form-group">
                                        <div class="row no-gutter">
                                            <div class="col-md-5">
                                                <input type="date" name="start_date" class="form-control js-daterange-start" value="{{ ($start_date)?date('Y-m-d', \Carbon\Carbon::parse($start_date)->timestamp): '' }}">
                                            </div>
                                            <div class="col-md-5">
                                                <input type="date" name="end_date" class="form-control js-daterange-end" value="{{ ($end_date)?date('Y-m-d', \Carbon\Carbon::parse($end_date)->timestamp): '' }}">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="submit" class="btn btn-default btn">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="user-list">
                        @forelse($users as $user)
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    @if(!$user->admin)
                                    <div class="pull-right">
                                        <form action="{{ route('deleteProfile', ['id' => $user->id]) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                            {!! csrf_field() !!}
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                    @endif
                                    <a href="{{ route('editProfile', ['id' => $user->id]) }}">
                                        {{ $user->first_name }} {{ $user->last_name }}<br> <small>&lt;{{ $user->email }}&gt;</small>
                                    </a>
                                </div>
                            </div>
                        @empty
                            There are no results for that search. <a href="{{ route('home') }}">Try again.</a>
                        @endforelse
                    </div>
                    <div class="pagination">
                        {{ $users->appends(['start_date' => $start_date, 'end_date' => $end_date])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
