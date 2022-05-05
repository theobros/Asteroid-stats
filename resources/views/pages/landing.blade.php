@extends('app')
@section('content')
<div class="mb-3 row">
    <h4>Select date range to show Asteroid Stats</h4>
</div>
<div>
    @if($errors->any())
    @foreach($errors->all() as $error)
    <p class="alert alert-danger">{{ $error }}</p>
    @endforeach
    @endif
</div>
<form method="POST" action="{{url('asteroid/stats')}}">
    @csrf
    <div class="mb-3 row">
        <label for="start_date" class="col-sm-2 col-form-label">Start Date</label>
        <div class="col-sm-10">
            <input id="start_date" name="start_date" data-provide="datepicker">

        </div>
    </div>

    <div class="mb-3 row">
        <label for="end_date" class="col-sm-2 col-form-label">End Date</label>
        <div class="col-sm-10">
            <input id="end_date" name="end_date" data-provide="datepicker">
        </div>
    </div>
    <div class="col-6">
        <button class="btn btn-primary w-75" type="submit">Submit
    </button>
    </div>
</form>
<script>
    $(document).ready(function(){

        $('#start_date').datepicker({
        format: 'yyyy-mm-dd',

        });
        $('#end_date').datepicker({
        format: 'yyyy-mm-dd',

        });
    });
</script>
@endsection
