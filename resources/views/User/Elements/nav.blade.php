<div class="sticky-wrapper" id="mainmenu-sticky-wrapper">
    <header style="" class="header">
        <nav class="navbar navbar-custom" role="navigation">
            <div class="">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#custom-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <div class="collapse navbar-collapse" id="custom-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="{{ route('home') }}">
                                <i class="fa fa-home fa-lg fa-fw"></i>
                                Trang chủ</a></li>
                        @foreach($categories as $category)
                            <li class="dropdown">
                                <a href="{{ route('categories.show', $category->id) }}" class="dropdown-toggle " data-toggle="dropdown" aria-expanded="true">
                                    {{ $category->name }}</a>
                                @foreach($category->childs as $key => $child)
                                    @if($child->posts->count())
                                        @if($key === 0)
                                            <ul class="dropdown-menu ">
                                        @endif
                                        <li><a href="{{ route('categories.show', $child->id) }}">{{ $child->name }}</a></li>
                                        @if($key === $category->childs()->whereHas('posts')->count() - 1)</ul>@endif
                                    @endif
                                @endforeach
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</div>
