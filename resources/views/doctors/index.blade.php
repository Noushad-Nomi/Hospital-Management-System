<h2>Doctors</h2>
<a href="{{ route('doctors.create') }}">Add Doctor</a>

<table>
    <thead>
        <tr><th>Name</th><th>Email</th><th>Specialization</th><th>Actions</th></tr>
    </thead>
    <tbody>
        @foreach($doctors as $doctor)
            <tr>
                <td>{{ $doctor->name }}</td>
                <td>{{ $doctor->email }}</td>
                <td>{{ $doctor->specialization }}</td>
                <td>
                    <a href="{{ route('doctors.edit', $doctor->id) }}">Edit</a> |
                    <a href="{{ route('doctors.availability', $doctor->id) }}">Availability</a> |
                    <a href="{{ route('doctors.performance', $doctor->id) }}">Performance</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
