import { Outlet } from "react-router-dom";
import { AppHeader } from "@/widgets/app-header/AppHeader";
import { AppFooter } from "@/widgets/app-footer/AppFooter";

export function AppLayout() {
  return (
    <div className="min-h-screen bg-slate-950 text-slate-50">
      <AppHeader />
      <Outlet />
      <AppFooter />
    </div>
  );
}
