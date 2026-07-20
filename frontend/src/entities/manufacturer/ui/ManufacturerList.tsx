import type { Manufacturer } from '../model/manufacturer';

type Props = {
    items: Manufacturer[];
};

export function ManufacturerList({ items }: Props){
    return (
        <div className="grid gap-3">
            {items.map((item) => (
                <div key={item.id} className="rounded-xl border border-slate-800 bg-slate-950 p-4">
                    <div className="flex items-center justify-between gap-4">
                        <div>
                            <h3 className="font-semibold text-slate-50">{item.name}</h3>
                            <p className="text-sm text-slate-400">{item.code}</p>
                            <p className="text-sm text-slate-500">/{item.slug}</p>
                        </div>

                        <span className="rounded-full bg-slate-800 px-3 py-1 text-xs text-slate-300">
                            {item.enabled ? 'Enabled': 'Disabled'}
                        </span>
                    </div>

                    {item.description && (
                        <p className="mt-3 text-sm text-slate-400">{item.description}</p>
                    )}
                </div>
            ))}
        </div>
    );
}
