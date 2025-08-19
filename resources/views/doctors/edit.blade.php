<h2>Edit Doctor</h2>
<form method="POST" action="{{ route('doctors.update', $doctor->id) }}">
    @csrf
    @method('PUT')

    <input type="text" name="name" value="{{ $doctor->name }}" placeholder="Name"><br>
    <input type="email" name="email" value="{{ $doctor->email }}" placeholder="Email"><br>
    <input type="text" name="phone" value="{{ $doctor->phone }}" placeholder="Phone"><br>
    <input type="text" name="specialization" value="{{ $doctor->specialization }}" placeholder="Specialization"><br>

    <button type="submit">Update</button>
</form>
