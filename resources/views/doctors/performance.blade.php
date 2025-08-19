<h3>Performance for {{ $doctor->name }}</h3>
<ul>
    @foreach($doctor->performances as $report)
        <li>{{ $report->report_date }} | Seen: {{ $report->patients_seen }} | Rating: {{ $report->rating }} | {{ $report->remarks }}</li>
    @endforeach
</ul>
