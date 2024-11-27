@extends('layouts.app')

@section('content')
    <h1>Admin Dashboard</h1>
    @if(session('status'))
        <div>{{ session('status') }}</div>
    @endif
    <h2>Pending Sellers</h2>
    <ul>
        @foreach($pendingSellers as $seller)
            <li>
                {{ $seller->name }} - {{ $seller->email }}
                <form action="{{ route('admin.approveSeller', $seller->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit">Approve</button>
                </form>
                <form action="{{ route('admin.rejectSeller', $seller->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit">Reject</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection