<ul class="dropdown-menu dropdown-menu-right">
    @foreach($categories as $category)
        <li><a href="{{$category['href']}}"  class="login-btn-outside" style="border-bottom: unset;">{{$category['name']}}</a></li>
    @endforeach
</ul>
