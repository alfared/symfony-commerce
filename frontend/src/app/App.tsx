import { HomePage } from '@/pages/HomePage';
import { AdminCatalogPage } from '@/pages/AdminCatalogPage';

export default function App() {
  const isAdmin = window.location.pathname.startsWith('/admin');

  return isAdmin ? <AdminCatalogPage /> : <HomePage />;
}