<h2>Create Site</h2>
<form action="{{ route('sites.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="name">Site Name</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="address">Site desc</label>
        <input type="text" name="description" id="description" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Create Site</button>
</form>