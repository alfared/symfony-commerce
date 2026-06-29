export function AppHeader() {
  return (
    <header className="sticky top-0 z-50 border-b border-slate-800 bg-slate-950/90 backdrop-blur">
      <div className="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
        <div className="text-xl font-bold tracking-tight">Symfony Commerce</div>

        <nav className="hidden items-center gap-6 text-sm text-slate-300 md:flex">
          <a href="#" className="hover:text-white">Home</a>
          <a href="#categories" className="hover:text-white">Categories</a>
          <a href="#products" className="hover:text-white">Products</a>
          <a href="/admin" className="hover:text-white">Admin</a>
        </nav>

        <button className="rounded-full bg-white px-4 py-2 text-sm font-semibold text-slate-950">
          Cart
        </button>
      </div>
    </header>
  );
}