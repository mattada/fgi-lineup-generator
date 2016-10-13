<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ url('/') }}"><img class="logo" src="/images/fgi_logo.png" width="145" height="41"></a>

            <ol class="breadcrumb navigation">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/p/privacy-policy') }}">Privacy Policy</a></li>
                <li><a href="{{ url('/p/terms-of-use') }}">Terms of Use</a></li>
                <li><a href="{{ url('/contact-us') }}">Contact Us</a></li>
                <li id="adminAccess" style="display: {{ (Auth::check() and Auth::User()->is_admin) ? 'inline' : 'none' }}"><a href="{{ url('/admin') }}">Admin</a></li>
            </ol>
        </div>
    </div>
</div>