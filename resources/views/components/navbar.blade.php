<nav class="navbar navbar-expand-lg border-bottom border-3 mb-3" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">MiApp</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link @if($activeLink == 'home') active @endif" href="/">Inicio</a>
        <a class="nav-link @if($activeLink == 'products') active @endif" href="/products">Productos</a>
        <a class="nav-link @if($activeLink == 'categories') active @endif" href="/categories">Categorías</a>
        <a class="nav-link @if($activeLink == 'clients') active @endif" href="/clients">Clientes</a>
        <a class="nav-link @if($activeLink == 'orders') active @endif" href="/orders">Pedidos</a>
        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        <a class="nav-link" href="/profile">Profile</a>
        
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>

      </div>
    </div>
  </div>
</nav>