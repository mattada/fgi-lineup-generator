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

    <p><b>Upload a DraftKings CSV file below. The required columns are:</b></p>

    <ul>
      <li>Name</li>
      <li>ID</li>
      <li>Salary</li>
    </ul>

    <p><em><small>Any additional columns may cause the upload to fail.</em></small></p>

    <div class="form-group">
      <input type="file" name="draftKings">
    </div>

    <div class="form-group">
      <p><b>Specify which slate the players belong to:</b></p>
      @foreach ($slates as $slate)
        <div class="radio">
          <label>
            <input type="radio" name="slate_id" value="{{$slate->id}}">
              {{$slate->name}}
          </label>
        </div>
      @endforeach
    </div>

    <button type="submit" class="btn btn-primary"><i class="fa fa-class"></i> Upload</button>
  </form>

@endsection