@extends("administration::layouts.admin")

@section("header")
    <div class="header">
        <h1>Draft Kings Import</h1>
        <div class="buttons">
            <a href="{{ \Activelogiclabs\Administration\Admin\Core::url("players") }}"><i class="icon fa fa-caret-left"></i> Back</a>
        </div>
    </div>
@endsection

@section("content")

    <form class="well" action="{{ url('admin/players/draft-kings-import') }}" method="POST" enctype="multipart/form-data">

        <p>Upload a DraftKings CSV file below. The required columns are:</p>

        <ul>
            <li>Name</li>
            <li>ID</li>
            <li>Salary</li>
        </ul>

        <div class="form-group">
            <input type="file" name="draftKings">
        </div>

        <button type="submit" class="btn btn-primary"><i class="fa fa-class"></i> Upload</button>
    </form>

@endsection