<header class="md:flex justify-between items-center p-3" id="header">
    <a class="flex title-font font-medium text-gray-900">
        <x-nav-link :href="route('index')" :active="request()->routeIs('index')">
            <img src="{{ asset('images/logo4.png') }}" alt="Logo" class="w-35 h-20">
        </x-nav-link>
    </a>
    <ul class="md:flex space-x-2 ml-auto">
        <nav class="navbar navbar-light bg-light">
            <div class="container-fluid">
                <form class="d-flex" action="{{ route('recipes.search') }}" method="GET">
                    <input class="form-control me-2" type="search" name="name" placeholder="料理名を入力" aria-label="料理名">
                    <input class="form-control me-2" type="search" name="tag" placeholder="タグを入力" aria-label="タグ">
                    <!-- カテゴリーのプルダウンメニュー -->
                    <select class="form-select me-2" name="category_id" aria-label="カテゴリー選択">
                        <option selected value="">カテゴリーを選択</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </nav>
        <x-nav-link :href="route('my.recipes')" :active="request()->routeIs('my.recipes')">
            <button class="inline-flex items-center bg-gray-100 border-0 py-1 px-3 focus:outline-none hover:bg-gray-200 rounded text-base">
                myレシピ
            </button>
        </x-nav-link>
        <x-nav-link :href="route('recipes.create')" :active="request()->routeIs('recipes.create')">
            <button class="inline-flex items-center bg-blue-300 border-0 py-1 px-3 focus:outline-none hover:bg-blue-400 rounded text-base" >
                投稿
            </button>
        </x-nav-link>
    </ul>
</header>