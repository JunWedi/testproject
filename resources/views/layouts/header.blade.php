<header class="text-gray-600 body-font" id=header>
  <div class="container mx-auto flex flex-wrap p-auto flex-col md:flex-row items-center">
    <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
        <x-nav-link :href="route('index')" :active="request()->routeIs('index')">
            <img src="{{ asset('images/logo4.png') }}" alt="Logo" class="w-35 h-20 ">
        </x-nav-link>
    </a>
    <nav class="navbar navbar-light bg-light">
       <div class="container-fluid">
       <form class="d-flex">
       <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
       <button class="btn btn-outline-success" type="submit">Search</button>
       </form>
       </div>
    </nav>
    <x-nav-link :href="route('recipes.create')" :active="request()->routeIs('recipes.create')">
        <button class="inline-flex items-center bg-gray-100 border-0 py-1 px-3 focus:outline-none hover:bg-gray-200 rounded text-base mt-4 md:mt-0">レシピを作る
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-1" viewBox="0 0 24 24">
                <path d="M5 12h14M12 5l7 7-7 7"></path>
            </svg>
        </button>
    </x-nav-link>
  </div>
</header>
