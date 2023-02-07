@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{'Create Restaurants'}}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.restaurants.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ 'Name' }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
            </div>
            <div class="form-group">
                <label for="categories">{{ 'Category'}}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ 'Select All' }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ 'Deselect All' }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('categories') ? 'is-invalid' : '' }}" name="categories[]" id="categories" multiple>
                    @foreach($categories as $id => $categories)
                        <option value="{{ $id }}" {{ in_array($id, old('categories', [])) ? 'selected' : '' }}>{{ $categories }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="description">{{ 'Description' }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description') }}</textarea>
            </div>
            <div class="form-group">
                <label for="address">{{ 'Address' }}</label>
                <input class="form-control map-input {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address') }}">
                <input type="hidden" name="latitude" id="address-latitude" value="{{ old('latitude') ?? '0' }}" />
                <input type="hidden" name="longitude" id="address-longitude" value="{{ old('longitude') ?? '0' }}" />
            </div>
            <div id="address-map-container" class="mb-2" style="width:100%;height:400px; ">
                <div style="width: 100%; height: 100%" id="address-map"></div>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('active') ? 'is-invalid' : '' }}">
                    <input class="form-check-input" type="checkbox" name="active" id="active" value="1" {{ old('active', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="active">{{ 'Active' }}</label>
                </div>
            </div>
            <label>{{ 'Working hours' }}</label>
            @foreach($days as $day)
                <div class="form-inline">
                    <label class="my-1 mr-2">{{ ucfirst($day->name) }}: from</label>
                    <select class="custom-select my-1 mr-sm-2" name="from_hours[{{ $day->id }}]">
                        <option value="">--</option>
                        @foreach(range(0,23) as $hours)
                            <option 
                                value="{{ $hours < 10 ? "0$hours" : $hours }}"
                                {{ old('from_hours.'.$day->id) == ($hours < 10 ? "0$hours" : $hours) ? 'selected' : '' }}
                            >{{ $hours < 10 ? "0$hours" : $hours }}</option>
                        @endforeach
                    </select>
                    <label class="my-1 mr-2">:</label>
                    <select class="custom-select my-1 mr-sm-2" name="from_minutes[{{ $day->id }}]">
                        <option value="">--</option>
                        <option value="00" {{ old('from_minutes.'.$day->id) == '00' ? 'selected' : '' }}>00</option>
                        <option value="30" {{ old('from_minutes.'.$day->id) == '30' ? 'selected' : '' }}>30</option>
                    </select>
                    <label class="my-1 mr-2">to</label>
                    <select class="custom-select my-1 mr-sm-2" name="to_hours[{{ $day->id }}]">
                        <option value="">--</option>
                        @foreach(range(0,23) as $hours)
                            <option 
                                value="{{ $hours < 10 ? "0$hours" : $hours }}"
                                {{ old('to_hours.'.$day->id) == ($hours < 10 ? "0$hours" : $hours) ? 'selected' : '' }}
                            >{{ $hours < 10 ? "0$hours" : $hours }}</option>
                        @endforeach
                    </select>
                    <label class="my-1 mr-2">:</label>
                    <select class="custom-select my-1 mr-sm-2" name="to_minutes[{{ $day->id }}]">
                        <option value="">--</option>
                        <option value="00" {{ old('to_minutes.'.$day->id) == '00' ? 'selected' : '' }}>00</option>
                        <option value="30" {{ old('to_minutes.'.$day->id) == '30' ? 'selected' : '' }}>30</option>
                    </select>
                </div>
            @endforeach

            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ 'Save' }}
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize&language=en&region=GB" async defer></script>
<script src="/js/mapInput.js"></script>
<script>
</script>
@endsection