<ul class="nav justify-content-center">
    <li class="nav-item">
        <a class="shadow nav-link btn btn-secondary mx-2 py-2 px-4 text-white" href="/shop/categories" style='width:12vw;'>Categories</a>
    </li>
    <li class="nav-item">
        <a class="shadow nav-link btn btn-secondary mx-2 py-2 px-4 text-white" href="/shop/products" style='width:12vw;'>Products</a>
    </li>
    @can('admin')
    <li class="nav-item">
        <a class="shadow nav-link btn btn-secondary mx-2 py-2 px-4 text-white" href="/shop/users" style='width:12vw;'>Users</a>
    </li>
    @endcan
</ul>