import { useEffect, useState } from 'react';
import { getCategories } from '@/entities/category/api/categoryApi';
import type { Category } from '@/entities/category/model/category';
import { CategoryList } from '@/entities/category/ui/CategoryList';
import { CreateCategoryForm } from '@/features/category/create/CreateCategoryForm';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

export function CategoryManagement() {
    const [categories, setCategories] = useState<Category[]>([]);

    useEffect(() => {
        getCategories().then(setCategories);
    }, []);

    function handleCreated(category: Category) {
        setCategories((current) => [category, ...current]);
    }

    return (
        <div className="grid gap-6 lg:grid-cols-[420px_1fr]">
            <Card className="border-slate-800 bg-slate-900 text-slate-50">
                <CardHeader>
                    <CardTitle>Create category</CardTitle>
                </CardHeader>

                <CardContent>
                    <CreateCategoryForm onCreated={handleCreated} />
                </CardContent>
            </Card>

            <CategoryList categories={categories} />
        </div>
    );
}