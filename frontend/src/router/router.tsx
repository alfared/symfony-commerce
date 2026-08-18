import { createBrowserRouter } from "react-router-dom";

import { AppLayout } from "@/widgets/app-layout/AppLayout";
import { HomePage } from "@/pages/home/HomePage";
import { CatalogPage } from "@/pages/catalog/CatalogPage";
import { ProductPage } from "@/pages/product/ProductPage";
import { AdminPage } from "@/pages/admin/AdminPage";
import { AttributesPage } from "@/pages/attributes/AttributesPage";

export const router = createBrowserRouter([
  {
    path: "/",
    element: <AppLayout />,
    children: [
      { index: true, element: <HomePage /> },
      { path: "catalog", element: <CatalogPage /> },
      { path: "products/:slug", element: <ProductPage /> },

      {
        path: "admin",
        children: [
          { index: true, element: <AdminPage /> },
          { path: "attributes", element: <AttributesPage /> },
        ],
      },
    ],
  },
]);
