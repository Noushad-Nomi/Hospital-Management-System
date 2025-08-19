<h2>Add Doctor</h2>
<form method="POST" action="{{ route('doctors.store') }}">
    @csrf

    <input type="text" name="name" placeholder="Name"><br>
    <input type="email" name="email" placeholder="Email"><br>
    <input type="text" name="phone" placeholder="Phone"><br>
    <input type="text" name="specialization" placeholder="Specialization"><br>

    <button type="submit">Create</button>
</form>
