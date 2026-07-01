import { CategoryStrip } from '@/widgets/category-strip/CategoryStrip';
import { HeroSlider } from '@/widgets/hero-slider/HeroSlider';
import { ProductGrid } from '@/widgets/product-grid/ProductGrid';

export function HomePage() {
    return (
        <main>
            <HeroSlider />
            <CategoryStrip />
            <ProductGrid />
        </main>
    );
}