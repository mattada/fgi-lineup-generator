<div class="breaking-news">
    <div class="title"><span>Breaking News</span></div>
    <marquee class="ticker">
            {{--@for($i = 0; $i <= 5; $i++)--}}
                {{--<div class="ticker_item">Lorem ipsum dolor sit amet.</div>--}}
            {{--@endfor--}}

        @foreach($breakingNews as $news)
            <div class="ticker_item">{{ $news->title }}</div>
        @endforeach
    </marquee>
</div>