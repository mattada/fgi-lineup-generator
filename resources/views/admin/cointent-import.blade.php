@extends("administration::layouts.admin")

@section("header")
    <div class="header">
        <h1>Cointent Import</h1>
        <div class="buttons">
            <a href="{{ \Activelogiclabs\Administration\Admin\Core::url("users") }}"><i class="icon fa fa-caret-left"></i> Back</a>
        </div>
    </div>
@endsection

@section("content")

    <form class="well" action="{{ url('admin/users/cointent-import') }}" method="POST" enctype="multipart/form-data">

        <p>Upload a Cointent Subscribers CSV file below. The required columns are:</p>

        <ul>
            <li>PlanId</li>
            <li>Email</li>
            <li>Active</li>
            <li>Was Granted</li>
            <li>Subscription Start Time</li>
            <li>Has Set Password</li>
        </ul>

        <div class="form-group">
            <input type="file" name="cointent">
        </div>

        <button type="submit" class="btn btn-primary"><i class="fa fa-class"></i> Upload</button>
    </form>

@endsection