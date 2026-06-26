import type { Product } from '@/entities/product/model/product';
import type { ProductVariant } from '@/entities/product-variant/model/product-variant';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';


type Props = {
	products: Product[];
	variants: ProductVariant[];
};

export function ProductList({ products, variants }: Props) {
	return (
	  <Card className="border-slate-800 bg-slate-900 text-slate-50">
			<CardHeader>
				<CardTitle>Products</CardTitle>
			</CardHeader>

			<CardContent>
				<div className="grid gap-4">
					{products.map((product) => {
						   const productVariants = variants.filter(
								(variant: ProductVariant) => variant.productId === product.id,
						   );

						return (
							<div key={product.id} className="rounded-xl border border-slate-800 bg-slate-950 p-4">
								<div className="flex items-center justify-between gap-4">
									<div>
										<h3 className="font-semibold">{product.name}</h3>
										<p className="text-sm text-slate-400">{product.code}</p>
									</div>

									<Badge variant={product.enabled ? 'default' : 'secondary'}>
										 {product.enabled ? 'Enabled' : 'Disabled'}
									</Badge>
								</div>

								<div className="mt-4 grid gap-2">
									{productVariants.length === 0 && (
										<p className="text-sm text-slate-500">No variants yet.</p>
									)}

									{productVariants.map((variant) => (
										 <div key={variant.id} 
										 	  className="flex items-center justify-between rounded-lg bg-slate-900 px-3 py-2 text-sm">
											<span>{variant.sku}</span>
											<span>${(variant.price / 100).toFixed(2)}</span>
                      						<span>Stock: {variant.stock}</span>
										</div>
									))}
								</div>
							</div>
						);
					})}
				</div>
			</CardContent>
	  </Card>
	);
}