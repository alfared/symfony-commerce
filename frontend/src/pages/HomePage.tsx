import { AppHeader } from '@/widgets/app-header/AppHeader';
import { HeroSlider } from '@/widgets/hero-slider/HeroSlider';
import { CategoryStrip } from '@/widgets/category-strip/CategoryStrip';
import { ProductGrid } from '@/widgets/product-grid/ProductGrid';
import { AppFooter } from '@/widgets/app-footer/AppFooter';

export function HomePage() {
    return (
        <div className='min-h-screen bg-slate-950 text-slate-50'>
            <AppHeader />

            <main>
                <HeroSlider />
                <CategoryStrip />
                <ProductGrid />
            </main>

            <AppFooter />
        </div>
    );
}