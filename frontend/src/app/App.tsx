import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import { ProductsPage } from '../pages/products/ProductsPage';

const queryClient = new QueryClient();

export function App() {
  return (
    <QueryClientProvider client={queryClient}>
      <ProductsPage />
    </QueryClientProvider>
  );
}