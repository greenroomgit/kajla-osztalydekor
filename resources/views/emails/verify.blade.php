@extends('emails.kajla')

@section('content')

	@include('emails.kajla.contentStart')

<p><b>Kedves Regisztráló!</b></p>

<br>

<p>A makett csomag igénylés véglegesítéshez kérjük, kattints a lenti linkre:</p>

  <p><a href="{{ $url }}">Osztálydekor csomag igénylés</a></p>


<p>Üdvözlettel: <br>
    Kajla csapat
</p>


	@include('emails.kajla.contentEnd')

@stop
