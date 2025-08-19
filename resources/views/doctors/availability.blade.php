<h3>Availability for {{ $doctor->name }}</h3>
<ul>
    @foreach($doctor->availabilities as $slot)
        <li>{{ $slot->date }} | {{ $slot->start_time }} to {{ $slot->end_time }}</li>
    @endforeach
</ul>
