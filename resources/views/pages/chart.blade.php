@extends('app')
@section('content')
<div class="mb-3 row">
    <h4>Asteroid Stats</h4>
</div>
<div>
    @if($errors->any())
    @foreach($errors->all() as $error)
    <p class="alert alert-danger">{{ $error }}</p>
    @endforeach
    @endif
</div>
<div class="row">
    Fastest Asteroid in km/h (Respective Asteroid ID & its speed)
</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Speed in km/hr</th>
        </tr>
    </thead>
    <tbody>
        @if(!empty($fastest_asteroid))
        <tr>
            <td>{{array_key_first($fastest_asteroid)}}</td>
            <td>{{round(current($fastest_asteroid),3)}}</td>
        </tr>

        @endif
    </tbody>
</table>
<div class="row">
    Closest Asteroid (Respective Asteroid ID & its distance)
</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Speed - km/hr</th>
        </tr>
    </thead>
    <tbody>
        @if(!empty($closest_asteroid))
        <tr>
            <td>{{array_key_first($closest_asteroid)}}</td>
            <td>{{round(current($closest_asteroid),3)}}</td>
        </tr>

        @endif
    </tbody>
</table>
<div class="row">
    Average Size of the Asteroids in kilometers
</div>
<table class="table">
    <tbody>
        <tr>
            <td><b>{{$average_size_of_asteroids}}</b></td>

        </tr>
    </tbody>
</table>

<div class="row">
    Chart
</div>
<div class="w-50 p-3">

    <canvas id="myChart" style="background-color: aliceblue;"></canvas>
</div>
<script>
    $(document).ready(function(){

        function random(number){
        return Math.floor(Math.random()*number);;
        }
        function getRandomColor(){
        return 'rgba('+random(255)+','+random(255)+','+random(255)+')';
        }

    var chart_data = @json($chart_data);

    var data=[];
    data['labels']=[];
    data['datasets']=[];
    data['datasets'][0]={
    data: [],
    backgroundColor: [],
    borderColor: "rgba(0,0,0,0)",
    label: 'Asteroids'
    };

    var i=0;
    for (const property in chart_data) {
        data['labels'][i]=property;
        data['datasets'][0].data[i]=chart_data[property];
        data['datasets'][0].backgroundColor[i]=getRandomColor();
        i++;
    }
    var ctx=document.getElementById("myChart");
    var myNewChart=new Chart(ctx,{type: 'bar' ,data: data});
});
</script>
@endsection
