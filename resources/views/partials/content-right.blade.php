<div class="sidebox">
    <div class="title-block">Follow Us</div>
    <div class="social-wrap">
        <a href="https://www.facebook.com/fantasygolfers/?fref=nf" target="_blank"><div class="network facebook">Facebook</div></a>
        <a href="https://twitter.com/FantasyGolfers" target="_blank"><div class="network twitter">Twitter</div></a>
        <a href="https://plus.google.com/+Fantasygolfinsider/posts" target="_blank"><div class="network google-plus">Google+</div></a>
        <span class="stretch"></span>
    </div>
</div>

<div class="sidebox published_content">
    <div>
        @foreach($rightbar_pages as $page)
            <a href="/p/{{ $page->title_slug }}">
                <img src="/images/{{ $page->thumbnail }}" />
            </a>
        @endforeach
    </div>
</div>

<div class="sidebox">
    <div class="title-block">Our Partners</div>
    <div>
        <img style="width: 100%;" src='http://fantasygolfinsider.com/wp-content/uploads/2016/03/fantasy_golf_floating_ad.jpg'>
        <img style="width: 100%;" src='https://media.go2speed.org/brand/files/draftkings/124/Standard300x250.jpg'>

    </div>
</div>

<div class="sidebox">
    <div class="title-block">World Golf Rankings</div>
    <div style="position: relative">
        <br>
        <iframe width="100%" height="403" src="http://origin-www.owgr.com/Global/Widgets/Left/SharingRankingTable.aspx?country=ALL&amp;continent=ALL" frameborder="0" allowfullscreen="true" style=" top: 0;"></iframe>
    </div>
</div>