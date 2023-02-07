@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
       {{ 'Show Restaurant'}}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.restaurants.index') }}">
                    {{'Back to list' }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ 'Id' }}
                        </th>
                        <td>
                            {{ $restaurant->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ 'Name' }}
                        </th>
                        <td>
                            {{ $restaurant->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ 'Category' }}
                        </th>
                        <td>
                            @foreach($restaurant->categories as $key => $categories)
                                <span class="label label-info">{{ $categories->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ 'Description' }}
                        </th>
                        <td>
                            {{ $restaurant->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ 'Address' }}
                        </th>
                        <td>
                            {{ $restaurant->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ 'Active' }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $restaurant->active ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ 'Working Hours' }}
                        </th>
                        <td>
                            @if($restaurant->days)
                                @foreach($restaurant->days as $day)
                                    <strong>{{ ucfirst($restaurant->name) }}</strong>:
                                    from <strong>{{ $day->pivot->from_hours }}:{{ $day->pivot->from_minutes }}</strong>
                                    to <strong>{{ $day->pivot->to_hours }}:{{ $day->pivot->to_minutes }}</strong>
                                    <br>
                                @endforeach
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>


    </div>
</div>
@endsection