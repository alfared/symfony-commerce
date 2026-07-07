export function AppFooter() {
  return (
    <footer className="mt-16 border-t border-slate-800 bg-slate-950">
      <div className="mx-auto flex max-w-7xl flex-col gap-4 px-6 py-8 text-sm text-slate-400 md:flex-row md:items-center md:justify-between">
        <p>© 2026 Symfony Commerce</p>
        <div className="flex gap-4">
          <a href="#" className="hover:text-white">
            Privacy
          </a>
          <a href="#" className="hover:text-white">
            Terms
          </a>
          <a href="/admin" className="hover:text-white">
            Admin
          </a>
        </div>
      </div>
    </footer>
  );
}
