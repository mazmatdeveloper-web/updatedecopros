<aside class="sidebar">
  <button type="button" class="sidebar-close-btn">
    <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
  </button>
  <div>
    <a href="https://brokers.escodelar.ae/" class="sidebar-logo">
      <img src="{{asset('logoss.png')}}" alt="site logo" class="light-logo">
      <img src="{{asset('logoss.png')}}" alt="site logo" class="dark-logo">
      <img src="{{asset('logoss.png')}}" alt="site logo" class="logo-icon">
    </a>
  </div>
  <div class="sidebar-menu-area">
    <ul class="sidebar-menu" id="sidebar-menu">
      <li>
        <a href="{{route('dashboard')}}">
          <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="sidebar-menu-group-title">Properties</li>
      <li>
        <a href="#">
        <iconify-icon icon="tabler:building" class="menu-icon"></iconify-icon>
          <span>All Properties</span>
        </a>
      </li>
      <li>
        <a href="#">
          <iconify-icon icon="bi:chat-dots" class="menu-icon"></iconify-icon>
          <span>Add Property</span> 
        </a>
      </li>

      <li class="sidebar-menu-group-title">Cleaners</li> 
      <li>
        <a href="{{ route('add.cleaner') }}">
        <iconify-icon icon="tabler:building" class="menu-icon"></iconify-icon>
          <span>Add Cleaner</span>
        </a>
      </li>
      <li>
        <a href="{{ route('add.cleaner.availability') }}">
        <iconify-icon icon="tabler:building" class="menu-icon"></iconify-icon>
          <span>Add Availability</span>
        </a>
      </li>

      <li>
        <a href="{{ route('add.zipcode') }}">
        <iconify-icon icon="tabler:building" class="menu-icon"></iconify-icon>
          <span>Zipcodes</span>
        </a>
      </li>
    </ul>
  </div>

</aside>

